<?php

namespace App\Models\ingresos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tramitesSidit extends Model
{
    protected $connection = "sqlsrv_ingresos";
    protected $table = 'PVGeneral';
    /*
    * Los atributos que se pueden solicitar.
    * @var array<int, string>
    */
   protected $fillable = [
       'id'
   ];
    // protected $primaryKey = '';
}
