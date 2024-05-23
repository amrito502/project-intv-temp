<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;
use App\Http\Controllers\TBPController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\DailyUsesController;
use App\Http\Controllers\BudgetHeadController;
use App\Http\Controllers\GalleryDateController;
use App\Http\Controllers\DailyExpenseController;
use App\Http\Controllers\MaterialGroupController;
use App\Http\Controllers\MaterialIssueController;
use App\Http\Controllers\CashRequisitionController;
use App\Http\Controllers\LogisticsChargeController;
use App\Http\Controllers\MaterialLiftingController;
use App\Http\Controllers\MaterialReceiveController;
use App\Http\Controllers\AdditionalBudgetController;
use App\Http\Controllers\DailyConsumptionController;
use App\Http\Controllers\GalleryDateImageController;
use App\Http\Controllers\ProjectWiseBudgetController;
use App\Http\Controllers\UnitConfigurationController;
use App\Http\Controllers\MaterialRequisitionController;
use App\Http\Controllers\ProjectWiseRoaBudgetController;
use App\Http\Controllers\MaterialVendorPaymentController;
use App\Http\Controllers\RequisitionCommunicationController;
use App\Http\Controllers\MaterialRequisitionCommunicationController;

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
    return redirect()->route('login');
});

Auth::routes();


// ------------ api start ----------

Route::get('get-unpaid-lifting-invoices', [APIController::class, 'getUnpaidLiftingInvoice'])->name('unpaid.lifting.invoice');
Route::get('get-vendor-due', [APIController::class, 'getVendorDue'])->name('getVendorDue');
Route::get('get-logistic-project-material', [APIController::class, 'getLogisticsChargeMaterials'])->name('logisticCharge.getMaterials');
Route::get('get-project-material-stock', [APIController::class, 'getProjectMaterialStock'])->name('getProjectMaterialStock');
Route::get('get-project-material-local-stock', [APIController::class, 'getProjectMaterialLocalStock'])->name('getProjectMaterialLocalStock');
Route::get('budgethead-wise-total-estimated/{project}/{unit}/{budgetHeadId}/{towerId?}', [APIController::class, 'budgetHeadWiseTotalEstimated'])->name('budgetHeadWiseTotalEstimated');
Route::get('budgethead-wise-total-approved', [APIController::class, 'budgetHeadWiseTotalApproved'])->name('budgetHeadWiseTotalApproved');
Route::get('budgethead-wise-total-used', [APIController::class, 'budgetHeadWiseTotalUsed'])->name('budgetHeadWiseTotalUsed');
Route::get('budgethead-wise-total-paid/{project}/{unit}/{budgetHeadId}', [APIController::class, 'budgetHeadWiseTotalPaid'])->name('budgetHeadWiseTotalPaid');
Route::get('project-unit-wise-budgethead/{projectId}/{unit}', [APIController::class, 'projectUnitWiseBudgetHead'])->name('projectUnitWiseBudgetHead');
Route::get('project-unit-wise-budgethead-cash-only/{projectId}/{unit}', [APIController::class, 'projectUnitWiseBudgetHeadCashOnly'])->name('projectUnitWiseBudgetHeadCashOnly');
Route::get('project-unit-wise-budgethead-material-only/{projectId}/{unit}', [APIController::class, 'projectUnitWiseBudgetHeadMaterialhOnly'])->name('projectUnitWiseBudgetHeadMaterialhOnly');
Route::get('budgethead-to-material-info/{projectId}', [APIController::class, 'budgetHeadToMaterialInfo'])->name('budgetHeadToMaterialInfo');
Route::get('budgethead-to-material-by-name/{projectId}', [APIController::class, 'budgetHeadToMaterialByName'])->name('budgetHeadToMaterialByName');
Route::get('project-wise-materials/{projectId}', [APIController::class, 'projectWiseMaterial'])->name('projectWiseMaterial');
Route::get('project-wise-costHead/{projectId}', [APIController::class, 'projectWiseCostHead'])->name('projectWiseCostHead');
Route::get('projectwiseunits/{projectId}', [APIController::class, 'projectWiseUnits'])->name('projectWiseUnits');
Route::get('project-units/{projectId}', [APIController::class, 'projectUnits'])->name('project.units');
Route::get('project-unit-config/{projectId}/{unitId}', [APIController::class, 'projectUnitConfig'])->name('project.unit.config');
Route::get('projectwise-tower-inherit/{projectId}', [APIController::class, 'projectwiseTowerInherit'])->name('projectwise.tower.inherit');
Route::get('projectwise-tower/{projectId}', [APIController::class, 'projectwiseTower'])->name('projectwise.tower');
Route::get('budgetheadbyId/{id}', [APIController::class, 'budgetheadById'])->name('budgetheadById');
Route::get('{project}-to-{unit}-budgetheads', [APIController::class, 'projectUnitToBudgetHead'])->name('projectUnitToBudgetHead');
Route::get('{project}-to-{unit}-materials', [APIController::class, 'projectUnitToMaterials'])->name('projectUnitToMaterials');
Route::get('unitconfig-by/{id}', [APIController::class, 'UnitConfigById'])->name('UnitConfigById');
Route::get('datewise-issue-projects', [APIController::class, 'datewiseIssueProject'])->name('datewiseIssueProject');
Route::get('datewise-issue-notower-projects', [APIController::class, 'datewiseIssueNoTowerProject'])->name('datewiseIssueNoTowerProject');
Route::get('datewise-issue-details', [APIController::class, 'datewiseIssueDetails'])->name('datewiseIssueDetails');
Route::get('projectwise-logistics-bill-table', [APIController::class, 'projectWiseLogisticsBillTable'])->name('projectWiseLogisticsBillTable');
Route::get('datewise-inventory-details', [APIController::class, 'datewiseInventoryStatus'])->name('datewiseInventoryStatus');
Route::get('project-unit-towerwise-projectbudget', [APIController::class, 'projectUnitTowerWiseBudget'])->name('projectUnitTowerWiseBudget');
Route::get('getprojectMaterialDesignQty', [APIController::class, 'getProjectMaterialDesignStock'])->name('getProjectMaterialDesignStock');


// ------------ api end ----------


// ------------ front start ----------
// ------------ front end ----------


// ------------ dashboard start ----------
Route::prefix('admin')->middleware(['auth', 'withMenu'])->group(function () {


    // select project
    // Route::get('/select-project', [HomeController::class, 'selectProject'])->name('select.project');
    // Route::post('/select-project-save', [HomeController::class, 'selectProjectSave'])->name('select.project.save');


    Route::middleware(['userSelectedProject'])->group(function () {

        // dashboard
        Route::get('/', [HomeController::class, 'index'])->name('home');

        // company setup
        Route::get('/company-setup', [HomeController::class, 'companySetupView'])->name('company.setup');

        // change own password
        Route::get('user/changepassword', [UserController::class, 'ChangeOwnPassView'])->name('cp.view');

        // change user password
        Route::get('user/change-password/{user}', [UserController::class, 'ChangePassView'])->name('changepassword.view');
        Route::post('user/change-password/{user}', [UserController::class, 'ChangePass'])->name('changepassword');

        // change user status
        Route::get('user/toggle-status/{user}', [UserController::class, 'toggleStatus'])->name('user.toggle.status');
        Route::resource('user', UserController::class);

        // role
        Route::resource('role', RoleController::class)->except(['show']);

        // menu
        Route::resource('module', ModuleController::class)->except(['show']);
        Route::get('action-menu/{menuId}/create', [ModuleController::class, 'actionMenuCreate'])->name('actionmenu.create');
        Route::get('action-menu/{menuId}', [ModuleController::class, 'actionMenuIndex'])->name('actionmenu.index');

        // site settings
        Route::get('/site-settings', [HomeController::class, 'siteSettingView'])->name('site_setting.index');
        Route::patch('/site-settings-update', [HomeController::class, 'siteSetting'])->name('site.setting');

        // company
        Route::resource('company', CompanyController::class)->except(['show']);

        // branch
        Route::resource('branch', BranchController::class)->except(['show']);

        // project
        Route::resource('project', ProjectController::class)->except(['show']);
        Route::get('project/{id}/toggleDashboardStatus', [ProjectController::class, 'toggleDashboardStatus'])->name('project.toggleDashboardStatus');


        // vendor
        Route::resource('vendor', VendorController::class)->except(['show']);

        // unit
        Route::resource('unit', UnitController::class)->except(['show']);

        // material group
        Route::resource('materialgroup', MaterialGroupController::class)->except(['show']);

        // material
        Route::resource('material', MaterialController::class)->except(['show']);

        // logistics charge
        Route::resource('logisticCharge', LogisticsChargeController::class)->except(['show']);

        // Transportation bill prepare
        Route::resource('tbp', TBPController::class)->except(['show', 'edit', 'update']);
        Route::get('/tbp/{id}/print', [TBPController::class, 'print'])->name('tbp.print');
        Route::get('/tbp/pay/index', [TBPController::class, 'payIndex'])->name('tbp.pay.index');
        Route::get('/tbp/{id}/pay-details', [TBPController::class, 'PayDetailsView'])->name('tbp.payView');
        Route::post('/tbp/pay', [TBPController::class, 'Pay'])->name('tbp.pay');


        // unit configuration
        Route::resource('unitconfiguration', UnitConfigurationController::class)->except(['show']);

        // toggle form start (unit configuration)

        Route::get('/unitconfig/create-form/{id}', [UnitConfigurationController::class, 'createFormToggle'])->name('unitConfigCreateFormToggle');

        // toggle form end (unit configuration)

        // material lifting
        Route::resource('materiallifting', MaterialLiftingController::class)->except(['show']);
        Route::get('/materiallifting/{id}/print', [MaterialLiftingController::class, 'print'])->name('materiallifting.print');

        // material issue
        Route::resource('materialissue', MaterialIssueController::class)->except(['show']);
        Route::get('/materialissue/{id}/print', [MaterialIssueController::class, 'print'])->name('materialissue.print');

        // material receive
        Route::get('/materialreceive', [MaterialReceiveController::class, 'index'])->name('materialreceive.index');
        Route::get('/materialreceive/{issue}/details', [MaterialReceiveController::class, 'receiveMaterialDetails'])->name('material.receiveDetails');
        Route::post('/materialreceive/{issue}', [MaterialReceiveController::class, 'receiveMaterial'])->name('material.receive');


        // daily consumption
        Route::resource('dailyconsumption', DailyConsumptionController::class)->except(['show']);
        Route::get('/dailyconsumption/{id}/print', [DailyConsumptionController::class, 'print'])->name('dailyconsumption.print');
        Route::get('/dailyconsumption/autocalculate-form/{id}', [DailyConsumptionController::class, 'dailyConsumptionAutoCalculateForm'])->name('dailyConsumptionAutoCalculateForm');
        Route::get('/dailyconsumption/receive', [DailyConsumptionController::class, 'receiveList'])->name('dailyconsumption.receiveList');
        Route::get('/dailyconsumption/{id}/receive', [DailyConsumptionController::class, 'receiveView'])->name('dailyconsumption.receiveView');
        Route::post('/dailyconsumption/{id}/receive-save', [DailyConsumptionController::class, 'receiveSave'])->name('dailyconsumption.receiveSave');

        // budget head
        Route::resource('budgethead', BudgetHeadController::class)->except(['show']);

        // project-unitwise budget
        Route::get('/projectwisebudget/inherit/{tower}/{unitconfig}/{newTower}', [ProjectWiseBudgetController::class, 'projectWiseBudgetInherit'])->name('projectwisebudget.inherit.view');
        Route::resource('projectwisebudget', ProjectWiseBudgetController::class)->except(['show']);

        // additional budget
        Route::resource('additionalbudget', AdditionalBudgetController::class)->except(['show', 'edit', 'update']);

        // projectwiseRoaBudget
        Route::get('projectwiseroabudget/{projectBudgetId}', [ProjectWiseRoaBudgetController::class, 'index'])->name('projectwiseroa.index');
        Route::post('projectwiseroabudget/{projectBudgetId}/update', [ProjectWiseRoaBudgetController::class, 'update'])->name('projectwiseroa.update');

        // Daily Consumption
        Route::resource('dailyuses', DailyUsesController::class)->except(['show']);
        Route::get('/dailyuses/{id}/print', [DailyUsesController::class, 'print'])->name('dailyuses.print');

        // supplier payment
        Route::get('/supplier-payment', [CashRequisitionController::class, 'supplierPaymentIndex'])->name('supplier.payment');
        Route::get('/supplier-payment/{id}/pay-details', [CashRequisitionController::class, 'PayDetailsView'])->name('cashrequisition.payView');
        Route::post('/supplier-payment/pay', [CashRequisitionController::class, 'Pay'])->name('cashrequisition.pay');

        // cash requisition
        Route::get('/cash-requisition-index-view', [CashRequisitionController::class, 'approveRequisitionIndexView'])->name('cashrequisition.index.view');
        Route::get('/cash-requisition-print/{cashRequisitionId}', [CashRequisitionController::class, 'CashRequisitionPrint'])->name('cash.requisition.print');

        Route::get('/cash-requisition-approve-view/{requisitionId}', [CashRequisitionController::class, 'approveRequisitionView'])->name('cashrequisition.approve.view');
        Route::post('/cash-requisition-approve', [CashRequisitionController::class, 'approveRequisition'])->name('cashrequisition.approve');


        Route::resource('cashrequisition', CashRequisitionController::class)->except(['show']);


        // daily expense
        Route::resource('dailyexpense', DailyExpenseController::class)->except(['show']);
        Route::get('/dailyexpense-print/{id}', [DailyExpenseController::class, 'DailyExpensePrint'])->name('dailyexpense.print');


        // cash requisition communication
        Route::get('cash-requisitioncommunication-details/{requisition}', [RequisitionCommunicationController::class, 'details'])->name('requisitioncommunication.details');
        Route::post('cash-requisitioncommunication-comment-save/{requisition}', [RequisitionCommunicationController::class, 'commentSave'])->name('requisitioncommunication.saveComment');
        Route::get('cash-requisitioncommunication-comment-update/{commentId}', [RequisitionCommunicationController::class, 'commentUpdate'])->name('requisitioncommunication.updateComment');
        Route::get('cash-requisitioncommunication-comment-delete/{commentId}', [RequisitionCommunicationController::class, 'commentDelete'])->name('requisitioncommunication.deleteComment');


        // material requisition approve step one
        Route::get('/material-requisition-approve-step-one-list', [MaterialRequisitionController::class, 'approveRequisitionStepOneList'])->name('approveRequisitionStepOneList');
        Route::get('/cash-requisition-approve-step-one-view/{requisitionId}', [MaterialRequisitionController::class, 'approveMaterialRequisitionStepOneView'])->name('material.requisition.approve.step.one.details');
        Route::post('/cash-requisition-step-one-approve', [MaterialRequisitionController::class, 'approveMaterialRequisitionStepOne'])->name('materialrequisition.approve.step.one');

        // material requisition approve step two
        Route::get('/material-requisition-approve-step-two-list', [MaterialRequisitionController::class, 'approveRequisitionStepTwoList'])->name('approveRequisitionStepTwoList');
        Route::get('/cash-requisition-approve-step-two-view/{requisitionId}', [MaterialRequisitionController::class, 'approveMaterialRequisitionStepTwoView'])->name('material.requisition.approve.step.two.details');
        Route::post('/cash-requisition-step-two-approve', [MaterialRequisitionController::class, 'approveMaterialRequisitionStepTwo'])->name('materialrequisition.approve.step.two');

        // material requisition
        Route::resource('materialrequisition', MaterialRequisitionController::class)->except(['show']);


        // material requisition communication
        Route::get('material-requisitioncommunication-details/{requisition}', [MaterialRequisitionCommunicationController::class, 'details'])->name('material.requisitioncommunication.details');
        Route::post('material-requisitioncommunication-comment-save/{requisition}', [MaterialRequisitionCommunicationController::class, 'commentSave'])->name('material.requisitioncommunication.saveComment');
        Route::get('material-requisitioncommunication-comment-update/{commentId}', [MaterialRequisitionCommunicationController::class, 'commentUpdate'])->name('material.requisitioncommunication.updateComment');
        Route::get('material-requisitioncommunication-comment-delete/{commentId}', [MaterialRequisitionCommunicationController::class, 'commentDelete'])->name('material.requisitioncommunication.deleteComment');


        // material payment
        Route::resource('materialvendorpayment', MaterialVendorPaymentController::class)->except(['show', 'edit', 'update']);

        // Gallery Module
        Route::resource('gallery', GalleryController::class);


        // gallerydates
        Route::get('/gallerydates/{gallery}', [GalleryDateController::class, 'index'])->name('galleryDates.index');
        Route::get('/gallerydates/{gallery}/create', [GalleryDateController::class, 'create'])->name('gallerydate.create');
        Route::post('/gallerydates/{gallery}/store', [GalleryDateController::class, 'store'])->name('gallerydate.store');
        Route::get('/gallerydates/{gallery}/edit/{gallerydate}', [GalleryDateController::class, 'edit'])->name('gallerydate.edit');
        Route::patch('/gallerydates/{gallery}/update/{gallerydate}', [GalleryDateController::class, 'update'])->name('gallerydate.update');
        Route::get('/gallerydates/show/{gallerydate}', [GalleryDateController::class, 'show'])->name('gallerydate.show');
        Route::delete('/gallerydates/delete/{gallerydate}', [GalleryDateController::class, 'destroy'])->name('gallerydate.destroy');


        // gallery datewise photos
        Route::get('/gallerydateimages/{gallerydate}', [GalleryDateImageController::class, 'index'])->name('gallerydateimages.index');
        Route::get('/gallerydateimages/{gallerydate}/create', [GalleryDateImageController::class, 'create'])->name('gallerydateimages.create');
        Route::post('/gallerydateimages/{gallerydate}/store', [GalleryDateImageController::class, 'store'])->name('gallerydateimages.store');
        Route::get('/gallerydateimages/{gallerydate}/edit/{gallerydateimage}', [GalleryDateImageController::class, 'edit'])->name('gallerydateimages.edit');
        Route::patch('/gallerydateimages/{gallerydate}/update/{gallerydateimage}', [GalleryDateImageController::class, 'update'])->name('gallerydateimages.update');
        Route::get('/gallerydateimages/{gallerydate}/show/{gallerydateimage}', [GalleryDateImageController::class, 'show'])->name('gallerydateimages.show');
        Route::delete('/gallerydateimages/delete/{gallerydateimage}', [GalleryDateImageController::class, 'destroy'])->name('gallerydateimages.destroy');


        // reports start
        Route::prefix('report')->group(function () {


            // vendor statement report
            Route::get('/vendor-statement', [ReportController::class, 'vendorStatement'])->name('vendorStatement');
            Route::get('/vendor-statement-print', [ReportController::class, 'vendorStatementPrint'])->name('vendorStatement.print');

            // plan sheet report
            Route::get('plan-sheet-follow-up', [ReportController::class, 'planSheetFollowUp'])->name('plan.sheet.follow.up');
            Route::get('plan-sheet-follow-up-print', [ReportController::class, 'planSheetFollowUpPrint'])->name('plan.sheet.follow.up.print');

            // project budget status report
            Route::get('project-budget-status', [ReportController::class, 'projectBudgetStatus'])->name('project.budget.status');
            Route::get('project-budget-status-print', [ReportController::class, 'projectBudgetStatusPrint'])->name('project.budget.status.print');

            // cash due status report
            Route::get('cash-due-status', [ReportController::class, 'cashDueStatus'])->name('cash.due.status');
            Route::get('cash-due-status-print', [ReportController::class, 'cashDueStatusPrint'])->name('cash.due.status.print');

            // Material Statement report
            Route::get('material-statement-report', [ReportController::class, 'materialStatement'])->name('material.statement.report');
            Route::get('material-statement-report-print', [ReportController::class, 'materialStatementPrint'])->name('material.statement.report.print');

            // daily consumption report
            Route::get('daily-consumption-report', [ReportController::class, 'dailyConsumptionReport'])->name('daily.consumption.report');
            Route::get('daily-consumption-report-print', [ReportController::class, 'dailyConsumptionReportPrint'])->name('daily.consumption.report.print');

            // local issue report
            Route::get('local-issue-report', [ReportController::class, 'localIssueReport'])->name('local.issue.report');
            Route::get('local-issue-report-print', [ReportController::class, 'localIssueReportPrint'])->name('local.issue.report.print');

            // stock report
            Route::get('stock-report', [ReportController::class, 'stockReport'])->name('stock.report');
            Route::get('stock-report-print', [ReportController::class, 'stockReportPrint'])->name('stock.report.print');

            // Lifting report
            Route::get('lifting-report', [ReportController::class, 'liftingReport'])->name('lifting.report');
            Route::get('lifting-report-print', [ReportController::class, 'liftingReportPrint'])->name('lifting.report.print');

            // Issue Log report
            Route::get('issue-log-report', [ReportController::class, 'IssueLogReport'])->name('issue.log.report');
            Route::get('issue-log-report-print', [ReportController::class, 'IssueLogReportPrint'])->name('issue.log.report.print');

            // Payment Log report
            Route::get('payment-log-report', [ReportController::class, 'PaymentLogReport'])->name('payment.log.report');
            Route::get('payment-log-report-print', [ReportController::class, 'PaymentLogReportPrint'])->name('payment.log.report.print');

            // Expence Log report
            Route::get('expense-log-report', [ReportController::class, 'ExpenseLogReport'])->name('expense.log.report');
            Route::get('expense-log-report-print', [ReportController::class, 'ExpenseLogReportPrint'])->name('expense.log.report.print');

            // Cost Ledger report
            Route::get('cost-ledger-report', [ReportController::class, 'CostLedgerReport'])->name('cost.ledger.report');
            Route::get('cost-ledger-report-print', [ReportController::class, 'CostLedgerReportPrint'])->name('cost.ledger.report.print');

            // project unit wise budget material details
            Route::get('budget-material-details/{projectId}/{unitId}/{budgetHeadId}', [ReportController::class, 'budgetMaterialDetails'])->name('budget.material.details');

            // project unit wise Issue material details
            Route::get('issue-material-details/{projectId}/{unitId}/{budgetHeadId}', [ReportController::class, 'issueMaterialDetails'])->name('issueMaterialDetails');

            // project unit wise consumption material details
            Route::get('consumption-material-details/{projectId}/{unitId}/{budgetHeadId}', [ReportController::class, 'consumptionMaterialDetails'])->name('consumptionMaterialDetails');
        });
    });
});
// ------------ dashboard end ----------




// ------------ utility start ----------

Route::get('/clear', function () {

    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('clear-compiled');

    // Artisan::call('optimize:clear');
    // Artisan::call('optimize');

    return "Cleared!";
});


// ------------ utility start ----------

Route::get('/storage-link', function () {

    $targetFolder = $_SERVER['DOCUMENT_ROOT'] . '/storage/app/public';
    $linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/public/storage';
    symlink($targetFolder, $linkFolder);
    echo 'Symlink Completed';

    artisan::call('storage:link');
});

// ------------ utility end ----------
