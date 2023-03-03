<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRecord extends Model
{
    use HasFactory;
     //Table Name
     protected $table = 'leave_record';

     public $primaryKey = 'id';
     public $timestamps = true;
}
