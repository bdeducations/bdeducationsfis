@extends('layouts.admin')
@section('page_css')
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Asset Allocation Report</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Allocation Report</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <!-- form start -->
                <form role="form" method="POST" class="form-horizontal" action="{{ url('/') }}/budget/allocation/report" >
                    {!! csrf_field() !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="budget_year" class="col-md-5 control-label">Select Organization <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-7">
                                        <select name="budget_year" class="ut_budget_year form-control" required="required">
                                             <option value="">Select</option>
                                             <option value="">Asiya Bari High School</option>
                                             <option value="">Mahmuda Khanam Memorial Academy</option>
                                             <option value="">Nizkunjara KG School</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="head_row_id" class="col-md-3 control-label">Select Head <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-9">
                                        <select name="head_row_id" class="ut_budget_head_drop_down form-control" required="required">
                                            <option value="">Select Head</option>
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">                           
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="from_datepicker" class="col-md-5 control-label">From Date</label>
                                    <div class="col-md-7">
                                        <input type="text" name="from_date" class="form-control" id="from_datepicker" value="" />
                                    </div>                                    
                                </div>
                            </div>
							<div class="col-md-6">
                                <div class="form-group">                                    
                                    <label for="to_datepicker" class="col-md-3 control-label">To Date</label>
                                    <div class="col-md-9">
                                        <input type="text" name="to_date" class="form-control" id="to_datepicker" value="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary pull-right">Submit</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-footer -->
                </form>
               
               
                <div class="box-body">
                    <h3 style="text-transform:uppercase;text-align:center;"> 12</h3>
                    <table class="table table-striped table-bordered table-hover table-checkable order-column">
                        <thead>
                            <tr>
                                <th width="60%" style="text-align:left;padding-left:10px">Head Name</th>
                                <th width="25%" style="text-align:center;padding-left:10px">Allocation</th>
                                <th width="15%" style="text-align:center;padding-left:10px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
							<tr v-for="todo in todos">
                                <td style="text-align:left;padding-left:10px">
                                    <strong>
                                        <span>sadsad</span>
                                        ttt
                                    </strong>
                                </td>
                                <td style="text-align:center;padding-left:10px">
                                   sad
                                </td>
                                <td style="text-align:center;padding-left:10px">
                                   d
                                </td>
                            </tr>
                           
                        </tbody>
                    </table>
                   
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('page_js')
<!-- page script -->
<!-- bootstrap datepicker -->
<script src="{{ url('/')}}/public/adminlte/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    $('#to_datepicker,#from_datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true,
    });
    
});
var app4 = new Vue({
  el: '#asset-view',
  data: {
    todos: [
      { text: 'Learn JavaScript' },
      { text: 'Learn Vue' },
      { text: 'Build something awesome' }
    ]
  }
})

</script>
@endsection