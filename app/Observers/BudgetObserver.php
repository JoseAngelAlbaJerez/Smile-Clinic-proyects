<?php

namespace App\Observers;

use App\Models\Budget;
use App\Models\CXC;

class BudgetObserver
{
    public function saved(Budget $budget)
    {
        $this->updatePatientBalance($budget->patient_id);
    }

    public function deleted(Budget $budget)
    {
        $this->updatePatientBalance($budget->patient_id);
    }

    private function updatePatientBalance($patient_id)
    {
       
        $totalSum = Budget::where('patient_id', $patient_id)->sum('Total');

        
        CXC::where('patient_id', $patient_id)->update(['balance' => $totalSum]);
    }
}

