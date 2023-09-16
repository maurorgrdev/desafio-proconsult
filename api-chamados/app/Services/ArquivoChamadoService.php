<?php

namespace App\Services;

use App\Models\ArquivoChamado;
use App\Repositories\ArquivoChamadoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArquivoChamadoService
{
    protected $arquivo_chamado_repository;

    public function __construct(ArquivoChamadoRepository $arquivo_chamado_repository) {
        $this->arquivo_chamado_repository = $arquivo_chamado_repository;
    }

    public function upload(Request $request)
    {
        $usuario_logado = Auth::user();

        $path_final = Storage::disk('local')->put('chamado/'. $usuario_logado->perfil.'/' . $request->chamado_id. '/' , $request->file('file'));
        
        $array_name_file = explode("/", $path_final);

        $upload = array(
            'usuario_id' => $usuario_logado->id,
            'chamado_id' => $request->chamado_id,
            'name' => $request->name,
            'filename' => $array_name_file[(count($array_name_file) - 1)],
            'path' => 'chamado/'. $usuario_logado->perfil,
        );

        return $this->arquivo_chamado_repository->createArquivoChamado($upload);
    }

    public function download($arquivo_chamado_id)
    {
        $arquivo = $this->arquivo_chamado_repository->getArquivoChamadoById($arquivo_chamado_id);
        
        $arquivo = Storage::path($arquivo->path. '/'. $arquivo->chamado_id. '/'. $arquivo->filename);

        return response()->file($arquivo);
    }

    public function deleteArquivo($arquivo_chamado_id){
        $arquivo = $this->arquivo_chamado_repository->getArquivoChamadoById($arquivo_chamado_id);

        Storage::delete($arquivo->path. '/'. $arquivo->chamado_id. '/'. $arquivo->filename);

        return $this->arquivo_chamado_repository->deleteArquivoChamado($arquivo_chamado_id);
    }
}