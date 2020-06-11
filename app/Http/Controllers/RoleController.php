<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller {
    private $rules = [
        'name' => 'required|unique:Role|max:50',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        $roles = Role::all();
        return response()->json($roles, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) {
        $data = $request->input();
        $validator = Validator::make($data, $this->rules);

        if($validator->fails()) {
            return response()->json($validator->errors(), 409);
        }

        $role = Role::create($data);
        return response()->json($role, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id) {
        $role = Role::all()->where("id", $id)->first();

        if(!empty($role)) {
            return response()->json($role, 200);
        }
        return response()->json($role, 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Role $role) {
        $data = $request->input();
        $validator = Validator::make($data, $this->rules);

        if($validator->fails()) {
            return response()->json($validator->errors(), 409);
        }

        $role->fill($data);
        $role->save();
        return response()->json($role, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id) {
        $role = Role::all()->where("id", $id)->first();

        if(!empty($role)) {
            $role->delete();
            return response()->json($role, 200);
        }
        return response()->json($role, 404);
    }
}
