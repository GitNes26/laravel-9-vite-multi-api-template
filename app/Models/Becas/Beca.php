<?php

namespace App\Models\becas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beca extends Model
{
    use HasFactory;

    /**
     * Especificar la conexion si no es la por default
     * @var string
     */
    protected $connection = "mysql_becas";

    /**
     * Los atributos que se pueden solicitar.
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'folio',
        'tutor_full_name',
        'tutor_phone',
        'single_mother',
        'student_id',
        'school_id',
        'grade',
        'average',
        'comments',
        'socioeconomic_study',
        'active',
        'deleted_at'
    ];

    /**
     * Nombre de la tabla asociada al modelo.
     * @var string
     */
    protected $table = 'becas';

    /**
     * LlavePrimaria asociada a la tabla.
     * @var string
     */
    protected $primaryKey = 'id';


    /**
     * Obtener estudainte asociada con la beca.
     */
    public function student()
    {   //primero se declara FK y despues la PK del modelo asociado
        return $this->belongsTo(StudentData::class, 'student_id', 'id');
    }

    /**
     * Obtener escuela asociada con la beca.
     */
    public function school()
    {   //primero se declara FK y despues la PK del modelo asociado
        return $this->belongsTo(School::class, 'school_id', 'id');
    }


    /**
     * Obtener los usuarios relacionados a un rol.
     */
    // public function users()
    // {
    //     return $this->hasMany(User::class,'role_id','id'); //primero se declara FK y despues la PK
    // }

    /**
     * Valores defualt para los campos especificados.
     * @var array
     */
    // protected $attributes = [
    //     'active' => true,
    // ];
}