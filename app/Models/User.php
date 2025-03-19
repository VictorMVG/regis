<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Configuracion\Catalogos\Status;
use App\Models\Configuracion\Usuarios\Catalogos\Company;
use App\Models\Configuracion\Usuarios\Catalogos\Headquarter;
use App\Models\Visitas\Visita\Visit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'company_id',
        'headquarter_id',
        'status_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    //Relacion uno a muchos inversa con la tabla company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    //Relacion uno a muchos inversa con la tabla status
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    //Relacion uno a muchos inversa con la tabla headquarters
    public function headquarter()
    {
        return $this->belongsTo(Headquarter::class);
    }

    //Relacion uno a muchos con la tabla visits
    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    // Relación uno a muchos con la tabla visits (registros actualizados por el usuario)
    public function updatedVisits()
    {
        return $this->hasMany(Visit::class, 'updated_by');
    }

    // Relación uno a muchos con la tabla visits (registros de salida registrados por el usuario)
    public function exitRegisteredVisits()
    {
        return $this->hasMany(Visit::class, 'exit_registered_by');
    }
}
