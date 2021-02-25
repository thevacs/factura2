<?php

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
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/validacion', 'HomeController@validacion')->name('validacion');
Route::get('/getDivisa', 'DivisaController@getDivisas')->name('getDivisa');
Route::resource('monedas', 'MonedaController');

Route::resource('impuestos', 'ImpuestoController');

Route::get('getListProductos', 'ProductoController@lists');
Route::get('getProducto/{producto}', 'ProductoController@getProducto');
Route::resource('productos', 'ProductoController');

Route::resource('tasas', 'TasaController');
Route::resource('aportes', 'AporteController');

Route::get('/contenedor/getContenedorsLocal', 'DataController@getContenedorsLocal')->name('contenedor.getContenedorsLocal');
Route::get('/contenedor/{numero}/getContenedorLocalData', 'DataController@getContenedorLocalData')->name('contenedor.getContenedorLocalData');
Route::get('/contenedor/getDataContenedors', 'DataController@getDataContenedors')->name('contenedor.getDataContenedors');
Route::get('/contenedor/{numero}', 'DataController@getContenedor')->name('contenedor.getContenedor');
Route::resource('/contenedores', 'ContenedorController');

Route::get('/inventarios/autocomplete', 'InventarioController@autocomplete')->name('inventarios.autocomplete');
Route::get('/inventarios/getItems', 'InventarioController@getItems')->name('inventarios.getItems');
Route::get('/inventarios/{neddle}/searchItem', 'InventarioController@searchItem')->name('inventarios.searchItem');
Route::resource('inventarios', 'InventarioController');

Route::delete('manifiestos/{manifiesto}/destroyContenedores', 'ManifiestoController@destroyContenedores')->name('manifiestos.destroyContenedores');
Route::delete('manifiestos/{manifiesto}/contenedores/{contenedor}', 'ManifiestoController@destroyContenedor')->name('manifiestos.destroy.contenedor');
Route::match(['put', 'patch'], 'manifiestos/{manifiesto}/contenedores/{contendor}', 'ManifiestoController@updateContenedor')->name('manifiestos.update.contenedor');
Route::match(['put', 'patch'], 'manifiestos/{manifiesto}/contenedores', 'ManifiestoController@uploadContenedor')->name('manifiestos.upload.contenedor');
Route::get('manifiestos/{manifiesto}/procesar', 'ManifiestoController@procesar')->name('manifiestos.procesar');

Route::resource('manifiestos', 'ManifiestoController');

Route::get('/clientes/autocomplete', 'ClienteController@autocomplete')->name('clientes.autocomplete');
Route::post('/clientes/getCliente', 'ClienteController@getCliente')->name('clientes.getCliente');
Route::resource('/clientes', 'ClienteController');

Route::get('/preliquidaciones/{preliquidacion}/printPreliquidacion', 'PreliquidacioneController@printPreliquidacion')->name('preliquidaciones.printPreliquidacion');
Route::get('/reporte-preliquidaciones', 'PreliquidacioneController@reporte')->name('preliquidaciones.reporte.index');
Route::resource('/preliquidaciones', 'PreliquidacioneController');
Route::post('/preliquidaciones/{preliquidacion}/anular', 'PreliquidacioneController@anular')->name('preliquidaciones.anular');

Route::get('/exoneraciones/{exoneracion}/printExoneracion', 'ExoneracionController@printPreliquidacion')->name('exoneraciones.printPreliquidacion');
Route::get('/reporte-exoneraciones', 'ExoneracionController@reporte')->name('exoneraciones.reporte.index');
Route::resource('/exoneraciones', 'ExoneracionController');
Route::post('/exoneraciones/{exoneracion}/anular', 'ExoneracionController@anular')->name('exoneraciones.anular');

Route::resource('/creditos', 'CreditosController');

Route::get('/facturas/reportes', 'FacturaController@reporte')->name('facturas.reporte');
Route::get('/facturas/reportes-excel', 'FacturaController@reporteExcel')->name('facturas.reporte-excel');
Route::get('/facturas/{factura}/printer', 'FacturaController@printer')->name('facturas.printer');
Route::get('/facturas/{factura}/printerFiscal', 'FacturaController@printerFiscal')->name('facturas.printer_fiscal');
Route::get('/facturas/{factura}/fiscal.txt', 'FacturaController@printerFiscal2')->name('facturas.printer_fiscal2');
Route::put('/facturas/{factura}/anular', 'FacturaController@anular')->name('facturas.anular');
Route::get('/facturas/preliquidar', 'FacturaController@preliquidar')->name('facturas.preliquidar');
Route::post('/facturas/getPreliquidacion', 'FacturaController@getPreliquidacion')->name('facturas.getPreliquidacion');
Route::get('/facturas/{preliquidacion}/printPreliquidacion', 'FacturaController@printPreliquidacion')->name('facturas.printPreliquidacion');
Route::resource('/facturas', 'FacturaController');

// Arqueo de Caja
Route::get('/arqueo-caja/{fecha}', 'ArqueoCajaController@index')->name('arqueo.index');
Route::get('/arqueo-caja/{fecha}/{taquilla}', 'ArqueoCajaController@taquilla')->name('arqueo.taquilla');

Route::get('/anulacion/{anulacion}/fiscal.txt', 'AnulacionFiscalController@fiscal')->name('anulacion.fiscal');
Route::get('/anulacion/{anulacion}', 'AnulacionFiscalController@show')->name('anulacion.show');

Route::get('creaClientes', function () {
    factory(App\Cliente::class, 50)->create();
    return redirect()->route('clientes.index');
});