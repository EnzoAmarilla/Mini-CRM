<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $fillable = [
        'nombre', 'email', 'logotipo', 'sitio_web', 'created_at', 'updated_at'
    ];
}
