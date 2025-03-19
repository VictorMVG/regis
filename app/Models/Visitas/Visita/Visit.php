<?php

namespace App\Models\Visitas\Visita;

use App\Models\Catalogos\UnitColor;
use App\Models\Catalogos\UnitType;
use App\Models\Configuracion\Usuarios\Catalogos\Headquarter;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'headquarter_id',
        'visitor_name',
        'company_name',
        'reason',
        'to_see',
        'alcohol_test',
        'unit',
        'unit_plate',
        'unit_type_id',
        'unit_model',
        'unit_number',
        'unit_color_id',
        'comment',
        'exit_time',
        'updated_by',
        'exit_registered_by',
    ];

    protected $casts = [
        'exit_time' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    //relacion uno a muchos inversa con la tabla unit_types
    public function unitType()
    {
        return $this->belongsTo(UnitType::class);
    }

    //relacion uno a muchos inversa con la tabla unit_colors
    public function unitColor()
    {
        return $this->belongsTo(UnitColor::class);
    }

    //relacion uno a muchos inversa con la tabla users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //relacion uno a muchos inversa con la tabla headquarters
    public function headquarter()
    {
        return $this->belongsTo(Headquarter::class);
    }

    //relacion uno a muchos inversa con la tabla users
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    //relacion uno a muchos inversa con la tabla users
    public function exitRegisteredBy()
    {
        return $this->belongsTo(User::class, 'exit_registered_by');
    }
}
