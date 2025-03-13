<?php

namespace App\Models\Configuracion\Catalogos;

use App\Models\Configuracion\Usuarios\Catalogos\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    //Relación uno a muchos con la tabla company
    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}
