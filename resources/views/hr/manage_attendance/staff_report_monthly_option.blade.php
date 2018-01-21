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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="area_name" class="col-md-3 control-label">Select Year <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-9">
                                        <div class="input-group input-medium  date date-picker col-md-9" style="padding: 0 0 0 12px">
                                            <select class="form-control" name="attendance_year">
                                                <option @if( date('Y') == 2017) selected="selected" @endif>2017</option>
                                                <option @if( date('Y') == 2018) selected="selected" @endif>2018</option>
                                                <option @if( date('Y') == 2019) selected="selected" @endif>2019</option>
                                                <option @if( date('Y') == 2020) selected="selected" @endif>2020</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="area_name" class="col-md-3 control-label">Select Month <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-9">
                                        <div class="input-group input-medium  date date-picker col-md-9" style="padding: 0 0 0 12px">
                                            <select class="form-control" name="attendance_month">
                                                <option value="1"  @if( date('n') == 1) selected="selected" @endif>January</option>
                                                <option value="2"  @if( date('n') == 2) selected="selected" @endif>February</option>
                                                <option value="3"  @if( date('n') == 3)  selected="selected" @endif>March</option>
                                                <option value="4" @if( date('n') == 4) selected="selected" @endif>April</option>
                                                <option value="5" @if( date('n') == 5) selected="selected" @endif>May</option>
                                                <option value="6" @if( date('n') == 6) selected="selected" @endif>June</option>
                                                <option value="7" @if( date('n') == 7) selected="selected" @endif>July</option>
                                                <option value="8"  @if( date('n') == 8) selected="selected" @endif>August</option>
                                                <option value="9" @if( date('n') == 9)  selected="selected" @endif>September</option>
                                                <option value="10" @if( date('n') == 10) selected="selected" @endif>October</option>
                                                <option value="11" @if( date('n') == 11) selected="selected" @endif>November</option>
                                                <option value="12" @if( date('n') == 12) selected="selected" @endif>December</option>
                                            </select>
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
                                    
                                    <div class="col-md-9 col-md-offset-3">
                                         <button type="submit" class="btn btn-primary" style="">Submit</button>
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
        $('#datepicker').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            todayHighlight: true,
        });
    });
</script>
@endsection