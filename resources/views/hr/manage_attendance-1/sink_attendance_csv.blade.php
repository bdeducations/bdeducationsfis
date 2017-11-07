@extends('layouts.admin')
@section('content')

    <div class="row">
        <div class="col-md-12 ">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <i class="icon-settings font-red-sunglo"></i>
                        <span class="caption-subject bold uppercase">Upload Attendance Data</span>
                    </div>
                    <div class="actions">
                    </div>
                </div>
                <div class="portlet-body form">
                     <form role="form" id="attendance_form" method="post" action="{{ url('/') }}/hr/attendance/sinkAttendanceRecordsFromCsv" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Select CSV File</label>
                                        <div class="input-group input-medium col-md-9 fileinput">
                                                <input type="file" name="import_file">
                                        </div>
                                    </div>                                    
                                </div>                              
                            </div>

                            <div class="row">                                
                                <div class="col-md-6">
                                	<div class="form-group">
                                		<label class="control-label col-md-3"></label>
                                		 <div class="input-group col-md-9">
			                            <button type="submit" class="btn blue submit_btn">Sink Attendance</button>		
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