<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Wallet;

class EloquentUserRepository implements UserRepositoryInterface {

    public function getAll()
    {
        return User::get();
    }

    public function getById($id)
    {
        return User::find($id);
    }

    public function getByName(string $name)
    {
        return User::where('name', 'like', "%$name%");

    }

    public function create(array $data)
    {
        $user = User::create($data);

        $wallet = new Wallet();
        $wallet->user_id = $user->id;
        $wallet->balance = 0;
        $wallet->save();
    
        return $user;
    }

    public function update(array $data, $id)
    {
        $users = User::findOrFail($id);
        $users->update($data);
        return $users;
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    }

}