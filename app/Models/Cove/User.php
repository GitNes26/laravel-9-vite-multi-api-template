<?php

namespace App\Models\cove;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Especificar la conexion si no es la por default
     * @var string
     */
    protected $connection = "mysql_cove";

    /**
     * Los atributos que se pueden solicitar.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role_id',
        'tel',
        'license_number',
        'payroll_number',
        'department_id',
        'name',
        'paternal_last_name',
        'maternal_last_name',
        'municipality_id',
        'colony_id',
        'address',
        'active',
        'deleted_at'
    ];

    /**
     * Los atributos que deben ocultarse para la serialización.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    /**
     * Nombre de la tabla asociada al modelo.
     * @var string
     */
    protected $table = 'users';

    /**
     * Obtener rol asociado con el user.
     */
    public function role()
    {   //primero se declara FK y despues la PK del modelo asociado
        return $this->belongsTo(Role::class,'role_id','id');
    }

    // public function games()
    // {
    //     return $this->hasMany(Game::class, 'game_user_id', 'id');
    // }

    /**
     * Valores defualt para los campos especificados.
     * @var array
     */
    protected $attributes = [
        'active' => true,
    ];
}
