@extends('layouts.admin')
@section('page_css')
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Monthly Salary Sheet</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Salary Sheet</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <!-- form start -->
                <form role="form" method="POST" class="form-horizontal" action="{{ url('/') }}/hr/salary-sheet-view-with-leave-record" >
                    {!! csrf_field() !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="category_row_id" class="col-md-5 control-label">Select Area <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-7">
                                        <select name="area_row_id" class ="form-control" required="required">
                                            <option value="">Select Area</option>
                                            <option value="all">All</option>
                                            @foreach($data['areas'] as $area_info)
                                                <option value="{{ $area_info->area_row_id}}">{{ $area_info->title}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                 <div class="form-group">
                                    <label for="applicant_row_id" class="col-md-3 control-label">Select Department <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-9">
                                        <select name="department_row_id" class="form-control" required="required">
                                            <option value="">Select Department</option>
                                            <option value="all">All</option>
                                            @foreach($data['departments_list'] as $department_info)
                                                <option value="{{ $department_info->department_row_id}}">{{ $department_info->department_name}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="applicant_type" class="col-md-5 control-label">Select Year  <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-7">
                                        <select name="salary_year"  class="form-control" required="required">
                                            <option value="">Select</option>
                                            @for($i=2017; $i<2050; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor                                           
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="applicant_row_id" class="col-md-3 control-label">Select Month <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-9">
                                        <select name="salary_month" class="form-control" required="required">
                                            <option value="">Select </option>
                                            <option value="1">January </option>
                                            <option value="2">February </option>
                                            <option value="3">March </option>
                                            <option value="4">April</option>
                                            <option value="5">May </option>
                                            <option value="6">June </option>
                                            <option value="7">July</option>
                                            <option value="8">August </option>
                                            <option value="9">Septemebr </option>
                                            <option value="10">October </option>
                                            <option value="11">November </option>
                                            <option value="12">December </option>
                                        </select>
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
                
            </div>
        </div>
    </div>
</section>
@endsection
@section('page_js')

@endsection