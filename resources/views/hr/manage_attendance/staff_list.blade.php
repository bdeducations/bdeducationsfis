@extends('backend.school_admin.layout_app')

@section('content')

    <div class="row">
        <div class="col-md-12 ">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <i class="icon-settings font-red-sunglo"></i>
                        <span class="caption-subject bold uppercase">  Staff's Attendance 
                        Entry <br><br> Attendance Date: {{ $date_of_attendance }} </span>
                    </div>
                    <div class="actions">
                    </div>
                </div>
                <form role="form" id="attendance_form" method="post" action="{{ url('/') }}/schoolAdmin/staffAttendance/storeStaffAttendance">
                {!! csrf_field() !!}
                 <input type="hidden" name="date_of_attendance" value="{{ $date_of_attendance }}">
	                <div class="portlet-body form">
	                	<div class="form-body">						
						    <div class="form-group">
							    <table class="table  table-bordered dt-responsive" width="100%" id="sample_1">
								    <thead>
										<tr>											
											
											<th class="min-phone-l">Name</th>
											<th class="min-phone-l">In Time</th>
											<th class="min-phone-l">Out Time </th>
										</tr>
									</thead>
									<tbody>
									<div class="checkbox_wrapper">
										<?php
										$i=1;
										?>
									   @foreach($staff_list as $row)	
										<tr>
											
											<td>{{ $row->admin_name}}</td>
											<td>
												<?php 
													$first_login = isset($row->first_login) ? $row->first_login : '' ;
													$first_login_hr = '';
													$first_login_min = '';
													$first_login_ampm = '';

													if($first_login) {
													$first_login_arr = explode(':', $first_login);

													$first_login_hr = $first_login_arr[0];
													$first_login_ampm = 'am';
													if($first_login_hr > 12) {
														$first_login_hr = $first_login_hr - 12;
														$first_login_ampm = 'pm';
													}  else if($first_login_hr == 12) {
														$last_logout_ampm = 'pm';
													}												
													$first_login_min = $first_login_arr[1];
													}

													?>														
													<select name="in_time_hr[]" style="width:70px;height:25px;margin: 0 0 0 10px">
													    	<option value="">Select</option>
													    	<?php for($i=1; $i<=12; $i++) { ?>
													    	<option <?php if($first_login_hr == $i) echo 'selected="selected"'; ?> value="<?php echo $i;?>"><?php echo $i;?></option>
													    	<?php } ?>
													    </select>
													    <select name="in_time_min[]" style="width:70px;height:25px;margin: 0 10px">
													    	<option <?php if($first_login_min == '') echo 'selected="selected"'; ?> value="">Select</option>
													    	<?php for($i=0; $i<=59; $i++) { ?>
													    	<option <?php if($first_login_min == $i) echo 'selected="selected"'; ?> value="<?php echo str_pad($i, 2, '0', STR_PAD_LEFT);?>"><?php echo str_pad($i, 2, '0', STR_PAD_LEFT);?></option>
													    	<?php } ?>
													    </select>
													    <select name="in_time_ampm[]" style="width:70px;height:25px">
													    	<option <?php if($first_login_ampm == '') echo 'selected="selected"'; ?> value="">Select</option>
													    	<option  <?php if($first_login_ampm == 'am') echo 'selected="selected"'; ?> value="am">AM</option>
													    	<option <?php if($first_login_ampm == 'pm') echo 'selected="selected"'; ?> value="pm">PM</option>
													    </select>
											</td>	
											
											<td>
												<?php 
  																$last_logout = isset($row->last_logout) ? $row->last_logout : '' ;
  																$last_logout_hr = '';
  																$last_logout_min = '';
  																$last_logout_ampm = '';

  																if($last_logout) {
  																	$last_logout_arr = explode(':', $last_logout);

  																	$last_logout_hr = $last_logout_arr[0];
  																	$last_logout_ampm = 'am';
  																	if($last_logout_hr > 12) {
  																		$last_logout_hr = $last_logout_hr - 12;
  																		$last_logout_ampm = 'pm';
  																	} else if($last_logout_hr == 12) {
  																		$last_logout_ampm = 'pm';
  																	}												
  																	$last_logout_min = $last_logout_arr[1];
  																}

															 ?>
														    <select name="out_time_hr[]" style="width:70px;height:25px;margin: 0 0 0 10px">
														    	<option value="">Select</option>
														    	<?php for($i=1; $i<=12; $i++) { ?>
														    	<option <?php if($last_logout_hr == $i) echo 'selected="selected"'; ?> value="<?php echo $i;?>"><?php echo $i;?></option>
														    	<?php } ?>
														    </select>
														    <select name="out_time_min[]" style="width:70px;height:25px;margin: 0 10px">
														    	<option <?php if($last_logout_min == '') echo 'selected="selected"'; ?> value="">Select</option>
														    	<?php for($i=0; $i<=59; $i++) { ?>
														    	<option <?php if($last_logout_min == $i) echo 'selected="selected"'; ?> value="<?php echo str_pad($i, 2, '0', STR_PAD_LEFT);?>"><?php echo str_pad($i, 2, '0', STR_PAD_LEFT);?></option>
														    	<?php } ?>
														    </select>
														    <select name="out_time_ampm[]" style="width:70px;height:25px">
														    	<option <?php if($last_logout_ampm == '') echo 'selected="selected"'; ?> value="">Select</option>
														    	<option  <?php if($last_logout_ampm == 'am') echo 'selected="selected"'; ?> value="am">AM</option>
														    	<option <?php if($last_logout_ampm == 'pm') echo 'selected="selected"'; ?> value="pm">PM</option>
														    </select>
											</td>
																							
										</tr>
										<?php
										$i++;
										?>
										<input type="hidden" name="staff_ids[]" value="{{ $row->admin_row_id}}" >
										@endforeach
										</div>
									</tbody>
								</table>
                            </div> 
															
	                        </div>
	                        <div class="form-actions">
	                            <button type="submit" class="btn blue" >{{  Lang::get('general.submit') }}</button>
	                            <button type="button" class="btn default" onclick="window.location.href='{{ url('/')}}/schoolAdmin/manualAttendance'">{{  Lang::get('general.cancel') }}</button>
	                        </div>                   
	                </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('page_js')

    <link href="{{ asset('/public')}}/metronic/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
	<link href="{{ asset('/public')}}/metronic/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
	<link href="{{ asset('/public')}}/metronic/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
	<link href="{{ asset('/public')}}/metronic/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />
	<script src="{{ asset('/public')}}/metronic/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
	<script src="{{ asset('/public')}}/metronic/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
	<script src="{{ asset('/public')}}/metronic/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
	<script src="{{ asset('/public')}}/metronic/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>	
	<script src="{{ asset('/public')}}/metronic/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>    
    <script src="{{ asset('/public')}}/metronic/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
	</script>
 @endsection 


