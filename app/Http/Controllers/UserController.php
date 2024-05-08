<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Models\User;

class UserController extends Controller
{
    protected $userService;

    /**
     * Create a new UserController instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index() {
        $author = $this->userService->getAllUsers();
        return response()->json($author);
    }

    public function show($id) {
        $author = $this->userService->getUserById($id);
        return response()->json($author);
    }

    public function store(UserRequest $request) {

        $data = [
            'email' => $request['email'],
            'name' => $request['name'],
            'password' => $request['password'],
            'document' => $request['document'],
        ];
        
        $author = $this->userService->createUser($data);
        return response()->json($author);
    }

    public function update(UserRequest $request, $id) {

        $data = [
            'email' => $request['email'],
            'name' => $request['name'],
            'password' => $request['password'],
            'document' => $request['document'],
        ];

        $author = $this->userService->updateUser($data, $id);
        return response()->json($author);
    }

    public function delete($id) {
        $author = $this->userService->deleteUser($id);
        return response()->json(null);
    }
}