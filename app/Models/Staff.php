<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    //Table Name
    protected $table = 'staff';

    public $primaryKey = 'id';
    public $timestamps = true;
}
