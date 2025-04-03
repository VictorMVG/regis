<?php

namespace App\Models\Bitacoras\Bitacora;

use App\Models\Catalogos\ObservationType;
use App\Models\Configuracion\Usuarios\Catalogos\Headquarter;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Binnacle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'headquarter_id',
        'observation_type_id',
        'title',
        'observation',
        'images',
        'updated_by',
        'created_at',
    ];

    protected $casts = [
        'images' => 'array',
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function headquarter()
    {
        return $this->belongsTo(Headquarter::class);
    }

    public function observationType()
    {
        return $this->belongsTo(ObservationType::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
