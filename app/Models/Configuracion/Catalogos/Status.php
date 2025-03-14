<?php

namespace App\Models\Configuracion\Catalogos;

use App\Models\Configuracion\Usuarios\Catalogos\Company;
use App\Models\Configuracion\Usuarios\Catalogos\Headquarter;
use App\Models\User;
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
    public function company()
    {
        return $this->hasMany(Company::class);
    }

    //Relación uno a muchos con la tabla user
    public function user()
    {
        return $this->hasMany(User::class);
    }

    //Relación uno a muchos con la tabla headquarter
    public function headquarter()
    {
        return $this->hasMany(Headquarter::class);
    }
}
