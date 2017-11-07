@extends('backend.school_admin.layout_app')

@section('content')

    <div class="row">
        <div class="col-md-12 ">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <i class="icon-settings font-red-sunglo"></i>
                        <span class="caption-subject bold uppercase">Staff Attendance Report</span>
                    </div>
                    <div class="actions">
                    </div>
                </div>
                <div class="portlet-body form">
                    <form role="form" method="post" action="{{ url('/') }}/schoolAdmin/attendance/staffIndividualReportGenerate" >
                        {!! csrf_field() !!}
                        <div class="form-body">
                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Select</label>
                                        <div class="input-group input-medium col-md-9" data-date-format="yyyy-mm-dd">
                                            <select class="form-control" name="admin_id" required>
                                            <option value="">Select</option>
                                            @foreach($data['all_staffs'] as $staff)
                                            <option value="{{ $staff->admin_id }}">{{ $staff->admin_name }}</option>
                                            @endforeach
                                             </select>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="col-md-6">
                                    
                                </div>
                            </div>
                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">From Date</label>
                                        <div class="input-group input-medium  date date-picker col-md-9" data-date-format="yyyy-mm-dd">
                                                <input required id="datepicker" type="text" class="form-control" name="date_from_attendance" >
                                                <span class="input-group-btn">
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                </span>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">To Date</label>
                                        <div class="input-group input-medium  date date-picker col-md-9" data-date-format="yyyy-mm-dd">
                                                <input required id="datepicker" type="text" class="form-control" name="date_to_attendance" >
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


                        <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button type="submit" class="btn blue submit_btn">Generate Report</button>
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