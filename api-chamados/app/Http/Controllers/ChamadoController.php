<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChamadoService;
use Exception;
use Illuminate\Http\JsonResponse;

class ChamadoController extends Controller
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
        return $this->chamado_service->findAll();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->chamado_service->create($request);
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
            ];
        }
        
        return response()->json($result, $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->chamado_service->findById($id);
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
        return $this->chamado_service->edit($request, $id);
    }
}
