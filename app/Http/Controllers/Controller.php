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

    protected function validateAndUpdate(Request $request, $model, int $id, array $rules): JsonResponse {
        if($this->validateModel($model)) {
            $resource = $model::all()->where("id", $id)->first();
            if(!empty($model)) {
                $data = $request->input();
                $validator = Validator::make($data, $rules);

                if($validator->fails()) {
                    return response()->json($validator->errors(), 409);
                }

                $resource->fill($data);
                $resource->save();
                return response()->json($resource, 200);
            }
            return response()->json($resource, 404);
        }
        return response()->json(new \stdClass(), 500);
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
