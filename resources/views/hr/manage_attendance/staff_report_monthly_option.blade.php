@extends('layouts.admin')
@section('page_css')
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datepicker/datepicker3.css">
@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Monthly Attendance Report</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Report Attendance</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <!-- form start -->
                <form role="form" method="post" action="{{ url('/') }}/hr/attendance/all-staff-attendance-monthly-report-pdf" >
                    {!! csrf_field() !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="area_name" class="col-md-2 control-label">From<span class="input-required-asterik">*</span></label>
                                    <div class="col-md-10">
                                        <div class="input-group input-medium  date date-picker col-md-12" data-date-format="yyyy-mm-dd" style="padding: 0 0 0 12px">
                                        <input type="text" name="date_from" class="form-control" id="datepicker1" required="required" />
                                    </div> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="area_name" class="col-md-2 control-label">To<span class="input-required-asterik">*</span></label>
                                    <div class="col-md-10">
                                        <div class="input-group input-medium  date date-picker col-md-12" data-date-format="yyyy-mm-dd" style="padding: 0 0 0 12px">
                                        <input type="text" name="date_to" class="form-control" id="datepicker2" required="required" />
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="area_name" class="col-md-3 control-label">Working Days<span class="input-required-asterik">*</span></label>
                                    <div class="col-md-9">
                                        <input type="text" name="total_working_days" class="form-control" required="required" value="19" />
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="row" style="padding-top: 20px">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="area_name" class="col-md-3 control-label">Report Type <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-9">
                                       <label class="col-md-3 control-label"><input type="radio" name="report_type" value="1">Pdf</label>
                                       <label class="col-md-3 control-label"><input type="radio" name="report_type" value="2">Excel</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">                                
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    
                                    <div class="col-md-11 col-md-offset-1">
                                         <button type="submit" class="btn btn-primary" style="" target="_blank">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-footer -->
                </form>
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
    $(document).ready(function(){
        $('#datepicker1').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            todayHighlight: true,
        });
        $('#datepicker2').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            todayHighlight: true,
        });
    });
</script>
@endsection