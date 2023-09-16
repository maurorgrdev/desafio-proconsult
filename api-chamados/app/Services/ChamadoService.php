<?php

namespace App\Services;

use App\Models\Chamado;
use App\Repositories\ChamadoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChamadoService
{
    protected $chamado_repository;

    public function __construct(ChamadoRepository $chamado_repository) {
        $this->chamado_repository = $chamado_repository;
    }

    public function create(Request $request)
    {
        // $usuario_logado = Auth::user();

        $dados = $request->only([
            'titulo',
            'descricao',
        ]);
        
        // $dados['cliente_nome'] = $usuario_logado->nome;
        // $dados['cliente_id']   = $usuario_logado->id;
        $dados['status']           = 'Aberto';
        print_r($dados);
        return $this->chamado_repository->createChamado($dados);
    }

    public function edit(Request $request, $id)
    {
        $usuario_logado = Auth::user();
        
        $dados = $request->all();

        if($usuario_logado->tipo == 'colaborador'){
            $dados['colaborador_nome'] = $usuario_logado->nome;
            $dados['colaborador_id']   = $usuario_logado->id;
            $dados['status']           = 'Em Andamento';
        }

        if($usuario_logado->tipo == 'cliente'){
            $dados['status'] = 'Concluído';
        }

        return $this->chamado_repository->updateChamado($dados, $id);
    }

    public function findAll()
    {
        $chamados = $this->chamado_repository->getAllChamados();

        return $chamados;
    }

    public function findById($id)
    {
        $chamado = $this->chamado_repository->getChamadoById($id);

        return $chamado;
    }
}