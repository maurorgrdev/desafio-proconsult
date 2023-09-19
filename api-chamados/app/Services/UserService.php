<?php

namespace App\Services;

use App\Exceptions\LoginNaoAutorizadoException;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
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

    public function login(Request $request): JsonResponse
    {
        try {
            $user = $this->user_repository->getUserByEmail($request->email);

            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw new LoginNaoAutorizadoException();
            }
        
            $result['token'] = $user->createToken('token-name', [$user->type])->plainTextToken;
            $result['user']  = new UserResource($user);

            return response()->json([
                'success' => true,
                'data' => $result,
                'message' => 'Requisição feita com sucesso',
            ], 200);
        } catch (LoginNaoAutorizadoException $e) {
            return response()->json([
                'success' => false,
                'data' => $e->customErrorMessage(),
                'message' => $e->getMessage(),
            ], 400);
        }
        
    }
}