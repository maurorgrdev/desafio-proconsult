<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\ValidationException;  

class UserService
{
    protected $user_repository;

    public function __construct(UserRepository $user_repository) {
        $this->user_repository = $user_repository;
    }

    public function findAll(){
        return $this->user_repository->getAllUsers();
    }

    public function save(Request $request){        
        $data = $request->only([
            'name', 'email', 'password', 'type'
        ]);

        $data['password'] = Hash::make($request->password);

        $user = $this->user_repository->createUser($data);

        return $user;
    }

    public function login(Request $request)
    {
        $user = $this->user_repository->getUserByEmail($request->email);

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['As credênciais fornecidas estão incorretas.'],
            ]);
        }
     
        return $user->createToken('token-name', [$user->type])->plainTextToken;
    }
}