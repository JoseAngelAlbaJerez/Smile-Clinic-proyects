<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CXC extends Model
{
    use HasFactory;
    protected $fillable = ['balance', 'patient_id', 'status','total'];
    protected $table = '_c_x_c';
    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }
    public function budgetheader()
    {
        return $this->hasMany(Budget_Header::class);
    }
    public function abonos(){
        return $this->hasMany(Abono::class);
    }
    public function patient() {
        return $this->belongsTo(Pacient::class, 'patient_id');
    }
    
}
