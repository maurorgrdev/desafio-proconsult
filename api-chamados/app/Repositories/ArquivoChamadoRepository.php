<?php

namespace App\Repositories;

use App\Models\ArquivoChamado;

class ArquivoChamadoRepository
{
    public function getAllArquivosChamados()
    {
        return ArquivoChamado::all();
    }

    public function getArquivoChamadoById($id)
    {
        return ArquivoChamado::findOrFail($id);
    }

    public function createArquivoChamado(array $dados){
        return ArquivoChamado::create($dados);
    }

    public function updateArquivoChamado(array $dados, $id){
        return ArquivoChamado::where('id', $id)->update($dados);
    }

    public function deleteArquivoChamado($id) 
    {
        return ArquivoChamado::where('id', $id)->delete();
    }
}