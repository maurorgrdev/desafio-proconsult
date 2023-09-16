<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chamado extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'chamados';

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'titulo' => '',
        'descricao' => '',
        'status' => '',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titulo',
        'descricao',
        'status',
        'cliente_id',
        'cliente_nome',
        'colaborador_id',
        'colaborador_nome',
        'cliente_resposta',
        'colaborador_resposta',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
}
