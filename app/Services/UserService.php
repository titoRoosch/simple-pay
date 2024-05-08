<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Repositories\UserRepositoryInterface;

class UserService {

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers()
    {
        return $this->userRepository->getAll();
    }

    public function getUserById($id)
    {
        return $this->userRepository->getById($id);
    }

    public function getUserByName(string $name)
    {
        return $this->userRepository->getByName($name);

    }

    public function createUser(array $data)
    {
        $rules = [
            'email' => 'required|string|max:255|unique:users,email',
            'name' => 'required|string|max:255',
            'password' => 'required|string',
            'document' => 'required|string|max:14|unique:users,document',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errorsArray = $errors->toArray();
            
            return $errorsArray;
        }

        return $this->userRepository->create($data);
    }

    public function updateUser(array $data, $id)
    {
        $rules = [
            'email' => 'required|string|max:255|unique:users,email,' . $id,
            'name' => 'required|string|max:255',
            'password' => 'required|string',
            'document' => 'required|string|max:14|unique:users,document',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errorsArray = $errors->toArray();
            
            return $errorsArray;
        }

        return $this->userRepository->update($data, $id);
    }

    public function deleteUser($id)
    {
        return $this->userRepository->delete($id);
    }

}