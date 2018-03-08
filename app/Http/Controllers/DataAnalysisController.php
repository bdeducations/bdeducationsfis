<?php 
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;
use DB;
use App\Models\Admin;
use Illuminate\Support\Facades\Input;
use App\Libraries\Common;
use Session;


class DataAnalysisController extends Controller
{
    private $viewFolderPath = 'data-analysis/';
    private $breadcrumb = 'Data Analysis';

    public function assetReport(Request $Request) {
    	$data = [];
        return view($this->viewFolderPath .  'asset_allocation_report', ['data'=>$data] );
    }
   
}