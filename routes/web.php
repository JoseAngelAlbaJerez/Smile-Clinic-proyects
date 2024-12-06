<?php

use App\Http\Controllers\Budget_HeaderController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CXCController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RXController;
use App\Http\Controllers\User_RoleController;
use App\Models\Budget_Header;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OdontographController;
use Spatie\GoogleCalendar\Event;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AbonoController;
use App\Http\Controllers\EventController    ;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// return view('welcome');


Auth::routes();
//Grupo de Autenticacion
Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //Pacientes
    Route::get('/patient/', [PatientController::class, 'index'])->name('patient.index');
    Route::get('/patientscalled/', [PatientController::class, 'patientscalled'])->name('patient.called');
    Route::get('/patient/create', [PatientController::class, 'create'])->name('patient.create');
    Route::get('/patient/{id}', [PatientController::class, 'show'])->name('patient.show');
    Route::get('/patient/{id}/edit', [PatientController::class, 'edit'])->name('patient.edit');
    Route::put('/patient/{id}/update',[PatientController::class, 'update'])->name('patient.update');
    Route::delete('/patient/{id}/destroy', [PatientController::class, 'destroy'])->name('patient.destroy');
    Route::get('/patient/budget', [PatientController::class, 'budget'])->name('patient.budget');
    Route::post('/patient/search', [PatientController::class, 'search'])->name('patient.search');
    Route::post('/patient/store', [PatientController::class, 'store'])->name('patient.store');


    //Odontodiagramas
    Route::get('/odontographchild/{pacient_id}', function ($pacient_id) {
        return view('odontograph/odontogrampediatry', ['pacient_id' => $pacient_id]);
    })->name('odontographchild');
    
    Route::get('/odontograph/{pacient_id}', function ($pacient_id) {
        return view('odontograph/odontogramadult', ['pacient_id' => $pacient_id]);
    })->name('odontograph');
    
    Route::post('/saveData', [OdontographController::class, 'saveData']);
   
    Route::get('/odontograph',[OdontographController::class,'index'])->name('odontograph.index');
    Route::get('/odontograph/{id}/show',[OdontographController::class,'show'])->name('odontograph.show');
    Route::get('/odontograph/{id}/edit', [OdontographController::class, 'edit'])->name('odontograph.edit');
    Route::post('/odontograph/update/{id}', [OdontographController::class, 'update'])->name('odontograph.update');
    Route::get('/odontographchild/{id}/edit', [OdontographController::class, 'editchild'])->name('odontographchild.edit');
    Route::post('/odontographchild/update/{id}', [OdontographController::class, 'updatechild'])->name('odontographchild.update');

    Route::delete('/odontograph/{id}/destroy',[OdontographController::class,'destroy'])->name('odontograph.destroy');

    //Presupuesto
    Route::get('/budget/{odontodiagram_id}', [OdontographController::class, 'showBudget'])->name('showBudget');
    Route::get('/budgets/index',[BudgetController::class,'index'])->name('budget.index');
    Route::post('/store.budgets',[BudgetController::class,'store'])->name('store.budgets');
    Route::delete('/delete/budgets',[BudgetController::class,'destroy'])->name('delete.budgets');
    Route::delete('/budgets/{id}/delete', [BudgetController::class, 'delete'])->name('delete.budget');
    Route::get('/budgets/{id}/edit/{pacientid}', [BudgetController::class, 'edit'])->name('budgets.edit');
    Route::put('/budget/update', [BudgetController::class, 'update'])->name('budgets.update');
    Route::put('/budgets/update', [BudgetController::class, 'updateBudgets'])->name('update.budgets');

    //Presupuesto Encabezado
    Route::post('/store/budgets_header',[Budget_HeaderController::class,'store'])->name('budget_header.store');
    Route::put('/update/{id}/budgets_header',[Budget_HeaderController::class,'update'])->name('budget_header.update');
    //Recetas
    Route::get('/RX',[RXController::class,'index'])->name('RX.index');
    Route::get('/RX/create',[RXController::class,'create'])->name('RX.create');
    Route::get('/RX/{id}',[RXController::class,'show'])->name('RX.show');
    Route::get('/RX/{id}/edit',[RXController::class,'edit'])->name('RX.edit');
    Route::put('/RX/{id}/update',[RXController::class, 'update'])->name(name: 'RX.update');
    Route::post('/RX/store', [RXController::class, 'store'])->name('RX.store');
    Route::delete('/RX/{id}/destroy', [RXController::class, 'destroy'])->name('RX.destroy');
   
    //Ajustes
    Route::get('/settings', [SettingController::class,'index'])->name('setting.index');

    //Seguro Medico
    Route::get('/insurance/create', [InsuranceController::class,'create'])->name('insurance.create');

    //User 
    Route::get('/user/index',[User_RoleController::class,'index'])->name('user.index');

    //Module
    Route::get('/module/load',[ModuleController::class,'load'])->name('module.load');
    Route::get('/module/get',[ModuleController::class,'GetModules'])->name('GetModules');
    Route::post('/module/store',[ModuleController::class,'store'])->name('module.store');
    Route::delete('/module/delete/{id}', [ModuleController::class,'delete'])->name('module.delete');

    //Profile
    Route::get('/profile/load',[ProfileController::class,'load'])->name('profile.load');
    Route::post('/profile/GetModulesByProfile', [ProfileController::class, 'GetModulesByProfile'])->name('profile.GetModulesByProfile');
    Route::post('/profile/store',[ProfileController::class,'store'])->name('profile.store');
    Route::delete('/profile/delete/{id}', [ProfileController::class,'delete'])->name('profile.delete');
    Route::post('/storeprofile_modules',[ProfileController::class,'storeprofile_modules'])->name('storeprofile_modules');
  
    //Reports

    //Report View
    Route::get('/reports/',[ReportController::class,'index'])->name('report.index');

    Route::post('/generate-report', [ReportController::class, 'generate'])->name('report.generate');
    Route::get('budgets/pdf/{patient_id}/{budgets?}', [BudgetController::class, 'generatePDF'])->name('budgets.pdf');
    Route::get('budgetsCXC/pdf/{patient_id}/{budgetIds}', [BudgetController::class, 'generatePDFCXC'])->name('budgetsCXC.pdf');
    Route::post('/abonos/pdf/{id}', [AbonoController::class, 'report'])->name('abonos.pdf');
    Route::post('/income/pdf', [IncomeController::class, 'report'])->name('income.pdf');
    Route::post('/expenses/pdf', [ExpensesController::class, 'report'])->name('expenses.pdf');
    Route::get('CXCReceipt/pdf/{patient_id}/{abonosEncoded?}', [CXCController::class, 'generateReceiptPDF'])->name('CXCReceipt.pdf');
    Route::post('/get-selected-meds', [RXController::class, 'getSelectedMeds'])->name('meds.selected');
    Route::post('/get-selected-meds-with-patient', [RXController::class, 'getSelectedMedswithPatients'])->name('meds.selectedwithpatient');
    Route::post('/income/{reportType}/pdf', [IncomeController::class, 'generateReport'])->name('income.report.generate');

    Route::get('/budgets/{id}/print', [BudgetController::class, 'print'])->name('budgets.print');
    Route::get('/abono/{id}/print', [AbonoController::class, 'print'])->name('abono.print');
   //CXC
    Route::get('/CXC', [CXCController::class,'index'])->name('CXC.index');
    Route::get('/CXC/create',[CXCController::class,'create'])->name('CXC.create');
    Route::get('/filtrar-budgets/{id}', [CXCController::class, 'filtrarBudgets']);
    Route::post('CXC/store', [CXCController::class, 'store'])->name('CXC.store');
    Route::put('/CXC/{id}/update',[CXCController::class, 'update'])->name('CXC.update');
    Route::delete('/cxc/{id}', [CXCController::class, 'destroy'])->name('delete.cxc');


    //Abonos
    Route::post('/Abono/store', [AbonoController::class, 'store'])->name('Abono.store');
    Route::get('/Abono/{id}',[CXCController::class,'show'])->name('Abono.show');
   Route::delete('/Abono/delete/{id}',[AbonoController::class,'destroy'])->name('Abono.destroy');


   //Citas
    Route::get('/events',[EventController::class, 'index'])->name('events.index');
    Route::get('/events/create',[EventController::class, 'create'])->name('events.create');
Route::post('/events/store', [EventController::class, 'store'])->name('events.store');
Route::get('/events/list',[EventController::class, 'list'])->name('events.list');
Route::get('/events/{id}/edit',[EventController::class,'edit'])->name('events.edit');
Route::patch('/events/{id}/update', [EventController::class, 'update'])->name('events.update');
Route::delete('/events/{id}/destroy', [EventController::class, 'destroy'])->name('events.destroy');
   
    //Ingresos
    Route::get('/income',[IncomeController::class, 'index'])->name('income.index');
    //Egresos
    Route::get('/expenses',[ExpensesController::class, 'index'])->name('expenses.index');
    Route::get('/expenses/create',[ExpensesController::class,'create'])->name('expenses.create');
    Route::post('expenses/store', [ExpensesController::class, 'store'])->name('expenses.store');
    Route::get('/expenses/{id}/edit',[ExpensesController::class,'edit'])->name('expenses.edit');
    Route::delete('/expenses/{id}/destroy', [ExpensesController::class, 'destroy'])->name('expenses.destroy');
    Route::put('/expenses/{id}/update',[ExpensesController::class, 'update'])->name('expenses.update');
    Route::post('/expenses/pdf/daily', 'ExpensesController@generateDailyReport');
    Route::post('/expenses/pdf/weekly', 'ExpensesController@generateWeeklyReport');
    Route::post('/expenses/pdf/biweekly', 'ExpensesController@generateBiweeklyReport');
    Route::post('/expenses/pdf/monthly', 'ExpensesController@generateMonthlyReport');
});
