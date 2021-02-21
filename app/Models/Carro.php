<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'link',
        'nome_veiculo',
        'img',
        'ano',
        'quilometragem',
        'combustivel',
        'cambio',
        'portas',
        'cor'
    ];

    public function user()
    {
       return $this->hasOne(User::class);
    }

    // use HasFactory;
}
