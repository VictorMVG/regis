<?php

namespace App\Models\Catalogos;

use App\Models\Bitacoras\Bitacora\Binnacle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class ObservationType extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    // Relación uno a muchos con la tabla binnacle
    public function binnacle()
    {
        return $this->hasMany(Binnacle::class);
    }
}
