<?php

namespace App\Http\Controllers;

use App\Models\ArquivoChamado;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\ArquivoChamadoService;
use Exception;

class ArquivosChamadosController extends BaseController
{
    protected $arquivo_chamado_service;

    public function __construct(ArquivoChamadoService $arquivo_chamado_service) {
        $this->arquivo_chamado_service = $arquivo_chamado_service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        try {
            $dados = $this->arquivo_chamado_service->upload($request);

            return $this->sendResponse($dados, null, 201);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), null, 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function download($arquivo_id)
    {
        try {
            $dados = $this->arquivo_chamado_service->download($arquivo_id);

            return $this->sendResponse($dados, null, 201);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete($arquivo_id)
    {
        try {
            $dados = $this->arquivo_chamado_service->delete($arquivo_id);

            return $this->sendResponse($dados, null, 201);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), null, 500);
        }
    }
}
