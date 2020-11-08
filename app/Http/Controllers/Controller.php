<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getAll($model): JsonResponse {
        if($this->validateModel($model)) {
            $users = $model::all();
            return response()->json($users, 200);
        }
    }

    protected function validateAndAdd(Request $request, $model, array $rules): JsonResponse {
        if($this->validateModel($model)) {
            $data = $request->input();
            $validator = Validator::make($data, $rules);

            if($validator->fails()) {
                return response()->json($validator->errors(), 409);
            }

            $permission = $model::create($data);
            return response()->json($permission, 201);
        }
        return response()->json(new \stdClass(), 500);
    }

    protected function getById($model, $id): JsonResponse {
        if($this->validateModel($model)) {
            $resource = $model::all()->where("id", $id)->first();
            if(!empty($resource)) {
                return response()->json($resource, 200);
            }
            return response()->json($resource, 404);
        }
        return response()->json(new \stdClass(), 500);
    }

    protected function validateAndUpdate(Request $request, $model, int $id, array $rules, bool $uniqueWithoutSelf = false): JsonResponse {
        foreach($rules as $key=>$rule) {
            $rules[$key] .= ",$key," . $model::all()->where("id", $id)->first()->$key;
        }
        //TODO: Fix problem with unique on update.

        if($this->validateModel($model)) {
            $resource = $model::all()->where("id", $id)->first();
            if(!empty($model)) {
                $data = $request->input();

                if(!$uniqueWithoutSelf) {
                    $validator = Validator::make($data, $rules);

                    if($validator->fails()) {
                        return response()->json($validator->errors(), 409);
                    }
                }else if(!$this->isUniqueExclusiveSelf($model, $id, $data)['state']) {
                    return response()->json($this->isUniqueExclusiveSelf($model, $id, $data)['errors'], 409);
                }


                $resource->fill($data);
                $resource->save();
                return response()->json($resource, 200);
            }
            return response()->json($resource, 404);
        }
        return response()->json(new \stdClass(), 500);
    }

    private function isUniqueExclusiveSelf($model, $id, $input) {
        $msg = array();
        $state = true;

        foreach($input as $key => $value) {
            $data = $model::where("id", "!=", $id)->where($key, "LIKE", $value)->first();

            if($data) {
                $state = false;
                $msg[$key] = array("The $key has already been taken.");
            }
        }

        return array("state" => $state, "errors" => $msg);
    }

    protected function removeResource($model, int $id): JsonResponse {
        if($this->validateModel($model)) {
            $resource = $model::all()->where("id", $id)->first();

            if(!empty($resource)) {
                $resource->delete();
                return response()->json($resource, 200);
            }
            return response()->json($resource, 404);
        }
        return response()->json(new \stdClass(), 500);
    }

    private function validateModel($classReference): bool {
        return class_exists($classReference) && is_subclass_of($classReference, Model::class);
    }
}
