<?php

namespace App\Repositories;

use App\Models\Chamado;

class ChamadoRepository
{

    public function getAllChamados()
    {
        return Chamado::all();
    }

    public function getChamadoById($id)
    {
        return Chamado::findOrFail($id);
    }

    public function createChamado(array $dados){
        return Chamado::create($dados);
    }

    public function updateChamado(array $dados, $id){
        return Chamado::where('id', $id)->update($dados);
    }

    public function deleteChamado($id) 
    {
        return Chamado::where('id', $id)->delete();
    }
}