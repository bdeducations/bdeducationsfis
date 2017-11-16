@extends('backend.school_admin.layout_app')

@section('content')

    <div class="row">
        <div class="col-md-12 ">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <i class="icon-settings font-red-sunglo"></i>
                        <span class="caption-subject bold uppercase"> Attendance Report</span>
                    </div>
                    <div class="actions">
                    </div>
                </div>
                <div class="portlet-body form">
                    <form role="form" method="post" action="{{ url('/') }}/schoolAdmin/attendance/reportGenerate" >
                        {!! csrf_field() !!}
                        <input type="hidden" name="section_row_id" value="{{ isset($section_info->section_row_id) ? $section_info->section_row_id : 0 }}" >
                        <div class="form-body">
                            <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Class</label>
                                            <div class="col-md-9">
                                                <select class="form-control classes" name="academic_class" required>
                                                    <option value="">Select Class</option>
                                                    @foreach($data['allclasses'] as $class)
                                                        <option value="{{ $class->class_row_id }}">{{ $class->class_name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="help-block"> Choose a class from the dropdown</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Shift/Session</label>
                                            <div class="col-md-9">
                                                <select class="form-control shift" name="academic_shift" required></select>
                                                <span class="help-block"> Select school shift </span>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Section</label>
                                        <div class="col-md-9">
                                            <select class="form-control sections" name="academic_section">
                                                <!--<option value="1">Rose</option>
                                                <option value="2">Tulip</option>
                                                <option value="3">Merigold</option>-->
                                            </select>
                                            <span class="help-block"> Choose a section from the dropdown</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Department</label>
                                        <div class="col-md-9">
                                            <select class="form-control department" name="academic_department">
                                                <option value="1">General</option>
                                                <!--<option value="2" disabled>Science</option>
                                                <option value="3" disabled>Commerce</option>
                                                <option value="4" disabled>Arts</option>-->
                                            </select>
                                            <span class="help-block"> Select school department </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Date</label>
                                        <div class="input-group input-medium  date date-picker col-md-9" data-date-format="yyyy-mm-dd" style="padding: 0 0 0 12px">
                                                <input required id="datepicker" type="text" class="form-control" name="date_of_attendance" >
                                                <span class="input-group-btn">
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                </span>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn blue hidden_submit_btn" disabled="disabled">Generate Report</button>
                            
                        </div>
                    </form>

                  
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.classes').change(function(){
                $('.hidden_submit_btn').attr("disabled", true);
                $('.sections').empty();
                $('.shift').empty();
                $('.department').empty();
                $('.subject').empty();
                var classid = $(this).val();
                if(classid == 9 || classid == 10 || classid == 11 || classid == 12) {
                    $(".department option[value='1']").remove();
                    $(".department").append('<option value="2">Science</option>');
                    $(".department").append('<option value="3">Commerce</option>');
                    $(".department").append('<option value="4">Arts</option>');
                } else {
                    $(".department option[value='2']").remove();
                    $(".department option[value='3']").remove();
                    $(".department option[value='4']").remove();
                    $(".department").append('<option value="1">General</option>');
                }
                $.ajax({
                    url: "{{ url('getSections/') }}"+ '/'+ classid,
                    type: "GET",
                    dataType: "html",
                    success: function(data){
                        $('.sections').append(data);
                    }
                });
                $.ajax({
                    url: "{{ url('getShift/') }}"+ '/'+ classid,
                    type: "GET",
                    dataType: "html",
                    success: function(data){
                        $('.hidden_submit_btn').removeAttr("disabled");
                        $('.shift').append(data);
                    }
                });
                 $.ajax({
                    url: "{{ url('getSubjectByClass') }}/"+ classid,
                    type: "GET",
                    dataType: "html",
                    success: function(data){

                        $('.subject').append(data);
                    }
                }); 

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