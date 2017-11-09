<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Input;
use Image;
use DB;
use File;

class Common {

    public $output = array();
    public $head_child_list = array();
    public $head_parent_list = array();
    public $all_area_single_head_info_list = array();
    public $all_area_all_head_info_list = array();
    public $head_total_expense_by_month = array();
    public $head_amount = array();
    public $parent_head_child_list = array();
    public $month_array = array(
        '1' => 'January',
        '2' => 'February',
        '3' => 'March',
        '4' => 'April',
        '5' => 'May',
        '6' => 'June',
        '7' => 'July',
        '8' => 'August',
        '9' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December'
    );
    public $alphabet_array = array(
        '1' => 'a',
        '2' => 'b',
        '3' => 'c',
        '4' => 'd',
        '5' => 'e',
        '6' => 'f',
        '7' => 'g',
        '8' => 'h',
        '9' => 'i',
        '10' => 'j',
        '11' => 'k',
        '12' => 'l',
        '13' => 'm',
        '14' => 'n',
        '15' => 'o',
        '16' => 'p',
        '17' => 'q',
        '18' => 'r',
        '19' => 's',
        '20' => 't',
        '21' => 'u',
        '22' => 'v',
        '23' => 'w',
        '24' => 'x',
        '25' => 'y',
        '26' => 'z'
    );
    public $roman_array = array(
        '1' => 'I',
        '2' => 'II',
        '3' => 'III',
        '4' => 'IV',
        '5' => 'V',
        '6' => 'VI',
        '7' => 'VII',
        '8' => 'VIII',
        '9' => 'IX',
        '10' => 'X',
        '11' => 'XI',
        '12' => 'XII',
        '13' => 'XIII',
        '14' => 'XIV',
        '15' => 'XV',
        '16' => 'XVI',
        '17' => 'XVII',
        '18' => 'XVIII',
        '19' => 'XIX',
        '20' => 'XX',
        '21' => 'XXI',
        '22' => 'XXII',
        '23' => 'XXIII',
        '24' => 'XXIV',
        '25' => 'XXV',
        '26' => 'XXVI'
    );

    /**
     *
     * @param type $fileInputField
     * @param type $uploadFolder
     * @param type $fileName
     * @param type $create_thumb
     * @param type $photoIndex
     * @return string
     */
    public function uploadImage($fileInputField, $uploadFolder) {
        $uploadedFileName = '';
        if (Input::file($fileInputField)) {
            $fileInfo = Input::file($fileInputField);
            $uploadedFileName = time() . "_" . $fileInfo->getClientOriginalName();
            /*
             * Upload Original Image
             */
            $upload_path = public_path($uploadFolder);
            if (!File::exists($upload_path)) {
                File::makeDirectory($upload_path, $mode = 0777, true, true);
            }
            $fileInfo->move($upload_path, $uploadedFileName);
        }
        return $uploadedFileName;
    }

    public function getAllDistrict() {
        $district_list = \App\Models\District::orderBy('full_name', 'asc')->get();
        return $district_list;
    }

    /**
     *
     * @param type $districtid
     * @param type $presentupazila
     */
    public function getUpazilas($districtid, $presentupazila = NULL) {
        $allupazilas = DB::table('upazila')->select('id', 'full_name')->where('district_id', $districtid)->orderBy('full_name', 'asc')->get();
        $html = "";
        $html .= "<option value=''>Select Upazila</option>";
        foreach ($allupazilas as $upazilas) {
            if (isset($presentupazila) && ($upazilas->id == $presentupazila)) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $html .= "<option value=" . $upazilas->id . " " . $selected . ">" . $upazilas->full_name . "</option>";
        }
        return $html;
    }

    /**
     *
     * @param type $applicant_type
     * @param type $applicant_row_id
     */
    public function getApplicantsByType($applicant_type, $applicant_row_id = NULL) {
        $allApplicant = DB::table('mis_applicants')->select('applicant_row_id', 'applicant_name', 'mobile')->where('is_individual', $applicant_type)->orderBy('mobile', 'asc')->get();
        $html = "";
        if ($applicant_row_id == -1) {
            $html .= "<option value=''>Select Applicant</option><option selected='selected' value='-1'>Add New Applicant</option>";
        } else {
            $html .= "<option value=''>Select Applicant</option><option value='-1'>Add New Applicant</option>";
        }
        foreach ($allApplicant as $applicant) {
            if (isset($applicant_row_id) && ($applicant->applicant_row_id == $applicant_row_id)) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $html .= "<option value=" . $applicant->applicant_row_id . " " . $selected . ">" . $applicant->mobile . ' - ' . $applicant->applicant_name . "</option>";
        }
        return $html;
    }

    /**
     *
     * @param type $applicant_type
     * @param type $applicant_row_id
     */
    public function getApplicantsByTypeOnUpdate($applicant_type, $applicant_row_id = NULL) {
        $allApplicant = DB::table('mis_applicants')->select('applicant_row_id', 'applicant_name', 'mobile')->where('is_individual', $applicant_type)->orderBy('mobile', 'asc')->get();
        $html = "<option value=''>Select Applicant</option>";
        foreach ($allApplicant as $applicant) {
            if (isset($applicant_row_id) && ($applicant->applicant_row_id == $applicant_row_id)) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $html .= "<option value=" . $applicant->applicant_row_id . " " . $selected . ">" . $applicant->mobile . ' - ' . $applicant->applicant_name . "</option>";
        }
        return $html;
    }

    public function get_applicant_donation_row_info($donation_row_id) {
        $donation_row = \App\Models\Donation::where('donation_row_id', $donation_row_id)->first();
        return $donation_row;
    }

    public function getApplicantDonationDetails($donation_row_id) {
        $donation_applicant_row_details = DB::table('mis_donations')->leftJoin('mis_applicants', 'mis_donations.applicant_row_id', '=', 'mis_applicants.applicant_row_id')->leftJoin('categories', 'categories.category_row_id', '=', 'mis_donations.category_row_id')->leftJoin('districts', 'mis_applicants.district_id', '=', 'districts.id')->leftJoin('upazila', 'mis_applicants.upazila_id', '=', 'upazila.id')->select('mis_donations.*', 'mis_applicants.*', 'districts.full_name AS district_name', 'upazila.full_name AS upazila_name', 'categories.title AS category_name')->where('mis_donations.donation_row_id', $donation_row_id)->first();
        return $donation_applicant_row_details;
    }

    public function allDonation() {
        $donation_applicant_list = DB::table('mis_donations')->leftJoin('mis_applicants', 'mis_donations.applicant_row_id', '=', 'mis_applicants.applicant_row_id')->leftJoin('districts', 'mis_applicants.district_id', '=', 'districts.id')->leftJoin('upazila', 'mis_applicants.upazila_id', '=', 'upazila.id')->select('mis_donations.*', 'mis_applicants.*', 'districts.full_name AS district_name', 'upazila.full_name AS upazila_name')->where('mis_applicants.status', 1)->orderBy('mis_donations.donation_row_id', 'desc')->get();
        return $donation_applicant_list;
    }

    public function allApplicant($status = 0) {
        if ($status == 1) {
            $applicant_list = DB::table('mis_applicants')->leftJoin('districts', 'mis_applicants.district_id', '=', 'districts.id')->leftJoin('upazila', 'mis_applicants.upazila_id', '=', 'upazila.id')->select('mis_applicants.*', 'districts.full_name AS district_name', 'upazila.full_name AS upazila_name')->where('mis_applicants.status', 1)->orderBy('mis_applicants.applicant_row_id', 'desc')->get();
        } else {
            $applicant_list = DB::table('mis_applicants')->leftJoin('districts', 'mis_applicants.district_id', '=', 'districts.id')->leftJoin('upazila', 'mis_applicants.upazila_id', '=', 'upazila.id')->select('mis_applicants.*', 'districts.full_name AS district_name', 'upazila.full_name AS upazila_name')->where('mis_applicants.status', 1)->orderBy('mis_applicants.applicant_row_id', 'desc')->get();
        }
        return $applicant_list;
    }

    public function GetAllApplicantJson($type = 0) {
        $this->output = array();
        if ($type == 1) {
            $applicant_list = DB::table('mis_applicants')->select('mis_applicants.*')->where('mis_applicants.is_individual', 1)->orderBy('mis_applicants.mobile', 'asc')->get();
        } elseif ($type == 2) {
            $applicant_list = DB::table('mis_applicants')->select('mis_applicants.*')->where('mis_applicants.is_individual', 2)->orderBy('mis_applicants.mobile', 'asc')->get();
        } else {
            $applicant_list = DB::table('mis_applicants')->select('mis_applicants.*')->orderBy('mis_applicants.mobile', 'asc')->get();
        }
        if ($applicant_list) {
            foreach ($applicant_list as $applicant_row) {
                $this->output[] = array(
                    "value" => $applicant_row->applicant_row_id,
                    "label" => $applicant_row->mobile,
                    "desc" => $applicant_row->applicant_name
                );
            }
        }
        $output = $this->output;
        $this->output = array();
        return json_encode($output);
    }

    public function checkUniqueApplicant($mobile_number = 0) {
        $applicant_row = \App\Models\Applicant::where('mobile', $mobile_number)->first();
        if ($applicant_row) {
            return false;
        } else {
            return true;
        }
    }

    public function checkUniqueApplicantOnUpdate($mobile_number = 0, $applicant_row_id = 0) {
        $applicant_row = \App\Models\Applicant::where([['applicant_row_id', '!=', $applicant_row_id], ['mobile', '=', $mobile_number]])->first();
        if ($applicant_row) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Retrieve all Category
     * @param type $status
     */
    public function allCategory($status = 0) {
        if ($status == 1) {
            $category_list = \App\Models\Category::where('status', 1)->orderBy('sort_order', 'asc')->get();
        } else {
            $category_list = \App\Models\Category::orderBy('sort_order', 'asc')->get();
        }
        return $category_list;
    }

    public function get_category_row_info($category_row_id) {
        $category_row = \App\Models\Category::where('category_row_id', $category_row_id)->first();
        return $category_row;
    }

    public function get_applicant_row_info($applicant_row_id) {
        $applicant_row = \App\Models\Applicant::where('applicant_row_id', $applicant_row_id)->first();
        return $applicant_row;
    }

    public function filterApplicantDonation($category_row_id, $applicant_type = 0, $applicant_row_id = 0, $district_id = 0, $upazila_id = 0, $start_date = 0, $end_date = 0) {
        $donation_applicant_list = '';
        $disrtict_upazila_condition = [];
        if (!empty($district_id) && !empty($upazila_id)) {
            $disrtict_upazila_condition = ['mis_applicants.district_id' => $district_id, 'mis_applicants.upazila_id' => $upazila_id];
        } elseif ($district_id) {
            $disrtict_upazila_condition = ['mis_applicants.district_id' => $district_id];
        } else {
            $disrtict_upazila_condition = [];
        }
        //dd($disrtict_upazila_condition);
        if (!empty($start_date) && !empty($end_date)) {
            if ($category_row_id > 0) {
                /**
                 * Specific Category selected
                 */
                if ($applicant_type && !$applicant_row_id) {
                    $donation_applicant_list = DB::table('mis_donations')->leftJoin('mis_applicants', 'mis_donations.applicant_row_id', '=', 'mis_applicants.applicant_row_id')->leftJoin('districts', 'mis_applicants.district_id', '=', 'districts.id')->leftJoin('upazila', 'mis_applicants.upazila_id', '=', 'upazila.id')->select('mis_donations.*', 'mis_applicants.*', 'districts.full_name AS district_name', 'upazila.full_name AS upazila_name')->where([['mis_donations.category_row_id', '=', $category_row_id], ['mis_donations.is_individual', '=', $applicant_type]])->where($disrtict_upazila_condition)->whereBetween('donation_at', [$start_date, $end_date])->orderBy('mis_donations.donation_row_id', 'desc')->get();
                } elseif (($applicant_type) && ($applicant_row_id)) {
                    $donation_applicant_list = DB::table('mis_donations')->leftJoin('mis_applicants', 'mis_donations.applicant_row_id', '=', 'mis_applicants.applicant_row_id')->leftJoin('districts', 'mis_applicants.district_id', '=', 'districts.id')->leftJoin('upazila', 'mis_applicants.upazila_id', '=', 'upazila.id')->select('mis_donations.*', 'mis_applicants.*', 'districts.full_name AS district_name', 'upazila.full_name AS upazila_name')->where([['mis_donations.category_row_id', '=', $category_row_id], ['mis_donations.is_individual', '=', $applicant_type], ['mis_donations.applicant_row_id', '=', $applicant_row_id]])->where($disrtict_upazila_condition)->whereBetween('donation_at', [$start_date, $end_date])->orderBy('mis_donations.donation_row_id', 'desc')->get();
                } else {
                    $donation_applicant_list = DB::table('mis_donations')->leftJoin('mis_applicants', 'mis_donations.applicant_row_id', '=', 'mis_applicants.applicant_row_id')->leftJoin('districts', 'mis_applicants.district_id', '=', 'districts.id')->leftJoin('upazila', 'mis_applicants.upazila_id', '=', 'upazila.id')->select('mis_donations.*', 'mis_applicants.*', 'districts.full_name AS district_name', 'upazila.full_name AS upazila_name')->where([['mis_donations.category_row_id', '=', $category_row_id]])->where($disrtict_upazila_condition)->whereBetween('donation_at', [$start_date, $end_date])->orderBy('mis_donations.donation_row_id', 'desc')->get();
                }
            } else {
                /**
                 * All Category Selected
                 */
                if ($applicant_type && !$applicant_row_id) {
                    $donation_applicant_list = DB::table('mis_donations')->leftJoin('mis_applicants', 'mis_donations.applicant_row_id', '=', 'mis_applicants.applicant_row_id')->leftJoin('districts', 'mis_applicants.district_id', '=', 'districts.id')->leftJoin('upazila', 'mis_applicants.upazila_id', '=', 'upazila.id')->select('mis_donations.*', 'mis_applicants.*', 'districts.full_name AS district_name', 'upazila.full_name AS upazila_name')->where([['mis_donations.is_individual', '=', $applicant_type]])->where($disrtict_upazila_condition)->whereBetween('donation_at', [$start_date, $end_date])->orderBy('mis_donations.donation_row_id', 'desc')->get();
                } elseif (($applicant_type) && ($applicant_row_id)) {
                    $donation_applicant_list = DB::table('mis_donations')->leftJoin('mis_applicants', 'mis_donations.applicant_row_id', '=', 'mis_applicants.applicant_row_id')->leftJoin('districts', 'mis_applicants.district_id', '=', 'districts.id')->leftJoin('upazila', 'mis_applicants.upazila_id', '=', 'upazila.id')->select('mis_donations.*', 'mis_applicants.*', 'districts.full_name AS district_name', 'upazila.full_name AS upazila_name')->where([['mis_donations.is_individual', '=', $applicant_type], ['mis_donations.applicant_row_id', '=', $applicant_row_id]])->where($disrtict_upazila_condition)->whereBetween('donation_at', [$start_date, $end_date])->orderBy('mis_donations.donation_row_id', 'desc')->get();
                } else {
                    $donation_applicant_list = DB::table('mis_donations')->leftJoin('mis_applicants', 'mis_donations.applicant_row_id', '=', 'mis_applicants.applicant_row_id')->leftJoin('districts', 'mis_applicants.district_id', '=', 'districts.id')->leftJoin('upazila', 'mis_applicants.upazila_id', '=', 'upazila.id')->select('mis_donations.*', 'mis_applicants.*', 'districts.full_name AS district_name', 'upazila.full_name AS upazila_name')->where($disrtict_upazila_condition)->whereBetween('donation_at', [$start_date, $end_date])->orderBy('mis_applicants.applicant_row_id', 'desc')->get();
                }
            }
        } else {
            if ($category_row_id > 0) {
                /**
                 * Specific Category selected
                 */
                if ($applicant_type && !$applicant_row_id) {
                    $donation_applicant_list = DB::table('mis_donations')->leftJoin('mis_applicants', 'mis_donations.applicant_row_id', '=', 'mis_applicants.applicant_row_id')->leftJoin('districts', 'mis_applicants.district_id', '=', 'districts.id')->leftJoin('upazila', 'mis_applicants.upazila_id', '=', 'upazila.id')->select('mis_donations.*', 'mis_applicants.*', 'districts.full_name AS district_name', 'upazila.full_name AS upazila_name')->where([['mis_donations.category_row_id', '=', $category_row_id], ['mis_donations.is_individual', '=', $applicant_type]])->where($disrtict_upazila_condition)->orderBy('mis_donations.donation_row_id', 'desc')->get();
                } elseif (($applicant_type) && ($applicant_row_id)) {
                    $donation_applicant_list = DB::table('mis_donations')->leftJoin('mis_applicants', 'mis_donations.applicant_row_id', '=', 'mis_applicants.applicant_row_id')->leftJoin('districts', 'mis_applicants.district_id', '=', 'districts.id')->leftJoin('upazila', 'mis_applicants.upazila_id', '=', 'upazila.id')->select('mis_donations.*', 'mis_applicants.*', 'districts.full_name AS district_name', 'upazila.full_name AS upazila_name')->where([['mis_donations.category_row_id', '=', $category_row_id], ['mis_donations.is_individual', '=', $applicant_type], ['mis_donations.applicant_row_id', '=', $applicant_row_id]])->where($disrtict_upazila_condition)->orderBy('mis_donations.donation_row_id', 'desc')->get();
                } else {
                    $donation_applicant_list = DB::table('mis_donations')->leftJoin('mis_applicants', 'mis_donations.applicant_row_id', '=', 'mis_applicants.applicant_row_id')->leftJoin('districts', 'mis_applicants.district_id', '=', 'districts.id')->leftJoin('upazila', 'mis_applicants.upazila_id', '=', 'upazila.id')->select('mis_donations.*', 'mis_applicants.*', 'districts.full_name AS district_name', 'upazila.full_name AS upazila_name')->where([['mis_donations.category_row_id', '=', $category_row_id]])->where($disrtict_upazila_condition)->orderBy('mis_donations.donation_row_id', 'desc')->get();
                }
            } else {

                /**
                 * All Category Selected
                 */
                if ($applicant_type && !$applicant_row_id) {
                    $donation_applicant_list = DB::table('mis_donations')->leftJoin('mis_applicants', 'mis_donations.applicant_row_id', '=', 'mis_applicants.applicant_row_id')->leftJoin('districts', 'mis_applicants.district_id', '=', 'districts.id')->leftJoin('upazila', 'mis_applicants.upazila_id', '=', 'upazila.id')->select('mis_donations.*', 'mis_applicants.*', 'districts.full_name AS district_name', 'upazila.full_name AS upazila_name')->where([['mis_donations.is_individual', '=', $applicant_type]])->where($disrtict_upazila_condition)->orderBy('mis_donations.donation_row_id', 'desc')->get();
                } elseif ($applicant_type && $applicant_row_id) {
                    $donation_applicant_list = DB::table('mis_donations')->leftJoin('mis_applicants', 'mis_donations.applicant_row_id', '=', 'mis_applicants.applicant_row_id')->leftJoin('districts', 'mis_applicants.district_id', '=', 'districts.id')->leftJoin('upazila', 'mis_applicants.upazila_id', '=', 'upazila.id')->select('mis_donations.*', 'mis_applicants.*', 'districts.full_name AS district_name', 'upazila.full_name AS upazila_name')->where([['mis_donations.is_individual', '=', $applicant_type], ['mis_donations.applicant_row_id', '=', $applicant_row_id]])->where($disrtict_upazila_condition)->orderBy('mis_donations.donation_row_id', 'desc')->get();
                } else {
                    $donation_applicant_list = DB::table('mis_donations')->leftJoin('mis_applicants', 'mis_donations.applicant_row_id', '=', 'mis_applicants.applicant_row_id')->leftJoin('districts', 'mis_applicants.district_id', '=', 'districts.id')->leftJoin('upazila', 'mis_applicants.upazila_id', '=', 'upazila.id')->select('mis_donations.*', 'mis_applicants.*', 'districts.full_name AS district_name', 'upazila.full_name AS upazila_name')->where($disrtict_upazila_condition)->orderBy('mis_donations.donation_row_id', 'desc')->get();
                }
            }
        }
        return $donation_applicant_list;
    }

    /**
     * Retrieve all area list with sort_order
     * @return type
     */
    public function allAreas($status = 0) {
        if ($status == 1) {
            $area_list = \App\Models\Area::where('status', 1)->orderBy('sort_order', 'asc')->get();
        } else {
            $area_list = \App\Models\Area::orderBy('sort_order', 'asc')->get();
        }
        return $area_list;
    }

    /**
     * Retrieve all area list with sort_order for dropdown
     * array as area_row_id => title
     * @return type
     */
    public function allAreaList($status = 0) {
        $this->output = array();
        if ($status == 1) {
            $area_list = \App\Models\Area::where('status', 1)->orderBy('sort_order', 'asc')->get();
        } else {
            $area_list = \App\Models\Area::orderBy('sort_order', 'asc')->get();
        }
        if (count($area_list)) {
            foreach ($area_list as $row) {
                $this->output[$row->area_row_id] = $row->title;
            }
        }
        $output = $this->output;
        $this->output = array();
        return $output;
    }

    /**
     * Retrieve total active area number count
     */
    public function area_number_count($status = 0) {
        $total_area_number = 1;
        if ($status == 1) {
            $total_area_number = \App\Models\Area::where('status', 1)->count('area_row_id');
        } else {
            $total_area_number = \App\Models\Area::count('area_row_id');
        }
        return $total_area_number;
    }

    /**
     * Retrieve area row info
     * @param type $area_row_id
     * @return type
     */
    public function get_area_row_info($area_row_id) {
        $area_row = \App\Models\Area::where('area_row_id', $area_row_id)->first();
        return $area_row;
    }

    /**
     * Get a head row info
     * @param type $head_row_id
     * @return type
     */
    public function get_head_row_info($head_row_id) {
        $head_row = \App\Models\Head::where('head_row_id', $head_row_id)->first();
        return $head_row;
    }

    /**
     * Get a project head row info
     * @param type $project_head_row_id
     * @return type
     */
    public function get_project_head_row_info($head_row_id) {
        $project_head_row = DB::table('heads')->join('project_heads', 'heads.head_row_id', '=', 'project_heads.head_row_id')->select('heads.*', 'project_heads.project_head_row_id AS project_head_row_id', 'project_heads.budget_year AS budget_year')->where([['heads.is_project', '=', 1], ['project_heads.head_row_id', '=', $head_row_id]])->first();
        return $project_head_row;
    }

    /**
     * Get a project row info
     * @param type $project_head_row_id
     * @return type
     */
    public function get_project_row_info($project_head_row_id) {
        $project_row = \App\Models\ProjectHead::where('project_head_row_id', $project_head_row_id)->first();
        return $project_row;
    }

    /**
     * Get a expense row info
     * @param type $expense_row_id
     */
    public function get_expense_row_info($expense_row_id) {
        $expense_row = \App\Models\Expense::where('expense_row_id', $expense_row_id)->first();
        return $expense_row;
    }

    /**
     * Get a allocation row info
     * @param type $allocation_row_id
     */
    public function get_allocation_row_info($allocation_row_id) {
        $allocation_row = \App\Models\Allocation::where('allocation_row_id', $allocation_row_id)->first();
        return $allocation_row;
    }

    /**
     * Generate All head list with current budget year project heads
     * @param type $budget_year
     * @param type $status
     */
    public function budgetAllHeadListWithProject($budget_year = 0, $status = 0) {
        $this->output = array();
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        if ($status == 1) {
            $result = \App\Models\Head::where([['status', '=', 1]])->orderBy('sort_order', 'asc')->get();
        } else {
            $result = \App\Models\Head::orderBy('sort_order', 'asc')->get();
        }
        foreach ($result as $head) {
            if ($head->parent_id == 0) {
                if ($head->is_project == 1) {
                    $this->output[] = $head;
                    $this->getProjectAllHead($budget_year, $head->head_row_id);
                } else {
                    if ($head->has_child) {
                        $this->output[] = $head;
                        $this->setBudgetGeneralHeadChildren($result, $head->head_row_id);
                    } else {
                        $this->output[] = $head;
                    }
                }
            }
        }
        $output = $this->output;
        $this->output = array();
        return $output;
    }

    /**
     * Get all head list with project
     * Call this function for get select option list
     * In head list dropdown
     * @param type $budget_year
     * @param type $status
     */
    public function getBudgetHeadList($budget_year = 0, $status = 0, $head_row_id = 0) {
        $this->output = array();
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        if ($status == 1) {
            $result = \App\Models\Head::where('status', 1)->orderBy('sort_order', 'asc')->get();
        } else {
            $result = \App\Models\Head::orderBy('sort_order', 'asc')->get();
        }
        foreach ($result as $head) {
            if ($head->parent_id == 0) {
                if ($head->is_project == 1) {
                    $this->output[] = $head;
                    $this->getProjectAllHead($budget_year, $head->head_row_id);
                } else {
                    if ($head->has_child) {
                        $this->output[] = $head;
                        $this->setBudgetGeneralHeadChildren($result, $head->head_row_id);
                    } else {
                        $this->output[] = $head;
                    }
                }
            }
        }
        $head_list = $this->output;
        $this->output = array();
        $html = "";
        $html .= "<option value=''>Select Head</option>";
        if ($head_list) {
            foreach ($head_list as $head_row) {
                if (isset($head_row_id) && ($head_row->head_row_id == $head_row_id)) {
                    $selected = 'selected="selected"';
                } else {
                    $selected = '';
                }
                $disabled = '';
                if ($head_row->has_child == 1):
                    $disabled = 'disabled="disabled"';
                endif;
                $option_label_name = '';
                if ($head_row->level == 0): $option_label_name .= "<b>";
                endif;
                if ($head_row->level == 1): $option_label_name .= "&nbsp; - ";
                endif;
                if ($head_row->level == 2): $option_label_name .= "&nbsp; &nbsp; - - ";
                endif;
                if ($head_row->level == 3): $option_label_name .= "&nbsp; &nbsp; &nbsp; - - - ";
                endif;
                if ($head_row->level == 4): $option_label_name .= "&nbsp; &nbsp; &nbsp; &nbsp; - - - - ";
                endif;
                if ($head_row->level == 5): $option_label_name .= "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  - - - - - ";
                endif;
                if ($head_row->level > 5): $option_label_name .= "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - - - ";
                endif;
                $option_label_name .= $head_row->title;
                if ($head_row->level == 0): $option_label_name .= "</b>";
                endif;
                $html .= "<option value=" . $head_row->head_row_id . " " . $selected . " " . $disabled . ">" . $option_label_name . "</option>";
            }
        }
        return $html;
    }

    /**
     * Get all head list with project
     * Call this function for get select option list
     * In head list dropdown
     * @param type $budget_year
     * @param type $status
     */
    public function getBudgetHeadListForReport($budget_year = 0, $status = 0, $head_row_id = 0) {
        $this->output = array();
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        if ($status == 1) {
            $result = \App\Models\Head::where('status', 1)->orderBy('sort_order', 'asc')->get();
        } else {
            $result = \App\Models\Head::orderBy('sort_order', 'asc')->get();
        }
        foreach ($result as $head) {
            if ($head->parent_id == 0) {
                if ($head->is_project == 1) {
                    $this->output[] = $head;
                    $this->getProjectAllHead($budget_year, $head->head_row_id);
                } else {
                    if ($head->has_child) {
                        $this->output[] = $head;
                        $this->setBudgetGeneralHeadChildren($result, $head->head_row_id);
                    } else {
                        $this->output[] = $head;
                    }
                }
            }
        }
        $head_list = $this->output;
        $this->output = array();
        $html = "";
        $html .= "<option value=''>Select Head</option>";
        if ($head_list) {
            $html .= "<option value='-1'>All Head</option>";
            foreach ($head_list as $head_row) {
                if (isset($head_row_id) && ($head_row->head_row_id == $head_row_id)) {
                    $selected = 'selected="selected"';
                } else {
                    $selected = '';
                }
                $option_label_name = '';
                if ($head_row->level == 0): $option_label_name .= "<b>";
                endif;
                if ($head_row->level == 1): $option_label_name .= "&nbsp; - ";
                endif;
                if ($head_row->level == 2): $option_label_name .= "&nbsp; &nbsp; - - ";
                endif;
                if ($head_row->level == 3): $option_label_name .= "&nbsp; &nbsp; &nbsp; - - - ";
                endif;
                if ($head_row->level == 4): $option_label_name .= "&nbsp; &nbsp; &nbsp; &nbsp; - - - - ";
                endif;
                if ($head_row->level == 5): $option_label_name .= "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  - - - - - ";
                endif;
                if ($head_row->level > 5): $option_label_name .= "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - - - ";
                endif;
                $option_label_name .= $head_row->title;
                if ($head_row->level == 0): $option_label_name .= "</b>";
                endif;
                $html .= "<option value=" . $head_row->head_row_id . " " . $selected . ">" . $option_label_name . "</option>";
            }
        }
        return $html;
    }

    /**
     * Generate all independent budget head list
     * Whose are common for all area
     * @param type $status
     */
    public function budgetGeneralHeadList($status = 0) {
        $this->output = array();
        if ($status == 1) {
            $result = \App\Models\Head::where([['status', '=', 1], ['is_project', '=', 0]])->orderBy('sort_order', 'asc')->get();
        } else {
            $result = \App\Models\Head::where([['is_project', '=', 0]])->orderBy('sort_order', 'asc')->get();
        }
        foreach ($result as $head) {
            if ($head->parent_id == 0) {
                if ($head->has_child) {
                    $this->output[] = $head;
                    $this->setBudgetGeneralHeadChildren($result, $head->head_row_id);
                } else {
                    $this->output[] = $head;
                }
            }
        }
        $output = $this->output;
        $this->output = array();
        return $output;
    }

    /**
     * Set all child of a head
     * For all general head
     * @param type $haystack
     * @param type $parentHeadId
     */
    public function setBudgetGeneralHeadChildren($haystack, $parentHeadId) {
        if (count($haystack)) {
            foreach ($haystack as $head) {
                if ($head->parent_id && $head->parent_id == $parentHeadId) {
                    if ($head->has_child) {
                        $this->output[] = $head;
                        $this->setBudgetGeneralHeadChildren($haystack, $head->head_row_id);
                    } else {
                        $this->output[] = $head;
                    }
                }
            }
        }
    }

    /**
     * Write all project head to output array
     * According to budget year, default current year
     * @param type $budget_year
     */
    public function getProjectAllHead($budget_year = 0, $project_head_row_id = 0) {
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        $project_head_list = DB::table('heads')->join('project_heads', 'heads.head_row_id', '=', 'project_heads.head_row_id')->select('heads.*', 'project_heads.project_head_row_id AS project_head_row_id')->where([['heads.is_project', '=', 1], ['project_heads.budget_year', '=', $budget_year]])->orderBy('heads.sort_order', 'asc')->get();
        if (count($project_head_list) > 0) {
            foreach ($project_head_list as $project_head) {
                if ($project_head->parent_id && $project_head->parent_id == $project_head_row_id) {
                    if ($project_head->has_child) {
                        $this->output[] = $project_head;
                        $this->setBudgetProjectHeadChildren($project_head_list, $budget_year, $project_head->head_row_id);
                    } else {
                        $this->output[] = $project_head;
                    }
                }
            }
        }
    }

    /**
     * Set all child of a Project head
     * For all general head
     * @param type $haystack
     * @param type $budget_year
     * @param type $parentHeadId
     */
    public function setBudgetProjectHeadChildren($haystack, $budget_year, $parentHeadId) {
        if (count($haystack)) {
            foreach ($haystack as $head) {
                if ($head->parent_id && $head->parent_id == $parentHeadId) {
                    if ($head->has_child) {
                        $this->output[] = $head;
                        $this->setBudgetProjectHeadChildren($haystack, $budget_year, $head->head_row_id);
                    } else {
                        $this->output[] = $head;
                    }
                }
            }
        }
    }

    /**
     * Generate all project head list
     * Default current budget year only
     * @param type $budget_year
     */
    public function budgetProjectHeadList($budget_year = 0) {
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        $project_main_head = \App\Models\Head::where([['parent_id', '=', 0], ['is_project', '=', 1]])->first();
        $this->output = array();
        if ($project_main_head) {
            $this->output[] = $project_main_head;
            $this->getProjectAllHead($budget_year, $project_main_head->head_row_id);
        }
        $output = $this->output;
        $this->output = array();
        return $output;
    }

    public function allMainHeads() {
        $result = \App\Models\Head::where([['status', '=', 1], ['parent_id', '=', 0]])->orderBy('sort_order', 'asc')->get();
        return $result;
    }

    /**
     * RETRIEVE ALL HEAD WITH ALL RELATED CHILD, GRAND-CHILD, GREAT-GRAND-CHILD
     * @param type $showAllocation
     * @param type $showExpense
     * @return type
     */
    public function allHeads($showAllocation = false, $showExpense = false, $showAdjustment = false, $status = 0, $budget_year = 0) {
        $this->output = array();
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        $result = $this->budgetAllHeadListWithProject($budget_year, $status);
        foreach ($result as $head) {
            if ($head->parent_id == 0) {
                $head->total_allocation = $this->totalAllcations($head->head_row_id, 0, $budget_year);
                if ($head->has_child) {
                    $this->output[] = $head;
                    $this->setChildren($result, $head->head_row_id, $budget_year, $showAllocation, $showExpense, $showAdjustment);
                    $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                    $parent_head_child_number = $this->findHeadChildrenNumber($head->head_row_id);
                    $parent_head_total_allocation = $this->totalParentHeadAllocations($this->parent_head_child_list, 0, $budget_year);
                    $head->parent_head_child_number = $parent_head_child_number;
                    $head->parent_head_total_allocation = $parent_head_total_allocation;
                    if ($showAdjustment) {
                        $head->parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, 0, $budget_year);
                    }
                    if ($showExpense) {
                        $head->parent_head_total_expense = $this->totalParentHeadExpense($this->parent_head_child_list, 0, $budget_year, 0, 0);
                    }
                } else {
                    if ($showAllocation) {
                        $head->total_allocation = $this->totalAllcations($head->head_row_id, 0, $budget_year);
                    }
                    if ($showExpense) {
                        $head->total_expense = $this->totalExpense($head->head_row_id, 0, $budget_year);
                    }
                    if ($showAdjustment) {
                        $head->total_adjustment = $this->totalAdjustment($head->head_row_id, 0, $budget_year);
                    }
                    $this->output[] = $head;
                }
            }
        }
        $output = $this->output;
        $this->output = array();
        return $output;
    }

    /**
     * Set all child of head
     * @param type $haystack
     * @param type $parentHeadId
     * @param type $showAllocation
     * @param type $showExpense
     */
    function setChildren($haystack, $parentHeadId, $budget_year, $showAllocation, $showExpense, $showAdjustment) {
        if (count($haystack)) {
            foreach ($haystack as $head) {
                if ($head->parent_id && $head->parent_id == $parentHeadId) {
                    if ($head->has_child) {
                        $this->output[] = $head;
                        $this->setChildren($haystack, $head->head_row_id, $budget_year, $showAllocation, $showExpense, $showAdjustment);
                        $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                        $parent_head_child_number = $this->findHeadChildrenNumber($head->head_row_id);
                        $head->parent_head_child_number = $parent_head_child_number;
                        $head->parent_head_total_allocation = $this->totalParentHeadAllocations($this->parent_head_child_list, 0, $budget_year);
                        if ($showAdjustment) {
                            $head->parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, 0, $budget_year);
                        }
                        if ($showExpense) {
                            $head->parent_head_total_expense = $this->totalParentHeadExpense($this->parent_head_child_list, 0, $budget_year, 0, 0);
                        }
                    } else {
                        if ($showAllocation) {
                            $head->total_allocation = $this->totalAllcations($head->head_row_id, 0, $budget_year);
                        }
                        if ($showExpense) {
                            $head->total_expense = $this->totalExpense($head->head_row_id, 0, $budget_year);
                        }
                        if ($showAdjustment) {
                            $head->total_adjustment = $this->totalAdjustment($head->head_row_id, 0, $budget_year);
                        }
                        $this->output[] = $head;
                    }
                }
            }
        }
    }

    public function expenseFilterAllHeads($showAllocation = false, $showExpense = true, $showBalance = false, $area_row_id = 0, $budget_year, $start_date = 0, $end_date = 0) {
        $status = 1;
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        $result = $this->budgetAllHeadListWithProject($budget_year, $status);
        $this->output = array();
        foreach ($result as $head) {
            if ($head->parent_id == 0) {
                if ($head->has_child) {
                    $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                    //$parent_head_child_number = $this->findHeadChildrenNumber($head->head_row_id);
                    $parent_head_child_number = $this->findHeadChildrenNumberByAllocation($head->head_row_id, $area_row_id, $budget_year);
                    $parent_head_total_allocation = $this->totalParentHeadAllocations($this->parent_head_child_list, $area_row_id, $budget_year);
                    $parent_head_total_expense = $this->totalParentHeadExpense($this->parent_head_child_list, $area_row_id, $budget_year, $start_date, $end_date);
                    $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area_row_id, $budget_year, 0, 0);
                    $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area_row_id, $budget_year, 0, 0);
                    $parent_head_total_current_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                    $parent_head_current_balance = $parent_head_total_current_allocation - $parent_head_total_expense;
                    $head->parent_head_current_balance = $parent_head_current_balance;
                    $head->parent_head_total_expense = $parent_head_total_expense;
                    $head->parent_head_total_allocation = $parent_head_total_current_allocation;
                    $head->parent_head_child_number = $parent_head_child_number;
                    if (isset($parent_head_total_current_allocation) && ($parent_head_total_current_allocation != 0)) {
                        $this->output[] = $head;
                    }
                    $this->setExpenseFilterAllHeadsChildren($result, $head->head_row_id, $area_row_id, $budget_year, $showAllocation, $showExpense, $showBalance, $start_date, $end_date);
                } else {
                    $head_current_total_allocation = 0;
                    $head_total_expense = 0;
                    $head_current_balance = 0;
                    if ($showAllocation) {
                        $head_total_allocation = $this->totalAllcations($head->head_row_id, $area_row_id, $budget_year);
                        $head_total_adjustment = $this->totalFilterReceiption($area_row_id, $head->head_row_id, $budget_year, 0, 0);
                        $head_total_donation = $this->totalFilterDonation($area_row_id, $head->head_row_id, $budget_year, 0, 0);
                        $head_current_total_allocation = ($head_total_allocation + $head_total_adjustment) - $head_total_donation;
                        $head->total_allocation = $head_current_total_allocation;
                    }
                    if ($showExpense) {
                        $head_total_expense = $this->totalFilterExpense($head->head_row_id, $area_row_id, $budget_year, $start_date, $end_date);
                        $head->total_expense = $head_total_expense;
                    }
                    if ($showBalance) {
                        $head_current_balance = $head_current_total_allocation - $head_total_expense;
                        $head->head_current_balance = $head_current_balance;
                    }
                    if (isset($head_current_total_allocation) && ($head_current_total_allocation != 0)) {
                        $this->output[] = $head;
                    }
                }
            }
        }
        $output = $this->output;
        $this->output = array();
        return $output;
    }

    public function setExpenseFilterAllHeadsChildren($haystack, $parentHeadId, $area_row_id = 0, $budget_year, $showAllocation, $showExpense, $showBalance, $start_date = 0, $end_date = 0) {
        if (count($haystack)) {
            foreach ($haystack as $head) {
                if ($head->parent_id && $head->parent_id == $parentHeadId) {
                    if ($head->has_child) {
                        $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                        $parent_head_child_number = $this->findHeadChildrenNumberByAllocation($head->head_row_id, $area_row_id, $budget_year);
                        $parent_head_total_allocation = $this->totalParentHeadAllocations($this->parent_head_child_list, $area_row_id, $budget_year);
                        $parent_head_total_expense = $this->totalParentHeadExpense($this->parent_head_child_list, $area_row_id, $budget_year, $start_date, $end_date);
                        $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area_row_id, $budget_year, 0, 0);
                        $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area_row_id, $budget_year, 0, 0);
                        $parent_head_total_current_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                        $parent_head_current_balance = $parent_head_total_current_allocation - $parent_head_total_expense;
                        $head->parent_head_current_balance = $parent_head_current_balance;
                        $head->parent_head_total_expense = $parent_head_total_expense;
                        $head->parent_head_total_allocation = $parent_head_total_current_allocation;
                        $head->parent_head_child_number = $parent_head_child_number;
                        if (isset($parent_head_total_current_allocation) && ($parent_head_total_current_allocation != 0)) {
                            $this->output[] = $head;
                        }
                        $this->setExpenseFilterAllHeadsChildren($haystack, $head->head_row_id, $area_row_id, $budget_year, $showAllocation, $showExpense, $showBalance, $start_date, $end_date);
                    } else {
                        $head_current_total_allocation = 0;
                        $head_total_expense = 0;
                        $head_current_balance = 0;
                        if ($showAllocation) {
                            $head_total_allocation = $this->totalAllcations($head->head_row_id, $area_row_id, $budget_year);
                            $head_total_adjustment = $this->totalFilterReceiption($area_row_id, $head->head_row_id, $budget_year, 0, 0);
                            $head_total_donation = $this->totalFilterDonation($area_row_id, $head->head_row_id, $budget_year, 0, 0);
                            $head_current_total_allocation = ($head_total_allocation + $head_total_adjustment) - $head_total_donation;
                            $head->total_allocation = $head_current_total_allocation;
                        }
                        if ($showExpense) {
                            $head_total_expense = $this->totalFilterExpense($head->head_row_id, $area_row_id, $budget_year, $start_date, $end_date);
                            $head->total_expense = $head_total_expense;
                        }
                        if ($showBalance) {
                            $head_current_balance = $head_current_total_allocation - $head_total_expense;
                            $head->head_current_balance = $head_current_balance;
                        }
                        if (isset($head_current_total_allocation) && ($head_current_total_allocation != 0)) {
                            $this->output[] = $head;
                        }
                    }
                }
            }
        }
    }

    /**
     * Return all  head with expense filter function
     * @param type $showAllocation
     * @param type $showExpense
     * @param type $head_row_id
     * @param type $start_date
     * @param type $end_date
     * @return type
     */
    public function expenseFilterHeads($showAllocation = false, $showExpense = true, $showBalance = false, $area_row_id = 0, $head_row_id = 0, $budget_year, $start_date = 0, $end_date = 0) {
        $head = \App\Models\Head::find($head_row_id);
        $status = 1;
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        $result = $this->budgetAllHeadListWithProject($budget_year, $status);
        $this->output = array();
        if ($head->has_child) {
            $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
            $parent_head_child_number = $this->findHeadChildrenNumberByAllocation($head->head_row_id, $area_row_id, $budget_year);
            $parent_head_total_allocation = $this->totalParentHeadAllocations($this->parent_head_child_list, $area_row_id, $budget_year);
            $parent_head_total_expense = $this->totalParentHeadExpense($this->parent_head_child_list, $area_row_id, $budget_year, $start_date, $end_date);
            $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area_row_id, $budget_year, 0, 0);
            $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area_row_id, $budget_year, 0, 0);
            $parent_head_total_current_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
            $parent_head_current_balance = $parent_head_total_current_allocation - $parent_head_total_expense;
            $head->parent_head_current_balance = $parent_head_current_balance;
            $head->parent_head_total_expense = $parent_head_total_expense;
            $head->parent_head_total_allocation = $parent_head_total_current_allocation;
            $head->parent_head_child_number = $parent_head_child_number;
            if (isset($parent_head_total_current_allocation) && ($parent_head_total_current_allocation != 0)) {
                $this->output[] = $head;
            }
            $this->setExpenseFilterChildren($result, $head->head_row_id, $area_row_id, $budget_year, $showAllocation, $showExpense, $showBalance, $start_date, $end_date);
        } else {
            $head_current_total_allocation = 0;
            if ($showAllocation) {
                $head_total_allocation = $this->totalAllcations($head->head_row_id, $area_row_id, $budget_year);
                $head_total_adjustment = $this->totalFilterReceiption($area_row_id, $head->head_row_id, $budget_year, 0, 0);
                $head_total_donation = $this->totalFilterDonation($area_row_id, $head->head_row_id, $budget_year, 0, 0);
                $head_current_total_allocation = ($head_total_allocation + $head_total_adjustment) - $head_total_donation;
                $head->total_allocation = $head_current_total_allocation;
            }
            $head_total_expense = 0;
            if ($showExpense) {
                $head_total_expense = $this->totalFilterExpense($head->head_row_id, $area_row_id, $budget_year, $start_date, $end_date);
                $head->total_expense = $head_total_expense;
            }
            $head_current_balance = 0;
            if ($showBalance) {
                $head_current_balance = $head_current_total_allocation - $head_total_expense;
                $head->head_current_balance = $head_current_balance;
            }
            if (isset($head_current_total_allocation) && ($head_current_total_allocation != 0)) {
                $this->output[] = $head;
            }
        }
        $output = $this->output;
        $this->output = array();
        return $output;
    }

    /**
     * Set head child list with expense filter
     * @param type $haystack
     * @param type $parentHeadId
     * @param type $showAllocation
     * @param type $showExpense
     * @param type $start_date
     * @param type $end_date
     */
    public function setExpenseFilterChildren($haystack, $parentHeadId, $area_row_id = 0, $budget_year, $showAllocation, $showExpense, $showBalance, $start_date = 0, $end_date = 0) {
        if (count($haystack)) {
            foreach ($haystack as $head) {
                if ($head->parent_id && $head->parent_id == $parentHeadId) {
                    if ($head->has_child) {
                        $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                        //$parent_head_child_number = $this->findHeadChildrenNumber($head->head_row_id);
                        $parent_head_child_number = $this->findHeadChildrenNumberByAllocation($head->head_row_id, $area_row_id, $budget_year);
                        $parent_head_total_allocation = $this->totalParentHeadAllocations($this->parent_head_child_list, $area_row_id, $budget_year);
                        $parent_head_total_expense = $this->totalParentHeadExpense($this->parent_head_child_list, $area_row_id, $budget_year, $start_date, $end_date);
                        $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area_row_id, $budget_year, 0, 0);
                        $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area_row_id, $budget_year, 0, 0);
                        $parent_head_total_current_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                        $parent_head_current_balance = $parent_head_total_current_allocation - $parent_head_total_expense;
                        $head->parent_head_current_balance = $parent_head_current_balance;
                        $head->parent_head_total_expense = $parent_head_total_expense;
                        $head->parent_head_total_allocation = $parent_head_total_current_allocation;
                        $head->parent_head_child_number = $parent_head_child_number;
                        if (isset($parent_head_total_current_allocation) && ($parent_head_total_current_allocation != 0)) {
                            $this->output[] = $head;
                        }
                        $this->setExpenseFilterChildren($haystack, $head->head_row_id, $area_row_id, $budget_year, $showAllocation, $showExpense, $showBalance, $start_date, $end_date);
                    } else {
                        $head_current_total_allocation = 0;
                        if ($showAllocation) {
                            $head_total_allocation = $this->totalAllcations($head->head_row_id, $area_row_id, $budget_year);
                            $head_total_adjustment = $this->totalFilterReceiption($area_row_id, $head->head_row_id, $budget_year, 0, 0);
                            $head_total_donation = $this->totalFilterDonation($area_row_id, $head->head_row_id, $budget_year, 0, 0);
                            $head_current_total_allocation = ($head_total_allocation + $head_total_adjustment) - $head_total_donation;
                            $head->total_allocation = $head_current_total_allocation;
                        }
                        $head_total_expense = 0;
                        if ($showExpense) {
                            $head_total_expense = $this->totalFilterExpense($head->head_row_id, $area_row_id, $budget_year, $start_date, $end_date);
                            $head->total_expense = $head_total_expense;
                        }
                        if ($showBalance) {
                            $head_current_balance = $head_current_total_allocation - $head_total_expense;
                            $head->head_current_balance = $head_current_balance;
                        }
                        if (isset($head_current_total_allocation) && ($head_current_total_allocation != 0)) {
                            $this->output[] = $head;
                        }
                    }
                }
            }
        }
    }

    /**
     * Expense Filter for all area on a single specific head
     * @param type $showAllocation
     * @param type $showExpense
     * @param type $showBalance
     * @param type $head_row_id
     * @param type $budget_year
     * @param type $start_date
     * @param type $end_date
     * @return type
     */
    public function expenseFilterAllAreaSingleHead($showAllocation = false, $showExpense = true, $showBalance = false, $head_row_id = 0, $budget_year, $start_date = 0, $end_date = 0) {
        $head = \App\Models\Head::find($head_row_id);
        $status = 1;
        $allArea = $this->allAreas(1);
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        $result = $this->budgetAllHeadListWithProject($budget_year, $status);
        $this->all_area_single_head_info_list = array();
        if (count($allArea)) {
            foreach ($allArea as $area) {
                if ($head->has_child) {
                    $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                    $parent_head_child_number = $this->findHeadChildrenNumberByAllocation($head->head_row_id, $area->area_row_id, $budget_year);
                    $parent_head_total_expense = $this->totalParentHeadExpense($this->parent_head_child_list, $area->area_row_id, $budget_year, $start_date, $end_date);
                    $parent_head_total_allocation = $this->totalParentHeadAllocations($this->parent_head_child_list, $area->area_row_id, $budget_year);
                    $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area->area_row_id, $budget_year, 0, 0);
                    $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area->area_row_id, $budget_year, 0, 0);
                    $parent_head_total_current_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                    $parent_head_current_balance = $parent_head_total_current_allocation - $parent_head_total_expense;
                    if (isset($parent_head_total_current_allocation) && ($parent_head_total_current_allocation != 0)) {
                        $this->all_area_single_head_info_list[$area->title][$head->head_row_id] = array(
                            'head_row_id' => $head->head_row_id,
                            'title' => $head->title,
                            'sort_order' => $head->sort_order,
                            'parent_id' => $head->parent_id,
                            'has_child' => $head->has_child,
                            'level' => $head->level,
                            'area_row_id' => $area->area_row_id,
                            'area_name' => $area->title,
                            'parent_head_child_number' => $parent_head_child_number,
                            'parent_head_total_allocation' => $parent_head_total_current_allocation,
                            'parent_head_current_balance' => $parent_head_current_balance,
                            'parent_head_total_expense' => $parent_head_total_expense
                        );
                    }
                    $this->setExpenseFilterAllAreaSingleHeadChildren($result, $head->head_row_id, $area->area_row_id, $budget_year, $showAllocation, $showExpense, $showBalance, $start_date, $end_date);
                } else {
                    $head_current_total_allocation = 0;
                    if ($showAllocation) {
                        $head_total_allocation = $this->totalAllcations($head->head_row_id, $area->area_row_id, $budget_year);
                        $head_total_adjustment = $this->totalFilterReceiption($area->area_row_id, $head->head_row_id, $budget_year, 0, 0);
                        $head_total_donation = $this->totalFilterDonation($area->area_row_id, $head->head_row_id, $budget_year, 0, 0);
                        $head_current_total_allocation = ($head_total_allocation + $head_total_adjustment) - $head_total_donation;
                    }
                    $head_total_expense = 0;
                    if ($showExpense) {
                        $head_total_expense = $this->totalFilterExpense($head->head_row_id, $area->area_row_id, $budget_year, $start_date, $end_date);
                    }
                    $head_current_balance = 0;
                    if ($showBalance) {
                        $head_current_balance = $head_current_total_allocation - $head_total_expense;
                    }
                    if (isset($head_current_total_allocation) && ($head_current_total_allocation != 0)) {
                        $this->all_area_single_head_info_list[$area->title][$head->head_row_id] = array(
                            'head_row_id' => $head->head_row_id,
                            'title' => $head->title,
                            'sort_order' => $head->sort_order,
                            'parent_id' => $head->parent_id,
                            'has_child' => $head->has_child,
                            'level' => $head->level,
                            'area_row_id' => $area->area_row_id,
                            'area_name' => $area->title,
                            'head_current_balance' => $head_current_balance,
                            'total_allocation' => $head_current_total_allocation,
                            'total_expense' => $head_total_expense
                        );
                    }
                }
            }
        }
        $output = $this->all_area_single_head_info_list;
        $this->all_area_single_head_info_list = array();
        return $output;
    }

    public function setExpenseFilterAllAreaSingleHeadChildren($haystack, $parentHeadId, $area_row_id = 0, $budget_year, $showAllocation, $showExpense, $showBalance, $start_date, $end_date) {
        if (count($haystack)) {
            $area_row_detail = $this->get_area_row_info($area_row_id);
            foreach ($haystack as $head) {
                if ($head->parent_id && $head->parent_id == $parentHeadId) {
                    if ($head->has_child) {
                        $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                        $parent_head_child_number = $this->findHeadChildrenNumberByAllocation($head->head_row_id, $area_row_id, $budget_year);
                        $parent_head_total_expense = $this->totalParentHeadExpense($this->parent_head_child_list, $area_row_id, $budget_year, $start_date, $end_date);
                        $parent_head_total_allocation = $this->totalParentHeadAllocations($this->parent_head_child_list, $area_row_id, $budget_year);
                        $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area_row_id, $budget_year, 0, 0);
                        $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area_row_id, $budget_year, 0, 0);
                        $parent_head_total_current_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                        $parent_head_current_balance = $parent_head_total_current_allocation - $parent_head_total_expense;
                        if (isset($parent_head_total_current_allocation) && ($parent_head_total_current_allocation != 0)) {
                            $this->all_area_single_head_info_list[$area_row_detail->title][$head->head_row_id] = array(
                                'head_row_id' => $head->head_row_id,
                                'title' => $head->title,
                                'sort_order' => $head->sort_order,
                                'parent_id' => $head->parent_id,
                                'has_child' => $head->has_child,
                                'level' => $head->level,
                                'area_row_id' => $area_row_id,
                                'area_name' => $area_row_detail->title,
                                'parent_head_child_number' => $parent_head_child_number,
                                'parent_head_total_allocation' => $parent_head_total_current_allocation,
                                'parent_head_current_balance' => $parent_head_current_balance,
                                'parent_head_total_expense' => $parent_head_total_expense
                            );
                        }
                        $this->setExpenseFilterAllAreaSingleHeadChildren($haystack, $head->head_row_id, $area_row_id, $budget_year, $showAllocation, $showExpense, $showBalance, $start_date, $end_date);
                    } else {
                        $head_current_total_allocation = 0;
                        if ($showAllocation) {
                            $head_total_allocation = $this->totalAllcations($head->head_row_id, $area_row_id, $budget_year);
                            $head_total_adjustment = $this->totalFilterReceiption($area_row_id, $head->head_row_id, $budget_year, 0, 0);
                            $head_total_donation = $this->totalFilterDonation($area_row_id, $head->head_row_id, $budget_year, 0, 0);
                            $head_current_total_allocation = ($head_total_allocation + $head_total_adjustment) - $head_total_donation;
                        }
                        $head_total_expense = 0;
                        if ($showExpense) {
                            $head_total_expense = $this->totalFilterExpense($head->head_row_id, $area_row_id, $budget_year, $start_date, $end_date);
                        }
                        $head_current_balance = 0;
                        if ($showBalance) {
                            $head_current_balance = $head_current_total_allocation - $head_total_expense;
                        }
                        if (isset($head_current_total_allocation) && ($head_current_total_allocation != 0)) {
                            $this->all_area_single_head_info_list[$area_row_detail->title][$head->head_row_id] = array(
                                'head_row_id' => $head->head_row_id,
                                'title' => $head->title,
                                'sort_order' => $head->sort_order,
                                'parent_id' => $head->parent_id,
                                'has_child' => $head->has_child,
                                'level' => $head->level,
                                'area_row_id' => $area_row_id,
                                'area_name' => $area_row_detail->title,
                                'head_current_balance' => $head_current_balance,
                                'total_allocation' => $head_current_total_allocation,
                                'total_expense' => $head_total_expense
                            );
                        }
                    }
                }
            }
        }
    }

    /**
     *
     * @param type $showAllocation
     * @param type $showExpense
     * @param type $showBalance
     * @param type $budget_year
     * @param type $start_date
     * @param type $end_date
     * @return type
     */
    public function expenseFilterAllHeadAllArea($showAllocation = false, $showExpense = true, $showBalance = false, $budget_year, $start_date = 0, $end_date = 0) {
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        $status = 1;
        $result = $this->budgetAllHeadListWithProject($budget_year, $status);
        $allArea = $this->allAreas(1);
        $this->all_area_all_head_info_list = array();
        if (count($allArea)) {
            foreach ($allArea as $area) {
                foreach ($result as $head) {
                    if ($head->parent_id == 0) {
                        if ($head->has_child) {
                            $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                            $parent_head_child_number = $this->findHeadChildrenNumberByAllocation($head->head_row_id, $area->area_row_id, $budget_year);
                            $parent_head_total_expense = $this->totalParentHeadExpense($this->parent_head_child_list, $area->area_row_id, $budget_year, $start_date, $end_date);
                            $parent_head_total_allocation = $this->totalParentHeadAllocations($this->parent_head_child_list, $area->area_row_id, $budget_year);
                            $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area->area_row_id, $budget_year, 0, 0);
                            $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area->area_row_id, $budget_year, 0, 0);
                            $parent_head_total_current_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                            $parent_head_current_balance = $parent_head_total_current_allocation - $parent_head_total_expense;
                            if (isset($parent_head_total_current_allocation) && ($parent_head_total_current_allocation != 0)) {
                                $this->all_area_all_head_info_list[$area->title][$head->head_row_id] = array(
                                    'head_row_id' => $head->head_row_id,
                                    'title' => $head->title,
                                    'sort_order' => $head->sort_order,
                                    'parent_id' => $head->parent_id,
                                    'has_child' => $head->has_child,
                                    'level' => $head->level,
                                    'area_row_id' => $area->area_row_id,
                                    'area_name' => $area->title,
                                    'parent_head_child_number' => $parent_head_child_number,
                                    'parent_head_total_allocation' => $parent_head_total_current_allocation,
                                    'parent_head_current_balance' => $parent_head_current_balance,
                                    'parent_head_total_expense' => $parent_head_total_expense
                                );
                            }
                            $this->setExpenseFilterAllHeadAllAreaChildren($result, $head->head_row_id, $area->area_row_id, $budget_year, $showAllocation, $showExpense, $showBalance, $start_date, $end_date);
                        } else {
                            $head_current_total_allocation = 0;
                            if ($showAllocation) {
                                $head_total_allocation = $this->totalAllcations($head->head_row_id, $area->area_row_id, $budget_year);
                                $head_total_adjustment = $this->totalFilterReceiption($area->area_row_id, $head->head_row_id, $budget_year, 0, 0);
                                $head_total_donation = $this->totalFilterDonation($area->area_row_id, $head->head_row_id, $budget_year, 0, 0);
                                $head_current_total_allocation = ($head_total_allocation + $head_total_adjustment) - $head_total_donation;
                            }
                            $head_total_expense = 0;
                            if ($showExpense) {
                                $head_total_expense = $this->totalFilterExpense($head->head_row_id, $area->area_row_id, $budget_year, $start_date, $end_date);
                            }
                            $head_current_balance = 0;
                            if ($showBalance) {
                                $head_current_balance = $head_current_total_allocation - $head_total_expense;
                            }
                            if (isset($head_current_total_allocation) && ($head_current_total_allocation != 0)) {
                                $this->all_area_all_head_info_list[$area->title][$head->head_row_id] = array(
                                    'head_row_id' => $head->head_row_id,
                                    'title' => $head->title,
                                    'sort_order' => $head->sort_order,
                                    'parent_id' => $head->parent_id,
                                    'has_child' => $head->has_child,
                                    'level' => $head->level,
                                    'area_row_id' => $area->area_row_id,
                                    'area_name' => $area->title,
                                    'head_current_balance' => $head_current_balance,
                                    'total_allocation' => $head_current_total_allocation,
                                    'total_expense' => $head_total_expense
                                );
                            }
                        }
                    }
                }
            }
        }
        $output = $this->all_area_all_head_info_list;
        $this->all_area_all_head_info_list = array();
        return $output;
    }

    /**
     *
     * @param type $haystack
     * @param type $parentHeadId
     * @param type $area_row_id
     * @param type $budget_year
     * @param type $showAllocation
     * @param type $showExpense
     * @param type $showBalance
     * @param type $start_date
     * @param type $end_date
     */
    public function setExpenseFilterAllHeadAllAreaChildren($haystack, $parentHeadId, $area_row_id = 0, $budget_year, $showAllocation, $showExpense, $showBalance, $start_date = 0, $end_date = 0) {
        if (count($haystack)) {
            $area_row_detail = $this->get_area_row_info($area_row_id);
            foreach ($haystack as $head) {
                if ($head->parent_id && $head->parent_id == $parentHeadId) {
                    if ($head->has_child) {
                        $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                        $parent_head_child_number = $this->findHeadChildrenNumberByAllocation($head->head_row_id, $area_row_id, $budget_year);
                        $parent_head_total_expense = $this->totalParentHeadExpense($this->parent_head_child_list, $area_row_id, $budget_year, $start_date, $end_date);
                        $parent_head_total_allocation = $this->totalParentHeadAllocations($this->parent_head_child_list, $area_row_id, $budget_year);
                        $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area_row_id, $budget_year, 0, 0);
                        $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area_row_id, $budget_year, 0, 0);
                        $parent_head_total_current_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                        $parent_head_current_balance = $parent_head_total_current_allocation - $parent_head_total_expense;
                        if (isset($parent_head_total_current_allocation) && ($parent_head_total_current_allocation != 0)) {
                            $this->all_area_all_head_info_list[$area_row_detail->title][$head->head_row_id] = array(
                                'head_row_id' => $head->head_row_id,
                                'title' => $head->title,
                                'sort_order' => $head->sort_order,
                                'parent_id' => $head->parent_id,
                                'has_child' => $head->has_child,
                                'level' => $head->level,
                                'area_row_id' => $area_row_id,
                                'area_name' => $area_row_detail->title,
                                'parent_head_child_number' => $parent_head_child_number,
                                'parent_head_total_allocation' => $parent_head_total_current_allocation,
                                'parent_head_current_balance' => $parent_head_current_balance,
                                'parent_head_total_expense' => $parent_head_total_expense
                            );
                        }
                        $this->setExpenseFilterAllHeadAllAreaChildren($haystack, $head->head_row_id, $area_row_id, $budget_year, $showAllocation, $showExpense, $showBalance, $start_date, $end_date);
                    } else {
                        $head_current_total_allocation = 0;
                        if ($showAllocation) {
                            $head_total_allocation = $this->totalAllcations($head->head_row_id, $area_row_id, $budget_year);
                            $head_total_adjustment = $this->totalFilterReceiption($area_row_id, $head->head_row_id, $budget_year, 0, 0);
                            $head_total_donation = $this->totalFilterDonation($area_row_id, $head->head_row_id, $budget_year, 0, 0);
                            $head_current_total_allocation = ($head_total_allocation + $head_total_adjustment) - $head_total_donation;
                        }
                        $head_total_expense = 0;
                        if ($showExpense) {
                            $head_total_expense = $this->totalFilterExpense($head->head_row_id, $area_row_id, $budget_year, $start_date, $end_date);
                        }
                        $head_current_balance = 0;
                        if ($showBalance) {
                            $head_current_balance = $head_current_total_allocation - $head_total_expense;
                        }
                        if (isset($head_current_total_allocation) && ($head_current_total_allocation != 0)) {
                            $this->all_area_all_head_info_list[$area_row_detail->title][$head->head_row_id] = array(
                                'head_row_id' => $head->head_row_id,
                                'title' => $head->title,
                                'sort_order' => $head->sort_order,
                                'parent_id' => $head->parent_id,
                                'has_child' => $head->has_child,
                                'level' => $head->level,
                                'area_row_id' => $area_row_id,
                                'area_name' => $area_row_detail->title,
                                'head_current_balance' => $head_current_balance,
                                'total_allocation' => $head_current_total_allocation,
                                'total_expense' => $head_total_expense
                            );
                        }
                    }
                }
            }
        }
    }

    public function balanceReportByMonthRange($showAllocation = true, $showExpense = true, $showBalance = true, $area_row_id = 0, $head_row_id = 0, $budget_year = 0, $from_month = 0, $to_month = 0) {
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        $status = 1;
        $all_head_list = $this->budgetAllHeadListWithProject($budget_year, $status);
        $this->all_area_all_head_info_list = array();
        $this->head_total_expense_by_month = array();
        if (!empty($from_month) && !empty($to_month)) {
            $data['from_month'] = $from_month;
            $data['to_month'] = $to_month;
        } elseif (!empty($from_month) && empty($to_month)) {
            $to_month = Carbon::now()->format('m');
            $data['from_month'] = $from_month;
            $data['to_month'] = $to_month;
        } elseif (empty($from_month) && !empty($to_month)) {
            $from_month = $to_month;
            $data['from_month'] = $from_month;
            $data['to_month'] = $to_month;
        } else {
            $from_month = Carbon::now()->format('m');
            $to_month = Carbon::now()->format('m');
        }
        /*
         * Check area_row_id value
         * which is selected all area or a specific area
         * area_row_id > 0, means a specific area selected
         * otherwise all area slected
         */
        if ($area_row_id > 0) {
            $area_row_detail = $this->get_area_row_info($area_row_id);
            if ($head_row_id > 0) {
                /*
                 * Specific area and head selected
                 */
                $head = \App\Models\Head::find($head_row_id);
                if ($head->has_child) {
                    $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                    $parent_head_child_number = $this->findHeadChildrenNumberByAllocation($head->head_row_id, $area_row_id, $budget_year);
                    $parent_head_total_allocation = $this->totalParentHeadAllocations($this->parent_head_child_list, $area_row_detail->area_row_id, $budget_year);
                    $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area_row_detail->area_row_id, $budget_year, 0, 0);
                    $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area_row_detail->area_row_id, $budget_year, 0, 0);
                    $parent_head_total_current_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                    $start_month = $from_month;
                    $parent_total_expense = 0;
                    $parent_month_expense = 0;
                    for ($start_month; $start_month <= $to_month; $start_month++) {
                        $parent_month_expense = $this->totalParentHeadExpenseByMonth($this->parent_head_child_list, $area_row_id, $budget_year, $start_month);
                        $this->head_total_expense_by_month[$start_month] = $parent_month_expense;
                        $parent_total_expense += $parent_month_expense;
                    }
                    $parent_head_current_balance = $parent_head_total_current_allocation - $parent_total_expense;
                    if (isset($parent_head_total_current_allocation) && ($parent_head_total_current_allocation != 0)) {
                        $this->all_area_all_head_info_list[$area_row_id][$head->head_row_id] = array(
                            'head_row_id' => $head->head_row_id,
                            'title' => $head->title,
                            'sort_order' => $head->sort_order,
                            'parent_id' => $head->parent_id,
                            'has_child' => $head->has_child,
                            'level' => $head->level,
                            'area_row_id' => $area_row_id,
                            'parent_head_child_number' => $parent_head_child_number,
                            'parent_head_total_allocation' => $parent_head_total_current_allocation,
                            'parent_head_current_balance' => $parent_head_current_balance,
                            'parent_head_total_expense' => $parent_total_expense
                        );
                        array_push($this->all_area_all_head_info_list[$area_row_id][$head->head_row_id], $this->head_total_expense_by_month);
                    }
                    unset($start_month);
                    unset($parent_total_expense);
                    unset($parent_month_expense);
                    $this->setBalanceReportByMonthRangeChildren($all_head_list, $head->head_row_id, $area_row_id, $budget_year, $showAllocation, $showExpense, $showBalance, $from_month, $to_month);
                } else {
                    $head_current_total_allocation = 0;
                    if ($showAllocation) {
                        $head_total_allocation = $this->totalAllcations($head->head_row_id, $area_row_id, $budget_year);
                        $head_total_adjustment = $this->totalFilterReceiption($area_row_id, $head->head_row_id, $budget_year, 0, 0);
                        $head_total_donation = $this->totalFilterDonation($area_row_id, $head->head_row_id, $budget_year, 0, 0);
                        $head_current_total_allocation = ($head_total_allocation + $head_total_adjustment) - $head_total_donation;
                    }
                    $start_month = $from_month;
                    $total_expense = 0;
                    $month_expense = 0;
                    for ($start_month; $start_month <= $to_month; $start_month++) {
                        $month_expense = $this->totalFilterExpenseByMonth($head->head_row_id, $area_row_id, $budget_year, $start_month);
                        $this->head_total_expense_by_month[$start_month] = $month_expense;
                        $total_expense += $month_expense;
                    }
                    $head_current_balance = 0;
                    if ($showBalance) {
                        $head_current_balance = $head_current_total_allocation - $total_expense;
                    }
                    if (isset($head_current_total_allocation) && ($head_current_total_allocation != 0)) {
                        $this->all_area_all_head_info_list[$area_row_id][$head->head_row_id] = array(
                            'head_row_id' => $head->head_row_id,
                            'title' => $head->title,
                            'sort_order' => $head->sort_order,
                            'parent_id' => $head->parent_id,
                            'has_child' => $head->has_child,
                            'level' => $head->level,
                            'area_row_id' => $area_row_id,
                            'head_total_allocation' => $head_current_total_allocation,
                            'head_current_balance' => $head_current_balance,
                            'head_total_expense' => $total_expense
                        );
                        array_push($this->all_area_all_head_info_list[$area_row_id][$head->head_row_id], $this->head_total_expense_by_month);
                    }
                    unset($start_month);
                    unset($month_expense);
                }
            } else {
                /*
                 * Specific area and all head Selected
                 */
                foreach ($all_head_list as $head) {
                    if ($head->parent_id == 0) {
                        if ($head->has_child) {
                            $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                            //$parent_head_child_number = $this->findHeadChildrenNumber($head->head_row_id);
                            $parent_head_child_number = $this->findHeadChildrenNumberByAllocation($head->head_row_id, $area_row_id, $budget_year);
                            $parent_head_total_allocation = $this->totalParentHeadAllocations($this->parent_head_child_list, $area_row_id, $budget_year);
                            $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area_row_id, $budget_year, 0, 0);
                            $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area_row_id, $budget_year, 0, 0);
                            $parent_head_total_current_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                            $start_month = $from_month;
                            $parent_total_expense = 0;
                            $parent_month_expense = 0;
                            for ($start_month; $start_month <= $to_month; $start_month++) {
                                $parent_month_expense = $this->totalParentHeadExpenseByMonth($this->parent_head_child_list, $area_row_id, $budget_year, $start_month);
                                $this->head_total_expense_by_month[$start_month] = $parent_month_expense;
                                $parent_total_expense += $parent_month_expense;
                            }
                            $parent_head_current_balance = $parent_head_total_current_allocation - $parent_total_expense;
                            if (isset($parent_head_total_current_allocation) && ($parent_head_total_current_allocation != 0)) {
                                $this->all_area_all_head_info_list[$area_row_id][$head->head_row_id] = array(
                                    'head_row_id' => $head->head_row_id,
                                    'title' => $head->title,
                                    'sort_order' => $head->sort_order,
                                    'parent_id' => $head->parent_id,
                                    'has_child' => $head->has_child,
                                    'level' => $head->level,
                                    'area_row_id' => $area_row_id,
                                    'parent_head_child_number' => $parent_head_child_number,
                                    'parent_head_total_allocation' => $parent_head_total_current_allocation,
                                    'parent_head_current_balance' => $parent_head_current_balance,
                                    'parent_head_total_expense' => $parent_total_expense
                                );
                                array_push($this->all_area_all_head_info_list[$area_row_id][$head->head_row_id], $this->head_total_expense_by_month);
                            }
                            unset($start_month);
                            unset($parent_total_expense);
                            unset($parent_month_expense);
                            $this->setBalanceReportByMonthRangeChildren($all_head_list, $head->head_row_id, $area_row_id, $budget_year, $showAllocation, $showExpense, $showBalance, $from_month, $to_month);
                        } else {
                            $head_current_total_allocation = 0;
                            if ($showAllocation) {
                                $head_total_allocation = $this->totalAllcations($head->head_row_id, $area_row_id, $budget_year);
                                $head_total_adjustment = $this->totalFilterReceiption($area_row_id, $head->head_row_id, $budget_year, 0, 0);
                                $head_total_donation = $this->totalFilterDonation($area_row_id, $head->head_row_id, $budget_year, 0, 0);
                                $head_current_total_allocation = ($head_total_allocation + $head_total_adjustment) - $head_total_donation;
                            }
                            $start_month = $from_month;
                            $total_expense = 0;
                            $month_expense = 0;
                            for ($start_month; $start_month <= $to_month; $start_month++) {
                                $month_expense = $this->totalFilterExpenseByMonth($head->head_row_id, $area_row_id, $budget_year, $start_month);
                                $this->head_total_expense_by_month[$start_month] = $month_expense;
                                $total_expense += $month_expense;
                            }
                            $head_current_balance = 0;
                            if ($showBalance) {
                                $head_current_balance = $head_current_total_allocation - $total_expense;
                            }
                            if (isset($head_current_total_allocation) && ($head_current_total_allocation != 0)) {
                                $this->all_area_all_head_info_list[$area_row_id][$head->head_row_id] = array(
                                    'head_row_id' => $head->head_row_id,
                                    'title' => $head->title,
                                    'sort_order' => $head->sort_order,
                                    'parent_id' => $head->parent_id,
                                    'has_child' => $head->has_child,
                                    'level' => $head->level,
                                    'area_row_id' => $area_row_id,
                                    'head_total_allocation' => $head_current_total_allocation,
                                    'head_current_balance' => $head_current_balance,
                                    'head_total_expense' => $total_expense
                                );
                                array_push($this->all_area_all_head_info_list[$area_row_id][$head->head_row_id], $this->head_total_expense_by_month);
                            }
                            unset($start_month);
                            unset($month_expense);
                        }
                    }
                }
            }
        } else {
            $allArea = $this->allAreas(1);
            if ($head_row_id > 0) {
                /*
                 * All area and specific head selected
                 */
                $head = \App\Models\Head::find($head_row_id);
                if (count($allArea)) {
                    foreach ($allArea as $area) {
                        if ($head->has_child) {
                            $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                            $parent_head_child_number = $this->findHeadChildrenNumberByAllocation($head->head_row_id, $area->area_row_id, $budget_year);
                            $parent_head_total_allocation = $this->totalParentHeadAllocations($this->parent_head_child_list, $area->area_row_id, $budget_year);
                            $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area->area_row_id, $budget_year, 0, 0);
                            $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area->area_row_id, $budget_year, 0, 0);
                            $parent_head_total_current_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                            $start_month = $from_month;
                            $parent_total_expense = 0;
                            $parent_month_expense = 0;
                            for ($start_month; $start_month <= $to_month; $start_month++) {
                                $parent_month_expense = $this->totalParentHeadExpenseByMonth($this->parent_head_child_list, $area->area_row_id, $budget_year, $start_month);
                                $this->head_total_expense_by_month[$start_month] = $parent_month_expense;
                                $parent_total_expense += $parent_month_expense;
                            }
                            $parent_head_current_balance = $parent_head_total_current_allocation - $parent_total_expense;
                            if (isset($parent_head_total_current_allocation) && ($parent_head_total_current_allocation != 0)) {
                                $this->all_area_all_head_info_list[$area->area_row_id][$head->head_row_id] = array(
                                    'head_row_id' => $head->head_row_id,
                                    'title' => $head->title,
                                    'sort_order' => $head->sort_order,
                                    'parent_id' => $head->parent_id,
                                    'has_child' => $head->has_child,
                                    'level' => $head->level,
                                    'area_row_id' => $area->area_row_id,
                                    'parent_head_child_number' => $parent_head_child_number,
                                    'parent_head_total_allocation' => $parent_head_total_current_allocation,
                                    'parent_head_current_balance' => $parent_head_current_balance,
                                    'parent_head_total_expense' => $parent_total_expense
                                );
                                array_push($this->all_area_all_head_info_list[$area->area_row_id][$head->head_row_id], $this->head_total_expense_by_month);
                            }
                            unset($start_month);
                            unset($parent_total_expense);
                            unset($parent_month_expense);
                            $this->setBalanceReportByMonthRangeChildren($all_head_list, $head->head_row_id, $area->area_row_id, $budget_year, $showAllocation, $showExpense, $showBalance, $from_month, $to_month);
                        } else {
                            $head_current_total_allocation = 0;
                            if ($showAllocation) {
                                $head_total_allocation = $this->totalAllcations($head->head_row_id, $area->area_row_id, $budget_year);
                                $head_total_adjustment = $this->totalFilterReceiption($area->area_row_id, $head->head_row_id, $budget_year, 0, 0);
                                $head_total_donation = $this->totalFilterDonation($area->area_row_id, $head->head_row_id, $budget_year, 0, 0);
                                $head_current_total_allocation = ($head_total_allocation + $head_total_adjustment) - $head_total_donation;
                            }
                            $start_month = $from_month;
                            $total_expense = 0;
                            $month_expense = 0;
                            for ($start_month; $start_month <= $to_month; $start_month++) {
                                $month_expense = $this->totalFilterExpenseByMonth($head->head_row_id, $area->area_row_id, $budget_year, $start_month);
                                $this->head_total_expense_by_month[$start_month] = $month_expense;
                                $total_expense += $month_expense;
                            }
                            $head_current_balance = 0;
                            if ($showBalance) {
                                $head_current_balance = $head_current_total_allocation - $total_expense;
                            }
                            if (isset($head_current_total_allocation) && ($head_current_total_allocation != 0)) {
                                $this->all_area_all_head_info_list[$area->area_row_id][$head->head_row_id] = array(
                                    'head_row_id' => $head->head_row_id,
                                    'title' => $head->title,
                                    'sort_order' => $head->sort_order,
                                    'parent_id' => $head->parent_id,
                                    'has_child' => $head->has_child,
                                    'level' => $head->level,
                                    'area_row_id' => $area->area_row_id,
                                    'head_total_allocation' => $head_current_total_allocation,
                                    'head_current_balance' => $head_current_balance,
                                    'head_total_expense' => $total_expense
                                );
                                array_push($this->all_area_all_head_info_list[$area->area_row_id][$head->head_row_id], $this->head_total_expense_by_month);
                            }
                            unset($start_month);
                            unset($month_expense);
                        }
                    }
                }
            } else {
                /*
                 * All area and head Selected
                 */
                if (count($allArea)) {
                    foreach ($allArea as $area) {
                        foreach ($all_head_list as $head) {
                            if ($head->parent_id == 0) {
                                if ($head->has_child) {
                                    $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                                    $parent_head_child_number = $this->findHeadChildrenNumberByAllocation($head->head_row_id, $area->area_row_id, $budget_year);
                                    $parent_head_total_allocation = $this->totalParentHeadAllocations($this->parent_head_child_list, $area->area_row_id, $budget_year);
                                    $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area->area_row_id, $budget_year, 0, 0);
                                    $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area->area_row_id, $budget_year, 0, 0);
                                    $parent_head_total_current_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                                    $start_month = $from_month;
                                    $parent_total_expense = 0;
                                    $parent_month_expense = 0;
                                    for ($start_month; $start_month <= $to_month; $start_month++) {
                                        $parent_month_expense = $this->totalParentHeadExpenseByMonth($this->parent_head_child_list, $area->area_row_id, $budget_year, $start_month);
                                        $this->head_total_expense_by_month[$start_month] = $parent_month_expense;
                                        $parent_total_expense += $parent_month_expense;
                                    }
                                    $parent_head_current_balance = $parent_head_total_current_allocation - $parent_total_expense;
                                    if (isset($parent_head_total_current_allocation) && ($parent_head_total_current_allocation != 0)) {
                                        $this->all_area_all_head_info_list[$area->area_row_id][$head->head_row_id] = array(
                                            'head_row_id' => $head->head_row_id,
                                            'title' => $head->title,
                                            'sort_order' => $head->sort_order,
                                            'parent_id' => $head->parent_id,
                                            'has_child' => $head->has_child,
                                            'level' => $head->level,
                                            'area_row_id' => $area->area_row_id,
                                            'parent_head_child_number' => $parent_head_child_number,
                                            'parent_head_total_allocation' => $parent_head_total_current_allocation,
                                            'parent_head_current_balance' => $parent_head_current_balance,
                                            'parent_head_total_expense' => $parent_total_expense
                                        );
                                        array_push($this->all_area_all_head_info_list[$area->area_row_id][$head->head_row_id], $this->head_total_expense_by_month);
                                    }
                                    unset($start_month);
                                    unset($parent_total_expense);
                                    unset($parent_month_expense);
                                    $this->setBalanceReportByMonthRangeChildren($all_head_list, $head->head_row_id, $area->area_row_id, $budget_year, $showAllocation, $showExpense, $showBalance, $from_month, $to_month);
                                } else {
                                    $head_current_total_allocation = 0;
                                    if ($showAllocation) {
                                        $head_total_allocation = $this->totalAllcations($head->head_row_id, $area->area_row_id, $budget_year);
                                        $head_total_adjustment = $this->totalFilterReceiption($area->area_row_id, $head->head_row_id, $budget_year, 0, 0);
                                        $head_total_donation = $this->totalFilterDonation($area->area_row_id, $head->head_row_id, $budget_year, 0, 0);
                                        $head_current_total_allocation = ($head_total_allocation + $head_total_adjustment) - $head_total_donation;
                                    }
                                    $start_month = $from_month;
                                    $total_expense = 0;
                                    $month_expense = 0;
                                    for ($start_month; $start_month <= $to_month; $start_month++) {
                                        $month_expense = $this->totalFilterExpenseByMonth($head->head_row_id, $area->area_row_id, $budget_year, $start_month);
                                        $this->head_total_expense_by_month[$start_month] = $month_expense;
                                        $total_expense += $month_expense;
                                    }
                                    $head_current_balance = 0;
                                    if ($showBalance) {
                                        $head_current_balance = $head_current_total_allocation - $total_expense;
                                    }
                                    if (isset($head_current_total_allocation) && ($head_current_total_allocation != 0)) {
                                        $this->all_area_all_head_info_list[$area->area_row_id][$head->head_row_id] = array(
                                            'head_row_id' => $head->head_row_id,
                                            'title' => $head->title,
                                            'sort_order' => $head->sort_order,
                                            'parent_id' => $head->parent_id,
                                            'has_child' => $head->has_child,
                                            'level' => $head->level,
                                            'area_row_id' => $area->area_row_id,
                                            'head_total_allocation' => $head_current_total_allocation,
                                            'head_current_balance' => $head_current_balance,
                                            'head_total_expense' => $total_expense
                                        );
                                        array_push($this->all_area_all_head_info_list[$area->area_row_id][$head->head_row_id], $this->head_total_expense_by_month);
                                    }
                                    unset($start_month);
                                    unset($month_expense);
                                }
                            }
                        }
                    }
                }
            }
        }
        $output = $this->all_area_all_head_info_list;
        $this->all_area_all_head_info_list = array();
        return $output;
    }

    public function setBalanceReportByMonthRangeChildren($haystack, $parentHeadId, $area_row_id = 0, $budget_year, $showAllocation, $showExpense, $showBalance, $from_month = 0, $to_month = 0) {
        if (count($haystack)) {
            foreach ($haystack as $head) {
                if ($head->parent_id && $head->parent_id == $parentHeadId) {
                    if ($head->has_child) {
                        $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                        //$parent_head_child_number = $this->findHeadChildrenNumber($head->head_row_id);
                        $parent_head_child_number = $this->findHeadChildrenNumberByAllocation($head->head_row_id, $area_row_id, $budget_year);
                        $parent_head_total_allocation = $this->totalParentHeadAllocations($this->parent_head_child_list, $area_row_id, $budget_year);
                        $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area_row_id, $budget_year, 0, 0);
                        $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area_row_id, $budget_year, 0, 0);
                        $parent_head_total_current_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                        $start_month = $from_month;
                        $parent_total_expense = 0;
                        $parent_month_expense = 0;
                        for ($start_month; $start_month <= $to_month; $start_month++) {
                            $parent_month_expense = $this->totalParentHeadExpenseByMonth($this->parent_head_child_list, $area_row_id, $budget_year, $start_month);
                            $this->head_total_expense_by_month[$start_month] = $parent_month_expense;
                            $parent_total_expense += $parent_month_expense;
                        }
                        $parent_head_current_balance = $parent_head_total_current_allocation - $parent_total_expense;
                        if (isset($parent_head_total_current_allocation) && ($parent_head_total_current_allocation != 0)) {
                            $this->all_area_all_head_info_list[$area_row_id][$head->head_row_id] = array(
                                'head_row_id' => $head->head_row_id,
                                'title' => $head->title,
                                'sort_order' => $head->sort_order,
                                'parent_id' => $head->parent_id,
                                'has_child' => $head->has_child,
                                'level' => $head->level,
                                'area_row_id' => $area_row_id,
                                'parent_head_child_number' => $parent_head_child_number,
                                'parent_head_total_allocation' => $parent_head_total_current_allocation,
                                'parent_head_current_balance' => $parent_head_current_balance,
                                'parent_head_total_expense' => $parent_total_expense
                            );
                            array_push($this->all_area_all_head_info_list[$area_row_id][$head->head_row_id], $this->head_total_expense_by_month);
                        }
                        unset($start_month);
                        unset($parent_total_expense);
                        unset($parent_month_expense);
                        $this->setBalanceReportByMonthRangeChildren($haystack, $head->head_row_id, $area_row_id, $budget_year, $showAllocation, $showExpense, $showBalance, $from_month, $to_month);
                    } else {
                        $head_current_total_allocation = 0;
                        if ($showAllocation) {
                            $head_total_allocation = $this->totalAllcations($head->head_row_id, $area_row_id, $budget_year);
                            $head_total_adjustment = $this->totalFilterReceiption($area_row_id, $head->head_row_id, $budget_year, 0, 0);
                            $head_total_donation = $this->totalFilterDonation($area_row_id, $head->head_row_id, $budget_year, 0, 0);
                            $head_current_total_allocation = ($head_total_allocation + $head_total_adjustment) - $head_total_donation;
                        }
                        $start_month = $from_month;
                        $total_expense = 0;
                        $month_expense = 0;
                        for ($start_month; $start_month <= $to_month; $start_month++) {
                            $month_expense = $this->totalFilterExpenseByMonth($head->head_row_id, $area_row_id, $budget_year, $start_month);
                            $this->head_total_expense_by_month[$start_month] = $month_expense;
                            $total_expense += $month_expense;
                        }
                        $head_current_balance = 0;
                        if ($showBalance) {
                            $head_current_balance = $head_current_total_allocation - $total_expense;
                        }
                        if (isset($head_current_total_allocation) && ($head_current_total_allocation != 0)) {
                            $this->all_area_all_head_info_list[$area_row_id][$head->head_row_id] = array(
                                'head_row_id' => $head->head_row_id,
                                'title' => $head->title,
                                'sort_order' => $head->sort_order,
                                'parent_id' => $head->parent_id,
                                'has_child' => $head->has_child,
                                'level' => $head->level,
                                'area_row_id' => $area_row_id,
                                'head_total_allocation' => $head_current_total_allocation,
                                'head_current_balance' => $head_current_balance,
                                'head_total_expense' => $total_expense
                            );
                            array_push($this->all_area_all_head_info_list[$area_row_id][$head->head_row_id], $this->head_total_expense_by_month);
                        }
                        unset($start_month);
                        unset($month_expense);
                    }
                }
            }
        }
    }

    /**
     * Return total allocation amount of a head
     * @param type $head_row_id
     * @return type
     */
    public function totalAllcations($head_row_id, $area_row_id = 0, $budget_year = 0) {
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        if ($area_row_id > 0) {
            return \App\Models\Allocation::where([['is_adjustment', '=', 0], ['head_row_id', '=', $head_row_id], ['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->sum('amount');
        } else {
            return \App\Models\Allocation::where([['is_adjustment', '=', 0], ['head_row_id', $head_row_id], ['budget_year', '=', $budget_year]])->sum('amount');
        }
    }

    /**
     * Return total adjustment amount of a head get from another donator head
     * @param type $head_row_id
     * @return type
     */
    public function totalAdjustment($head_row_id, $area_row_id = 0, $budget_year = 0) {
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        if ($area_row_id > 0) {
            return \App\Models\Allocation::where([['is_adjustment', '=', 1], ['head_row_id', '=', $head_row_id], ['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->sum('amount');
        } else {
            return \App\Models\Allocation::where([['is_adjustment', '=', 1], ['head_row_id', $head_row_id], ['budget_year', '=', $budget_year]])->sum('amount');
        }
    }

    /**
     * Return total parent head receiption amount that get from another donator head
     * @param type $parent_head_child_list
     * @param type $area_row_id
     * @param type $budget_year
     * @return type
     */
    public function totalParentHeadAdjustment($parent_head_child_list, $area_row_id = 0, $budget_year = 0, $start_date = 0, $end_date = 0) {
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        if (!empty($start_date) && !empty($end_date)) {
            if ($area_row_id > 0) {
                return \App\Models\Allocation::where([['is_adjustment', '=', 1], ['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->whereIn('head_row_id', $parent_head_child_list)->whereBetween('allocation_at', [$start_date, $end_date])->sum('amount');
            } else {
                return \App\Models\Allocation::where([['is_adjustment', '=', 1], ['budget_year', '=', $budget_year]])->whereIn('head_row_id', $parent_head_child_list)->whereBetween('allocation_at', [$start_date, $end_date])->sum('amount');
            }
        } else {
            if ($area_row_id > 0) {
                return \App\Models\Allocation::where([['is_adjustment', '=', 1], ['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->whereIn('head_row_id', $parent_head_child_list)->sum('amount');
            } else {
                return \App\Models\Allocation::where([['is_adjustment', '=', 1], ['budget_year', '=', $budget_year]])->whereIn('head_row_id', $parent_head_child_list)->sum('amount');
            }
        }
    }

    /**
     * Return total parent head donation amount that give to another recipient head
     * @param type $parent_head_child_list
     * @param type $area_row_id
     * @param type $budget_year
     * @return type
     */
    public function totalParentHeadDonation($parent_head_child_list, $area_row_id = 0, $budget_year = 0, $start_date = 0, $end_date = 0) {
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        if (!empty($start_date) && !empty($end_date)) {
            if ($area_row_id > 0) {
                return \App\Models\Allocation::where([['is_adjustment', '=', 1], ['source_area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->whereIn('source_head_row_id', $parent_head_child_list)->whereBetween('allocation_at', [$start_date, $end_date])->sum('amount');
            } else {
                return \App\Models\Allocation::where([['is_adjustment', '=', 1], ['budget_year', '=', $budget_year]])->whereIn('source_head_row_id', $parent_head_child_list)->whereBetween('allocation_at', [$start_date, $end_date])->sum('amount');
            }
        } else {
            if ($area_row_id > 0) {
                return \App\Models\Allocation::where([['is_adjustment', '=', 1], ['source_area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->whereIn('source_head_row_id', $parent_head_child_list)->sum('amount');
            } else {
                return \App\Models\Allocation::where([['is_adjustment', '=', 1], ['budget_year', '=', $budget_year]])->whereIn('source_head_row_id', $parent_head_child_list)->sum('amount');
            }
        }
    }

    public function totalParentHeadAllocations($parent_head_child_list, $area_row_id = 0, $budget_year) {
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        if ($area_row_id > 0) {
            return \App\Models\Allocation::where([['is_adjustment', '=', 0], ['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->whereIn('head_row_id', $parent_head_child_list)->sum('amount');
        } else {
            return \App\Models\Allocation::where([['is_adjustment', '=', 0], ['budget_year', '=', $budget_year]])->whereIn('head_row_id', $parent_head_child_list)->sum('amount');
        }
    }

    public function checkParentHeadAllocations($parent_head_child_list, $area_row_id = 0, $budget_year) {
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        if ($area_row_id > 0) {
            return \App\Models\Allocation::where([['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->whereIn('head_row_id', $parent_head_child_list)->sum('amount');
        } else {
            return \App\Models\Allocation::where([['budget_year', '=', $budget_year]])->whereIn('head_row_id', $parent_head_child_list)->sum('amount');
        }
    }

    public function totalParentHeadFilterAllocations($parent_head_child_list, $area_row_id = 0, $budget_year, $start_date = 0, $end_date = 0) {
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        if (!empty($start_date) && !empty($end_date)) {
            if ($area_row_id > 0) {
                return \App\Models\Allocation::where([['is_adjustment', '=', 0], ['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->whereIn('head_row_id', $parent_head_child_list)->whereBetween('allocation_at', [$start_date, $end_date])->sum('amount');
            } else {
                return \App\Models\Allocation::where([['is_adjustment', '=', 0], ['budget_year', '=', $budget_year]])->whereIn('head_row_id', $parent_head_child_list)->whereBetween('allocation_at', [$start_date, $end_date])->sum('amount');
            }
        } else {
            if ($area_row_id > 0) {
                return \App\Models\Allocation::where([['is_adjustment', '=', 0], ['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->whereIn('head_row_id', $parent_head_child_list)->sum('amount');
            } else {
                return \App\Models\Allocation::where([['is_adjustment', '=', 0], ['budget_year', '=', $budget_year]])->whereIn('head_row_id', $parent_head_child_list)->sum('amount');
            }
        }
    }

    /**
     * Return total expense amount of a head
     * @param type $head_row_id
     * @return type
     */
    public function totalExpense($head_row_id, $area_row_id = 0, $budget_year = 0) {
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        if ($area_row_id > 0) {
            return \App\Models\Expense::where([['head_row_id', '=', $head_row_id], ['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->sum('amount');
        } else {
            return \App\Models\Expense::where([['head_row_id', $head_row_id], ['budget_year', '=', $budget_year]])->sum('amount');
        }
    }

    /**
     * Return total filter expense of a head
     * @param type $head_row_id
     * @param string $start_date
     * @param string $end_date
     * @return type
     */
    public function totalFilterExpense($head_row_id, $area_row_id = 0, $budget_year, $start_date = 0, $end_date = 0) {
        if (!empty($start_date) && !empty($end_date)) {
            $start_date = $start_date;
            $end_date = $end_date;
            if ($area_row_id > 0) {
                return \App\Models\Expense::where([['head_row_id', '=', $head_row_id], ['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->whereBetween('expense_at', [$start_date, $end_date])->sum('amount');
            } else {
                return \App\Models\Expense::where([['head_row_id', $head_row_id], ['budget_year', '=', $budget_year]])->whereBetween('expense_at', [$start_date, $end_date])->sum('amount');
            }
        } else {
            if ($area_row_id > 0) {
                return \App\Models\Expense::where([['head_row_id', '=', $head_row_id], ['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->sum('amount');
            } else {
                return \App\Models\Expense::where([['head_row_id', $head_row_id], ['budget_year', '=', $budget_year]])->sum('amount');
            }
        }
    }

    /**
     *
     * @param type $head_row_id
     * @param type $area_row_id
     * @param type $budget_year
     * @param type $month
     * @return type
     */
    public function totalFilterExpenseByMonth($head_row_id = 0, $area_row_id = 0, $budget_year = 0, $month = 0) {
        return \App\Models\Expense::where([['head_row_id', '=', $head_row_id], ['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->whereMonth('expense_at', $month)->sum('amount');
    }

    public function getTotalAreaExpenseByMonth($area_row_id = 0, $budget_year = 0, $month = 0) {
        if ($area_row_id > 0) {
            /** For specific Area */
            return \App\Models\Expense::where([['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->whereMonth('expense_at', $month)->sum('amount');
        } else {
            /** For All Area */
            return \App\Models\Expense::where([['budget_year', '=', $budget_year]])->whereMonth('expense_at', $month)->sum('amount');
        }
    }

    public function totalParentHeadExpenseByMonth($parent_head_child_list, $area_row_id = 0, $budget_year, $month = 0) {
        return \App\Models\Expense::where([['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->whereIn('head_row_id', $parent_head_child_list)->whereMonth('expense_at', $month)->sum('amount');
    }

    /**
     * Return total expense of a parent head
     * sum of expense of all child head
     * @param type $parent_head_child_list
     * @param string $start_date
     * @param string $end_date
     * @return type
     */
    public function totalParentHeadExpense($parent_head_child_list, $area_row_id = 0, $budget_year, $start_date = 0, $end_date = 0) {
        if (!empty($start_date) && !empty($end_date)) {
            $start_date = $start_date;
            $end_date = $end_date;
            if ($area_row_id > 0) {
                return \App\Models\Expense::where([['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->whereIn('head_row_id', $parent_head_child_list)->whereBetween('expense_at', [$start_date, $end_date])->sum('amount');
            } else {
                return \App\Models\Expense::where([['budget_year', '=', $budget_year]])->whereIn('head_row_id', $parent_head_child_list)->whereBetween('expense_at', [$start_date, $end_date])->sum('amount');
            }
        } else {
            if ($area_row_id > 0) {
                return \App\Models\Expense::where([['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->whereIn('head_row_id', $parent_head_child_list)->sum('amount');
            } else {
                return \App\Models\Expense::where([['budget_year', '=', $budget_year]])->whereIn('head_row_id', $parent_head_child_list)->sum('amount');
            }
        }
    }

    /**
     *
     * @param type $id
     * @return type
     */
    public function destroy($id) {
        $file = Upload::find($id);
        $filename = Input::get('database field name for file');
        $path = public_path() . '/path/to/file/';

        if (!File::delete($path . $filename)) {
            Session::flash('flash_message', 'ERROR deleted the File!');
            return Redirect::to('page name');
        } else {
            $file->delete();
            Session::flash('flash_message', 'Successfully deleted the File!');
            return Redirect::to('page name');
        }
    }

    /**
     * Find direct child number of parent
     * @param int $parent_head_row_id
     * @return direct child number of parent_head_row_id
     */
    public function findHeadChildrenNumber($parent_head_row_id = 0) {
        $childrenNumber = 0;
        $childrenNumber = \App\Models\Head::where('parent_id', $parent_head_row_id)->count();
        return $childrenNumber;
    }

    /**
     * Return Head total allocation amount of a head
     * @param type $head_row_id
     * @return type
     */
    public function checkHeadTotalAllcations($head_row_id, $area_row_id = 0, $budget_year = 0, $start_date = 0, $end_date = 0) {
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        $check_allocation = 0;
        if (!empty($start_date) && !empty($end_date)) {
            if ($area_row_id > 0) {
                $check_allocation = \App\Models\Allocation::where([['head_row_id', '=', $head_row_id], ['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->whereBetween('allocation_at', [$start_date, $end_date])->sum('amount');
            } else {
                $check_allocation = \App\Models\Allocation::where([['head_row_id', $head_row_id], ['budget_year', '=', $budget_year]])->whereBetween('allocation_at', [$start_date, $end_date])->sum('amount');
            }
        } else {
            if ($area_row_id > 0) {
                $check_allocation = \App\Models\Allocation::where([['head_row_id', '=', $head_row_id], ['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->sum('amount');
            } else {
                $check_allocation = \App\Models\Allocation::where([['head_row_id', $head_row_id], ['budget_year', '=', $budget_year]])->sum('amount');
            }
        }

        if (isset($check_allocation) && ($check_allocation > 0)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Find direct child number of parent by allocation status
     * @param int $parent_head_row_id
     * @return direct child number of parent_head_row_id
     */
    public function findHeadChildrenNumberByAllocation($parent_head_row_id = 0, $area_row_id = 0, $budget_year = 0, $start_date = 0, $end_date = 0) {
        $childrenNumber = 0;
        $check_allocation_status = false;
        $parentTotalAllocation = 0;
        $childrenList = \App\Models\Head::where('parent_id', $parent_head_row_id)->get();
        if (!empty($start_date) && !empty($end_date)) {
            if ($childrenList) {
                foreach ($childrenList as $child_row) {
                    $grandChildList = array();
                    if ($child_row->has_child) {
                        $grandChildList = \App\Models\Head::where('parent_id', $child_row->head_row_id)->get();
                        foreach ($grandChildList as $grand_child_row) {
                            $check_allocation_status = $this->checkHeadTotalAllcations($grand_child_row->head_row_id, $area_row_id, $budget_year, $start_date, $end_date);
                            if ($check_allocation_status) {
                                ++$childrenNumber;
                                break 1;
                            }
                        }
                    } else {
                        $check_allocation_status = $this->checkHeadTotalAllcations($child_row->head_row_id, $area_row_id, $budget_year, $start_date, $end_date);
                        if ($check_allocation_status) {
                            ++$childrenNumber;
                        }
                    }
                }
            }
        } else {
            if ($childrenList) {
                foreach ($childrenList as $child_row) {
                    $grandChildList = array();
                    if ($child_row->has_child) {
                        $grandChildList = \App\Models\Head::where('parent_id', $child_row->head_row_id)->get();
                        foreach ($grandChildList as $grand_child_row) {
                            $check_allocation_status = $this->checkHeadTotalAllcations($grand_child_row->head_row_id, $area_row_id, $budget_year, 0, 0);
                            if ($check_allocation_status) {
                                ++$childrenNumber;
                                break 1;
                            }
                        }
                    } else {
                        $check_allocation_status = $this->checkHeadTotalAllcations($child_row->head_row_id, $area_row_id, $budget_year, 0, 0);
                        if ($check_allocation_status) {
                            ++$childrenNumber;
                        }
                    }
                }
            }
        }
        return $childrenNumber;
    }

    /**
     * Find child list of parent
     * @param int $parent_head_row_id
     * @return child list array with head_row_id
     */
    public function findHeadChildrenList($parent_head_row_id) {
        $childrenList = \App\Models\Head::where('parent_id', $parent_head_row_id)->get();
        if (count($childrenList)) {
            foreach ($childrenList as $children) {
                if ($children->has_child) {
                    $this->findHeadGrandChildrenList($children->head_row_id);
                } else {
                    $this->head_child_list[] = $children->head_row_id;
                }
            }
        }
        $head_child_list = $this->head_child_list;
        $this->head_child_list = array();
        return $head_child_list;
    }

    /**
     * Find child list of child
     * @param int $parent_head_row_id
     * @return child list array with head_row_id
     */
    public function findHeadGrandChildrenList($parent_head_row_id) {
        $grandChildrenList = \App\Models\Head::where('parent_id', $parent_head_row_id)->get();
        if (count($grandChildrenList)) {
            foreach ($grandChildrenList as $grandChildren) {
                if ($grandChildren->has_child) {
                    $this->findHeadGreatGrandChildrenList($grandChildren->head_row_id);
                } else {
                    $this->head_child_list[] = $grandChildren->head_row_id;
                }
            }
            return $this->head_child_list;
        }
    }

    /**
     * Find child list of Grand-child
     * @param type $parent_head_row_id
     * @return child list array with head_row_id
     */
    public function findHeadGreatGrandChildrenList($parent_head_row_id) {
        $greatgrandChildrenList = \App\Models\Head::where('parent_id', $parent_head_row_id)->get();
        if (count($greatgrandChildrenList)) {
            foreach ($greatgrandChildrenList as $greatGrandChildren) {
                $this->head_child_list[] = $greatGrandChildren->head_row_id;
            }
            return $this->head_child_list;
        }
    }

    /**
     * Find parent info of a head
     * @param type $head_row_id
     */
    public function findHeadParent($head_row_id) {
        $head_row = \App\Models\Head::where('head_row_id', $head_row_id)->first();
        if (isset($head_row->parent_id) && ($head_row->parent_id > 0)) {
            $headParent = \App\Models\Head::where('head_row_id', $head_row->parent_id)->first();
            $this->head_parent_list['head_parent'] = $headParent;
            if (!empty($headParent->parent_id)) {
                $this->findHeadGrandParent($headParent->parent_id);
            }
        }
        $head_parent_list = $this->head_parent_list;
        $this->head_parent_list = array();
        return $head_parent_list;
        /* echo "<pre>";
          print_r($head_parent_list); */
    }

    /**
     * Find grand parent info of a head
     * @param type $head_row_id
     */
    public function findHeadGrandParent($head_row_id) {
        $headGrandParent = \App\Models\Head::where('head_row_id', $head_row_id)->first();
        $this->head_parent_list['head_grand_parent'] = $headGrandParent;
        if (!empty($headGrandParent->parent_id)) {
            $this->findHeadGreatGrandParent($headGrandParent->parent_id);
        }
        return $this->head_parent_list;
    }

    /**
     * Find great grand parent info of a head
     * @param type $head_row_id
     */
    public function findHeadGreatGrandParent($head_row_id) {
        $headGreatGrandParent = \App\Models\Head::where('head_row_id', $head_row_id)->first();
        $this->head_parent_list['head_great_grand_parent'] = $headGreatGrandParent;
        return $this->head_parent_list;
    }

    /**
     * Get the head current balance amount for which has_child ~ 0
     * @param type $source_area_row_id
     * @param type $source_head_row_id
     * @param type $budget_year
     */
    public function getHeadCurrentBalance($source_area_row_id = 0, $source_head_row_id = 0, $budget_year = 0, $start_date = 0, $end_date = 0) {
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        $head_row_info = $this->get_head_row_info($source_head_row_id);
        /* Find head total adjustment */
        $head_total_adjustment = 0;
        $head_total_allocation = 0;
        $head_current_balance = 0;
        /**
         * Get Head total allocation
         */
        $head_total_allocation = $this->totalAllcations($source_head_row_id, $source_area_row_id, $budget_year);
        /**
         * Get Head total donation
         */
        $head_total_adjustment = $this->totalFilterDonation($source_area_row_id, $source_head_row_id, $budget_year, $start_date, $end_date);
        /**
         * Get Head total receiption
         */
        $head_total_receiption = $this->totalFilterReceiption($source_area_row_id, $source_head_row_id, $budget_year, $start_date, $end_date);
        /**
         * Check selected head is unforeseen or not
         */
        if ($head_row_info->is_unforeseen == 1) {
            /* Find total adjustment amount only for unforeseen */
            $head_current_balance = ($head_total_allocation + $head_total_receiption) - $head_total_adjustment;
        } else {
            /* Find total adjustment and expense */
            $head_total_expense = $this->totalExpense($source_head_row_id, $source_area_row_id, $budget_year);
            $head_current_balance = ($head_total_allocation + $head_total_receiption) - ($head_total_expense + $head_total_adjustment);
        }
        return $head_current_balance;
    }

    /**
     * How many amount that head donate to other head
     * Get source head total Donation
     * It is use in manage adjustment for check source head current balance
     * @param type $source_area_row_id
     * @param type $source_head_row_id
     * @param type $budget_year
     * @return type
     */
    public function getHeadTotalAdjustment($source_area_row_id = 0, $source_head_row_id = 0, $budget_year = 0) {
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        if ($source_area_row_id > 0) {
            return \App\Models\Allocation::where([['is_adjustment', '=', 1], ['source_head_row_id', '=', $source_head_row_id], ['source_area_row_id', '=', $source_area_row_id], ['budget_year', '=', $budget_year]])->sum('amount');
        } else {
            return \App\Models\Allocation::where([['is_adjustment', '=', 1], ['source_head_row_id', '=', $source_head_row_id], ['budget_year', '=', $budget_year]])->sum('amount');
        }
    }

    public function totalFilterDonation($area_row_id = 0, $head_row_id = 0, $budget_year = 0, $start_date = 0, $end_date = 0) {
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        if (!empty($start_date) && !empty($end_date)) {
            if ($area_row_id > 0) {
                return \App\Models\Allocation::where([['is_adjustment', '=', 1], ['source_head_row_id', '=', $head_row_id], ['source_area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->whereBetween('allocation_at', [$start_date, $end_date])->sum('amount');
            } else {
                return \App\Models\Allocation::where([['is_adjustment', '=', 1], ['source_head_row_id', '=', $head_row_id], ['budget_year', '=', $budget_year]])->whereBetween('allocation_at', [$start_date, $end_date])->sum('amount');
            }
        } else {
            if ($area_row_id > 0) {
                return \App\Models\Allocation::where([['is_adjustment', '=', 1], ['source_head_row_id', '=', $head_row_id], ['source_area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->sum('amount');
            } else {
                return \App\Models\Allocation::where([['is_adjustment', '=', 1], ['source_head_row_id', '=', $head_row_id], ['budget_year', '=', $budget_year]])->sum('amount');
            }
        }
    }

    public function totalFilterReceiption($area_row_id = 0, $head_row_id = 0, $budget_year = 0, $start_date = 0, $end_date = 0) {
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        if (!empty($start_date) && !empty($end_date)) {
            if ($area_row_id > 0) {
                return \App\Models\Allocation::where([['is_adjustment', '=', 1], ['head_row_id', '=', $head_row_id], ['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->whereBetween('allocation_at', [$start_date, $end_date])->sum('amount');
            } else {
                return \App\Models\Allocation::where([['is_adjustment', '=', 1], ['head_row_id', '=', $head_row_id], ['budget_year', '=', $budget_year]])->whereBetween('allocation_at', [$start_date, $end_date])->sum('amount');
            }
        } else {
            if ($area_row_id > 0) {
                return \App\Models\Allocation::where([['is_adjustment', '=', 1], ['head_row_id', '=', $head_row_id], ['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->sum('amount');
            } else {
                return \App\Models\Allocation::where([['is_adjustment', '=', 1], ['head_row_id', '=', $head_row_id], ['budget_year', '=', $budget_year]])->sum('amount');
            }
        }
    }

    public function totalFilterAllocationByDate($area_row_id = 0, $head_row_id = 0, $budget_year = 0, $start_date = 0, $end_date = 0) {
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        if (!empty($start_date) && !empty($end_date)) {
            return \App\Models\Allocation::where([['is_adjustment', '=', 0], ['head_row_id', '=', $head_row_id], ['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->whereBetween('allocation_at', [$start_date, $end_date])->sum('amount');
        } else {
            return \App\Models\Allocation::where([['is_adjustment', '=', 0], ['head_row_id', '=', $head_row_id], ['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->sum('amount');
        }
    }

    public function getAllocationDetailsList($area_row_id = 0, $head_row_id = 0, $budget_year = 0, $start_date = 0, $end_date = 0) {
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        $allocation_list = '';
        if ($area_row_id > 0) {
            if (!empty($start_date) && !empty($end_date)) {
                $allocation_list = \App\Models\Allocation::where([['is_adjustment', '=', 0], ['head_row_id', '=', $head_row_id], ['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->whereBetween('allocation_at', [$start_date, $end_date])->orderBy('allocation_at', 'desc')->get();
            } else {
                $allocation_list = \App\Models\Allocation::where([['is_adjustment', '=', 0], ['head_row_id', '=', $head_row_id], ['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->orderBy('allocation_at', 'desc')->get();
            }
        } else {
            if (!empty($start_date) && !empty($end_date)) {
                $allocation_list = \App\Models\Allocation::where([['is_adjustment', '=', 0], ['head_row_id', '=', $head_row_id], ['budget_year', '=', $budget_year]])->whereBetween('allocation_at', [$start_date, $end_date])->orderBy('allocation_at', 'desc')->get();
            } else {
                $allocation_list = \App\Models\Allocation::where([['is_adjustment', '=', 0], ['head_row_id', '=', $head_row_id], ['budget_year', '=', $budget_year]])->orderBy('allocation_at', 'desc')->get();
            }
        }
        return $allocation_list;
    }

    /**
     * Get Ancestor Hierarchy of a specific Head
     * i.e Pay and Allowances > Complex Staff Salary / Honorarium
     * @param type $head_row_id
     * @return string
     */
    public function getHeadAncestorHierarchy($head_row_id) {
        $selected_head_hierarchy = '';
        $head_row_detail = $this->get_head_row_info($head_row_id);
        $head_parent_list = $this->findHeadParent($head_row_id);
        if (!count($head_parent_list)) {
            $selected_head_hierarchy = $head_row_detail->title;
        }
        if (isset($head_parent_list['head_parent'])) {
            $selected_head_hierarchy = $head_parent_list['head_parent']->title . " > " . $head_row_detail->title;
        }
        if (isset($head_parent_list['head_grand_parent'])) {
            $selected_head_hierarchy = $head_parent_list['head_grand_parent']->title . " > " . $selected_head_hierarchy;
        }
        if (isset($head_parent_list['head_great_grand_parent'])) {
            $selected_head_hierarchy = $head_parent_list['head_great_grand_parent']->title . " > " . $selected_head_hierarchy;
        }
        return $selected_head_hierarchy;
    }

    public function getSectorHeadList() {
        $this->output = array();
        $head_list = \App\Models\Head::where([['is_project', '=', 0], ['has_child', '=', 0]])->orderBy('head_row_id', 'asc')->get();
        if ($head_list) {
            foreach ($head_list as $head_row) {
                $this->output[] = $head_row->head_row_id;
            }
        }
        $output = $this->output;
        $this->output = array();
        return $output;
    }

    public function getSectorProjectHeadList($budget_year) {
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        $this->output = array();
        $project_head_list = $this->budgetProjectHeadList($budget_year);
        if ($project_head_list) {
            foreach ($project_head_list as $head_row) {
                if ($head_row->has_child == 0)
                    $this->output[] = $head_row->head_row_id;
            }
        }
        $output = $this->output;
        $this->output = array();
        return $output;
    }

    public function getSectorHeadTotalAllocation($budget_year, $area_row_id, $sector_head_list) {
        if ($area_row_id > 0) {
            return \App\Models\Allocation::where([['is_adjustment', '=', 0], ['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->whereIn('head_row_id', $sector_head_list)->sum('amount');
        } else {
            return \App\Models\Allocation::where([['is_adjustment', '=', 0], ['budget_year', '=', $budget_year]])->whereIn('head_row_id', $sector_head_list)->sum('amount');
        }
    }

    public function getAllocationSummary($budget_year, $area_row_id = -1) {
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        $sector_head_list = $this->getSectorHeadList();
        $sector_project_head_list = $this->getSectorProjectHeadList($budget_year);
        $this->output = array();
        $sector_head_total_allocation = 0;
        $sector_project_head_total_allocation = 0;
        $total_allocation = 0;
        if ($area_row_id > 0) {
            $area_row = $this->get_area_row_info($area_row_id);
            $total_allocation = $this->getTotalAllocation($area_row_id, $budget_year, 0, 0);
            $sector_project_head_total_allocation = $this->getSectorHeadTotalAllocation($budget_year, $area_row_id, $sector_project_head_list);
            $sector_head_total_allocation = $this->getSectorHeadTotalAllocation($budget_year, $area_row_id, $sector_head_list);
            $this->output[$area_row_id] = array(
                'area_row_id' => $area_row->area_row_id,
                'area_name' => $area_row->title,
                'sector_head_allocation' => $sector_head_total_allocation,
                'project_head_allocation' => $sector_project_head_total_allocation,
                'total_allocation' => $total_allocation
            );
        } else {
            $area_list = $this->allAreas(1);
            foreach ($area_list as $area) {
                $total_allocation = $this->getTotalAllocation($area->area_row_id, $budget_year, 0, 0);
                $sector_project_head_total_allocation = $this->getSectorHeadTotalAllocation($budget_year, $area->area_row_id, $sector_project_head_list);
                $sector_head_total_allocation = $this->getSectorHeadTotalAllocation($budget_year, $area->area_row_id, $sector_head_list);
                $this->output[$area->area_row_id] = array(
                    'area_row_id' => $area->area_row_id,
                    'area_name' => $area->title,
                    'sector_head_allocation' => $sector_head_total_allocation,
                    'project_head_allocation' => $sector_project_head_total_allocation,
                    'total_allocation' => $total_allocation
                );
            }
        }
        $output = $this->output;
        $this->output = array();
        return $output;
    }

    public function allocationFilterHeads($showAdjustment = false, $area_row_id = 0, $head_row_id = 0, $budget_year, $start_date = 0, $end_date = 0) {
        $status = 1;
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        $result = $this->budgetAllHeadListWithProject($budget_year, $status);
        $this->output = array();
        /*
         * Check area_row_id value
         * which is selected all area or a specific area
         * area_row_id > 0, means a specific area selected
         * otherwise all area slected
         */
        if ($area_row_id > 0) {
            $area_row_detail = $this->get_area_row_info($area_row_id);
            if ($head_row_id > 0) {
                /*
                 * Specific area and head selected
                 */
                $head = \App\Models\Head::find($head_row_id);
                if ($head->has_child) {
                    $parent_head_total_allocation = 0;
                    $parent_head_total_adjustment = 0;
                    $parent_head_total_donation = 0;
                    $parent_head_current_total_allocation = 0;
                    //$parent_head_child_number = $this->findHeadChildrenNumber($head->head_row_id);
                    $parent_head_child_number = $this->findHeadChildrenNumberByAllocation($head->head_row_id, $area_row_id, $budget_year, $start_date, $end_date);
                    $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                    $parent_head_total_allocation = $this->totalParentHeadFilterAllocations($this->parent_head_child_list, $area_row_id, $budget_year, $start_date, $end_date);
                    if ($showAdjustment) {
                        $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area_row_id, $budget_year, $start_date, $end_date);
                        $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area_row_id, $budget_year, $start_date, $end_date);
                        $parent_head_current_total_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                    }
                    if (isset($parent_head_total_allocation) && ($parent_head_total_allocation > 0)) {
                        $this->output[$area_row_detail->title][$head->head_row_id] = array(
                            'head_row_id' => $head->head_row_id,
                            'title' => $head->title,
                            'sort_order' => $head->sort_order,
                            'parent_id' => $head->parent_id,
                            'has_child' => $head->has_child,
                            'level' => $head->level,
                            'area_row_id' => $area_row_detail->area_row_id,
                            'parent_head_child_number' => $parent_head_child_number,
                            'area_name' => $area_row_detail->title,
                            'parent_head_total_allocation' => $parent_head_total_allocation,
                            'parent_head_total_adjustment' => $parent_head_total_adjustment,
                            'parent_head_total_donation' => $parent_head_total_donation,
                            'parent_head_current_total_allocation' => $parent_head_current_total_allocation
                        );
                    }
                    $this->setAllocationFilterChildren($result, $head->head_row_id, $area_row_id, $budget_year, $showAdjustment, $start_date, $end_date);
                } else {
                    $head_total_allocation = 0;
                    $head_total_adjustment = 0;
                    $head_total_donation = 0;
                    $head_current_total_allocation = 0;
                    $head_total_allocation = $this->totalFilterAllocationByDate($area_row_id, $head->head_row_id, $budget_year, $start_date, $end_date);
                    if ($showAdjustment) {
                        $head_total_adjustment = $this->totalFilterReceiption($area_row_id, $head->head_row_id, $budget_year, $start_date, $end_date);
                        $head_total_donation = $this->totalFilterDonation($area_row_id, $head->head_row_id, $budget_year, $start_date, $end_date);
                        $head_current_total_allocation = ($head_total_allocation + $head_total_adjustment) - $head_total_donation;
                    }
                    if (isset($head_total_allocation) && ($head_total_allocation > 0)) {
                        $this->output[$area_row_detail->title][$head->head_row_id] = array(
                            'head_row_id' => $head->head_row_id,
                            'title' => $head->title,
                            'sort_order' => $head->sort_order,
                            'parent_id' => $head->parent_id,
                            'has_child' => $head->has_child,
                            'level' => $head->level,
                            'area_row_id' => $area_row_detail->area_row_id,
                            'area_name' => $area_row_detail->title,
                            'head_total_allocation' => $head_total_allocation,
                            'head_total_adjustment' => $head_total_adjustment,
                            'head_total_donation' => $head_total_donation,
                            'head_current_total_allocation' => $head_current_total_allocation
                        );
                    }
                }
            } else {
                /*
                 * Specific area and All head selected
                 */
                foreach ($result as $head) {
                    if ($head->parent_id == 0) {
                        if ($head->has_child) {
                            $parent_head_total_allocation = 0;
                            $parent_head_total_adjustment = 0;
                            $parent_head_total_donation = 0;
                            $parent_head_current_total_allocation = 0;
                            $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                            $parent_head_child_number = $this->findHeadChildrenNumberByAllocation($head->head_row_id, $area_row_id, $budget_year, $start_date, $end_date);
                            $parent_head_total_allocation = $this->totalParentHeadFilterAllocations($this->parent_head_child_list, $area_row_id, $budget_year, $start_date, $end_date);
                            if ($showAdjustment) {
                                $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area_row_id, $budget_year, $start_date, $end_date);
                                $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area_row_id, $budget_year, $start_date, $end_date);
                                $parent_head_current_total_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                            }
                            if (isset($parent_head_total_allocation) && ($parent_head_total_allocation > 0)) {
                                $this->output[$area_row_detail->title][$head->head_row_id] = array(
                                    'head_row_id' => $head->head_row_id,
                                    'title' => $head->title,
                                    'sort_order' => $head->sort_order,
                                    'parent_id' => $head->parent_id,
                                    'has_child' => $head->has_child,
                                    'level' => $head->level,
                                    'parent_head_child_number' => $parent_head_child_number,
                                    'area_row_id' => $area_row_detail->area_row_id,
                                    'area_name' => $area_row_detail->title,
                                    'parent_head_total_allocation' => $parent_head_total_allocation,
                                    'parent_head_total_adjustment' => $parent_head_total_adjustment,
                                    'parent_head_total_donation' => $parent_head_total_donation,
                                    'parent_head_current_total_allocation' => $parent_head_current_total_allocation
                                );
                            }
                            $this->setAllocationFilterChildren($result, $head->head_row_id, $area_row_id, $budget_year, $showAdjustment, $start_date, $end_date);
                        } else {
                            $head_total_allocation = 0;
                            $head_total_adjustment = 0;
                            $head_total_donation = 0;
                            $head_current_total_allocation = 0;
                            $head_total_allocation = $this->totalFilterAllocationByDate($area_row_id, $head->head_row_id, $budget_year, $start_date, $end_date);
                            if ($showAdjustment) {
                                $head_total_adjustment = $this->totalFilterReceiption($area_row_id, $head->head_row_id, $budget_year, $start_date, $end_date);
                                $head_total_donation = $this->totalFilterDonation($area_row_id, $head->head_row_id, $budget_year, $start_date, $end_date);
                                $head_current_total_allocation = ($head_total_allocation + $head_total_adjustment) - $head_total_donation;
                            }
                            if (isset($head_total_allocation) && ($head_total_allocation > 0)) {
                                $this->output[$area_row_detail->title][$head->head_row_id] = array(
                                    'head_row_id' => $head->head_row_id,
                                    'title' => $head->title,
                                    'sort_order' => $head->sort_order,
                                    'parent_id' => $head->parent_id,
                                    'has_child' => $head->has_child,
                                    'level' => $head->level,
                                    'area_row_id' => $area_row_detail->area_row_id,
                                    'area_name' => $area_row_detail->title,
                                    'head_total_allocation' => $head_total_allocation,
                                    'head_total_adjustment' => $head_total_adjustment,
                                    'head_total_donation' => $head_total_donation,
                                    'head_current_total_allocation' => $head_current_total_allocation
                                );
                            }
                        }
                    }
                }
            }
        } else {
            $allArea = $this->allAreas(1);
            if ($head_row_id > 0) {
                /*
                 * All area and specific head selected
                 */
                $head = \App\Models\Head::find($head_row_id);
                if (count($allArea)) {
                    foreach ($allArea as $area) {
                        if ($head->has_child) {
                            $parent_head_total_allocation = 0;
                            $parent_head_total_adjustment = 0;
                            $parent_head_total_donation = 0;
                            $parent_head_current_total_allocation = 0;
                            $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                            $parent_head_child_number = $this->findHeadChildrenNumberByAllocation($head->head_row_id, $area->area_row_id, $budget_year, $start_date, $end_date);
                            //$parent_head_child_number = $this->findHeadChildrenNumber($head->head_row_id);
                            $parent_head_total_allocation = $this->totalParentHeadFilterAllocations($this->parent_head_child_list, $area->area_row_id, $budget_year, $start_date, $end_date);
                            if ($showAdjustment) {
                                $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area->area_row_id, $budget_year, $start_date, $end_date);
                                $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area->area_row_id, $budget_year, $start_date, $end_date);
                                $parent_head_current_total_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                            }
                            if (isset($parent_head_total_allocation) && ($parent_head_total_allocation > 0)) {
                                $this->output[$area->title][$head->head_row_id] = array(
                                    'head_row_id' => $head->head_row_id,
                                    'title' => $head->title,
                                    'sort_order' => $head->sort_order,
                                    'parent_id' => $head->parent_id,
                                    'has_child' => $head->has_child,
                                    'level' => $head->level,
                                    'area_row_id' => $area->area_row_id,
                                    'area_name' => $area->title,
                                    'parent_head_child_number' => $parent_head_child_number,
                                    'parent_head_total_allocation' => $parent_head_total_allocation,
                                    'parent_head_total_adjustment' => $parent_head_total_adjustment,
                                    'parent_head_total_donation' => $parent_head_total_donation,
                                    'parent_head_current_total_allocation' => $parent_head_current_total_allocation
                                );
                            }
                            $this->setAllocationFilterChildren($result, $head->head_row_id, $area->area_row_id, $budget_year, $showAdjustment, $start_date, $end_date);
                        } else {
                            $head_total_allocation = 0;
                            $head_total_adjustment = 0;
                            $head_total_donation = 0;
                            $head_current_total_allocation = 0;
                            $head_total_allocation = $this->totalFilterAllocationByDate($area->area_row_id, $head->head_row_id, $budget_year, $start_date, $end_date);
                            if ($showAdjustment) {
                                $head_total_adjustment = $this->totalFilterReceiption($area->area_row_id, $head->head_row_id, $budget_year, $start_date, $end_date);
                                $head_total_donation = $this->totalFilterDonation($area->area_row_id, $head->head_row_id, $budget_year, $start_date, $end_date);
                                $head_current_total_allocation = ($head_total_allocation + $head_total_adjustment) - $head_total_donation;
                            }
                            if (isset($head_total_allocation) && ($head_total_allocation > 0)) {
                                $this->output[$area->title][$head->head_row_id] = array(
                                    'head_row_id' => $head->head_row_id,
                                    'title' => $head->title,
                                    'sort_order' => $head->sort_order,
                                    'parent_id' => $head->parent_id,
                                    'has_child' => $head->has_child,
                                    'level' => $head->level,
                                    'area_row_id' => $area->area_row_id,
                                    'area_name' => $area->title,
                                    'head_total_allocation' => $head_total_allocation,
                                    'head_total_adjustment' => $head_total_adjustment,
                                    'head_total_donation' => $head_total_donation,
                                    'head_current_total_allocation' => $head_current_total_allocation
                                );
                            }
                        }
                    }
                }
            } else {
                /*
                 * All area and All head selected
                 */
                if (count($allArea)) {
                    foreach ($allArea as $area) {
                        foreach ($result as $head) {
                            if ($head->parent_id == 0) {
                                if ($head->has_child) {
                                    $parent_head_total_allocation = 0;
                                    $parent_head_total_adjustment = 0;
                                    $parent_head_total_donation = 0;
                                    $parent_head_current_total_allocation = 0;
                                    $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                                    $parent_head_child_number = $this->findHeadChildrenNumberByAllocation($head->head_row_id, $area->area_row_id, $budget_year, $start_date, $end_date);
                                    $parent_head_total_allocation = $this->totalParentHeadFilterAllocations($this->parent_head_child_list, $area->area_row_id, $budget_year, $start_date, $end_date);
                                    if ($showAdjustment) {
                                        $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area->area_row_id, $budget_year, $start_date, $end_date);
                                        $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area->area_row_id, $budget_year, $start_date, $end_date);
                                        $parent_head_current_total_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                                    }
                                    if (isset($parent_head_total_allocation) && ($parent_head_total_allocation > 0)) {
                                        $this->output[$area->title][$head->head_row_id] = array(
                                            'head_row_id' => $head->head_row_id,
                                            'title' => $head->title,
                                            'sort_order' => $head->sort_order,
                                            'parent_id' => $head->parent_id,
                                            'has_child' => $head->has_child,
                                            'level' => $head->level,
                                            'area_row_id' => $area->area_row_id,
                                            'area_name' => $area->title,
                                            'parent_head_child_number' => $parent_head_child_number,
                                            'parent_head_total_allocation' => $parent_head_total_allocation,
                                            'parent_head_total_adjustment' => $parent_head_total_adjustment,
                                            'parent_head_total_donation' => $parent_head_total_donation,
                                            'parent_head_current_total_allocation' => $parent_head_current_total_allocation
                                        );
                                    }
                                    $this->setAllocationFilterChildren($result, $head->head_row_id, $area->area_row_id, $budget_year, $showAdjustment, $start_date, $end_date);
                                } else {
                                    $head_total_allocation = 0;
                                    $head_total_adjustment = 0;
                                    $head_total_donation = 0;
                                    $head_current_total_allocation = 0;
                                    $head_total_allocation = $this->totalFilterAllocationByDate($area->area_row_id, $head->head_row_id, $budget_year, $start_date, $end_date);
                                    if ($showAdjustment) {
                                        $head_total_adjustment = $this->totalFilterReceiption($area->area_row_id, $head->head_row_id, $budget_year, $start_date, $end_date);
                                        $head_total_donation = $this->totalFilterDonation($area->area_row_id, $head->head_row_id, $budget_year, $start_date, $end_date);
                                        $head_current_total_allocation = ($head_total_allocation + $head_total_adjustment) - $head_total_donation;
                                    }
                                    if (isset($head_total_allocation) && ($head_total_allocation > 0)) {
                                        $this->output[$area->title][$head->head_row_id] = array(
                                            'head_row_id' => $head->head_row_id,
                                            'title' => $head->title,
                                            'sort_order' => $head->sort_order,
                                            'parent_id' => $head->parent_id,
                                            'has_child' => $head->has_child,
                                            'level' => $head->level,
                                            'area_row_id' => $area->area_row_id,
                                            'area_name' => $area->title,
                                            'head_total_allocation' => $head_total_allocation,
                                            'head_total_adjustment' => $head_total_adjustment,
                                            'head_total_donation' => $head_total_donation,
                                            'head_current_total_allocation' => $head_current_total_allocation
                                        );
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $output = $this->output;
        $this->output = array();
        return $output;
    }

    function setAllocationFilterChildren($haystack, $parentHeadId, $area_row_id, $budget_year, $showAdjustment = false, $start_date, $end_date) {
        if (count($haystack)) {
            $area_row_detail = $this->get_area_row_info($area_row_id);
            foreach ($haystack as $head) {
                if ($head->parent_id && $head->parent_id == $parentHeadId) {
                    if ($head->has_child) {
                        $parent_head_total_allocation = 0;
                        $parent_head_total_adjustment = 0;
                        $parent_head_total_donation = 0;
                        $parent_head_current_total_allocation = 0;
                        $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                        $parent_head_child_number = $this->findHeadChildrenNumberByAllocation($head->head_row_id, $area_row_id, $budget_year, $start_date, $end_date);
                        $parent_head_total_allocation = $this->totalParentHeadFilterAllocations($this->parent_head_child_list, $area_row_id, $budget_year, $start_date, $end_date);
                        if ($showAdjustment) {
                            $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area_row_id, $budget_year, $start_date, $end_date);
                            $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area_row_id, $budget_year, $start_date, $end_date);
                            $parent_head_current_total_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                        }
                        if (isset($parent_head_total_allocation) && ($parent_head_total_allocation > 0)) {
                            $this->output[$area_row_detail->title][$head->head_row_id] = array(
                                'head_row_id' => $head->head_row_id,
                                'title' => $head->title,
                                'sort_order' => $head->sort_order,
                                'parent_id' => $head->parent_id,
                                'has_child' => $head->has_child,
                                'level' => $head->level,
                                'area_row_id' => $area_row_detail->area_row_id,
                                'area_name' => $area_row_detail->title,
                                'parent_head_child_number' => $parent_head_child_number,
                                'parent_head_total_allocation' => $parent_head_total_allocation,
                                'parent_head_total_adjustment' => $parent_head_total_adjustment,
                                'parent_head_total_donation' => $parent_head_total_donation,
                                'parent_head_current_total_allocation' => $parent_head_current_total_allocation
                            );
                        }
                        $this->setAllocationFilterChildren($haystack, $head->head_row_id, $area_row_id, $budget_year, $showAdjustment, $start_date, $end_date);
                    } else {
                        $head_total_allocation = 0;
                        $head_total_adjustment = 0;
                        $head_total_donation = 0;
                        $head_current_total_allocation = 0;
                        $head_total_allocation = $this->totalFilterAllocationByDate($area_row_id, $head->head_row_id, $budget_year, $start_date, $end_date);
                        if ($showAdjustment) {
                            $head_total_adjustment = $this->totalFilterReceiption($area_row_id, $head->head_row_id, $budget_year, $start_date, $end_date);
                            $head_total_donation = $this->totalFilterDonation($area_row_id, $head->head_row_id, $budget_year, $start_date, $end_date);
                            $head_current_total_allocation = ($head_total_allocation + $head_total_adjustment) - $head_total_donation;
                        }
                        if (isset($head_total_allocation) && ($head_total_allocation > 0)) {
                            $this->output[$area_row_detail->title][$head->head_row_id] = array(
                                'head_row_id' => $head->head_row_id,
                                'title' => $head->title,
                                'sort_order' => $head->sort_order,
                                'parent_id' => $head->parent_id,
                                'has_child' => $head->has_child,
                                'level' => $head->level,
                                'area_row_id' => $area_row_detail->area_row_id,
                                'area_name' => $area_row_detail->title,
                                'head_total_allocation' => $head_total_allocation,
                                'head_total_adjustment' => $head_total_adjustment,
                                'head_total_donation' => $head_total_donation,
                                'head_current_total_allocation' => $head_current_total_allocation
                            );
                        }
                    }
                }
            }
        }
    }

    public function allocationFilterHeadsWithAdjustment($showAdjustment = false, $area_row_id = 0, $head_row_id = 0, $budget_year, $start_date = 0, $end_date = 0) {
        $status = 1;
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        $result = $this->budgetAllHeadListWithProject($budget_year, $status);
        $this->output = array();
        /*
         * Check area_row_id value
         * which is selected all area or a specific area
         * area_row_id > 0, means a specific area selected
         * otherwise all area slected
         */
        if ($area_row_id > 0) {
            $area_row_detail = $this->get_area_row_info($area_row_id);
            if ($head_row_id > 0) {
                /*
                 * Specific area and head selected
                 */
                $head = \App\Models\Head::find($head_row_id);
                if ($head->has_child) {
                    $parent_head_total_allocation = 0;
                    $parent_head_total_adjustment = 0;
                    $parent_head_total_donation = 0;
                    $parent_head_current_total_allocation = 0;
                    //$parent_head_child_number = $this->findHeadChildrenNumber($head->head_row_id);
                    $parent_head_child_number = $this->findHeadChildrenNumberByAllocation($head->head_row_id, $area_row_id, $budget_year, 0, 0);
                    $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                    $parent_head_total_allocation = $this->totalParentHeadFilterAllocations($this->parent_head_child_list, $area_row_id, $budget_year, 0, 0);
                    if ($showAdjustment) {
                        $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area_row_id, $budget_year, $start_date, $end_date);
                        $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area_row_id, $budget_year, $start_date, $end_date);
                        $parent_head_current_total_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                    }
                    if (isset($parent_head_total_allocation) && ($parent_head_total_allocation > 0)) {
                        $this->output[$area_row_detail->title][$head->head_row_id] = array(
                            'head_row_id' => $head->head_row_id,
                            'title' => $head->title,
                            'sort_order' => $head->sort_order,
                            'parent_id' => $head->parent_id,
                            'has_child' => $head->has_child,
                            'level' => $head->level,
                            'area_row_id' => $area_row_detail->area_row_id,
                            'parent_head_child_number' => $parent_head_child_number,
                            'area_name' => $area_row_detail->title,
                            'parent_head_total_allocation' => $parent_head_total_allocation,
                            'parent_head_total_adjustment' => $parent_head_total_adjustment,
                            'parent_head_total_donation' => $parent_head_total_donation,
                            'parent_head_current_total_allocation' => $parent_head_current_total_allocation
                        );
                    }
                    $this->setAllocationFilterWithAdjustmentChildren($result, $head->head_row_id, $area_row_id, $budget_year, $showAdjustment, $start_date, $end_date);
                } else {
                    $head_total_allocation = 0;
                    $head_total_adjustment = 0;
                    $head_total_donation = 0;
                    $head_current_total_allocation = 0;
                    $head_total_allocation = $this->totalFilterAllocationByDate($area_row_id, $head->head_row_id, $budget_year, 0, 0);
                    if ($showAdjustment) {
                        $head_total_adjustment = $this->totalFilterReceiption($area_row_id, $head->head_row_id, $budget_year, $start_date, $end_date);
                        $head_total_donation = $this->totalFilterDonation($area_row_id, $head->head_row_id, $budget_year, $start_date, $end_date);
                        $head_current_total_allocation = ($head_total_allocation + $head_total_adjustment) - $head_total_donation;
                    }
                    if (isset($head_total_allocation) && ($head_total_allocation > 0)) {
                        $this->output[$area_row_detail->title][$head->head_row_id] = array(
                            'head_row_id' => $head->head_row_id,
                            'title' => $head->title,
                            'sort_order' => $head->sort_order,
                            'parent_id' => $head->parent_id,
                            'has_child' => $head->has_child,
                            'level' => $head->level,
                            'area_row_id' => $area_row_detail->area_row_id,
                            'area_name' => $area_row_detail->title,
                            'head_total_allocation' => $head_total_allocation,
                            'head_total_adjustment' => $head_total_adjustment,
                            'head_total_donation' => $head_total_donation,
                            'head_current_total_allocation' => $head_current_total_allocation
                        );
                    }
                }
            } else {
                /*
                 * Specific area and All head selected
                 */
                foreach ($result as $head) {
                    if ($head->parent_id == 0) {
                        if ($head->has_child) {
                            $parent_head_total_allocation = 0;
                            $parent_head_total_adjustment = 0;
                            $parent_head_total_donation = 0;
                            $parent_head_current_total_allocation = 0;
                            $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                            $parent_head_child_number = $this->findHeadChildrenNumberByAllocation($head->head_row_id, $area_row_id, $budget_year, 0, 0);
                            $parent_head_total_allocation = $this->totalParentHeadFilterAllocations($this->parent_head_child_list, $area_row_id, $budget_year, 0, 0);
                            if ($showAdjustment) {
                                $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area_row_id, $budget_year, $start_date, $end_date);
                                $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area_row_id, $budget_year, $start_date, $end_date);
                                $parent_head_current_total_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                            }
                            if (isset($parent_head_total_allocation) && ($parent_head_total_allocation > 0)) {
                                $this->output[$area_row_detail->title][$head->head_row_id] = array(
                                    'head_row_id' => $head->head_row_id,
                                    'title' => $head->title,
                                    'sort_order' => $head->sort_order,
                                    'parent_id' => $head->parent_id,
                                    'has_child' => $head->has_child,
                                    'level' => $head->level,
                                    'parent_head_child_number' => $parent_head_child_number,
                                    'area_row_id' => $area_row_detail->area_row_id,
                                    'area_name' => $area_row_detail->title,
                                    'parent_head_total_allocation' => $parent_head_total_allocation,
                                    'parent_head_total_adjustment' => $parent_head_total_adjustment,
                                    'parent_head_total_donation' => $parent_head_total_donation,
                                    'parent_head_current_total_allocation' => $parent_head_current_total_allocation
                                );
                            }
                            $this->setAllocationFilterWithAdjustmentChildren($result, $head->head_row_id, $area_row_id, $budget_year, $showAdjustment, $start_date, $end_date);
                        } else {
                            $head_total_allocation = 0;
                            $head_total_adjustment = 0;
                            $head_total_donation = 0;
                            $head_current_total_allocation = 0;
                            $head_total_allocation = $this->totalFilterAllocationByDate($area_row_id, $head->head_row_id, $budget_year, 0, 0);
                            if ($showAdjustment) {
                                $head_total_adjustment = $this->totalFilterReceiption($area_row_id, $head->head_row_id, $budget_year, $start_date, $end_date);
                                $head_total_donation = $this->totalFilterDonation($area_row_id, $head->head_row_id, $budget_year, $start_date, $end_date);
                                $head_current_total_allocation = ($head_total_allocation + $head_total_adjustment) - $head_total_donation;
                            }
                            if (isset($head_total_allocation) && ($head_total_allocation > 0)) {
                                $this->output[$area_row_detail->title][$head->head_row_id] = array(
                                    'head_row_id' => $head->head_row_id,
                                    'title' => $head->title,
                                    'sort_order' => $head->sort_order,
                                    'parent_id' => $head->parent_id,
                                    'has_child' => $head->has_child,
                                    'level' => $head->level,
                                    'area_row_id' => $area_row_detail->area_row_id,
                                    'area_name' => $area_row_detail->title,
                                    'head_total_allocation' => $head_total_allocation,
                                    'head_total_adjustment' => $head_total_adjustment,
                                    'head_total_donation' => $head_total_donation,
                                    'head_current_total_allocation' => $head_current_total_allocation
                                );
                            }
                        }
                    }
                }
            }
        } else {
            $allArea = $this->allAreas(1);
            if ($head_row_id > 0) {
                /*
                 * All area and specific head selected
                 */
                $head = \App\Models\Head::find($head_row_id);
                if (count($allArea)) {
                    foreach ($allArea as $area) {
                        if ($head->has_child) {
                            $parent_head_total_allocation = 0;
                            $parent_head_total_adjustment = 0;
                            $parent_head_total_donation = 0;
                            $parent_head_current_total_allocation = 0;
                            $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                            $parent_head_child_number = $this->findHeadChildrenNumberByAllocation($head->head_row_id, $area->area_row_id, $budget_year, 0, 0);
                            //$parent_head_child_number = $this->findHeadChildrenNumber($head->head_row_id);
                            $parent_head_total_allocation = $this->totalParentHeadFilterAllocations($this->parent_head_child_list, $area->area_row_id, $budget_year, 0, 0);
                            if ($showAdjustment) {
                                $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area->area_row_id, $budget_year, $start_date, $end_date);
                                $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area->area_row_id, $budget_year, $start_date, $end_date);
                                $parent_head_current_total_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                            }
                            if (isset($parent_head_total_allocation) && ($parent_head_total_allocation > 0)) {
                                $this->output[$area->title][$head->head_row_id] = array(
                                    'head_row_id' => $head->head_row_id,
                                    'title' => $head->title,
                                    'sort_order' => $head->sort_order,
                                    'parent_id' => $head->parent_id,
                                    'has_child' => $head->has_child,
                                    'level' => $head->level,
                                    'area_row_id' => $area->area_row_id,
                                    'area_name' => $area->title,
                                    'parent_head_child_number' => $parent_head_child_number,
                                    'parent_head_total_allocation' => $parent_head_total_allocation,
                                    'parent_head_total_adjustment' => $parent_head_total_adjustment,
                                    'parent_head_total_donation' => $parent_head_total_donation,
                                    'parent_head_current_total_allocation' => $parent_head_current_total_allocation
                                );
                            }
                            $this->setAllocationFilterWithAdjustmentChildren($result, $head->head_row_id, $area->area_row_id, $budget_year, $showAdjustment, $start_date, $end_date);
                        } else {
                            $head_total_allocation = 0;
                            $head_total_adjustment = 0;
                            $head_total_donation = 0;
                            $head_current_total_allocation = 0;
                            $head_total_allocation = $this->totalFilterAllocationByDate($area->area_row_id, $head->head_row_id, $budget_year, 0, 0);
                            if ($showAdjustment) {
                                $head_total_adjustment = $this->totalFilterReceiption($area->area_row_id, $head->head_row_id, $budget_year, $start_date, $end_date);
                                $head_total_donation = $this->totalFilterDonation($area->area_row_id, $head->head_row_id, $budget_year, $start_date, $end_date);
                                $head_current_total_allocation = ($head_total_allocation + $head_total_adjustment) - $head_total_donation;
                            }
                            if (isset($head_total_allocation) && ($head_total_allocation > 0)) {
                                $this->output[$area->title][$head->head_row_id] = array(
                                    'head_row_id' => $head->head_row_id,
                                    'title' => $head->title,
                                    'sort_order' => $head->sort_order,
                                    'parent_id' => $head->parent_id,
                                    'has_child' => $head->has_child,
                                    'level' => $head->level,
                                    'area_row_id' => $area->area_row_id,
                                    'area_name' => $area->title,
                                    'head_total_allocation' => $head_total_allocation,
                                    'head_total_adjustment' => $head_total_adjustment,
                                    'head_total_donation' => $head_total_donation,
                                    'head_current_total_allocation' => $head_current_total_allocation
                                );
                            }
                        }
                    }
                }
            } else {
                /*
                 * All area and All head selected
                 */
                if (count($allArea)) {
                    foreach ($allArea as $area) {
                        foreach ($result as $head) {
                            if ($head->parent_id == 0) {
                                if ($head->has_child) {
                                    $parent_head_total_allocation = 0;
                                    $parent_head_total_adjustment = 0;
                                    $parent_head_total_donation = 0;
                                    $parent_head_current_total_allocation = 0;
                                    $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                                    $parent_head_child_number = $this->findHeadChildrenNumberByAllocation($head->head_row_id, $area->area_row_id, $budget_year, 0, 0);
                                    $parent_head_total_allocation = $this->totalParentHeadFilterAllocations($this->parent_head_child_list, $area->area_row_id, $budget_year, 0, 0);
                                    if ($showAdjustment) {
                                        $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area->area_row_id, $budget_year, $start_date, $end_date);
                                        $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area->area_row_id, $budget_year, $start_date, $end_date);
                                        $parent_head_current_total_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                                    }
                                    if (isset($parent_head_total_allocation) && ($parent_head_total_allocation > 0)) {
                                        $this->output[$area->title][$head->head_row_id] = array(
                                            'head_row_id' => $head->head_row_id,
                                            'title' => $head->title,
                                            'sort_order' => $head->sort_order,
                                            'parent_id' => $head->parent_id,
                                            'has_child' => $head->has_child,
                                            'level' => $head->level,
                                            'area_row_id' => $area->area_row_id,
                                            'area_name' => $area->title,
                                            'parent_head_child_number' => $parent_head_child_number,
                                            'parent_head_total_allocation' => $parent_head_total_allocation,
                                            'parent_head_total_adjustment' => $parent_head_total_adjustment,
                                            'parent_head_total_donation' => $parent_head_total_donation,
                                            'parent_head_current_total_allocation' => $parent_head_current_total_allocation
                                        );
                                    }
                                    $this->setAllocationFilterWithAdjustmentChildren($result, $head->head_row_id, $area->area_row_id, $budget_year, $showAdjustment, $start_date, $end_date);
                                } else {
                                    $head_total_allocation = 0;
                                    $head_total_adjustment = 0;
                                    $head_total_donation = 0;
                                    $head_current_total_allocation = 0;
                                    $head_total_allocation = $this->totalFilterAllocationByDate($area->area_row_id, $head->head_row_id, $budget_year, 0, 0);
                                    if ($showAdjustment) {
                                        $head_total_adjustment = $this->totalFilterReceiption($area->area_row_id, $head->head_row_id, $budget_year, $start_date, $end_date);
                                        $head_total_donation = $this->totalFilterDonation($area->area_row_id, $head->head_row_id, $budget_year, $start_date, $end_date);
                                        $head_current_total_allocation = ($head_total_allocation + $head_total_adjustment) - $head_total_donation;
                                    }
                                    if (isset($head_total_allocation) && ($head_total_allocation > 0)) {
                                        $this->output[$area->title][$head->head_row_id] = array(
                                            'head_row_id' => $head->head_row_id,
                                            'title' => $head->title,
                                            'sort_order' => $head->sort_order,
                                            'parent_id' => $head->parent_id,
                                            'has_child' => $head->has_child,
                                            'level' => $head->level,
                                            'area_row_id' => $area->area_row_id,
                                            'area_name' => $area->title,
                                            'head_total_allocation' => $head_total_allocation,
                                            'head_total_adjustment' => $head_total_adjustment,
                                            'head_total_donation' => $head_total_donation,
                                            'head_current_total_allocation' => $head_current_total_allocation
                                        );
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $output = $this->output;
        $this->output = array();
        return $output;
    }

    function setAllocationFilterWithAdjustmentChildren($haystack, $parentHeadId, $area_row_id, $budget_year, $showAdjustment = false, $start_date, $end_date) {
        if (count($haystack)) {
            $area_row_detail = $this->get_area_row_info($area_row_id);
            foreach ($haystack as $head) {
                if ($head->parent_id && $head->parent_id == $parentHeadId) {
                    if ($head->has_child) {
                        $parent_head_total_allocation = 0;
                        $parent_head_total_adjustment = 0;
                        $parent_head_total_donation = 0;
                        $parent_head_current_total_allocation = 0;
                        $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                        $parent_head_child_number = $this->findHeadChildrenNumberByAllocation($head->head_row_id, $area_row_id, $budget_year, 0, 0);
                        $parent_head_total_allocation = $this->totalParentHeadFilterAllocations($this->parent_head_child_list, $area_row_id, $budget_year, 0, 0);
                        if ($showAdjustment) {
                            $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area_row_id, $budget_year, $start_date, $end_date);
                            $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area_row_id, $budget_year, $start_date, $end_date);
                            $parent_head_current_total_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                        }
                        if (isset($parent_head_total_allocation) && ($parent_head_total_allocation > 0)) {
                            $this->output[$area_row_detail->title][$head->head_row_id] = array(
                                'head_row_id' => $head->head_row_id,
                                'title' => $head->title,
                                'sort_order' => $head->sort_order,
                                'parent_id' => $head->parent_id,
                                'has_child' => $head->has_child,
                                'level' => $head->level,
                                'area_row_id' => $area_row_detail->area_row_id,
                                'area_name' => $area_row_detail->title,
                                'parent_head_child_number' => $parent_head_child_number,
                                'parent_head_total_allocation' => $parent_head_total_allocation,
                                'parent_head_total_adjustment' => $parent_head_total_adjustment,
                                'parent_head_total_donation' => $parent_head_total_donation,
                                'parent_head_current_total_allocation' => $parent_head_current_total_allocation
                            );
                        }
                        $this->setAllocationFilterWithAdjustmentChildren($haystack, $head->head_row_id, $area_row_id, $budget_year, $showAdjustment, $start_date, $end_date);
                    } else {
                        $head_total_allocation = 0;
                        $head_total_adjustment = 0;
                        $head_total_donation = 0;
                        $head_current_total_allocation = 0;
                        $head_total_allocation = $this->totalFilterAllocationByDate($area_row_id, $head->head_row_id, $budget_year, 0, 0);
                        if ($showAdjustment) {
                            $head_total_adjustment = $this->totalFilterReceiption($area_row_id, $head->head_row_id, $budget_year, $start_date, $end_date);
                            $head_total_donation = $this->totalFilterDonation($area_row_id, $head->head_row_id, $budget_year, $start_date, $end_date);
                            $head_current_total_allocation = ($head_total_allocation + $head_total_adjustment) - $head_total_donation;
                        }
                        if (isset($head_total_allocation) && ($head_total_allocation > 0)) {
                            $this->output[$area_row_detail->title][$head->head_row_id] = array(
                                'head_row_id' => $head->head_row_id,
                                'title' => $head->title,
                                'sort_order' => $head->sort_order,
                                'parent_id' => $head->parent_id,
                                'has_child' => $head->has_child,
                                'level' => $head->level,
                                'area_row_id' => $area_row_detail->area_row_id,
                                'area_name' => $area_row_detail->title,
                                'head_total_allocation' => $head_total_allocation,
                                'head_total_adjustment' => $head_total_adjustment,
                                'head_total_donation' => $head_total_donation,
                                'head_current_total_allocation' => $head_current_total_allocation
                            );
                        }
                    }
                }
            }
        }
    }

    /**
     * Get total allocation
     * @param type $area_row_id
     * @param type $budget_year
     * @return type
     */
    public function getTotalAllocation($area_row_id = 0, $budget_year = 0, $start_date = 0, $end_date = 0) {
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        if (!empty($start_date) && !empty($end_date)) {
            if ($area_row_id > 0) {
                return \App\Models\Allocation::where([['is_adjustment', '=', 0], ['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->whereBetween('allocation_at', [$start_date, $end_date])->sum('amount');
            } else {
                return \App\Models\Allocation::where([['is_adjustment', '=', 0], ['budget_year', '=', $budget_year]])->whereBetween('allocation_at', [$start_date, $end_date])->sum('amount');
            }
        } else {
            if ($area_row_id > 0) {
                return \App\Models\Allocation::where([['is_adjustment', '=', 0], ['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->sum('amount');
            } else {
                return \App\Models\Allocation::where([['is_adjustment', '=', 0], ['budget_year', '=', $budget_year]])->sum('amount');
            }
        }
    }

    /**
     * Get total donation
     * @param type $area_row_id
     * @param type $budget_year
     * @return type
     */
    public function getTotalDonation($area_row_id = 0, $budget_year = 0, $start_date = 0, $end_date = 0) {
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        if (!empty($start_date) && !empty($end_date)) {
            if ($area_row_id > 0) {
                return \App\Models\Allocation::where([['is_adjustment', '=', 1], ['source_area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->whereBetween('allocation_at', [$start_date, $end_date])->sum('amount');
            } else {
                return \App\Models\Allocation::where([['is_adjustment', '=', 1], ['budget_year', '=', $budget_year]])->whereBetween('allocation_at', [$start_date, $end_date])->sum('amount');
            }
        } else {
            if ($area_row_id > 0) {
                return \App\Models\Allocation::where([['is_adjustment', '=', 1], ['source_area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->sum('amount');
            } else {
                return \App\Models\Allocation::where([['is_adjustment', '=', 1], ['budget_year', '=', $budget_year]])->sum('amount');
            }
        }
    }

    /**
     * Get total reception
     * @param type $area_row_id
     * @param type $budget_year
     * @return type
     */
    public function getTotalReception($area_row_id = 0, $budget_year = 0, $start_date = 0, $end_date = 0) {
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        if (!empty($start_date) && !empty($end_date)) {
            if ($area_row_id > 0) {
                return \App\Models\Allocation::where([['is_adjustment', '=', 1], ['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->whereBetween('allocation_at', [$start_date, $end_date])->sum('amount');
            } else {
                return \App\Models\Allocation::where([['is_adjustment', '=', 1], ['budget_year', '=', $budget_year]])->whereBetween('allocation_at', [$start_date, $end_date])->sum('amount');
            }
        } else {
            if ($area_row_id > 0) {
                return \App\Models\Allocation::where([['is_adjustment', '=', 1], ['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->sum('amount');
            } else {
                return \App\Models\Allocation::where([['is_adjustment', '=', 1], ['budget_year', '=', $budget_year]])->sum('amount');
            }
        }
    }

    /**
     * Get total expense by area wise
     * @param type $area_row_id
     * @param type $budget_year
     * @return type
     */
    public function getTotalExpenseByArea($area_row_id = 0, $budget_year = 0, $start_date = 0, $end_date = 0) {
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        if (!empty($start_date) && !empty($end_date)) {
            if ($area_row_id > 0) {
                return \App\Models\Expense::where([['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->whereBetween('expense_at', [$start_date, $end_date])->sum('amount');
            } else {
                return \App\Models\Expense::where([['budget_year', '=', $budget_year]])->whereBetween('expense_at', [$start_date, $end_date])->sum('amount');
            }
        } else {
            if ($area_row_id > 0) {
                return \App\Models\Expense::where([['area_row_id', '=', $area_row_id], ['budget_year', '=', $budget_year]])->sum('amount');
            } else {
                return \App\Models\Expense::where([['budget_year', '=', $budget_year]])->sum('amount');
            }
        }
    }

    /**
     * Get total absolute allocation with adjustment by area
     * @param type $area_row_id
     * @param type $budget_year
     * @param type $start_date
     * @param type $end_date
     */
    public function getTotalAllocationWithAdjustmentByArea($area_row_id = 0, $budget_year = 0, $start_date = 0, $end_date = 0) {
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        $absolute_allocation = 0;
        if (!empty($start_date) && !empty($end_date)) {
            if ($area_row_id > 0) {
                $total_allocation = $this->getTotalAllocation($area_row_id, $budget_year, 0, 0);
                $total_donation = $this->getTotalDonation($area_row_id, $budget_year, $start_date, $end_date);
                $total_reception = $this->getTotalReception($area_row_id, $budget_year, $start_date, $end_date);
                $absolute_allocation = $total_allocation + $total_reception - $total_donation;
            } else {
                $total_allocation = $this->getTotalAllocation(-1, $budget_year, 0, 0);
                $total_donation = $this->getTotalDonation(-1, $budget_year, $start_date, $end_date);
                $total_reception = $this->getTotalReception(-1, $budget_year, $start_date, $end_date);
                $absolute_allocation = $total_allocation + $total_reception - $total_donation;
            }
        } else {
            if ($area_row_id > 0) {
                $total_allocation = $this->getTotalAllocation($area_row_id, $budget_year, 0, 0);
                $total_donation = $this->getTotalDonation($area_row_id, $budget_year, 0, 0);
                $total_reception = $this->getTotalReception($area_row_id, $budget_year, 0, 0);
                $absolute_allocation = $total_allocation + $total_reception - $total_donation;
            } else {
                $total_allocation = $this->getTotalAllocation(-1, $budget_year, 0, 0);
                $total_donation = $this->getTotalDonation(-1, $budget_year, 0, 0);
                $total_reception = $this->getTotalReception(-1, $budget_year, 0, 0);
                $absolute_allocation = $total_allocation + $total_reception - $total_donation;
            }
        }
        return $absolute_allocation;
    }

    /**
     * Call for Balance summary statement for only main head
     * @param type $area_row_id
     * @param type $head_row_id
     * @param type $budget_year
     * @param type $start_date
     * @param type $end_date
     */
    public function budgetBalanceSummaryByDate($area_row_id = -1, $head_row_id = -1, $budget_year = 0, $start_date = 0, $end_date = 0) {
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        $this->output = array();
        if ($area_row_id > 0) {
            if ($head_row_id > 0) {
                /**
                 * For specific area and specific main head
                 */
                $head = \App\Models\Head::find($head_row_id);
                if ($head->has_child) {
                    $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                    $parent_head_total_allocation = $this->totalParentHeadAllocations($this->parent_head_child_list, $area_row_id, $budget_year);
                    $parent_head_total_expense = $this->totalParentHeadExpense($this->parent_head_child_list, $area_row_id, $budget_year, $start_date, $end_date);
                    $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area_row_id, $budget_year, 0, 0);
                    $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area_row_id, $budget_year, 0, 0);
                    $parent_head_total_current_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                    $parent_head_current_balance = $parent_head_total_current_allocation - $parent_head_total_expense;
                    $head->parent_head_current_balance = $parent_head_current_balance;
                    $head->parent_head_total_expense = $parent_head_total_expense;
                    $head->parent_head_total_allocation = $parent_head_total_current_allocation;
                    if (isset($parent_head_total_current_allocation) && ($parent_head_total_current_allocation != 0)) {
                        $this->output[] = $head;
                    }
                } else {
                    $parent_head_total_allocation = $this->totalAllcations($head->head_row_id, $area_row_id, $budget_year);
                    $parent_head_total_adjustment = $this->totalFilterReceiption($area_row_id, $head->head_row_id, $budget_year, 0, 0);
                    $parent_head_total_donation = $this->totalFilterDonation($area_row_id, $head->head_row_id, $budget_year, 0, 0);
                    $parent_head_total_current_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                    $head->parent_head_total_allocation = $parent_head_total_current_allocation;
                    $parent_head_total_expense = $this->totalFilterExpense($head->head_row_id, $area_row_id, $budget_year, $start_date, $end_date);
                    $head->parent_head_total_expense = $parent_head_total_expense;
                    $parent_head_current_balance = $parent_head_total_current_allocation - $parent_head_total_expense;
                    $head->parent_head_current_balance = $parent_head_current_balance;
                    if (isset($parent_head_total_current_allocation) && ($parent_head_total_current_allocation != 0)) {
                        $this->output[] = $head;
                    }
                }
            } else {
                /**
                 * For specific area and all main head
                 */
                $all_main_head = $this->allMainHeads();
                foreach ($all_main_head as $head) {
                    if ($head->has_child) {
                        $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                        $parent_head_total_allocation = $this->totalParentHeadAllocations($this->parent_head_child_list, $area_row_id, $budget_year);
                        $parent_head_total_expense = $this->totalParentHeadExpense($this->parent_head_child_list, $area_row_id, $budget_year, $start_date, $end_date);
                        $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area_row_id, $budget_year, 0, 0);
                        $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area_row_id, $budget_year, 0, 0);
                        $parent_head_total_current_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                        $parent_head_current_balance = $parent_head_total_current_allocation - $parent_head_total_expense;
                        $head->parent_head_current_balance = $parent_head_current_balance;
                        $head->parent_head_total_expense = $parent_head_total_expense;
                        $head->parent_head_total_allocation = $parent_head_total_current_allocation;
                        if (isset($parent_head_total_current_allocation) && ($parent_head_total_current_allocation != 0)) {
                            $this->output[] = $head;
                        }
                    } else {
                        $parent_head_total_allocation = $this->totalAllcations($head->head_row_id, $area_row_id, $budget_year);
                        $parent_head_total_adjustment = $this->totalFilterReceiption($area_row_id, $head->head_row_id, $budget_year, 0, 0);
                        $parent_head_total_donation = $this->totalFilterDonation($area_row_id, $head->head_row_id, $budget_year, 0, 0);
                        $parent_head_total_current_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                        $head->parent_head_total_allocation = $parent_head_total_current_allocation;
                        $parent_head_total_expense = $this->totalFilterExpense($head->head_row_id, $area_row_id, $budget_year, $start_date, $end_date);
                        $head->parent_head_total_expense = $parent_head_total_expense;
                        $parent_head_current_balance = $parent_head_total_current_allocation - $parent_head_total_expense;
                        $head->parent_head_current_balance = $parent_head_current_balance;
                        if (isset($parent_head_total_current_allocation) && ($parent_head_total_current_allocation != 0)) {
                            $this->output[] = $head;
                        }
                    }
                }
            }
        } else {
            if ($head_row_id > 0) {
                /**
                 * For all area and specific main head
                 */
                $head = \App\Models\Head::find($head_row_id);
                $allArea = $this->allAreas(1);
                if (count($allArea)) {
                    foreach ($allArea as $area) {
                        if ($head->has_child) {
                            $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                            $parent_head_total_expense = $this->totalParentHeadExpense($this->parent_head_child_list, $area->area_row_id, $budget_year, $start_date, $end_date);
                            $parent_head_total_allocation = $this->totalParentHeadAllocations($this->parent_head_child_list, $area->area_row_id, $budget_year);
                            $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area->area_row_id, $budget_year, 0, 0);
                            $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area->area_row_id, $budget_year, 0, 0);
                            $parent_head_total_current_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                            $parent_head_current_balance = $parent_head_total_current_allocation - $parent_head_total_expense;
                            if (isset($parent_head_total_current_allocation) && ($parent_head_total_current_allocation != 0)) {
                                $this->output[$area->title][$head->head_row_id] = array(
                                    'head_row_id' => $head->head_row_id,
                                    'title' => $head->title,
                                    'sort_order' => $head->sort_order,
                                    'parent_id' => $head->parent_id,
                                    'has_child' => $head->has_child,
                                    'level' => $head->level,
                                    'area_row_id' => $area->area_row_id,
                                    'area_name' => $area->title,
                                    'parent_head_total_allocation' => $parent_head_total_current_allocation,
                                    'parent_head_current_balance' => $parent_head_current_balance,
                                    'parent_head_total_expense' => $parent_head_total_expense
                                );
                            }
                        } else {
                            $parent_head_total_allocation = $this->totalAllcations($head->head_row_id, $area->area_row_id, $budget_year);
                            $parent_head_total_adjustment = $this->totalFilterReceiption($area->area_row_id, $head->head_row_id, $budget_year, 0, 0);
                            $parent_head_total_donation = $this->totalFilterDonation($area->area_row_id, $head->head_row_id, $budget_year, 0, 0);
                            $parent_head_total_current_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                            $parent_head_total_expense = $this->totalFilterExpense($head->head_row_id, $area->area_row_id, $budget_year, $start_date, $end_date);
                            $parent_head_current_balance = $parent_head_total_current_allocation - $parent_head_total_expense;
                            if (isset($parent_head_total_current_allocation) && ($parent_head_total_current_allocation != 0)) {
                                $this->output[$area->title][$head->head_row_id] = array(
                                    'head_row_id' => $head->head_row_id,
                                    'title' => $head->title,
                                    'sort_order' => $head->sort_order,
                                    'parent_id' => $head->parent_id,
                                    'has_child' => $head->has_child,
                                    'level' => $head->level,
                                    'area_row_id' => $area->area_row_id,
                                    'area_name' => $area->title,
                                    'parent_head_total_allocation' => $parent_head_total_current_allocation,
                                    'parent_head_current_balance' => $parent_head_current_balance,
                                    'parent_head_total_expense' => $parent_head_total_expense
                                );
                            }
                        }
                    }
                }
            } else {
                /**
                 * For all area and all main head
                 */
                $allArea = $this->allAreas(1);
                $all_main_head = $this->allMainHeads();
                if (count($allArea)) {
                    foreach ($allArea as $area) {
                        foreach ($all_main_head as $head) {
                            if ($head->has_child) {
                                $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                                $parent_head_total_expense = $this->totalParentHeadExpense($this->parent_head_child_list, $area->area_row_id, $budget_year, $start_date, $end_date);
                                $parent_head_total_allocation = $this->totalParentHeadAllocations($this->parent_head_child_list, $area->area_row_id, $budget_year);
                                $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area->area_row_id, $budget_year, 0, 0);
                                $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area->area_row_id, $budget_year, 0, 0);
                                $parent_head_total_current_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                                $parent_head_current_balance = $parent_head_total_current_allocation - $parent_head_total_expense;
                                if (isset($parent_head_total_current_allocation) && ($parent_head_total_current_allocation != 0)) {
                                    $this->output[$area->title][$head->head_row_id] = array(
                                        'head_row_id' => $head->head_row_id,
                                        'title' => $head->title,
                                        'sort_order' => $head->sort_order,
                                        'parent_id' => $head->parent_id,
                                        'has_child' => $head->has_child,
                                        'level' => $head->level,
                                        'area_row_id' => $area->area_row_id,
                                        'area_name' => $area->title,
                                        'parent_head_total_allocation' => $parent_head_total_current_allocation,
                                        'parent_head_current_balance' => $parent_head_current_balance,
                                        'parent_head_total_expense' => $parent_head_total_expense
                                    );
                                }
                            } else {
                                $parent_head_total_allocation = $this->totalAllcations($head->head_row_id, $area->area_row_id, $budget_year);
                                $parent_head_total_adjustment = $this->totalFilterReceiption($area->area_row_id, $head->head_row_id, $budget_year, 0, 0);
                                $parent_head_total_donation = $this->totalFilterDonation($area->area_row_id, $head->head_row_id, $budget_year, 0, 0);
                                $parent_head_total_current_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                                $parent_head_total_expense = $this->totalFilterExpense($head->head_row_id, $area->area_row_id, $budget_year, $start_date, $end_date);
                                $parent_head_current_balance = $parent_head_total_current_allocation - $parent_head_total_expense;
                                if (isset($parent_head_total_current_allocation) && ($parent_head_total_current_allocation != 0)) {
                                    $this->output[$area->title][$head->head_row_id] = array(
                                        'head_row_id' => $head->head_row_id,
                                        'title' => $head->title,
                                        'sort_order' => $head->sort_order,
                                        'parent_id' => $head->parent_id,
                                        'has_child' => $head->has_child,
                                        'level' => $head->level,
                                        'area_row_id' => $area->area_row_id,
                                        'area_name' => $area->title,
                                        'parent_head_total_allocation' => $parent_head_total_current_allocation,
                                        'parent_head_current_balance' => $parent_head_current_balance,
                                        'parent_head_total_expense' => $parent_head_total_expense
                                    );
                                }
                            }
                        }
                    }
                }
            }
        }
        $output = $this->output;
        $this->output = array();
        return $output;
    }

    public function BudgetBalanceSummaryReportByMonthRange($area_row_id = -1, $head_row_id = -1, $budget_year = 0, $from_month = 0, $to_month = 0) {
        $budget_year = !empty($budget_year) ? $budget_year : date('Y');
        $all_main_head = $this->allMainHeads();
        $this->output = array();
        if (!empty($from_month) && !empty($to_month)) {
            $data['from_month'] = $from_month;
            $data['to_month'] = $to_month;
        } elseif (!empty($from_month) && empty($to_month)) {
            $to_month = Carbon::now()->format('m');
            $data['from_month'] = $from_month;
            $data['to_month'] = $to_month;
        } elseif (empty($from_month) && !empty($to_month)) {
            $from_month = $to_month;
            $data['from_month'] = $from_month;
            $data['to_month'] = $to_month;
        } else {
            $from_month = Carbon::now()->format('m');
            $to_month = Carbon::now()->format('m');
        }
        /*
         * Check area_row_id value
         * which is selected all area or a specific area
         * area_row_id > 0, means a specific area selected
         * otherwise all area slected
         */
        if ($area_row_id > 0) {
            $area_row_detail = $this->get_area_row_info($area_row_id);
            if ($head_row_id > 0) {
                /*
                 * Specific area and head selected
                 */
                $head = \App\Models\Head::find($head_row_id);
                if ($head->has_child) {
                    $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                    $parent_head_total_allocation = $this->totalParentHeadAllocations($this->parent_head_child_list, $area_row_detail->area_row_id, $budget_year);
                    $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area_row_detail->area_row_id, $budget_year, 0, 0);
                    $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area_row_detail->area_row_id, $budget_year, 0, 0);
                    $parent_head_total_current_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                    $start_month = $from_month;
                    $parent_total_expense = 0;
                    $parent_month_expense = 0;
                    for ($start_month; $start_month <= $to_month; $start_month++) {
                        $parent_month_expense = $this->totalParentHeadExpenseByMonth($this->parent_head_child_list, $area_row_id, $budget_year, $start_month);
                        $this->head_total_expense_by_month[$start_month] = $parent_month_expense;
                        $parent_total_expense += $parent_month_expense;
                    }
                    $parent_head_current_balance = $parent_head_total_current_allocation - $parent_total_expense;
                    if (isset($parent_head_total_current_allocation) && ($parent_head_total_current_allocation != 0)) {
                        $this->output[$area_row_id][$head->head_row_id] = array(
                            'head_row_id' => $head->head_row_id,
                            'title' => $head->title,
                            'sort_order' => $head->sort_order,
                            'parent_id' => $head->parent_id,
                            'has_child' => $head->has_child,
                            'level' => $head->level,
                            'area_row_id' => $area_row_id,
                            'parent_head_total_allocation' => $parent_head_total_current_allocation,
                            'parent_head_current_balance' => $parent_head_current_balance,
                            'parent_head_total_expense' => $parent_total_expense
                        );
                        array_push($this->output[$area_row_id][$head->head_row_id], $this->head_total_expense_by_month);
                    }
                    unset($start_month);
                    unset($parent_total_expense);
                    unset($parent_month_expense);
                } else {
                    $head_current_total_allocation = 0;
                    $head_total_allocation = $this->totalAllcations($head->head_row_id, $area_row_id, $budget_year);
                    $head_total_adjustment = $this->totalFilterReceiption($area_row_id, $head->head_row_id, $budget_year, 0, 0);
                    $head_total_donation = $this->totalFilterDonation($area_row_id, $head->head_row_id, $budget_year, 0, 0);
                    $head_current_total_allocation = ($head_total_allocation + $head_total_adjustment) - $head_total_donation;
                    $start_month = $from_month;
                    $total_expense = 0;
                    $month_expense = 0;
                    for ($start_month; $start_month <= $to_month; $start_month++) {
                        $month_expense = $this->totalFilterExpenseByMonth($head->head_row_id, $area_row_id, $budget_year, $start_month);
                        $this->head_total_expense_by_month[$start_month] = $month_expense;
                        $total_expense += $month_expense;
                    }
                    $head_current_balance = 0;
                    $head_current_balance = $head_current_total_allocation - $total_expense;
                    if (isset($head_current_total_allocation) && ($head_current_total_allocation != 0)) {
                        $this->output[$area_row_id][$head->head_row_id] = array(
                            'head_row_id' => $head->head_row_id,
                            'title' => $head->title,
                            'sort_order' => $head->sort_order,
                            'parent_id' => $head->parent_id,
                            'has_child' => $head->has_child,
                            'level' => $head->level,
                            'area_row_id' => $area_row_id,
                            'parent_head_total_allocation' => $head_current_total_allocation,
                            'parent_head_current_balance' => $head_current_balance,
                            'parent_head_total_expense' => $total_expense
                        );
                        array_push($this->output[$area_row_id][$head->head_row_id], $this->head_total_expense_by_month);
                    }
                    unset($start_month);
                    unset($month_expense);
                }
            } else {
                /*
                 * Specific area and all head Selected
                 */
                foreach ($all_main_head as $head) {
                    if ($head->has_child) {
                        $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                        $parent_head_total_allocation = $this->totalParentHeadAllocations($this->parent_head_child_list, $area_row_id, $budget_year);
                        $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area_row_id, $budget_year, 0, 0);
                        $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area_row_id, $budget_year, 0, 0);
                        $parent_head_total_current_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                        $start_month = $from_month;
                        $parent_total_expense = 0;
                        $parent_month_expense = 0;
                        for ($start_month; $start_month <= $to_month; $start_month++) {
                            $parent_month_expense = $this->totalParentHeadExpenseByMonth($this->parent_head_child_list, $area_row_id, $budget_year, $start_month);
                            $this->head_total_expense_by_month[$start_month] = $parent_month_expense;
                            $parent_total_expense += $parent_month_expense;
                        }
                        $parent_head_current_balance = $parent_head_total_current_allocation - $parent_total_expense;
                        if (isset($parent_head_total_current_allocation) && ($parent_head_total_current_allocation != 0)) {
                            $this->output[$area_row_id][$head->head_row_id] = array(
                                'head_row_id' => $head->head_row_id,
                                'title' => $head->title,
                                'sort_order' => $head->sort_order,
                                'parent_id' => $head->parent_id,
                                'has_child' => $head->has_child,
                                'level' => $head->level,
                                'area_row_id' => $area_row_id,
                                'parent_head_total_allocation' => $parent_head_total_current_allocation,
                                'parent_head_current_balance' => $parent_head_current_balance,
                                'parent_head_total_expense' => $parent_total_expense
                            );
                            array_push($this->output[$area_row_id][$head->head_row_id], $this->head_total_expense_by_month);
                        }
                        unset($start_month);
                        unset($parent_total_expense);
                        unset($parent_month_expense);
                    } else {
                        $head_current_total_allocation = 0;
                        $head_total_allocation = $this->totalAllcations($head->head_row_id, $area_row_id, $budget_year);
                        $head_total_adjustment = $this->totalFilterReceiption($area_row_id, $head->head_row_id, $budget_year, 0, 0);
                        $head_total_donation = $this->totalFilterDonation($area_row_id, $head->head_row_id, $budget_year, 0, 0);
                        $head_current_total_allocation = ($head_total_allocation + $head_total_adjustment) - $head_total_donation;
                        $start_month = $from_month;
                        $total_expense = 0;
                        $month_expense = 0;
                        for ($start_month; $start_month <= $to_month; $start_month++) {
                            $month_expense = $this->totalFilterExpenseByMonth($head->head_row_id, $area_row_id, $budget_year, $start_month);
                            $this->head_total_expense_by_month[$start_month] = $month_expense;
                            $total_expense += $month_expense;
                        }
                        $head_current_balance = 0;
                        $head_current_balance = $head_current_total_allocation - $total_expense;
                        if (isset($head_current_total_allocation) && ($head_current_total_allocation != 0)) {
                            $this->output[$area_row_id][$head->head_row_id] = array(
                                'head_row_id' => $head->head_row_id,
                                'title' => $head->title,
                                'sort_order' => $head->sort_order,
                                'parent_id' => $head->parent_id,
                                'has_child' => $head->has_child,
                                'level' => $head->level,
                                'area_row_id' => $area_row_id,
                                'parent_head_total_allocation' => $head_current_total_allocation,
                                'parent_head_current_balance' => $head_current_balance,
                                'parent_head_total_expense' => $total_expense
                            );
                            array_push($this->output[$area_row_id][$head->head_row_id], $this->head_total_expense_by_month);
                        }
                        unset($start_month);
                        unset($month_expense);
                    }
                }
            }
        } else {
            $allArea = $this->allAreas(1);
            if ($head_row_id > 0) {
                /*
                 * All area and specific head selected
                 */
                $head = \App\Models\Head::find($head_row_id);
                if (count($allArea)) {
                    foreach ($allArea as $area) {
                        if ($head->has_child) {
                            $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                            $parent_head_total_allocation = $this->totalParentHeadAllocations($this->parent_head_child_list, $area->area_row_id, $budget_year);
                            $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area->area_row_id, $budget_year, 0, 0);
                            $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area->area_row_id, $budget_year, 0, 0);
                            $parent_head_total_current_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                            $start_month = $from_month;
                            $parent_total_expense = 0;
                            $parent_month_expense = 0;
                            for ($start_month; $start_month <= $to_month; $start_month++) {
                                $parent_month_expense = $this->totalParentHeadExpenseByMonth($this->parent_head_child_list, $area->area_row_id, $budget_year, $start_month);
                                $this->head_total_expense_by_month[$start_month] = $parent_month_expense;
                                $parent_total_expense += $parent_month_expense;
                            }
                            $parent_head_current_balance = $parent_head_total_current_allocation - $parent_total_expense;
                            if (isset($parent_head_total_current_allocation) && ($parent_head_total_current_allocation != 0)) {
                                $this->output[$area->area_row_id][$head->head_row_id] = array(
                                    'head_row_id' => $head->head_row_id,
                                    'title' => $head->title,
                                    'sort_order' => $head->sort_order,
                                    'parent_id' => $head->parent_id,
                                    'has_child' => $head->has_child,
                                    'level' => $head->level,
                                    'area_row_id' => $area->area_row_id,
                                    'parent_head_total_allocation' => $parent_head_total_current_allocation,
                                    'parent_head_current_balance' => $parent_head_current_balance,
                                    'parent_head_total_expense' => $parent_total_expense
                                );
                                array_push($this->output[$area->area_row_id][$head->head_row_id], $this->head_total_expense_by_month);
                            }
                            unset($start_month);
                            unset($parent_total_expense);
                            unset($parent_month_expense);
                        } else {
                            $head_current_total_allocation = 0;
                            $head_total_allocation = $this->totalAllcations($head->head_row_id, $area->area_row_id, $budget_year);
                            $head_total_adjustment = $this->totalFilterReceiption($area->area_row_id, $head->head_row_id, $budget_year, 0, 0);
                            $head_total_donation = $this->totalFilterDonation($area->area_row_id, $head->head_row_id, $budget_year, 0, 0);
                            $head_current_total_allocation = ($head_total_allocation + $head_total_adjustment) - $head_total_donation;
                            $start_month = $from_month;
                            $total_expense = 0;
                            $month_expense = 0;
                            for ($start_month; $start_month <= $to_month; $start_month++) {
                                $month_expense = $this->totalFilterExpenseByMonth($head->head_row_id, $area->area_row_id, $budget_year, $start_month);
                                $this->head_total_expense_by_month[$start_month] = $month_expense;
                                $total_expense += $month_expense;
                            }
                            $head_current_balance = 0;
                            $head_current_balance = $head_current_total_allocation - $total_expense;

                            if (isset($head_current_total_allocation) && ($head_current_total_allocation != 0)) {
                                $this->output[$area->area_row_id][$head->head_row_id] = array(
                                    'head_row_id' => $head->head_row_id,
                                    'title' => $head->title,
                                    'sort_order' => $head->sort_order,
                                    'parent_id' => $head->parent_id,
                                    'has_child' => $head->has_child,
                                    'level' => $head->level,
                                    'area_row_id' => $area->area_row_id,
                                    'parent_head_total_allocation' => $head_current_total_allocation,
                                    'parent_head_current_balance' => $head_current_balance,
                                    'parent_head_total_expense' => $total_expense
                                );
                                array_push($this->output[$area->area_row_id][$head->head_row_id], $this->head_total_expense_by_month);
                            }
                            unset($start_month);
                            unset($month_expense);
                        }
                    }
                }
            } else {
                /*
                 * All area and head Selected
                 */
                if (count($allArea)) {
                    foreach ($allArea as $area) {
                        foreach ($all_main_head as $head) {
                            if ($head->has_child) {
                                $this->parent_head_child_list = $this->findHeadChildrenList($head->head_row_id);
                                $parent_head_total_allocation = $this->totalParentHeadAllocations($this->parent_head_child_list, $area->area_row_id, $budget_year);
                                $parent_head_total_adjustment = $this->totalParentHeadAdjustment($this->parent_head_child_list, $area->area_row_id, $budget_year, 0, 0);
                                $parent_head_total_donation = $this->totalParentHeadDonation($this->parent_head_child_list, $area->area_row_id, $budget_year, 0, 0);
                                $parent_head_total_current_allocation = ($parent_head_total_allocation + $parent_head_total_adjustment) - $parent_head_total_donation;
                                $start_month = $from_month;
                                $parent_total_expense = 0;
                                $parent_month_expense = 0;
                                for ($start_month; $start_month <= $to_month; $start_month++) {
                                    $parent_month_expense = $this->totalParentHeadExpenseByMonth($this->parent_head_child_list, $area->area_row_id, $budget_year, $start_month);
                                    $this->head_total_expense_by_month[$start_month] = $parent_month_expense;
                                    $parent_total_expense += $parent_month_expense;
                                }
                                $parent_head_current_balance = $parent_head_total_current_allocation - $parent_total_expense;
                                if (isset($parent_head_total_current_allocation) && ($parent_head_total_current_allocation != 0)) {
                                    $this->output[$area->area_row_id][$head->head_row_id] = array(
                                        'head_row_id' => $head->head_row_id,
                                        'title' => $head->title,
                                        'sort_order' => $head->sort_order,
                                        'parent_id' => $head->parent_id,
                                        'has_child' => $head->has_child,
                                        'level' => $head->level,
                                        'area_row_id' => $area->area_row_id,
                                        'parent_head_total_allocation' => $parent_head_total_current_allocation,
                                        'parent_head_current_balance' => $parent_head_current_balance,
                                        'parent_head_total_expense' => $parent_total_expense
                                    );
                                    array_push($this->output[$area->area_row_id][$head->head_row_id], $this->head_total_expense_by_month);
                                }
                                unset($start_month);
                                unset($parent_total_expense);
                                unset($parent_month_expense);
                            } else {
                                $head_current_total_allocation = 0;
                                $head_total_allocation = $this->totalAllcations($head->head_row_id, $area->area_row_id, $budget_year);
                                $head_total_adjustment = $this->totalFilterReceiption($area->area_row_id, $head->head_row_id, $budget_year, 0, 0);
                                $head_total_donation = $this->totalFilterDonation($area->area_row_id, $head->head_row_id, $budget_year, 0, 0);
                                $head_current_total_allocation = ($head_total_allocation + $head_total_adjustment) - $head_total_donation;
                                $start_month = $from_month;
                                $total_expense = 0;
                                $month_expense = 0;
                                for ($start_month; $start_month <= $to_month; $start_month++) {
                                    $month_expense = $this->totalFilterExpenseByMonth($head->head_row_id, $area->area_row_id, $budget_year, $start_month);
                                    $this->head_total_expense_by_month[$start_month] = $month_expense;
                                    $total_expense += $month_expense;
                                }
                                $head_current_balance = 0;
                                $head_current_balance = $head_current_total_allocation - $total_expense;
                                if (isset($head_current_total_allocation) && ($head_current_total_allocation != 0)) {
                                    $this->output[$area->area_row_id][$head->head_row_id] = array(
                                        'head_row_id' => $head->head_row_id,
                                        'title' => $head->title,
                                        'sort_order' => $head->sort_order,
                                        'parent_id' => $head->parent_id,
                                        'has_child' => $head->has_child,
                                        'level' => $head->level,
                                        'area_row_id' => $area->area_row_id,
                                        'parent_head_total_allocation' => $head_current_total_allocation,
                                        'parent_head_current_balance' => $head_current_balance,
                                        'parent_head_total_expense' => $total_expense
                                    );
                                    array_push($this->output[$area->area_row_id][$head->head_row_id], $this->head_total_expense_by_month);
                                }
                                unset($start_month);
                                unset($month_expense);
                            }
                        }
                    }
                }
            }
        }
        $output = $this->output;
        $this->output = array();
        return $output;
    }

}
