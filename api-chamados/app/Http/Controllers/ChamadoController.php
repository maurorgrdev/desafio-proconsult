<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChamadoService;
use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseController;

class ChamadoController extends BaseController
{
    protected $chamado_service;

    public function __construct(ChamadoService $chamado_service) {
        $this->chamado_service = $chamado_service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados = $this->chamado_service->findAll();

        return $this->sendResponse($dados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $result = $this->chamado_service->create($request);

            return $this->sendResponse($result, 'Registro feito com sucesso', 201);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), null, $code = 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $dados = $this->chamado_service->findById($id);

            return $this->sendResponse($dados, null, 200);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), null, $code = 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $result = $this->chamado_service->edit($request, $id);

            return $this->sendResponse($result, 'Registro atualizado com sucesso', 201);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), null, $code = 500);
        }
    }
}
