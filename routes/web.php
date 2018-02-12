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

Route::get('/', 'Auth\LoginController@showLoginForm');
/*
  | Default routing always check login
 */

Auth::routes();

Route::get('/home', 'HomeController@index');
/**
 *  Routing For Manage area
 */
Route::any('/areas', 'AreasController@index');
Route::get('/areas/createArea', 'AreasController@createArea');
Route::post('/areas/store', 'AreasController@store');
Route::get('/areas/editArea/{area_id}', 'AreasController@editArea');
Route::post('/areas/update/{area_id}', 'AreasController@update');
Route::get('/areas/deleteArea/{area_id}', 'AreasController@destroy');

/**
 * Routing For Manage Budget Head
 */
Route::any('/budgetHeads', 'HeadsController@index');
Route::get('/heads/createHead', 'HeadsController@createHead');
Route::post('/heads/store', 'HeadsController@store');
Route::get('/heads/editHead/{head_row_id}', 'HeadsController@editHead');
Route::post('/heads/update/{head_row_id}', 'HeadsController@update');
Route::get('/heads/deleteHead/{head_row_id}', 'HeadsController@destroy');
Route::get('/heads/getHeadAncestor/{head_row_id}', 'HeadsController@getHeadAncestor');
Route::any('/budget/project/head', 'ProjectHeadsController@index');
Route::get('/budget/heads/dropdown/{selected_budget_year}/{selected_head_row_id}', 'HeadsController@getHeadListByYear');
Route::get('/budget/report/heads/dropdown/{selected_budget_year}/{selected_head_row_id}', 'HeadsController@getHeadListByYearForReport');
Route::get('/budget/project/head/create', 'ProjectHeadsController@create');
Route::post('/budget/project/head/store', 'ProjectHeadsController@store');
Route::get('/budget/project/head/edit/{head_row_id}', 'ProjectHeadsController@edit');
Route::post('/budget/project/head/update/{head_row_id}', 'ProjectHeadsController@update');
Route::get('/budget/project/head/delete/{head_row_id}', 'ProjectHeadsController@destroy');
/**
 * Routing For Manage Budget Allocation
 */
Route::any('/budgetAllocation', 'AllocationController@index');
Route::get('/createAllocation', 'AllocationController@createAllocation');
Route::post('/allocation/store', 'AllocationController@store');
Route::any('/allocationDetails/{head_row_id}', 'AllocationController@allocationDetails');
Route::get('/allocation/edit/{allocation_row_id}', 'AllocationController@edit');
Route::post('/allocation/update/{allocation_row_id}', 'AllocationController@update');
Route::get('/allocation/delete/{allocation_row_id}', 'AllocationController@destroy');
/**
 * Routing For Manage Budget Expense
 */
Route::any('/budgetExpense', 'ExpenseController@index');
Route::get('/createExpense', 'ExpenseController@createExpense');
Route::post('/expense/store', 'ExpenseController@store');
Route::any('/expenseDetails/{head_row_id}', 'ExpenseController@expenseDetails');
Route::get('/expense/edit/{expense_row_id}', 'ExpenseController@edit');
Route::post('/expense/update/{expense_row_id}', 'ExpenseController@update');
Route::get('/expense/delete/{expense_row_id}', 'ExpenseController@destroy');
/**
 * Routing For Manage Budget Expense Report
 */
Route::any('/budgetReport/expense', 'BudgetReportController@index')->name('budgetExpenseReport');
Route::any('/budgetReport/expenseReportDetails', 'BudgetReportController@expenseReportDetails');
Route::any('/budgetReport/expenseReportDownload', 'BudgetReportController@expenseReportDownload');
Route::any('/budgetReport/expenseReportDetailsDownload', 'BudgetReportController@expenseReportDetailsDownload');
Route::any('/budgetReport/expenseExtended', 'BudgetReportController@expenseReportExtended');
Route::any('/budgetReport/expenseReportExtendedDownload', 'BudgetReportController@expenseReportExtendedDownload');
Route::any('/budgetReport/expenseReportExtendedCSVDownload', 'BudgetReportController@expenseReportExtendedCSVDownload');
Route::any('/budgetReport/expenseAdvanced', 'BudgetReportController@reportAdvanced');
/**
 * Routing For Manage Budget Balance Report
 */
Route::any('/budgetReport/balance', 'BalanceReportController@index');
Route::any('/budgetReport/balanceReportDownload', 'BalanceReportController@balanceReportPdfDownload');
Route::any('/budgetReport/balanceReportCSVDownload', 'BalanceReportController@balanceReportCSVDownload');
Route::any('/budgetReport/balance/summary', 'BalanceSummaryReportController@index');
Route::any('/budgetReport/balance/summary/download', 'BalanceSummaryReportController@balanceReportPdfDownload');
Route::any('/budgetReport/balance/summary/downloadCSV', 'BalanceSummaryReportController@downloadBalanceSummaryReportCsv');
/**
 * Routing For Manage Budget Adjustment
 */
Route::get('/budget/adjustment', 'BudgetAdjustmentController@index');
Route::post('/budget/adjustment/store', 'BudgetAdjustmentController@store');
Route::any('/budget/adjustment/details/{head_row_id}', 'BudgetAdjustmentController@details');
Route::get('/budget/adjustment/edit/{allocation_row_id}', 'BudgetAdjustmentController@edit');
Route::post('/budget/adjustment/update/{allocation_row_id}', 'BudgetAdjustmentController@update');
Route::get('/budget/adjustment/delete/{allocation_row_id}', 'BudgetAdjustmentController@destroy');
Route::any('/budget/adjustment/report', 'AdjustmentReportController@index');
Route::any('/budget/allocation/adjustment/report', 'AllocationAdjustmentReportController@index');
Route::any('/budget/allocation/adjustment/report/download', 'AllocationAdjustmentReportController@allocationReportPdfDownload');
Route::any('/budget/allocation/adjustment/report/downloadCSV', 'AllocationAdjustmentReportController@downloadAllocationReportCsv');
Route::any('/budget/allocation/report/details', 'AllocationReportController@allocationReportDetails');
Route::any('/budget/allocation/report/details/download', 'AllocationReportController@allocationReportDetailsPdfDownload');
Route::any('/budget/allocation/report/download', 'AllocationReportController@allocationReportPdfDownload');
Route::any('/budget/allocation/report/downloadCSV', 'AllocationReportController@downloadAllocationReportCsv');
Route::any('/budget/adjustment/report/download', 'AdjustmentReportController@adjustmentReportPdfDownload');
Route::any('/budget/adjustment/report/downloadCSV', 'AdjustmentReportController@downloadAdjustmentReportCsv');
/**
 * Routing For Budget Allocation Report
 */
Route::any('/budget/allocation/report', 'AllocationReportController@index');
Route::any('/budget/allocation/summary/report', 'AllocationSummaryReportController@index');
Route::any('/budget/allocation/summary/report/download', 'AllocationSummaryReportController@allocationSummaryReportPdfDownload');
Route::any('/budget/allocation/summary/report/downloadCSV', 'AllocationSummaryReportController@downloadAllocationSummaryReportCsv');
Route::any('/budget/allocation/report/details/downloadCSV', 'AllocationReportController@downloadAllocationDetailsReportCsv');
/**
 * Routing For Hospital MIS
 */
/**
 * Manage Hospital
 */
Route::any('/mis/hospital/list', 'ManageHospitalController@index');
Route::get('/mis/hospital/createHospital', 'ManageHospitalController@createHospital');
Route::post('/mis/hospital/storeHospital', 'ManageHospitalController@store');
Route::get('/mis/hospital/editHospital/{hospital_row_id}', 'ManageHospitalController@editHospital');
Route::post('/mis/hospital/updateHospital/{hospital_row_id}', 'ManageHospitalController@update');
Route::get('/mis/hospital/deleteHospital/{hospital_row_id}', 'ManageHospitalController@destroy');

/**
 * Manage Patient Type
 */
Route::any('/mis/hospital/patient/typeList', 'PatientTypeController@index');
Route::get('/mis/hospital/patient/createType', 'PatientTypeController@createType');
Route::post('/mis/hospital/patient/storeType', 'PatientTypeController@store');
Route::get('/mis/hospital/patient/edittype/{patient_type_row_id}', 'PatientTypeController@editType');
Route::post('/mis/hospital/patient/updateType/{patient_type_row_id}', 'PatientTypeController@update');
Route::get('/mis/hospital/patient/deleteType/{patient_type_row_id}', 'PatientTypeController@destroy');

/**
 * Manage Hospital Patient List
 */
Route::any('/mis/hospital/patient/list', 'PatientListController@index');
Route::get('/mis/hospital/patient/create', 'PatientListController@create');
Route::post('/mis/hospital/patient/store', 'PatientListController@store');
Route::get('/mis/hospital/patient/list/edit/{hospital_row_id}/{report_at}', 'PatientListController@edit');
Route::post('/mis/hospital/patient/update/{hospital_row_id}/{report_at}', 'PatientListController@update');
Route::get('/mis/hospital/patient/list/delete/{hospital_row_id}/{report_at}', 'PatientListController@destroy');


/**
 * Manage Hospital Pathology List
 */
Route::any('/mis/hospital/pathology/itemList', 'PathologyItemController@index');
Route::get('/mis/hospital/pathology/createItem', 'PathologyItemController@createItem');
Route::post('/mis/hospital/pathology/storeItem', 'PathologyItemController@store');
Route::get('/mis/hospital/pathology/editItem/{pathology_item_row_id}', 'PathologyItemController@editItem');
Route::post('/mis/hospital/pathology/updateItem/{pathology_item_row_id}', 'PathologyItemController@update');
Route::get('/mis/hospital/pathology/deleteItem/{pathology_item_row_id}', 'PathologyItemController@destroy');


/**
 * Manage Hospital Pathology List
 */
Route::any('/mis/hospital/pathology/list', 'PathologyListController@index');
Route::get('/mis/hospital/pathology/create', 'PathologyListController@create');
Route::post('/mis/hospital/pathology/store', 'PathologyListController@store');
Route::get('/mis/hospital/pathology/list/edit/{hospital_row_id}/{report_at}', 'PathologyListController@edit');
Route::post('/mis/hospital/pathology/update/{hospital_row_id}/{report_at}', 'PathologyListController@update');
Route::get('/mis/hospital/pathology/list/delete/{hospital_row_id}/{report_at}', 'PathologyListController@destroy');


/**
 * Manage Hospital Income Item List
 */
Route::any('/mis/hospital/income/itemList', 'IncomeItemController@index');
Route::get('/mis/hospital/income/createItem', 'IncomeItemController@createItem');
Route::post('/mis/hospital/income/storeItem', 'IncomeItemController@store');
Route::get('/mis/hospital/income/editItem/{income_item_row_id}', 'IncomeItemController@editItem');
Route::post('/mis/hospital/income/updateItem/{income_item_row_id}', 'IncomeItemController@update');
Route::get('/mis/hospital/income/deleteItem/{income_item_row_id}', 'IncomeItemController@destroy');

/**
 * Manage Hospital Income List
 */
Route::any('/mis/hospital/income/list', 'IncomeListController@index');
Route::get('/mis/hospital/income/create', 'IncomeListController@create');
Route::post('/mis/hospital/income/store', 'IncomeListController@store');
Route::get('/mis/hospital/income/list/edit/{hospital_row_id}/{report_at}', 'IncomeListController@edit');
Route::post('/mis/hospital/income/update/{hospital_row_id}/{report_at}', 'IncomeListController@update');
Route::get('/mis/hospital/income/list/delete/{hospital_row_id}/{report_at}', 'IncomeListController@destroy');


/**
 * Manage Hospital Expense Item List
 */
Route::any('/mis/hospital/expense/itemList', 'ExpenseItemController@index');
Route::get('/mis/hospital/expense/createItem', 'ExpenseItemController@createItem');
Route::post('/mis/hospital/expense/storeItem', 'ExpenseItemController@store');
Route::get('/mis/hospital/expense/editItem/{expense_item_row_id}', 'ExpenseItemController@editItem');
Route::post('/mis/hospital/expense/updateItem/{expense_item_row_id}', 'ExpenseItemController@update');
Route::get('/mis/hospital/expense/deleteItem/{expense_item_row_id}', 'ExpenseItemController@destroy');

/**
 * Manage Hospital Expense List
 */
Route::any('/mis/hospital/expense/list', 'ExpenseListController@index');
Route::get('/mis/hospital/expense/create', 'ExpenseListController@create');
Route::post('/mis/hospital/expense/store', 'ExpenseListController@store');
Route::get('/mis/hospital/expense/list/edit/{hospital_row_id}/{report_at}', 'ExpenseListController@edit');
Route::post('/mis/hospital/expense/update/{hospital_row_id}/{report_at}', 'ExpenseListController@update');
Route::get('/mis/hospital/expense/list/delete/{hospital_row_id}/{report_at}', 'ExpenseListController@destroy');

/**
 * Manage Hospital Free Medicine Item List
 */
Route::any('/mis/hospital/free/medicine/itemList', 'FreeMedicineItemController@index');
Route::get('/mis/hospital/free/medicine/createItem', 'FreeMedicineItemController@createItem');
Route::post('/mis/hospital/free/medicine/storeItem', 'FreeMedicineItemController@store');
Route::get('/mis/hospital/free/medicine/editItem/{free_medicine_item_row_id}', 'FreeMedicineItemController@editItem');
Route::post('/mis/hospital/free/medicine/updateItem/{free_medicine_item_row_id}', 'FreeMedicineItemController@update');
Route::get('/mis/hospital/free/medicine/deleteItem/{free_medicine_item_row_id}', 'FreeMedicineItemController@destroy');

/**
 * Manage Hospital Free Medicine List
 */
Route::any('/mis/hospital/free/medicine/list', 'FreeMedicineListController@index');
Route::get('/mis/hospital/free/medicine/create', 'FreeMedicineListController@create');
Route::post('/mis/hospital/free/medicine/store', 'FreeMedicineListController@store');
Route::get('/mis/hospital/free/medicine/list/edit/{hospital_row_id}/{report_at}', 'FreeMedicineListController@edit');
Route::post('/mis/hospital/free/medicine/update/{hospital_row_id}/{report_at}', 'FreeMedicineListController@update');
Route::get('/mis/hospital/free/medicine/list/delete/{hospital_row_id}/{report_at}', 'FreeMedicineListController@destroy');

/**
 * Manage Hospital MIS Reports
 */
Route::any('/mis/hospital/report', 'HospitalReportController@index');
Route::any('/mis/hospital/report/download', 'HospitalReportController@downloadHospitalReport');

/**
 * Manage Education MIS  Area
 */
Route::any('/mis/education/area/list', 'EducationAreasController@index');
Route::get('/mis/education/area/create', 'EducationAreasController@create');
Route::post('/mis/education/area/store', 'EducationAreasController@store');
Route::get('/mis/education/area/edit/{education_area_row_id}', 'EducationAreasController@edit');
Route::post('/mis/education/area/update/{education_area_row_id}', 'EducationAreasController@update');
Route::get('/mis/education/area/delete/{education_area_row_id}', 'EducationAreasController@destroy');

/**
 * Manage Education MIS  Exam
 */
Route::any('/mis/education/exam/list', 'EducationExamsController@index');
Route::get('/mis/education/exam/create', 'EducationExamsController@create');
Route::post('/mis/education/exam/store', 'EducationExamsController@store');
Route::get('/mis/education/exam/edit/{education_exam_row_id}', 'EducationExamsController@edit');
Route::post('/mis/education/exam/update/{education_exam_row_id}', 'EducationExamsController@update');
Route::get('/mis/education/exam/delete/{education_exam_row_id}', 'EducationExamsController@destroy');

/**
 * Manage Education MIS  Grade
 */
Route::any('/mis/education/grade/list', 'EducationGradesController@index');
Route::get('/mis/education/grade/create', 'EducationGradesController@create');
Route::post('/mis/education/grade/store', 'EducationGradesController@store');
Route::get('/mis/education/grade/edit/{education_grade_row_id}', 'EducationGradesController@edit');
Route::post('/mis/education/grade/update/{education_grade_row_id}', 'EducationGradesController@update');
Route::get('/mis/education/grade/delete/{education_grade_row_id}', 'EducationGradesController@destroy');

/**
 * Manage Education MIS  School/Institute
 */
Route::any('/mis/education/institute/list', 'EducationInstitutesController@index');
Route::get('/mis/education/institute/create', 'EducationInstitutesController@create');
Route::post('/mis/education/institute/store', 'EducationInstitutesController@store');
Route::get('/mis/education/institute/edit/{education_institute_row_id}', 'EducationInstitutesController@edit');
Route::post('/mis/education/institute/update/{education_institute_row_id}', 'EducationInstitutesController@update');
Route::get('/mis/education/institute/delete/{education_institute_row_id}', 'EducationInstitutesController@destroy');


/**
 * Manage Education Result List
 */
Route::any('/mis/education/result/list', 'EducationResultsController@index');
Route::get('/mis/education/result/create', 'EducationResultsController@create');
Route::post('/mis/education/result/store', 'EducationResultsController@store');
Route::get('/mis/education/result/list/edit/{education_institute_row_id}/{education_exam_row_id}/{result_year}', 'EducationResultsController@edit');
Route::post('/mis/education/result/update/{education_institute_row_id}/{education_exam_row_id}/{result_year}', 'EducationResultsController@update');
Route::get('/mis/education/result/list/delete/{education_institute_row_id}/{education_exam_row_id}/{result_year}', 'EducationResultsController@destroy');

/**
 * Manage Education MIS Reports
 */
Route::any('/mis/education/report', 'EducationResultReportController@index');
Route::any('/mis/education/report/download', 'EducationResultReportController@downloadEducationReport');
Route::get('/mis/education/getInstituteExamList/{type_id}/{institute_exam_id}', 'EducationResultReportController@getInstituteExamList');

/**
 * Routing For Relief MIS
 */
Route::any('/mis/relief/areaList', 'ReliefAreasController@index');
Route::get('/mis/relief/createArea', 'ReliefAreasController@create');
Route::post('/mis/relief/storeArea', 'ReliefAreasController@store');
Route::get('/mis/relief/editArea/{relief_area_row_id}', 'ReliefAreasController@edit');
Route::post('/mis/relief/updateArea/{relief_area_row_id}', 'ReliefAreasController@update');
Route::get('/mis/relief/deleteArea/{relief_area_row_id}', 'ReliefAreasController@destroy');


/**
 * Routing For Tree Plantation MIS
 */
Route::any('/mis/treePlantation/list', 'TreePlantationsController@index');
Route::get('/mis/treePlantation/create', 'TreePlantationsController@create');
Route::post('/mis/treePlantation/store', 'TreePlantationsController@store');
Route::get('/mis/treePlantation/edit/{tree_plantation_row_id}', 'TreePlantationsController@edit');
Route::post('/mis/treePlantation/update/{tree_plantation_row_id}', 'TreePlantationsController@update');
Route::get('/mis/treePlantation/delete/{tree_plantation_row_id}', 'TreePlantationsController@destroy');

/**
 * Routing For Relief MIS
 */
Route::any('/mis/relief/list', 'ReliefsController@index');
Route::get('/mis/relief/create', 'ReliefsController@create');
Route::post('/mis/relief/store', 'ReliefsController@store');
Route::get('/mis/relief/edit/{relief_row_id}', 'ReliefsController@edit');
Route::post('/mis/relief/update/{relief_row_id}', 'ReliefsController@update');
Route::get('/mis/relief/delete/{relief_row_id}', 'ReliefsController@destroy');

/**
 * Manage Relief/Tree Plantation MIS Reports
 */
Route::any('/mis/relief/report', 'ReliefReportController@index');
Route::any('/mis/relief/report/download', 'ReliefReportController@downloadReliefReport');
Route::any('/mis/tree/plantation/report', 'TreePlantationReportController@index');
Route::any('/mis/tree/plantation/report/download', 'TreePlantationReportController@downloadTreePlantationReport');

/**
 * Routing For Manage Budget Allocation
 */
Route::any('/jakat/allocation/list', 'JakatAllocationsController@index');
Route::get('/jakat/allocation/create', 'JakatAllocationsController@create');
Route::post('/jakat/allocation/store', 'JakatAllocationsController@store');
Route::any('/jakat/allocation/details/{jakat_year}', 'JakatAllocationsController@details');
Route::get('/jakat/allocation/edit/{jakat_allocation_row_id}', 'JakatAllocationsController@edit');
Route::post('/jakat/allocation/update/{jakat_allocation_row_id}', 'JakatAllocationsController@update');
Route::get('/jakat/allocation/delete/{jakat_allocation_row_id}', 'JakatAllocationsController@destroy');

/**
 * Routing For Manage Jakat Applicant
 */
Route::any('/jakat/applicant/list', 'JakatApplicantsController@index');
Route::get('/jakat/applicant/create', 'JakatApplicantsController@create');
Route::post('/jakat/applicant/store', 'JakatApplicantsController@store');
Route::get('/jakat/applicant/edit/{jakat_recipient_row_id}', 'JakatApplicantsController@edit');
Route::post('/jakat/applicant/update/{jakat_recipient_row_id}', 'JakatApplicantsController@update');
Route::get('/jakat/applicant/getApplicantPartialFormByType/{applicant_type}', 'JakatApplicantsController@getApplicantPartialFormByType');
Route::get('/jakat/applicant/delete/{jakat_recipient_row_id}', 'JakatApplicantsController@destroy');
Route::any('/jakat/applicant/checkUniqueApplicantByMobile/{mobile_number}', 'JakatApplicantsController@checkUniqueApplicantByMobile');
Route::any('/jakat/applicant/checkUniqueApplicantByMobileOnUpdate/{mobile_number}/{jakat_recipient_row_id}', 'JakatApplicantsController@checkUniqueApplicantByMobileOnUpdate');
Route::get('/jakat/applicant/getApplicantJsonList/{applicant_type}', 'JakatApplicantsController@getApplicantJsonList');

/**
 * Routing For Manage Jakat Donation
 */
Route::any('/jakat/donation/list', 'JakatDonationController@index');
Route::any('/jakat/donation/create', 'JakatDonationController@create');
Route::post('/jakat/donation/store', 'JakatDonationController@store');
Route::get('/jakat/donation/edit/{jakat_donation_row_id}', 'JakatDonationController@edit');
Route::post('/jakat/donation/update/{jakat_donation_row_id}', 'JakatDonationController@update');
Route::get('/jakat/donation/delete/{jakat_donation_row_id}', 'JakatDonationController@destroy');
Route::get('/jakat/donation/getPartialformByType/{applicant_type}', 'JakatDonationController@getPartialFormByType');
Route::get('/jakat/donation/getApplicantListByType/{applicant_type}/{jakat_recipient_row_id}', 'JakatDonationController@getApplicantListByType');
Route::get('/jakat/donation/getApplicantListByTypeOnUpdate/{applicant_type}/{jakat_recipient_row_id}', 'JakatDonationController@getApplicantListByTypeOnUpdate');
Route::any('/jakat/donation/report', 'JakatReportsController@index');
Route::any('/jakat/donation/downloadDonationList', 'JakatReportsController@downloadDonationList');
Route::any('/jakat/donation/details/{jakat_donation_row_id}', 'JakatReportsController@donationDetails');
Route::any('/jakat/donation/details/download/{jakat_donation_row_id}', 'JakatReportsController@donationDetailsDownload');

/**
 * Routing for Daridro Bimochon Project
 */
Route::any('/dbp/branch/list', 'DbpBranchController@index');
Route::get('/dbp/branch/create', 'DbpBranchController@create');
Route::post('/dbp/branch/store', 'DbpBranchController@store');
Route::get('/dbp/branch/edit/{dbp_branch_row_id}', 'DbpBranchController@edit');
Route::post('/dbp/branch/update/{dbp_branch_row_id}', 'DbpBranchController@update');
Route::get('/dbp/branch/delete/{dbp_branch_row_id}', 'DbpBranchController@destroy');

/**
 * Routing for DBP Category
 */
Route::any('/dbp/category/list', 'DbpCategoryController@index');
Route::get('/dbp/category/create', 'DbpCategoryController@create');
Route::post('/dbp/category/store', 'DbpCategoryController@store');
Route::get('/dbp/category/edit/{dbp_category_row_id}', 'DbpCategoryController@edit');
Route::post('/dbp/category/update/{dbp_category_row_id}', 'DbpCategoryController@update');
Route::get('/dbp/category/delete/{dbp_category_row_id}', 'DbpCategoryController@destroy');

/**
 * Routing for DBP Category Item
 */
Route::any('/dbp/item/list', 'DbpItemController@index');
Route::get('/dbp/item/create', 'DbpItemController@create');
Route::post('/dbp/item/store', 'DbpItemController@store');
Route::get('/dbp/item/edit/{dbp_item_row_id}', 'DbpItemController@edit');
Route::post('/dbp/item/update/{dbp_item_row_id}', 'DbpItemController@update');
Route::get('/dbp/item/delete/{dbp_item_row_id}', 'DbpItemController@destroy');



use App\Libraries\HrCommon;
Route::resource('/manage-employee', 'ManageEmployeeController');
Route::post('/manage-employee/search', 'ManageEmployeeController@search');
Route::resource('/manage-employee', 'ManageEmployeeController', ['names' => 'hr-manage-employee']);
Route::post('manage-employee/{id}/update', 'ManageEmployeeController@update');
Route::get('/manage-employee/{employee_row_id}/employeeDetailsPdf', 'ManageEmployeeController@employeeDetailsPdf');
Route::any('/hr/manage-departments', 'ManageEmployeeController@departments')->name('hr-department');
Route::get('/hr/manage-departments/delete/{department_row_id}', 'ManageEmployeeController@deleteDepartment');

Route::any('/hr/manage-designations', 'ManageEmployeeController@designations')->name('hr-designation');
Route::get('/hr/manage-designations/delete/{designation_row_id}', 'ManageEmployeeController@deleteDesignation');
Route::any('/hr/employee-list-payroll', 'ManageEmployeeController@employeeListForPayroll')->name('hr-employee-payroll');

Route::get('/hr/salary-sheet', 'ManageEmployeeController@salarySheet')->name('hr-salary-sheet');


Route::get('/hr/salary-sheet', 'ManageEmployeeController@salarySheet')->name('hr-salary-sheet');
Route::any('/hr/salary-heads', 'ManageEmployeeController@salaryHeads')->name('hr-salary-head');
Route::any('/hr/salary-heads/delete/{id}', 'ManageEmployeeController@deleteSalaryHeads');
Route::get('/hr/salary-heads-pay-setting', 'ManageEmployeeController@salaryHeadsPaySettings')->name('hr-salary-head-pay-setting');
Route::post('/hr/save-salary-heads-pay-setting', 'ManageEmployeeController@saveSalaryHeadsPaySettings')->name('hr-salary-head-pay-setting');
Route::get('/hr/get-salary-head-amount/{basic_salary}', 'ManageEmployeeController@getSalaryHeadAmount')->name('hr-salary-setting');


Route::any('/hr/salary-heads', 'ManageEmployeeController@salaryHeads')->name('hr-salary-head');
Route::any('/hr/salary-heads/delete/{id}', 'ManageEmployeeController@deleteSalaryHeads');
Route::get('/hr/salary-heads-pay-setting', 'ManageEmployeeController@salaryHeadsPaySettings')->name('hr-salary-head-pay-setting');
Route::get('/hr/get-salary-head-amount/{basic_salary}', 'ManageEmployeeController@getSalaryHeadAmount')->name('hr-salary-setting');

Route::get('/hr/get-employee-starting-salary/{employee_row_id}', 'ManageEmployeeController@getEmployeeStartingSalary');
Route::any('/hr/employee-salary-settings/{employee_row_id}', 'ManageEmployeeController@employeeSalarySettings');

Route::get('/hr/manage-employee/{employee_row_id}/download','ManageEmployeeController@downloadAllDocuments');

Route::post('/hr/save-increament/{employee_row_id}', 'ManageEmployeeController@saveIncreament');
Route::get('/hr/employee-increament-edit/{employee_row_id}', 'ManageEmployeeController@editIncreament');
Route::post('/hr/salary-sheet-view-with-leave-record', 'ManageEmployeeController@salarySheetViewWithLeaveRecord');


/* .......... Attendance Routes.......................  */

//get attendance from device csv.
Route::get('hr/attendance/attendance-from-device', 'ManageAttendanceController@sinkAttendanceRecordsFromCsvOption')->name('attendance-from-device');
Route::post('hr/attendance/sinkAttendanceRecordsFromCsv', 'ManageAttendanceController@sinkAttendanceRecordsFromCsv');

//get attendance manualy
Route::any('hr/attendance/manual-attendance', 'ManageAttendanceController@manualAttendanceForm')->name('manual-attendance');
Route::any('hr/attendance/store-attendance', 'ManageAttendanceController@storeStaffAttendance')->name('manual-attendance');

//staff attendance report 
Route::get('hr/attendance/all-staff-attendance-report-option', 'ManageAttendanceController@allStaffAttendanceReportOption')->name('all-staff-attendance-report-option');
Route::post('hr/attendance/all-staff-attendance-report-show', 'ManageAttendanceController@allStaffAttendanceReportShow');
Route::get('hr/attendance/individual-staff-attendance-report-option', 'ManageAttendanceController@individualStaffAttendanceReportOption')->name('hr/attendance/individual-staff-attendance-report-option');
Route::post('hr/attendance/individual-staff-attendance-report-show', 'ManageAttendanceController@individualStaffAttendanceReportShow');
Route::get('hr/attendance/all-staff-attendance-report-pdf/{date}', 'ManageAttendanceController@allStaffAttendanceReportPdf');
Route::get('hr/attendance/staff-individual-report-pdf/{id}/{fromDate}/{toDate}', 'ManageAttendanceController@staffIndividualReportPdf');
Route::get('hr/attendance/all-staff-attendance-monthly-report-option', 'ManageAttendanceController@allStaffAttendanceMonthlyReportOption')->name('all-staff-attendance-monthly-report-option');
Route::post('hr/attendance/all-staff-attendance-monthly-report-pdf', 'ManageAttendanceController@allStaffAttendanceMonthlyReportPdf');








Route::post('schoolAdmin/attendance/staffList', 'ManageAttendanceController@staffList');
Route::post('schoolAdmin/staffAttendance/storeStaffAttendance', 'ManageAttendanceController@storeStaffAttendance');


Route::get('schoolAdmin/attendance/studentIndividualReportPdf/{id}/{val1}/{val2}', 'ManageAttendanceController@studentIndividualReportPdf');
/* .......... End of Attendance route.....................*/


//.........................Leave Management....................................

Route::get('/hr/employee-leave', 'ManageEmployeeLeaveController@index')->name('hr-manage-leave');
Route::post('/hr/employee-leave/create', 'ManageEmployeeLeaveController@create');
Route::get('/hr/employee-leave/{leave_record_row_id}/delete', 'ManageEmployeeLeaveController@deleteRecord');
Route::get('/hr/employee-leave/{leave_record_row_id}/edit', 'ManageEmployeeLeaveController@edit');

//..........................Manage Institutions..................................
Route::any('/hr/manage-institutions', 'ManageEmployeeController@institutions')->name('hr-institutions');
Route::get('/hr/manage-institutions/delete/{institution_row_id}', 'ManageEmployeeController@deleteInstitution');

//...........................Manage Calender..................................................
Route::get('/hr/calender', 'ManageCalenderController@index')->name('hr-calender');
Route::get('/hr/calender/pdf/{format}', 'ManageCalenderController@calenderPdfDownload');
Route::post('/hr/manageCalender/storeEventDetails', 'ManageCalenderController@storeEventDetails');
Route::get('/hr/calender/deleteEvent/{event_row_id}', 'ManageCalenderController@deleteEvent');
Route::get('/hr/viewcalender', 'ManageCalenderController@viewCalender');
Route::get('/hr/viewcalender/viewAsCalendar', 'ManageCalenderController@viewAsCalendar');

//..............................Employee performance...........................................
Route::get('/hr/employee-performance', 'ManagePerformanceController@index')->name('hr-manage-employee-performance');
Route::post('/hr/employee-performance/store', 'ManagePerformanceController@store');

Route::get('/hr/employee-performance/delete/{id}', 'ManagePerformanceController@deleteRecord');

//..........................Manage Weekend.........................................................
Route::get('/hr/institution-offday', 'ManageOffDayController@index')->name('hr-manage-offday');
Route::post('/hr/institution-offday/create', 'ManageOffDayController@create');
Route::get('/hr/institution-offday/delete/{off_day_row_id}', 'ManageOffDayController@delete');

//..........................Send sms...............................................................
Route::get('/hr/sendSMS', 'SendSMSController@index')->name('hr-sendSMS');
Route::post('/hr/sendSMS', 'SendSMSController@sendSMS');
	
//.............................Common............................................

Route::get('getDesignation/{department_row_id}/{current_designation_id?}', function ($department_row_id, $current_designation_id = 0) {
    $CommonData = new \App\Libraries\HrCommon();
    return $CommonData->getDesignations($department_row_id, $current_designation_id);
});
Route::get('getDistricts/{divisionId}/{presentDist?}', function ($divisionId, $presentDist = NULL) {
    $CommonData = new HrCommon();
    return $CommonData->getDistricts($divisionId, $presentDist);
});
Route::get('getUpazilas/{districtId}/{presentUpazila?}', function ($districtId, $presentUpazila = NULL) {
    $CommonData = new HrCommon();
    return $CommonData->getUpazilas($districtId, $presentUpazila);
});

Route::get('getEmployeeList/{department_row_id}/{employee_row_id?}', function ($department_row_id,$employee_row_id=0) {
    $CommonData = new HrCommon();
    return $CommonData->employeeListByDepartment($department_row_id,$employee_row_id);
});

Route::get('getInstitutions/{area_row_id}/{department_row_id}/{current_institution_id?}', function ($area_row_id,$department_row_id, $current_institution_id = 0) {
    $CommonData = new \App\Libraries\HrCommon();
    return $CommonData->getInstitutions($area_row_id,$department_row_id, $current_institution_id);
});


