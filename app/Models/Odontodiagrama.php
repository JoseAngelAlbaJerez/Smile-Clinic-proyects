<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pacient;
class Odontodiagrama extends Model
{
    use HasFactory;

    protected $fillable = ['patient_id', 'caries', 'restauraciones', 'extracciones', 'image_path', 'ausencias', 'puentes', 'endodoncias', 'implantes'];
 // Define the relationship between Odontodiagrama and Patient
 public function patient()
 {
     return $this->belongsTo(Pacient::class, 'pacient_id', 'pacient_id');
 }
}
