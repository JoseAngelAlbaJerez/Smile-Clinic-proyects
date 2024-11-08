<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pacient extends Model
{
    use HasFactory;
    protected $table = 'pacient';
    protected $primaryKey = 'pacient_id'; 
    protected $fillable = [
        'fecha', 'ars', 'name', 'age', 'complications', 'complication_detail',
        'alergies', 'alergies_detail', 'drugs', 'drugs_detail', 'motive', 'date',
        'address','Cedula','phone',
    ];
    

    public $incrementing = true;

    public function odontodiagramas() {
        return $this->hasMany(Odontodiagrama::class, 'patient_id');
    }
    public function cxc() {
        return $this->hasOne(CXC::class, 'patient_id');
    }
 

}
