<?php

use Illuminate\Support\Facades\Route;

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

// use App\Http\Controllers\DashController;

// Route::get('/', [DashController::class, 'index']);
// Route::get('/dashboard', [DashController::class, 'index']);
// Route::get('/', function () {
//     return view('maintenance.maintenance');
// });

use App\Http\Controllers\MailController;
// Mail
Route::get('/mails/{signer}', [MailController::class, 'index']);
Route::get('/getmailsdata/{signer}', [MailController::class, 'getMailsData'])->name('getmailsdata');
Route::get('/edit/{id}', [MailController::class, 'editDataSurat'])->name('edit');
Route::get('/modaltambahsurat/{signer}', [MailController::class, 'modalTambahSurat'])->name('modaltambahsurat');
Route::post('/tambahsurat', [MailController::class, 'tambahsurat']);
Route::post('/modaledit/{signer}', [MailController::class, 'modalEdit']);
Route::post('/editsurat', [MailController::class, 'editSurat']);
Route::post('/modalupload', [MailController::class, 'modalupload']);
Route::post('/uploadsurat', [MailController::class, 'uploadsurat']);
Route::get('/downloadsurat/{nama_file}', [MailController::class, 'downloadsurat']);
Route::post('/hapussurat', [MailController::class, 'hapussurat']);
Route::get('/modalcetakregister/{signer}', [MailController::class, 'modalCetakRegister']);
Route::get('/modalcetakregisterharian/{signer}', [MailController::class, 'modalCetakRegisterHarian']);
Route::post('/cetakregister', [MailController::class, 'cetakRegister']);
Route::post('/cetakregisterharian', [MailController::class, 'cetakRegisterHarian']);
Route::post('/terimaarsip', [MailController::class, 'terimaarsip']);
Route::get('/template_mail', [MailController::class, 'template_mail']);
Route::get('/modal_template_surat', [MailController::class, 'modal_template_surat']);
Route::post('/tambah_template', [MailController::class, 'tambah_template']);
Route::post('/modal_edit_template_surat', [MailController::class, 'modal_edit_template_surat']);
Route::post('/edit_template', [MailController::class, 'edit_template']);
Route::post('/modalcetaksurat', [MailController::class, 'modalCetakSurat']);
Route::post('/cetak_surat', [MailController::class, 'cetakSurat']);

// Setting
// Employee
use App\Http\Controllers\EmployeeController;

Route::get('/employees', [EmployeeController::class, 'getEmployeesData']);
Route::get('/modaltambahpegawai', [EmployeeController::class, 'modalTambahPegawai']);
Route::post('/tambahpegawai', [EmployeeController::class, 'tambahPegawai']);
Route::post('/modaleditpegawai', [EmployeeController::class, 'modalEditPegawai']);
Route::post('/editpegawai', [EmployeeController::class, 'editPegawai']);
Route::post('/hapuspegawai', [EmployeeController::class, 'hapusPegawai']);

// Position
use App\Http\Controllers\PositionController;

Route::get('/positions', [PositionController::class, 'getPositionsData']);
Route::get('/modaltambahjabatan', [PositionController::class, 'modalTambahJabatan']);
Route::post('/tambahjabatan', [PositionController::class, 'tambahJabatan']);
Route::post('/modaleditjabatan', [PositionController::class, 'modalEditJabatan']);
Route::post('/editjabatan', [PositionController::class, 'editJabatan']);
Route::post('/hapusjabatan', [PositionController::class, 'hapusJabatan']);

// Unit
use App\Http\Controllers\UnitController;

Route::get('/units', [UnitController::class, 'getUnitsData']);
Route::get('/modaltambahunit', [UnitController::class, 'modalTambahUnit']);
Route::post('/tambahunit', [UnitController::class, 'tambahUnit']);
Route::post('/modaleditunit', [UnitController::class, 'modalEditUnit']);
Route::post('/editunit', [UnitController::class, 'editUnit']);
Route::post('/hapusunit', [UnitController::class, 'hapusUnit']);

// Unit
use App\Http\Controllers\AkunController;

Route::get('/akuns', [AkunController::class, 'getAkunsData']);
Route::get('/modaltambahakun', [AkunController::class, 'modalTambahAkun']);
Route::post('/tambahakun', [AkunController::class, 'tambahAkun']);
Route::post('/hapusakun', [AkunController::class, 'hapusAkun']);

// Auth
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'login']);
Route::post('/attemptlogin', [AuthController::class, 'attemptLogin']);
Route::get('/logout', [AuthController::class, 'logout']);

// Dash
use App\Http\Controllers\DashController;

Route::get('/', [DashController::class, 'index']);
Route::get('/dashboard', [DashController::class, 'index']);
Route::post('/getchartsurat', [DashController::class, 'getChartSurat']);

//Order
use App\Http\Controllers\OrderController;

Route::get('/orders', [OrderController::class, 'index']);
Route::get('/getordersdata/{jenis}', [OrderController::class, 'getOrdersData']);
Route::get('/tambahpesanan', [OrderController::class, 'tambahPesanan']);
Route::post('/modaledittanggal', [OrderController::class, 'modalEditTanggal']);
Route::post('/edittanggalorder', [OrderController::class, 'editTanggalOrder']);
Route::post('/insertorderdetails', [OrderController::class, 'insertOrderDetails']);
Route::post('/cancelorder', [OrderController::class, 'cancelOrder']);
Route::get('/orderdetail/{order_id}', [OrderController::class, 'orderDetail']);
Route::post('/insertpemenuhan', [OrderController::class, 'insertPemenuhan']);
Route::get('/markascompleted/{order_detail_id}/{order_id}', [OrderController::class, 'markAsCompleted']);
Route::get('/cetakorder/{order_id}', [OrderController::class, 'cetakOrder']);
Route::get('/cetakpreviousform/{key}', [OrderController::class, 'cetakPreviousForm']);
Route::post('/hapusorder', [OrderController::class, 'hapusOrder']);
Route::get('/testquery', [OrderController::class, 'testQuery']);
Route::get('/notifikasiorder', [OrderController::class, 'notifikasiOrder']);
Route::get('/notifikasiorder03', [OrderController::class, 'notifikasiOrder03']);
Route::get('/modalcetakregisterorder', [OrderController::class, 'modalCetakRegister']);
Route::post('/cetakregisterorder', [OrderController::class, 'cetakRegister']);
Route::get('/anounce', [OrderController::class, 'anounce']);
Route::get('/modalcetakoutput', [OrderController::class, 'modalCetakOutput']);
Route::post('/cetakoutput', [OrderController::class, 'cetakOutput']);
Route::get('/orders/delete_fullfills/{id}/{order_id}', [OrderController::class, 'delete_fullfills']);


//Salary
use App\Http\Controllers\SalaryController;

Route::get('/test_salary', [SalaryController::class, 'testQuery']);
Route::get('/salary', [SalaryController::class, 'index']);
Route::get('/getsalarylist', [SalaryController::class, 'getsalaryData']);
Route::get('/importsalary', [SalaryController::class, 'importsalary']);
Route::post('/importexcel', [SalaryController::class, 'importExcel']);
Route::get('/salary/get_slip/{bulan}/{tahun}', [SalaryController::class, 'slipGaji']);
Route::get('/salary/admin_list', [SalaryController::class, 'adminList']);
Route::get('/getsalaryadmin', [SalaryController::class, 'getsalaryAdmin']);
Route::get('/salary/delete_admin/{bulan}/{tahun}', [SalaryController::class, 'deleteAdmin']);
Route::get('/salary/slip_umum', [SalaryController::class, 'slipUmum']);
Route::post('/getsalaryumum', [SalaryController::class, 'getSalaryUmum']);
Route::get('/salary/get_slip/{bulan}/{tahun}/{nama}', [SalaryController::class, 'slipGaji']);


//Referencies
use App\Http\Controllers\RefController;

Route::get('/goods', [RefController::class, 'index']);
Route::get('/goods/getgoodsdata', [RefController::class, 'getGoodsData'])->name('getgoodsdata');
Route::post('/goods/insertrefbarang', [RefController::class, 'insertRefBarang']);
Route::post('/goods/editrefbarang', [RefController::class, 'editRefBarang']);
Route::post('/goods/delete_barang', [RefController::class, 'deleteBarang']);
Route::get('/goods/ref_jenis_barang', [RefController::class, 'refJenisBarang']);
Route::get('/goods/getrefbarang', [RefController::class, 'getRefBarang'])->name('getrefbarang');
Route::get('/goods/modal_tambah_jenis', [RefController::class, 'modalTambahJenis']);
Route::post('/goods/insert_jenis_barang', [RefController::class, 'insertJenisBarang']);
Route::post('/goods/modal_edit_jenis', [RefController::class, 'modalEditJenis']);
Route::post('/goods/edit_jenis_barang', [RefController::class, 'editJenisBarang']);
Route::post('/goods/delete_jenis_barang', [RefController::class, 'deleteJenisBarang']);
Route::get('/goods/modal_import', [RefController::class, 'importBarang']);
Route::post('/goods/importexcel', [RefController::class, 'importExcel']);
Route::get('/goods/delete_all', [RefController::class, 'hapusAll']);

//Referencies
use App\Http\Controllers\TestController;

Route::get('test', [TestController::class, 'index']);
// Route::get('/goods/getgoodsdata', [RefController::class, 'getGoodsData'])->name('getgoodsdata');
// Route::post('/goods/insertrefbarang', [RefController::class, 'insertRefBarang']);

// Mail
use App\Http\Controllers\LeaveController;

Route::get('/leave', [LeaveController::class, 'index']);
Route::get('/leave_user/{jenis}', [LeaveController::class, 'index']);
Route::get('/getleavesgeneral', [LeaveController::class, 'getLeavesGeneral'])->name('getleavesgeneral');
Route::get('/getleavesgeneral/{nip}/{kategori}', [LeaveController::class, 'getLeavesGeneral'])->name('getleavesuser');
Route::get('/leave/modalinsertgeneral', [LeaveController::class, 'modalInsertGeneral'])->name('modalinsertgeneral');
Route::post('/leave/insertgeneral', [LeaveController::class, 'insertGeneral']);
Route::post('/leave/modaleditgeneral', [LeaveController::class, 'modalEditGeneral']);
Route::post('/leave/editgeneral', [LeaveController::class, 'editGeneral']);
Route::post('/leave/modaldetailgeneral', [LeaveController::class, 'modalDetailGeneral']);
Route::post('/leave/deletegeneral', [LeaveController::class, 'deleteGeneral']);
Route::get('/edit/{id}', [LeaveController::class, 'editDataSurat'])->name('edit');
Route::get('/leave/permohonan', [LeaveController::class, 'permohonan']);
Route::get('/leave/permohonan/{jenis}', [LeaveController::class, 'permohonan']);
Route::post('/leave/setujuatasan', [LeaveController::class, 'setujuAtasan']);
Route::post('/leave/modaltolakatasan', [LeaveController::class, 'modalTolakAtasan']);
Route::post('/leave/modaltangguhkanatasan', [LeaveController::class, 'modalTangguhkanAtasan']);
Route::post('/leave/tolakatasan', [LeaveController::class, 'tolakAtasan']);
Route::post('/leave/tangguhkanatasan', [LeaveController::class, 'tangguhkanAtasan']);
Route::get('/getleavespermohonan/{jenis}', [LeaveController::class, 'getLeavesPermohonan'])->name('getleavespermohonan');
Route::get('/leave/notifikasicuti', [LeaveController::class, 'notifikasiCuti']);
Route::get('/leave/sisa_cuti', [LeaveController::class, 'sisa_cuti']);
Route::get('/leave/detail_sisa_cuti', [LeaveController::class, 'detail_sisa_cuti']);
Route::get('/leave/tambah_saldo_cuti', [LeaveController::class, 'tambah_saldo_cuti']);
Route::post('/leave/insertsaldocuti', [LeaveController::class, 'insertSaldoCuti']);
Route::get('/leave/edit_sisa_cuti', [LeaveController::class, 'edit_sisa_cuti']);
Route::post('/leave/editsaldocuti', [LeaveController::class, 'editSaldoCuti']);
Route::post('/leave/cetakrekapsaldocuti', [LeaveController::class, 'cetakRekapSaldoCuti']);
Route::post('/leave/cetakrekapsaldocuti', [LeaveController::class, 'cetakRekapSaldoCuti']);
Route::get('/leave/cetak_form/{id_cuti}', [LeaveController::class, 'cetak_form']);
Route::post('/leave/modalnomorcuti', [LeaveController::class, 'modalNomorCuti']);
Route::post('/leave/insertnomorcuti', [LeaveController::class, 'insertNomorCuti']);
Route::get('/leave/modalcetakregister', [LeaveController::class, 'modalCetakRegister']);
Route::post('/leave/cetakregister', [LeaveController::class, 'cetakRegister']);


use App\Http\Controllers\PermissionController;

Route::get('/permission', [PermissionController::class, 'index']);

Route::get('/getpermission', [PermissionController::class, 'getPermission']);
Route::get('/getpermission/{nip}', [PermissionController::class, 'getPermission']);
Route::get('/permission/modalinsert/{jenis}', [PermissionController::class, 'modalInsert']);
Route::post('/permission/insert', [PermissionController::class, 'insert']);
Route::post('/permission/modaledit', [PermissionController::class, 'modalEdit']);
Route::post('/permission/delete', [PermissionController::class, 'delete']);
Route::get('/permission/cetak_form/{id}', [PermissionController::class, 'cetak_form']);
Route::get('/permission/modalcetakregister', [PermissionController::class, 'modalCetakRegister']);
Route::post('/permission/cetakregister', [PermissionController::class, 'cetakRegister']);
Route::get('/permission/pribadi/', [PermissionController::class, 'pribadi']);
Route::get('/permission/permohonan/', [PermissionController::class, 'permohonan']);
Route::get('/permission/getdatapermohonan', [PermissionController::class, 'getDataPermohonan']);
Route::post('/permission/setuju', [PermissionController::class, 'setuju']);
Route::post('/permission/tolak', [PermissionController::class, 'tolak']);
Route::get('/permission/notifikasi', [PermissionController::class, 'notifikasi']);


use App\Http\Controllers\PresensiController;

Route::post('/presensi/modal_presensi', [PresensiController::class, 'modal_presensi']);
Route::post('/presensi/insert', [PresensiController::class, 'insert']);
Route::get('/presensi/laporan_umum', [PresensiController::class, 'laporan_umum']);
Route::post('/presensi/get_table_umum', [PresensiController::class, 'get_table_umum']);
Route::post('/presensi/cetak_laporan_umum', [PresensiController::class, 'cetak_laporan_umum']);
Route::get('/presensi/laporan_pribadi', [PresensiController::class, 'laporan_pribadi']);
Route::post('/presensi/get_table_pribadi', [PresensiController::class, 'get_table_pribadi']);

use App\Http\Controllers\SuratKeputusanController;

Route::controller(SuratKeputusanController::class)->group(function () {
    Route::get('/surat_keputusan', 'index');
    Route::get('/getskdata', 'getSkData')->name('getskdata');
    Route::get('/modaltambahsk', 'modalTambahSk')->name('modaltambahsk');
    Route::post('/tambahsk', 'insert');
    Route::post('/hapussk', 'hapusSk');
    Route::post('/modaleditsk', 'modalEditSk');
    Route::post('/editsk', 'editSk');
    Route::get('/modalcetakregistersk', 'modalCetakRegister');
    Route::post('/cetakregistersk', 'cetakRegister');
});

use App\Http\Controllers\ReviewController;
Route::controller(ReviewController::class)->group(function () {
    Route::get('/review/ptsp', 'ptsp');
    Route::get('/review/get_result_ptsp', 'getResultPtsp');
    Route::get('/modal_cetak_review_bulanan', 'modalCetakReviewBulanan');
    Route::post('/cetak_register_review_bulanan', 'printReportBulanan');
    Route::get('/review/petugas_ptsp', 'petugasPtsp');
    Route::get('/review/get_petugas_ptsp', 'getListPetugasPtsp');
    Route::post('/review/destroy_petugas_ptsp', 'activateOfficer')->name('review.destroy_officer');
    Route::get('/review/modal_tambah_petugas_ptsp', 'addPtspOfficer');
    Route::post('/review/tambah_petugas_ptsp', 'insertPtspOfficer');
    Route::post('/review/modal_edit_ptsp', 'editPtspOfficer');
    Route::get('/review/petugas_satpam', 'petugasSatpam');
    Route::get('/review/get_petugas_satpam', 'getListPetugasSatpam');
    Route::get('/review/modal_tambah_petugas_satpam', 'addSatpamOfficer');
    Route::post('/review/tambah_petugas_satpam', 'insertSatpamOfficer');
    Route::post('/review/destroy_petugas_satpam', 'activateOfficerSatpam')->name('review.destroy_officer_satpam');
    Route::post('/review/modal_edit_satpam', 'editSatpamOfficer');
    Route::get('/review/satpam', 'satpam');
    Route::get('/review/get_result_satpam', 'getResultSatpam');
    Route::get('/modal_cetak_review_bulanan_satpam', 'modalCetakReviewSatpamBulanan');
    Route::post('/cetak_register_review_bulanan_satpam', 'printReportBulananSatpam');
    Route::get('/modal_cetak_review_harian_satpam', 'modalCetakReviewSatpamHarian');
    Route::post('/cetak_register_review_harian_satpam', 'printReportHarianSatpam');
    Route::get('/modal_cetak_review_harian_ptsp', 'modalCetakReviewPtspHarian');
    Route::post('/cetak_register_review_harian_ptsp', 'printReportHarianPtsp');
    
});

use App\Http\Controllers\PpnpnAssessmentController;
Route::controller(PpnpnAssessmentController::class)->group(function () {
    Route::get('/ppnpn/daftar_assessment', 'ppnpn');
    Route::get('/ppnpn/get_result_ppnpn_assessment', 'getResultPpnpnAssessment');
    Route::get('ppnpn/modal_tambah_penilaian', 'modalTambahPenilaian');
    Route::post('ppnpn/insert_penilaian', 'insertPenilaian');
    Route::get('ppnpn/modal_cetak_review_bulanan', 'modalCetakReviewBulanan');
    Route::post('ppnpn/cetak_penilaian', 'printReportBulanan');
   
});
