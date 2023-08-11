<?php

namespace App\Models\Becas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    /**
     * Especificar la conexion si no es la por default
     * @var string
     */
    protected $connection = "mysql_becas";
    protected $table = 'schools';
    public $timestamps = false;
}