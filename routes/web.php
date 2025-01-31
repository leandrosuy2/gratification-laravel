<?php

use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\GerenteController;
use App\Http\Controllers\PerfilAcessoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VotoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth:web')->get('/usuarios', [UsuarioController::class, 'index']);

Route::middleware('auth:web')->get('/perfil_acessos', [PerfilAcessoController::class, 'index']);

Route::middleware('auth:web')->group(function () {
    Route::get('/empresas', [EmpresaController::class, 'index'])->name('empresas.index');
    Route::get('/empresas/create', [EmpresaController::class, 'create'])->name('empresas.create');
    Route::post('/empresas', [EmpresaController::class, 'store'])->name('empresas.store');
    Route::get('/empresas/{id}', [EmpresaController::class, 'show'])->name('empresas.show');
    Route::get('/empresas/{id}/edit', [EmpresaController::class, 'edit'])->name('empresas.edit');
    Route::put('/empresas/{id}', [EmpresaController::class, 'update'])->name('empresas.update');
    Route::delete('/empresas/{id}', [EmpresaController::class, 'destroy'])->name('empresas.destroy');
});

Route::middleware('auth:web')->get('/gerentes', [GerenteController::class, 'index']);
Route::middleware('auth:web')->get('/gerentes/{id}', [GerenteController::class, 'show']);
Route::middleware('auth:web')->post('/gerentes', [GerenteController::class, 'store']);
Route::middleware('auth:web')->put('/gerentes/{id}', [GerenteController::class, 'update']);
Route::middleware('auth:web')->delete('/gerentes/{id}', [GerenteController::class, 'destroy']);

Route::middleware('auth:web')->get('/servicos', [ServicoController::class, 'index']);
Route::middleware('auth:web')->get('/servicos/{id}', [ServicoController::class, 'show']);
Route::middleware('auth:web')->post('/servicos', [ServicoController::class, 'store']);
Route::middleware('auth:web')->put('/servicos/{id}', [ServicoController::class, 'update']);
Route::middleware('auth:web')->delete('/servicos/{id}', [ServicoController::class, 'destroy']);

Route::post('/votar', [VotoController::class, 'votar'])->withoutMiddleware('auth:api');
Route::get('/votos', [VotoController::class, 'listarVotos']);

require __DIR__ . '/auth.php';
