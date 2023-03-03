<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;
     //Table Name
     protected $table = 'leave';

     public $primaryKey = 'id';
     public $timestamps = true;
}
