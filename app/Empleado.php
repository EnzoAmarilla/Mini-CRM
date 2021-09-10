<?php

namespace App;

use App\Empresa;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $fillable = [
        'nombre', 'apellido', 'empresa_id', 'email', 'telefono', 'created_at', 'updated_at'
    ];

    public function empresa() {
        return $this->hasOne(Empresa::class, 'id', 'empresa_id');
    }
}
