<?php

namespace App\Models;

use App\Http\Controllers\CXCController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abono extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'procedure',
        'treatment',
        'quantity',
        'amount',
        'coberture',
        'discount',
        'total',
        'patient_id',
        'c_x_c_id',
        'abonar',
    ];
    public function patient()
    {
        return $this->belongsTo(Pacient::class, 'pacient_id', 'patient_id');
    }
    
    public function CXC()
{
    return $this->belongsTo(CXC::class, 'c_x_c_id', 'id');
}
}