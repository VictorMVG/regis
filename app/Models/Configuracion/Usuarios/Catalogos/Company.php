<?php

namespace App\Models\Configuracion\Usuarios\Catalogos;

use App\Models\Configuracion\Catalogos\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'company',
        'headquarter',
        'status_id'
    ];

    //Relación uno a muchos inversa con la tabla status
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    //Relación uno a muchos con la tabla user
    public function user()
    {
        return $this->hasMany(User::class);
    }
}
