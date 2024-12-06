<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget_Header extends Model
{
    use HasFactory;
    protected $table = 'header_budgets';
    protected $fillable = [
       
        'patient_id',
        'c_x_c_id',
        'type',
        'Total',
        'budget_detail_id',
        
        

    ];
    public function patient()
    {
        return $this->belongsTo(Pacient::class, 'patient_id');
    }
    
    public function cxc()
{
    return $this->belongsTo(Cxc::class, 'c_x_c_id', 'id');
} 

public function budgetDetails()
{
    return $this->hasMany(Budget::class, 'budget_header_id');
}

}
