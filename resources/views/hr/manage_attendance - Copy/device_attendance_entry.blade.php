@extends('backend.school_admin.layout_app')

@section('content')

    <div class="row">
        <div class="col-md-12 ">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <i class="icon-settings font-red-sunglo"></i>
                        <span class="caption-subject bold uppercase"> Attendance From Device</span>
                    </div>
                    <div class="actions">
                    </div>
                </div>
                <div class="portlet-body form">
                    <form role="form" method="post" id="attendance_entry" action="{{ url('/') }}/schoolAdmin/attendance/reportGenerate" >
                        {!! csrf_field() !!}
                        
                        <div class="form-body">                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        
                                        <div class="col-md-9">
                                           <input type="text" name="student_rfid" id="student_rfid">
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                    </form>

                  
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {

        	 // process the form
    $('#attendance_entry').submit(function(event) {
    	

    	var student_rfid = $("#student_rfid") . val();
    	$("#student_rfid") . val('');


		$.ajax({
				url: "{{ url('/') }}/schoolAdmin/saveAttendanceFromDevice"+ '/'+ student_rfid,
				type: "GET",
				dataType: "html",
				success: function(data){
					$('.shift').append(data);
				}
			});

		return false;
        
    });
            
        });
    </script>

    <link href="{{ asset('/public')}}/metronic/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/public')}}/metronic/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/public')}}/metronic/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/public')}}/metronic/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
    <script src="{{ asset('/public')}}/metronic/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="{{ asset('/public')}}/metronic/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="{{ asset('/public')}}/metronic/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="{{ asset('/public')}}/metronic/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
    <script src="{{ asset('/public')}}/metronic/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>
    <script src="{{ asset('/public')}}/metronic/pages/scripts/form-wizard.js" type="text/javascript"></script>
    <script src="{{ asset('/public')}}/metronic/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <script src="{{ asset('/public')}}/metronic/pages/scripts/form-validation.js" type="text/javascript"></script>
@endsection