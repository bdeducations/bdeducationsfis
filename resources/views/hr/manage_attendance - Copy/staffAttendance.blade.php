@extends('backend.school_admin.layout_app')

@section('content')

    <div class="row">
        <div class="col-md-12 ">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <i class="icon-settings font-red-sunglo"></i>
                        <span class="caption-subject bold uppercase"> Staff Attendance </span>
                    </div>
                    <div class="actions">
                    </div>
                </div>
                <form role="form" id="attendance_form" method="post" action="{{ url('/') }}/schoolAdmin/staffAttendance/storeStaffAttendance" >
                {!! csrf_field() !!}
                    <div class="portlet-body form">
	                	<div class="form-body">						
							    <div class="form-group">
							    	<table class="table   dt-responsive" width="100%">
								    	<tr>
											<td colspan="4">Select Date
												<div class="input-group input-medium  date date-picker" data-date-format="yyyy-mm-dd">
												<input id="datepicker" type="text" class="form-control" required name="date_of_attendance">
												<span class="input-group-btn">
													<button class="btn default" type="button">
														<i class="fa fa-calendar"></i>
													</button>
												</span>
												</div>
											</td>											
								    	</tr>
								    	
							    	</table>
							    </div>
	                       					
							    <div class="form-group">
								    <table class="table  table-bordered dt-responsive" width="100%">
										  <thead>
												<tr>											
													<th class="all">ID </th>
													<th class="min-phone-l">Name</th>
													<th class="min-phone-l"><input type="checkbox" class="select_all_checkbox" id="select_all"/> Provide Presence</th>
												</tr>
											</thead>
											<tbody>
											
											   @foreach($admin_list as $row)	
												<tr style="height:90px">
													<td>{{ $row->admin_row_id}}</td>
													<td>{{ $row->admin_name}}</td>
													<td>
													 <input type="hidden" id="checkAttendance"name="student_row_ids[]" value="{{ $row->admin_row_id}}" >
														<label><input type="checkbox" class="checkbox_single" value="{{ $row->admin_row_id}}"  name="attendance[]" > </label>
													</td>											
												</tr>
												@endforeach
												
											</tbody>
									</table>
	                            </div> 
															
	                        </div>
	                        <div class="form-actions">
	                            <button type="submit" class="btn blue">{{  Lang::get('general.submit') }}</button>
	                            <button type="button" class="btn default" onclick="window.location.href='{{ url('/')}}/schoolAdmin/staffAttendance'">{{  Lang::get('general.cancel') }}</button>
	                        </div>                   
	                </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('page_js')
    <link href="{{ asset('/public')}}/metronic/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
    <script src="{{ asset('/public')}}/metronic/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="{{ asset('/public')}}/metronic/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="{{ asset('/public')}}/metronic/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
    <script src="{{ asset('/public')}}/metronic/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>
    <script src="{{ asset('/public')}}/metronic/pages/scripts/form-wizard.js" type="text/javascript"></script>
    <script src="{{ asset('/public')}}/metronic/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <script src="{{ asset('/public')}}/metronic/pages/scripts/form-validation.js" type="text/javascript"></script> 
    <script type="text/javascript">
    
	$('#select_all').click(function() {
	    if ($(this).is(':checked')) {
	        $('.checkbox_single').prop('checked', true).uniform('refresh');
	    } else {    	
	    	$('.checkbox_single').prop('checked', false).uniform('refresh');	       
	    }
	});
	</script>

 @endsection 


