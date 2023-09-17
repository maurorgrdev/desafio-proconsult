<?php

namespace App\Http\Resources;

use App\Models\ArquivoChamado;
use Illuminate\Http\Resources\Json\JsonResource;

class ChamadoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        $arquivo_cliente = ArquivoChamado::where('chamado_id', $this->id)
                                         ->where('usuario_id', $this->cliente_id)
                                         ->first();

        $arquivo_colaborador = ArquivoChamado::where('chamado_id', $this->id)
                                             ->where('usuario_id', $this->colaborador_id)
                                             ->first();                              

        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'status' =>  $this->status,
            'cliente_id' => $this->cliente_id,
            'cliente_nome' => $this->cliente_nome,
            'cliente_resposta' => $this->cliente_resposta,
            'colaborador_id' => $this->colaborador_id,
            'colaborador_nome' => $this->colaborador_nome,
            'colaborador_resposta' => $this->colaborador_resposta,
            // PIPIPIPOPOPO 
            'cliente_arquivo' => $arquivo_cliente ? $arquivo_cliente : null,
            'colaborador_arquivo' => $arquivo_colaborador ? $arquivo_colaborador : null,
        ];
    }
}
