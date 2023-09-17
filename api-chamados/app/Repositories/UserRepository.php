<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getAllUsers()
    {
        return User::all();
    }

    public function getUserById($id)
    {
        return User::findOrFail($id);
    }

    public function getUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function createUser(array $dados){
        return User::create($dados);
    }

    public function updateUser(array $dados, $id){
        return User::where('id', $id)->update($dados);
    }

    public function deleteUser($id) 
    {
        return User::where('id', $id)->delete();
    }
}