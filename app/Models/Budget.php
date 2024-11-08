<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'procedure',
        'treatment',
        'quantity',
        'amount',
        'coberture',
        'discount',
        'patient_id',
        'total',
        'type',
        'budget_header_id',
        'c_x_c_id',
        

    ];
    public function patient()
    {
        return $this->belongsTo(Pacient::class, 'patient_id');
    }
    
    public function cxc()
{
    return $this->belongsTo(Cxc::class, 'c_x_c_id', 'id');
}
public function budgetHeader()
{
    return $this->belongsTo(Budget_Header::class, 'budget_header_id');
}
}
