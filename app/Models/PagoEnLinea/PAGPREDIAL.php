<?php

namespace App\Models\PagoEnLinea;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PAGPREDIAL extends Model
{
    use HasFactory;
    protected $connection = "sql_pagos_en_linea";
    protected $table = 'PAGPREDIAL';
    public $timestamps = false;
}