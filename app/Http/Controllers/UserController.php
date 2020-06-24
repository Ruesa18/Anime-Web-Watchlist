<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserController extends Controller {
    private $rules = [
        'username' => 'required|unique:User|string|max:100',
        'email' => 'required|email|unique:User',
        'password' => 'required',
        'roleFk' => 'required|exists:Role,id'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        $users = User::all();
        return response()->json($users, 200);
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

        $role = User::create($data);
        return response()->json($role, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id) {
        $user = User::all()->where("id", $id)->first();
        if(!empty($role)) {
            return response()->json($user, 200);
        }
        return response()->json($user, 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id) {
        $user = User::all()->where("id", $id)->first();

        if(!empty($user)) {
            $data = $request->input();
            $validator = Validator::make($data, $this->rules);

            if($validator->fails()) {
                return response()->json($validator->errors(), 409);
            }

            $user->fill($data);
            $user->save();
            return response()->json($user, 200);
        }
        return response()->json($user, 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id) {
        $user = User::all()->where("id", $id)->first();

        if(!empty($user)) {
            $user->delete();
            return response()->json($user, 200);
        }
        return response()->json($user, 404);
    }
}
