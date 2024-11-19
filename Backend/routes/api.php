<?php

use App\Http\Controllers\AportacionController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AreaEmpleadoTipoController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\FormulaController;
use App\Http\Controllers\FormulaParametroController;
use App\Http\Controllers\ParametroController;
use App\Http\Controllers\BancoController;
use App\Http\Controllers\CategoriaEmpleadoController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\ControlAsistenciaController;
use App\Http\Controllers\CuotaController;
use App\Http\Controllers\DetalleAportacionController;
use App\Http\Controllers\DetalleEgresoController;
use App\Http\Controllers\DetalleFamiliaController;
use App\Http\Controllers\DetalleIngresoController;
use App\Http\Controllers\EgresoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\EmpleadoTipoController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\LicenciaController;
use App\Http\Controllers\ParentescoController;
use App\Http\Controllers\PlanillaController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\RemuneracionController;
use App\Http\Controllers\SubCategoriaEmpleadoController;
use App\Http\Controllers\SubTipoEmpleadoController;
use App\Http\Controllers\TipoEmpleadoController;
use App\Http\Controllers\VacacionController;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth:api'])->group(function () {
    Route::get('/check-auth', [AuthController::class, 'checkAuth']); // Nueva ruta para verificar autenticación

    // Route::post('register', [AuthController::class, 'register']);
    // Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
    //Documento
    Route::apiResource('documentos', DocumentoController::class);
    //Formula
    Route::apiResource('formulas', FormulaController::class);
    //Parametro
    Route::apiResource('parametros', ParametroController::class);
    //FormulaParametro
    Route::apiResource('formula-parametro', FormulaParametroController::class);
    //TipoEmpleado
    Route::apiResource('tipo-empleados', TipoEmpleadoController::class);
    //SubTipoEmpleado
    Route::apiResource('sub-tipo-empleados', SubTipoEmpleadoController::class);
    //CategoriaEmpleado
    Route::apiResource('categoria-empleados', CategoriaEmpleadoController::class);
    //SubCategoriaEmpleado
    Route::apiResource('sub-categoria-empleados', SubCategoriaEmpleadoController::class);
    //Parentesco
    Route::apiResource('parentescos', ParentescoController::class);
    //Empleado  
    Route::apiResource('empleados', EmpleadoController::class);
    //DetalleFamilia
    Route::apiResource('detalle-familias', DetalleFamiliaController::class);
    //Banco
    Route::apiResource('bancos', BancoController::class);
    //EmpleadoTIpo
    Route::apiResource('empleado-tipos', EmpleadoTipoController::class);

    //ControlAsistencia
    Route::apiResource('control-asistencias', ControlAsistenciaController::class);
    //Contrato
    Route::apiResource('contratos', ContratoController::class);
    //Prestamo
    Route::apiResource('prestamos', PrestamoController::class);
    //Cuota
    Route::apiResource('cuotas', CuotaController::class);
    //Vacacion
    Route::apiResource('vacaciones', VacacionController::class);
    //Licencia
    Route::apiResource('licencias', LicenciaController::class);
    //Area
    Route::apiResource('areas', AreaController::class);
    //AreaEmpleadoTipo
    Route::apiResource('area-empleado-tipos', AreaEmpleadoTipoController::class);
    //Ingreso
    Route::apiResource('ingresos', IngresoController::class);
    //Egreso
    Route::apiResource('egresos', EgresoController::class);
    //Aportacion
    Route::apiResource('aportaciones', AportacionController::class);
    //DetalleIngreso
    Route::apiResource('detalle-ingresos', DetalleIngresoController::class);
    //DetalleEgreso
    Route::apiResource('detalle-egresos', DetalleEgresoController::class);
    //DetalleAportacion
    Route::apiResource('detalle-aportaciones', DetalleAportacionController::class);

    //Remuneracion
    /* Route::apiResource('remuneraciones', RemuneracionController::class);

    //Planilla
    Route::apiResource('planillas', PlanillaController::class); */

    //Listar Todos los EmpleadoTipo 
    Route::get('all-empleado-tipo/{id}', [EmpleadoTipoController::class, 'getEmpleadoTipoData']);

    //Generacion de reporte en Excel para Practicante
    Route::get('/exportar-reporte-practicante', [ExportController::class, 'exportExcel']);
});


//Generacion de Planilla para todos los EmpleadoTipo
Route::get('/generar-planilla', [PlanillaController::class, 'generarPlanilla']);
//Generacion de Planilla
Route::get('/generar-boleta/{id_tipo_empleado}/{num_doc_iden}', [PlanillaController::class, 'generarBoletaIndividual']);


Route::get('/test', [PlanillaController::class, 'testing']);



Route::post('/google-login', [AuthController::class, 'googleLogin']);
