<?php
/**
 * Created by PhpStorm.
 * User: shaon
 * Date: 5/20/2022
 * Time: 10:27 AM
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\FrontEnd\FaqController;
use App\Http\Controllers\FrontEnd\TeamController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\FrontEnd\ServiceController;
use App\Http\Controllers\FrontEnd\FrontEndController;
use App\Http\Controllers\Admin\Account\BankController;
use App\Http\Controllers\Admin\Report\ReportController;
use App\Http\Controllers\Admin\Settings\AreaController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Settings\StaffController;
use App\Http\Controllers\Admin\Account\AccountController;
use App\Http\Controllers\Admin\Account\BillPayController;
use App\Http\Controllers\Admin\Billing\BillingController;
use App\Http\Controllers\Admin\Expense\ExpenseController;
use App\Http\Controllers\Admin\Settings\DeviceController;
use App\Http\Controllers\Admin\Settings\PackageController;
use App\Http\Controllers\Admin\Settings\IdentityController;
use App\Http\Controllers\Admin\Account\AccountTypeController;
use App\Http\Controllers\Admin\Account\TransactionController;
use App\Http\Controllers\Admin\Complaint\ComplaintController;
use App\Http\Controllers\Admin\Account\FundTransferController;
use App\Http\Controllers\Admin\Subscriber\SubscriberController;
use App\Http\Controllers\Admin\Client\ClientDashboardController;
use App\Http\Controllers\Admin\Expense\ExpenseCategoryController;
use App\Http\Controllers\Admin\Settings\ConnectionTypeController;
use App\Http\Controllers\Admin\Complaint\ClassificationController;
use App\Http\Controllers\Admin\Subscriber\SubscriberCategoryController;

//dashboard filtering route
Route::get('general-settings', [DashboardController::class, 'GeneralSettings'])->name('general-settings');

Route::post('general-settings-store', [DashboardController::class, 'GeneralSettingStore'])->name('general-settings-store');
Route::get('/dashboard-filter/{start_date}/{end_date}', [DashboardController::class, 'dashboardFilter'])->name('dashboardFilter');
//staff dashboard route
Route::get('staff-dashboard', [DashboardController::class, 'StaffDashboard'])->name('staff-dashboard');
Route::get('clients-dashboard', [DashboardController::class, 'ClientDashboard'])->name('clients-dashboard');
//area route starts here
Route::resource('area', AreaController::class)->except('show');
//all area list
Route::post('area-list', [AreaController::class, 'area'])->name('area-list');
//area status change
Route::post('area-status', [AreaController::class, 'StatusChange'])->name('area-status');
//area code generate
Route::get('area-code', [AreaController::class, "code"])->name('area-code');
//end area route

//connection route starts here
Route::resource('connection', ConnectionTypeController::class)->except('show');
//all connection list
Route::post('connection-list', [ConnectionTypeController::class, "connection"])->name('connection-list');
//connection status change
Route::post('connection-status', [ConnectionTypeController::class, 'StatusChange'])->name('connection-status');
//automatic code generate
Route::get('connection-code', [ConnectionTypeController::class, "code"])->name('connection-code');
//end connection route

//package route starts here
Route::resource('package', PackageController::class)->except('show');
//all package list
Route::post('package-list', [PackageController::class, "package"])->name('package-list');
//package status change
Route::post('package-status', [PackageController::class, "StatusChange"])->name('package-status');
//automatic code generate
Route::get('package-code', [PackageController::class, "code"])->name('package-code');
//end package route

//identity card type route starts here
Route::resource('identity', IdentityController::class)->except('show');
//all idcard type list
Route::post('idcard-list', [IdentityController::class, "idcard"])->name('idcard-list');
//idcard type status change
Route::post('idcard-status', [IdentityController::class, "StatusChange"])->name('idcard-status');
// end identity card route

//device type route starts here
Route::resource('device', DeviceController::class)->except('show');
//all device type list
Route::post('device-list', [DeviceController::class, "device"])->name('device-list');
//device type status change
Route::post('device-status', [DeviceController::class, "StatusChange"])->name('device-status');
//end device type route

//device type route starts here
Route::resource('staff', StaffController::class);
//all device type list
Route::post('staff-list', [StaffController::class, "staff"])->name('staff-list');
//device type status change
Route::post('staff-status', [StaffController::class, "StatusChange"])->name('staff-status');
Route::get('staff-profile/{id}', [StaffController::class, "StaffProfile"])->name('staff-profile');

Route::put('staff-profile-update/{id}', [StaffController::class, "StaffProfileUpdate"])->name('staff-profile-update');
//end device type route

//subscriber-category route starts
Route::resource('subscriber-category', SubscriberCategoryController::class)->except('show');
//all subscriber-category list
Route::post('subscriber-category-list', [SubscriberCategoryController::class, "SubscriberCategories"])->name('subscriber-category-list');
//subscriber-category status change
Route::post('subscriber-category.status', [SubscriberCategoryController::class, "StatusChange"])->name('subscriber-category.status');
//end subscriber-category route

//subscriber route start
Route::resource('subscriber', SubscriberController::class);
//all subscribers list
Route::post('all-subscriber', [SubscriberController::class, "subscribers"])->name('all-subscriber');
//get packages from package table
Route::get('all-package', [SubscriberController::class, "packages"])->name('all-package');
//subscriber status change
Route::post('subscriber-status', [SubscriberController::class, "StatusChange"])->name('subscriber-status');
// sample excel
Route::get('client-sample-excel', [SubscriberController::class, 'sampleExcel'])->name('subscriber.sample-excel');
// import
Route::post('client-data-import', [SubscriberController::class, 'import'])->name('subscriber.import');
//end subscriber route

//billing route start
Route::resource('bill', BillingController::class);
//get monthly bill
Route::get('bill-list', [BillingController::class, "bill"])->name('bill-list');
// get billing month data
Route::post('billing-month', [BillingController::class, "BillingMonth"])->name('billing-month');
// bill generate
Route::post('bill-generate', [BillingController::class, "BillGenerate"])->name('bill-generate');
//monthly bill
Route::post('monthly-bill', [BillingController::class, "monthlyBill"])->name('monthly-bill');
// get billing date
Route::get('monthly-bills/{billing_month}', [BillingController::class, "allMontlyBill"])->name('monthly-bills');
//monthly bill list
Route::post('monthly-bill-list', [BillingController::class, "monthlyBillList"])->name('monthly-bill-list');
// bill invoice
Route::get('bill-invoice/{id}', [BillingController::class, "invoice"])->name('bill-invoice');
Route::get('all-accounts', [BillingController::class, "accounts"])->name('all-accounts');

//paid client index
Route::get('paid-client', [BillingController::class, 'paidclient'])->name('paid-client');
//paid client list
Route::post('paid-clients', [BillingController::class, 'paidclients'])->name('paid-clients');

//unpaid client index
Route::get('unpaid-client', [BillingController::class, 'unpaidclient'])->name('unpaid-client');
//unpaid client list
Route::post('unpaid-clients', [BillingController::class, 'unpaidclients'])->name('unpaid-clients');

Route::get('subscriber-data', [BillPayController::class, "subscribers"])->name('subscriber-data');
//end billing route

//expense-category route start here
Route::resource('expense-category', ExpenseCategoryController::class)->except('show');
//all expense-category list
Route::post('expense-categories', [ExpenseCategoryController::class, "ExpenseCategory"])->name('expense-categories');
//status change route
Route::post('expense-category-status', [ExpenseCategoryController::class, 'StatusChange'])->name('expense-category-status');
//end expense-category route

//expense route start here
Route::resource('expense', ExpenseController::class);
//all expense list
Route::post('all-expenses', [ExpenseController::class, "expenses"])->name('all-expenses');
//expense invoice
Route::get('expense-invoice/{id}', [ExpenseController::class, "invoice"])->name('expense-invoice');
//end expense route

//classification route start here
Route::resource('classification', ClassificationController::class);
//all classification list
Route::post('classification-list', [ClassificationController::class, "classifications"])->name('classification-list');
//classification status change
Route::post('classification-status', [ClassificationController::class, "StatusChange"])->name('classification-status');
//end classification route

//complaint route start here
Route::resource('complaint', ComplaintController::class);
//all complaint list
Route::post('all-complaint', [ComplaintController::class, "complaints"])->name('all-complaint');
////complaint status change
Route::post('complaint-status', [ComplaintController::class, "StatusChange"])->name('complaint-status');
//end complaint route

//bank route start here
Route::resource('bank', BankController::class)->except('show');
//all bank list
Route::post('bank-list', [BankController::class, "bank"])->name('bank-list');
////bank status change
Route::post('bank-status', [BankController::class, "StatusChange"])->name('bank-status');
//end bank route

//account_type route start here
Route::resource('account-type', AccountTypeController::class)->except('show');
//all account-type list
Route::post('all-account-type', [AccountTypeController::class, "accountTypes"])->name('all-account-type');
//account-type status change
Route::post('account-type.status', [AccountTypeController::class, "StatusChange"])->name('account-type.status');
//end account_type route

//account route start here
Route::resource('account', AccountController::class);
//all account list
Route::post('account-list', [AccountController::class, "account"])->name('account-list');
////account status change
Route::post('account-status', [AccountController::class, "StatusChange"])->name('account-status');
//end account route

//transactions route start here
Route::resource('transactions', TransactionController::class);
//all transaction list
Route::post('transaction-list', [TransactionController::class, "transactions"])->name('transaction-list');
//transaction status change
Route::post('transaction-status', [TransactionController::class, "StatusChange"])->name('transaction-status');
//balance sheet
Route::get('balance', [TransactionController::class, "balance"])->name('balance');
//balance sheet list
Route::post('balance-list', [TransactionController::class, "AllBalance"])->name('balance-list');
//statement index
Route::get('account-statement', [TransactionController::class, "statement"])->name('account-statement');
//statement list
Route::post('account-statements', [TransactionController::class, "statements"])->name('account-statements');
//get account balance
Route::get('account-balance/{id}', [TransactionController::class, "getAccountBalance"])->name('account-balance');
//get account initial balance
Route::get('account-initial-balance/{id}', [TransactionController::class, "getAccountInitialBalance"])->name('account-initial-balance');
//end account route

//reports route start here
Route::get('subscriber-list', [ReportController::class, 'subscriber'])->name('subscriber-list');
//active, inactive subscriber list
Route::post('subscriber-lists', [ReportController::class, 'subscribers'])->name('subscriber-lists');

//area index
Route::get('report-area', [ReportController::class, 'area'])->name('report-area');
//area list
Route::post('report-areas', [ReportController::class, 'areas'])->name('report-areas');
//connections index
Route::get('report-connection', [ReportController::class, 'connection'])->name('report-connection');
//connections list
Route::post('report-connections', [ReportController::class, 'connections'])->name('report-connections');
//packages index
Route::get('report-package', [ReportController::class, 'package'])->name('report-package');
//packages list
Route::post('report-packages', [ReportController::class, 'packages'])->name('report-packages');
//devices index
Route::get('report-device', [ReportController::class, 'device'])->name('report-device');
//devices list
Route::post('report-devices', [ReportController::class, 'devices'])->name('report-devices');
//client categories index
Route::get('report-category', [ReportController::class, 'category'])->name('report-category');
//client categories list
Route::post('report-categories', [ReportController::class, 'categories'])->name('report-categories');
//end reports route

//Start Client Dashboard Here
Route::resource('client-dashboard', ClientDashboardController::class);
//client list
Route::post('client-lists', [ClientDashboardController::class, 'subscribers'])->name('client-lists');
//area change request
Route::post('request-area', [ClientDashboardController::class, 'AreaUpdate'])->name('request-area');
//area request list page
Route::get('request-area-list', [ClientDashboardController::class, 'AreaRequest'])->name('request-area-list');
//area request list
Route::post('request-area-lists', [ClientDashboardController::class, 'AreaRequests'])->name('request-area-lists');
//area request status change
Route::post('request-area-status', [ClientDashboardController::class, 'AreaStatusChange'])->name('request-area-status');
//connection change request
Route::post('request-connection', [ClientDashboardController::class, 'ConnectionUpdate'])->name('request-connection');
//connection request list page
Route::get('request-connection-list', [ClientDashboardController::class, 'ConnectionRequest'])->name('request-connection-list');
//connection request list
Route::post('request-connection-lists', [ClientDashboardController::class, 'ConnectionRequests'])->name('request-connection-lists');

//package change request
Route::post('request-package', [ClientDashboardController::class, 'PackageUpdate'])->name('request-package');
//package request page
Route::get('request-package-list', [ClientDashboardController::class, 'PackageRequest'])->name('request-package-list');
//package request list
Route::post('request-package-lists', [ClientDashboardController::class, 'PackageRequests'])->name('request-package-lists');

Route::post('request-package-status', [ClientDashboardController::class, 'PackageStatusChange'])->name('request-package-status');

//client billing history
Route::get('billing-history/{id}', [ClientDashboardController::class, 'BillingHistory'])->name('billing-history');
Route::get('billing-client', [ClientDashboardController::class, 'billingclient'])->name('billing-client');
Route::post('billing-clients', [ClientDashboardController::class, 'billingclients'])->name('billing-clients');
//End Client Dashboard

//Start fund transfer
Route::resource('fund-transfer', FundTransferController::class);
Route::post('all-fund-transfer', [FundTransferController::class, 'FundTransfer'])->name('all-fund-transfer');

//Start bill pay
Route::resource('bill-pay', BillPayController::class);
Route::post('all-bill-pay', [BillPayController::class, 'billpay'])->name('all-bill-pay');
Route::get('get-account-balance/{id}', [BillPayController::class, 'getAccountBalance'])->name('get.account.balance');
Route::post('all-bill-pays', [BillPayController::class, 'billpays'])->name('all-bill-pays');

Route::get('request-bill', [BillPayController::class, 'requestbill'])->name('request-bill');

Route::get('client-bill-request', [BillPayController::class, 'ClientBillRequest'])->name('client-bill-request');

Route::post('client-bill-store', [BillPayController::class, 'ClientBillStore'])->name('client-bill-store');

Route::post('request-bill-status', [BillPayController::class, "StatusChange"])->name('request-bill-status');

Route::get('approve-request-bill/{id}', [BillPayController::class, 'client_bill'])->name('approve-request-bill');

Route::put('approve-request-bill-update/{id}', [BillPayController::class, 'client_bill_update'])->name('approve-request-bill-update');

//Role-Permission route start here
Route::resource('role', RoleController::class);
Route::post('all-role', [RoleController::class, 'role'])->name('all-role');
Route::resource('permission', PermissionController::class)->except('show');
Route::post('all-permission', [PermissionController::class, 'permission'])->name('all-permission');

//frontEnd banner-setting
Route::get('banner-setting', [FrontEndController::class, 'BannerSetting'])->name('banner-setting');
Route::post('banner-setting-store', [FrontEndController::class, 'BannerSettingStore'])->name('banner-setting-store');

//frontEnd about-setting
Route::get('about-setting', [FrontEndController::class, 'AboutSetting'])->name('about-setting');
Route::post('about-setting-store', [FrontEndController::class, 'AboutSettingStore'])->name('about-setting-store');

//frontEnd service-setting
Route::resource('service-setting', ServiceController::class)->except('show');
Route::post('service-setting-list', [ServiceController::class, 'ServiceSettingList'])->name('service-setting-list');
Route::post('service-setting-status', [ServiceController::class, 'StatusChange'])->name('service-setting-status');

Route::get('service-color-setting', [ServiceController::class, 'ServiceColorSetting'])->name('service-color-setting');
Route::post('service-color-store', [ServiceController::class, 'ServiceColorStore'])->name('service-color-store');

//frontEnd team-setting
Route::resource('team-setting', TeamController::class);
Route::post('team-setting-list', [TeamController::class, 'TeamSettingList'])->name('team-setting-list');
Route::post('team-setting-status', [TeamController::class, 'StatusChange'])->name('team-setting-status');

Route::get('team-color-setting', [TeamController::class, 'TeamColorSetting'])->name('team-color-setting');
Route::post('team-color-store', [TeamController::class, 'TeamColorStore'])->name('team-color-store');

//frontEnd faq-setting
Route::resource('faq-setting', FaqController::class)->except('show');
Route::post('faq-setting-list', [FaqController::class, 'FaqSettingList'])->name('faq-setting-list');
Route::post('faq-setting-status', [FaqController::class, 'StatusChange'])->name('faq-setting-status');

Route::get('faq-color-setting', [FaqController::class, 'FaqColorSetting'])->name('faq-color-setting');
Route::post('faq-color-store', [FaqController::class, 'FaqColorStore'])->name('faq-color-store');

Route::get('package-color-setting', [FrontEndController::class, 'PackageColorSetting'])->name('package-color-setting');
Route::post('package-color-store', [FrontEndController::class, 'PackageColorStore'])->name('package-color-store');

//frontEnd social-setting
Route::get('social-link', [FrontEndController::class, 'SocialLink'])->name('social-link');
Route::post('social-link-store', [FrontEndController::class, 'SocialLinkStore'])->name('social-link-store');

Route::post('message-store', [FrontEndController::class, 'MessageStore'])->name('message-store');

Route::get('message-list', [FrontEndController::class, 'MessageList'])->name('message-list');
Route::post('all-message', [FrontEndController::class, 'AllMessage'])->name('all-messages');
Route::delete('message-delete/{id}', [FrontEndController::class, 'MessageDelete'])->name('message-delete');
