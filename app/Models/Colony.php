<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colony extends Model
{
    protected $connection = "mysql_communities";
    protected $table = 'colonies';
    public $timestamps = false;
}
