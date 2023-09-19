<?php

namespace App\Services;

use App\Repositories\ChamadoRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Http\Resources\ChamadoResource;

class ChamadoService
{
    protected $chamadoRepository;
    protected $baseController;

    public function __construct(
        BaseController $baseController, 
        ChamadoRepository $chamadoRepository,
    ){
        $this->baseController = $baseController;
        $this->chamadoRepository = $chamadoRepository;
    }

    public function findAll()
    {
        return $this->chamadoRepository->getAllChamados();
    }

    public function findById($id)
    {
        $chamado = $this->chamadoRepository->getChamadoById($id);

        return $chamado;
    }

    public function create(Request $request)
    {
        $usuario_logado = Auth::user();
        
        $dados = $request->only([
            'titulo',
            'descricao',
        ]);
        
        $dados['cliente_nome'] = $usuario_logado->name;
        $dados['cliente_id']   = $usuario_logado->id;
        $dados['status']       = 'Aberto';
        
        return $this->chamadoRepository->createChamado($dados);
    }

    public function edit(Request $request, $id)
    {
        $usuario_logado = Auth::user();
        
        $dados = $request->all();

        if($usuario_logado->type == 'colaborador'){
            $dados['colaborador_nome'] = $usuario_logado->name;
            $dados['colaborador_id']   = $usuario_logado->id;
            $dados['status']           = 'Em Andamento';
        }

        if($usuario_logado->type == 'cliente'){
            $dados['status'] = 'Concluído';
        }

        return $this->chamadoRepository->updateChamado($dados, $id);
    }
}