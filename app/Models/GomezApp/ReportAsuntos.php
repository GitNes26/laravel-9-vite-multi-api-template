<?php

namespace App\Models\GomezApp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportAsuntos extends Model
{
    protected $connection = 'mysql_gomezapp';
    protected $table = 'reportes_asuntos';
    public $timestamps = false;
}
