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
        return $this->getAll(Role::class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) {
        return $this->validateAndAdd($request, Role::class, $this->rules);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id) {
        return $this->getById(Role::class, $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id) {
        return $this->validateAndUpdate($request, Role::class, $id, $this->rules);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id) {
        return $this->removeResource(Role::class, $id);
    }
}
