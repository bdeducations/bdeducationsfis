<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function budget_year_list() {
    $year_array = array(
        '2010' => '2010',
        '2011' => '2011',
        '2012' => '2012',
        '2013' => '2013',
        '2014' => '2014',
        '2015' => '2015',
        '2016' => '2016',
        '2017' => '2017',
        '2018' => '2018',
        '2019' => '2019',
        '2020' => '2020',
        '2021' => '2021',
        '2022' => '2022',
        '2023' => '2023',
        '2024' => '2024',
        '2025' => '2025',
        '2026' => '2026',
        '2027' => '2027',
        '2028' => '2028',
        '2029' => '2029',
        '2030' => '2030'
    );
    return $year_array;
}

function relief_item_list() {
    $item_array = array(
        '1' => 'Blanket',
        '2' => 'Medicine',
        '3' => 'Dry Eatable Food',
        '4' => 'Water',
        '5' => 'Grocery',
        '6' => 'Shelter',
        '7' => 'Street Light'
    );
    return $item_array;
}

function getCurrentDateTimeForDB() {
    return date('Y-m-d H:i:s');
}

function getMenuListByRole($role_row_id) {
    $menu_list = array();
    if ($role_row_id == 1) {
        $menu_list['area_menu'] = 1;
        $menu_list['head_menu'] = 1;
        $menu_list['project_head_menu'] = 1;
        $menu_list['budget_allocation_menu'] = 1;
        $menu_list['budget_adjustment_menu'] = 1;
        $menu_list['budget_expenditure_menu'] = 1;
        $menu_list['budget_allocation_report_menu'] = 1;
        $menu_list['budget_report_menu'] = 1;
        $menu_list['budget_allocation_summary_report_menu'] = 1;
        $menu_list['budget_allocation_adjustment_report_menu'] = 1;
        $menu_list['budget_adjustment_report_menu'] = 1;
        $menu_list['budget_expense_report_menu'] = 1;
        $menu_list['budget_expenditure_report_menu'] = 1;
        $menu_list['budget_expenditure_summary_report_menu'] = 1;
        $menu_list['budget_expense_report_menu'] = 1;
        $menu_list['donation_mis_menu'] = 1;
        $menu_list['education_mis_menu'] = 1;
        $menu_list['hospital_mis_menu'] = 1;
        $menu_list['relief_tree_mis_menu'] = 1;
        $menu_list['jakat_mis_menu'] = 1;
        $menu_list['dbp_mis_menu'] = 1;
    } else {
        /**
         * Check area menu
         */
        $area_menu_permission = \App\Models\RolePermission::where([['role_row_id', '=', $role_row_id], ['controller', '=', "Areas"]])->first();
        if (!count($area_menu_permission) || ($area_menu_permission->allow_view == 0) && ($area_menu_permission->allow_create == 0) && ($area_menu_permission->allow_update == 0) && ($area_menu_permission->allow_delete == 0)) {
            $menu_list['area_menu'] = 0;
        } else {
            $menu_list['area_menu'] = 1;
        }
        /**
         * Check Head menu
         */
        $head_menu_permission = \App\Models\RolePermission::where([['role_row_id', '=', $role_row_id], ['controller', '=', "Heads"]])->first();
        if (!count($head_menu_permission) || ($head_menu_permission->allow_view == 0) && ($head_menu_permission->allow_create == 0) && ($head_menu_permission->allow_update == 0) && ($head_menu_permission->allow_delete == 0)) {
            $menu_list['head_menu'] = 0;
        } else {
            $menu_list['head_menu'] = 1;
        }
        /**
         * Check Project Head menu
         */
        $project_head_menu_permission = \App\Models\RolePermission::where([['role_row_id', '=', $role_row_id], ['controller', '=', "ProjectHeads"]])->first();
        if (!count($project_head_menu_permission) || ($project_head_menu_permission->allow_view == 0) && ($project_head_menu_permission->allow_create == 0) && ($project_head_menu_permission->allow_update == 0) && ($project_head_menu_permission->allow_delete == 0)) {
            $menu_list['project_head_menu'] = 0;
        } else {
            $menu_list['project_head_menu'] = 1;
        }
        /**
         * Check Budget Allocation menu
         */
        $budget_allocation_menu_permission = \App\Models\RolePermission::where([['role_row_id', '=', $role_row_id], ['controller', '=', "Allocation"]])->first();
        if (!count($budget_allocation_menu_permission) || ($budget_allocation_menu_permission->allow_view == 0) && ($budget_allocation_menu_permission->allow_create == 0) && ($budget_allocation_menu_permission->allow_update == 0) && ($budget_allocation_menu_permission->allow_delete == 0)) {
            $menu_list['budget_allocation_menu'] = 0;
        } else {
            $menu_list['budget_allocation_menu'] = 1;
        }
        /**
         * Check Budget Adjustment menu
         */
        $budget_adjustment_menu_permission = \App\Models\RolePermission::where([['role_row_id', '=', $role_row_id], ['controller', '=', "BudgetAdjustment"]])->first();
        if (!count($budget_adjustment_menu_permission) || ($budget_adjustment_menu_permission->allow_view == 0) && ($budget_adjustment_menu_permission->allow_create == 0) && ($budget_adjustment_menu_permission->allow_update == 0) && ($budget_adjustment_menu_permission->allow_delete == 0)) {
            $menu_list['budget_adjustment_menu'] = 0;
        } else {
            $menu_list['budget_adjustment_menu'] = 1;
        }
        /**
         * Check Budget Expenditure menu
         */
        $budget_expenditure_menu_permission = \App\Models\RolePermission::where([['role_row_id', '=', $role_row_id], ['controller', '=', "Expense"]])->first();
        if (!count($budget_expenditure_menu_permission) || ($budget_expenditure_menu_permission->allow_view == 0) && ($budget_expenditure_menu_permission->allow_create == 0) && ($budget_expenditure_menu_permission->allow_update == 0) && ($budget_expenditure_menu_permission->allow_delete == 0)) {
            $menu_list['budget_expenditure_menu'] = 0;
        } else {
            $menu_list['budget_expenditure_menu'] = 1;
        }
        /**
         * Check Budget Report menu
         */
        $budget_allocation_report_menu_permission = \App\Models\RolePermission::where([['role_row_id', '=', $role_row_id], ['controller', '=', "AllocationReport"]])->first();
        $budget_allocation_summary_report_menu_permission = \App\Models\RolePermission::where([['role_row_id', '=', $role_row_id], ['controller', '=', "AllocationSummaryReport"]])->first();
        $budget_allocation_adjustment_report_menu_permission = \App\Models\RolePermission::where([['role_row_id', '=', $role_row_id], ['controller', '=', "AllocationAdjustmentReport"]])->first();
        $budget_adjustment_report_menu_permission = \App\Models\RolePermission::where([['role_row_id', '=', $role_row_id], ['controller', '=', "AdjustmentReport"]])->first();
        $budget_expense_report_menu_permission = \App\Models\RolePermission::where([['role_row_id', '=', $role_row_id], ['controller', '=', "BudgetReport"]])->first();
        $budget_expenditure_report_menu_permission = \App\Models\RolePermission::where([['role_row_id', '=', $role_row_id], ['controller', '=', "BalanceReport"]])->first();
        $budget_expenditure_summary_report_menu_permission = \App\Models\RolePermission::where([['role_row_id', '=', $role_row_id], ['controller', '=', "BalanceSummaryReport"]])->first();
        if (!count($budget_allocation_report_menu_permission) || ($budget_allocation_report_menu_permission->allow_view == 0)) {
            $menu_list['budget_allocation_report_menu'] = 0;
        } else {
            $menu_list['budget_allocation_report_menu'] = 1;
        }
        if (!count($budget_allocation_summary_report_menu_permission) || ($budget_allocation_summary_report_menu_permission->allow_view == 0)) {
            $menu_list['budget_allocation_summary_report_menu'] = 0;
        } else {
            $menu_list['budget_allocation_summary_report_menu'] = 1;
        }
        if (!count($budget_allocation_adjustment_report_menu_permission) || ($budget_allocation_adjustment_report_menu_permission->allow_view == 0)) {
            $menu_list['budget_allocation_adjustment_report_menu'] = 0;
        } else {
            $menu_list['budget_allocation_adjustment_report_menu'] = 1;
        }
        if (!count($budget_adjustment_report_menu_permission) || ($budget_adjustment_report_menu_permission->allow_view == 0)) {
            $menu_list['budget_adjustment_report_menu'] = 0;
        } else {
            $menu_list['budget_adjustment_report_menu'] = 1;
        }
        if (!count($budget_expense_report_menu_permission) || ($budget_expense_report_menu_permission->allow_view == 0)) {
            $menu_list['budget_expense_report_menu'] = 0;
        } else {
            $menu_list['budget_expense_report_menu'] = 1;
        }
        if (!count($budget_expenditure_report_menu_permission) || ($budget_expenditure_report_menu_permission->allow_view == 0)) {
            $menu_list['budget_expenditure_report_menu'] = 0;
        } else {
            $menu_list['budget_expenditure_report_menu'] = 1;
        }
        if (!count($budget_expenditure_summary_report_menu_permission) || ($budget_expenditure_summary_report_menu_permission->allow_view == 0)) {
            $menu_list['budget_expenditure_summary_report_menu'] = 0;
        } else {
            $menu_list['budget_expenditure_summary_report_menu'] = 1;
        }
        if ((!count($budget_allocation_report_menu_permission) && (!count($budget_allocation_summary_report_menu_permission)) && (!count($budget_allocation_adjustment_report_menu_permission)) && (!count($budget_adjustment_report_menu_permission)) && (!count($budget_expense_report_menu_permission)) && (!count($budget_expenditure_report_menu_permission)) && (!count($budget_expenditure_summary_report_menu_permission))) || ($budget_allocation_report_menu_permission->allow_view == 0) && ($budget_allocation_summary_report_menu_permission->allow_view == 0) && ($budget_allocation_adjustment_report_menu_permission->allow_view == 0) && ($budget_adjustment_report_menu_permission->allow_view == 0) && ($budget_expense_report_menu_permission->allow_view == 0) && ($budget_expenditure_report_menu_permission->allow_view == 0) && ($budget_expenditure_summary_report_menu_permission->allow_view == 0)) {
            $menu_list['budget_report_menu'] = 0;
        } else {
            $menu_list['budget_report_menu'] = 1;
        }
    }

    /**
     * Check Donation MIS menu
     */
    $donation_mis_menu_permission = \App\Models\RolePermission::where([['role_row_id', '=', $role_row_id], ['controller', '=', "DonationMIS"]])->first();
    if (!count($donation_mis_menu_permission) || ($donation_mis_menu_permission->allow_view == 0) && ($donation_mis_menu_permission->allow_create == 0) && ($donation_mis_menu_permission->allow_update == 0) && ($donation_mis_menu_permission->allow_delete == 0)) {
        $menu_list['donation_mis_menu'] = 0;
    } else {
        $menu_list['donation_mis_menu'] = 1;
    }
    /**
     * Check Education MIS menu
     */
    $education_mis_menu_permission = \App\Models\RolePermission::where([['role_row_id', '=', $role_row_id], ['controller', '=', "EducationMIS"]])->first();
    if (!count($education_mis_menu_permission) || ($education_mis_menu_permission->allow_view == 0) && ($education_mis_menu_permission->allow_create == 0) && ($education_mis_menu_permission->allow_update == 0) && ($education_mis_menu_permission->allow_delete == 0)) {
        $menu_list['education_mis_menu'] = 0;
    } else {
        $menu_list['education_mis_menu'] = 1;
    }
    /**
     * Check Hospital MIS menu
     */
    $hospital_mis_menu_permission = \App\Models\RolePermission::where([['role_row_id', '=', $role_row_id], ['controller', '=', "HospitalMIS"]])->first();
    if (!count($hospital_mis_menu_permission) || ($hospital_mis_menu_permission->allow_view == 0) && ($hospital_mis_menu_permission->allow_create == 0) && ($hospital_mis_menu_permission->allow_update == 0) && ($hospital_mis_menu_permission->allow_delete == 0)) {
        $menu_list['hospital_mis_menu'] = 0;
    } else {
        $menu_list['hospital_mis_menu'] = 1;
    }
    /**
     * Check Relief/Tree Plantation MIS menu
     */
    $relief_tree_mis_menu_permission = \App\Models\RolePermission::where([['role_row_id', '=', $role_row_id], ['controller', '=', "ReliefTreePlantationMIS"]])->first();
    if (!count($relief_tree_mis_menu_permission) || ($relief_tree_mis_menu_permission->allow_view == 0) && ($relief_tree_mis_menu_permission->allow_create == 0) && ($relief_tree_mis_menu_permission->allow_update == 0) && ($relief_tree_mis_menu_permission->allow_delete == 0)) {
        $menu_list['relief_tree_mis_menu'] = 0;
    } else {
        $menu_list['relief_tree_mis_menu'] = 1;
    }
    /**
     * Check Jakat MIS menu
     */
    $jakat_mis_menu_permission = \App\Models\RolePermission::where([['role_row_id', '=', $role_row_id], ['controller', '=', "JakatMIS"]])->first();
    if (!count($jakat_mis_menu_permission) || ($jakat_mis_menu_permission->allow_view == 0) && ($jakat_mis_menu_permission->allow_create == 0) && ($jakat_mis_menu_permission->allow_update == 0) && ($jakat_mis_menu_permission->allow_delete == 0)) {
        $menu_list['jakat_mis_menu'] = 0;
    } else {
        $menu_list['jakat_mis_menu'] = 1;
    }
    /**
     * Check DBP MIS menu
     */
    $dbp_mis_menu_permission = \App\Models\RolePermission::where([['role_row_id', '=', $role_row_id], ['controller', '=', "DbpMIS"]])->first();
    if (!count($dbp_mis_menu_permission) || ($dbp_mis_menu_permission->allow_view == 0) && ($dbp_mis_menu_permission->allow_create == 0) && ($dbp_mis_menu_permission->allow_update == 0) && ($dbp_mis_menu_permission->allow_delete == 0)) {
        $menu_list['dbp_mis_menu'] = 0;
    } else {
        $menu_list['dbp_mis_menu'] = 1;
    }
    $menu_list = (object) $menu_list;
    return $menu_list;
}

function getPoweredBy () {
     return  '<div class="footer-pdf" style="border-top: 2px solid #000; text-align:right; margin-top:0px; font-style: italic; opacity:0.5">Powered By: bdeducations.org</div>';
}

function isEmployeeHoliday($emloyee_row_id, $date_of_attendance) {
    //Raiyan
    if($emloyee_row_id == 117) {
        if( date('l', strtotime($date_of_attendance)) == 'Monday' || date('l', strtotime($date_of_attendance)) == 'Wednesday' ) {
            return true;
        }
    }

    // Arif Hossain Bhuiyan
    if($emloyee_row_id == 119) {
        if( date('l', strtotime($date_of_attendance)) == 'Sunday' || date('l', strtotime($date_of_attendance)) == 'Tuesday' ) {
            return true;
        }
    }

    //Sadi
    if($emloyee_row_id == 120) { 
        if( date('l', strtotime($date_of_attendance)) == 'Monday' || date('l', strtotime($date_of_attendance)) == 'Tuesday') {
            return true;
        }
    }


    return false;

}
