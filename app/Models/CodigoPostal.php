<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodigoPostal extends Model
{
    protected $connection = "mysql_communities";

    protected $table = 'db_communities.vista_cp';
}
