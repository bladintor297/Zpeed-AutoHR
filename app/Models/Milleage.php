<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Milleage extends Model
{
    use HasFactory;
    
    //Table Name
    protected $table = 'milleage';

    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
       'date',
       'vehicle',
       'origin',
       'destination',
   ];  
}
