<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory;

     //Table Name
     protected $table = 'claim';

     public $primaryKey = 'id';
     public $timestamps = true;

     protected $fillable = [
        'date',
        'detail',
        'amount',
        'type',
        'receipt',
    ];  
}
