<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Usuario\ShowUsuarios;
use App\Http\Livewire\Lead\NuevoLead;
use App\Http\Livewire\Oportunidad\NuevaOportunidad;

use App\Http\Controllers\LeadsController;
use App\Http\Controllers\OportunidadController;
use App\Http\Controllers\CotizacionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
})->middleware('auth');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/usuarios',ShowUsuarios::class)->name('usuarios')->middleware('auth');

Route::get('/actividades',function (){return view('actividades.calendario_actividades');})->name('actividades')->middleware('auth');

Route::get('/nuevo_lead',NuevoLead::class)->name('nuevo_lead')->middleware('auth');
Route::get('/base_leads',[LeadsController::class,'base_leads'])->middleware('auth')->name('base_leads');

Route::get('/nueva_oportunidad',NuevaOportunidad::class)->name('nueva_oportunidad')->middleware('auth');
Route::get('/base_oportunidades',[OportunidadController::class,'base_oportunidades'])->middleware('auth')->name('base_oportunidades');

Route::get('/cotizaciones/{id_oportunidad}',[CotizacionController::class,'cotizaciones'])->middleware('auth')->name('cotizaciones');
