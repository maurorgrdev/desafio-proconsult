<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\BaseController as BaseController;
use Exception;
use Illuminate\Http\JsonResponse;

class UserController extends BaseController
{
    protected $user_service;

    public function __construct(UserService $user_service) {
        $this->user_service = $user_service;
    }

    /**
     * Listar usuários cadastrados
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados = $this->user_service->findAll();

        return $this->sendResponse($dados, null, null);
    }

    /**
     * Adicionar novo usuário
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $dados = $this->user_service->save($request);

            return $this->sendResponse($dados, 'Registro feito com sucesso', 201);
        } catch (Exception $e) {
            return $this->sendResponse($e->getMessage(), null, 500);
        }
    }

    /**
     * Login de usuario com retorno de token
     * 
     * @param \Illuminate\Http\Request  $request
     */
    public function login(Request $request)
    {
        return $this->user_service->login($request);
    }
}
