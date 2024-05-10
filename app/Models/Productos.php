<?php

namespace App\Models;

use App\Models\Negocios;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Productos extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'negocio_id',
        'nombre',
        'imagen',
        'descripcion',
        'costo',
        'estado',
    ];
    // Relación con productos
    public function negocio(){
        return $this->belongsTo(Negocios::class, 'negocio_id');
    }

    public function getImagenUrl(){
        if($this->imagen && $this->imagen != 'default.png' && $this->imagen != null){
            return asset('imagenes/productos/' . $this->imagen);
        } else {
            return asset('default.png');
        }
    }
}
