@extends('layouts.admin')
@section('page_css')
<style type="text/css">
    content{
        text-align :left;
    }
</style>
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/iCheck/minimal/_all.css">
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Manual Attendance</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Manual Attendance</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Staff's Attendance Entry</h3><br>
                    <p >Date: {{ $data['date_of_attendance'] }}</p>
                </div>
                <!-- form start -->
                <div>
                    <form role="form" id="attendance_form" method="post" action="{{ url('/') }}/hr/staffAttendance/storeStaffAttendance">
		                {!! csrf_field() !!}
		                 <input type="hidden" name="date_of_attendance" value="{{ $data['date_of_attendance'] }}">
			                <div class="portlet-body form">
			                	<div class="form-body">						
								    <div class="form-group">
									    <table class="table table-bordered table-striped" width="100%" id="sample_1">
										    <thead>
												<tr>
													<th class="min-phone-l">#</th>
													<th class="min-phone-l">Names </th>
													<th class="min-phone-l">Time In</th>
													<th class="min-phone-l">Time Out</th>
													<th class="min-phone-l">Count Time Manually</th>
												</tr>
											</thead>
											<tbody>
											<div class="checkbox_wrapper">
												<?php
												$i=1;
												
												?>
											   @foreach($data['staff_list'] as $row) 
												<?php
												//login time calculation
												$first_login = isset($row->first_login) ? $row->first_login : '' ;
												$date = date('Y-m-d', strtotime($first_login));
												$time_first = date('H:i:s', strtotime($first_login));

												$first_login_hr = '';
												$first_login_min = '';
												$first_login_ampm = '';

												if($first_login) {
													$first_login_arr = explode(':', $time_first);
													
													$first_login_hr = $first_login_arr[0];

													// dd($first_login_hr);

													if($first_login_hr > 12) {
														$first_login_hr = $first_login_hr - 12;
														$first_login_ampm = 'pm';
													}  else if($first_login_hr == 12) {
														$first_login_ampm = 'pm';
													}else if($first_login_hr < 12 && $first_login_hr) {
														$first_login_ampm = 'am';
													} else {
													$first_login_ampm = '';
													}							

													$first_login_min = $first_login_arr[1];
												}
											   
											    //logout calculation
												$last_logout = isset($row->last_logout) ? $row->last_logout : '' ;
												$date = date('Y-m-d', strtotime($last_logout));
												$time_last = date('H:i:s', strtotime($last_logout));

												$last_logout_hr = '';
												$last_logout_min = '';
												$last_logout_ampm = '';

												if($last_logout) {
													$last_logout_arr = explode(':', $time_last);
													$last_logout_hr = $last_logout_arr[0];

													
													if($last_logout_hr > 12) {
														$last_logout_hr = $last_logout_hr - 12;
														$last_logout_ampm = 'pm';
													} else if($last_logout_hr == 12) {
														$last_logout_ampm = 'pm';
													} else if ($last_logout_hr < 12 && $last_logout_hr >0) {
														$last_logout_ampm = 'am'; 
													} else {
														$last_logout_ampm = '';	
													}											
													$last_logout_min = $last_logout_arr[1];
												}

												

												// if attendance info exist in db with hour minute 00 , it means he was absent. 
												if($first_login_hr == '00') {  
													$first_login_ampm = '';
													$last_logout_ampm = '';
												}
												?>

												<tr>	
													<td>{{ $i }}</td>										
													<td>{{ $row->employee_name}}</td>
													<td>
														<input type="text" style="width:50px" name="in_time_hr[]" value="{{ $first_login_hr }}">
														<input type="text" style="width:50px" name="in_time_min[]" value="{{ $first_login_min }}">
														<input type="text" style="width:50px" name="in_time_ampm[]" value="{{ $first_login_ampm }}">
													</td>	
													
													<td>
														<input type="text" style="width:50px" name="out_time_hr[]" value="{{ $last_logout_hr }}">
														<input type="text" style="width:50px" name="out_time_min[]" value="{{ $last_logout_min }}">
														<input type="text" style="width:50px" name="out_time_ampm[]" value="{{ $last_logout_ampm }}">
													</td>
													<td> 
														<input type="checkbox" style="margin-left: 30px;" name="count_manual_hours[]" class="check_count_manual_hours" employee="{{ $row->employee_row_id }}" @if($row->count_manual_hours != 0) checked @endif >

														<input type="text" style="width:50px;padding-left: 13px" name="total_hour[]" value="{{ $row->count_manual_hours }}" class="total_hour_{{ $row->employee_row_id }}"> Hours
													</td>
												</tr>
												<?php
												$i++;
												?>
												<input type="hidden" name="staff_ids[]" value="{{ $row->employee_row_id}}" >
												@endforeach
												</div>
											</tbody>
										</table>
		                            </div>															
			                        </div>
			                        <div class="form-actions" style="padding-bottom:20px; ">
			                        	<button type="submit" value="submit" class="btn btn-primary" style="margin-left: 15px;">Submit</button>
			                            
			                            <button type="button" class="btn btn-primary" onclick="window.location.href='{{ url('/')}}/hr/attendance/all-staff-manual-attendance'">Cancel</button>
			                        </div>                   
			                </div>
		                </form>
            	</div>
            </div>
        </div>
    </div>
</section>
@endsection

