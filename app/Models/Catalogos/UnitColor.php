<?php

namespace App\Models\Catalogos;

use App\Models\Visitas\Visita\Visit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitColor extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    //relacion uno a muchos con la tabla visits
    public function visit()
    {
        return $this->hasMany(Visit::class);
    }
}
