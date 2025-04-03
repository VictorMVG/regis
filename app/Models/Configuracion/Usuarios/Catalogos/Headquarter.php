<?php

namespace App\Models\Configuracion\Usuarios\Catalogos;

use App\Models\Bitacoras\Bitacora\Binnacle;
use App\Models\Configuracion\Catalogos\Status;
use App\Models\User;
use App\Models\Visitas\Visita\Visit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Headquarter extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'company_id',
        'name',
        'description',
        'status_id',
    ];

    // Relación uno a muchos inversa con la tabla company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Relación uno a muchos con la tabla user
    public function user()
    {
        return $this->hasMany(User::class);
    }

    // Relación uno a muchos inversa con la tabla status
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    // Relación uno a muchos con la tabla visits
    public function visit()
    {
        return $this->hasMany(Visit::class);
    }

    // Relación uno a muchos con la tabla binnacle
    public function binnacle()
    {
        return $this->hasMany(Binnacle::class);
    }
}
