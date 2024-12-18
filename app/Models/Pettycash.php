<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pettycash extends Model
{
    use HasFactory;

    protected $table = 'petty_cash';
   
    protected $fillable = [      'name','amount','date'      ];
}
