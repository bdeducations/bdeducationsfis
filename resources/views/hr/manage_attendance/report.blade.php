@extends('backend.school_admin.layout_app')

@section('content')

    <div class="row">
        <div class="col-md-12 ">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <i class="icon-settings font-red-sunglo"></i>
                        <span class="caption-subject bold uppercase">  Attendance Report  </span>
                    </div>
                    <div class="actions">
                    </div>
                </div>
                
                <div class="portlet-body form">
                    <div class="form-body">                     
                        <div class="form-group">
                            <table class="table  table-bordered dt-responsive" >
                                 <tr>
                                  <td style="width:25%">Class: {{ $data['class_name'] }} </td>
                                  <td style="width:25%">Shift: {{ $data['shift_title'] }} </td>
                                  <td style="width:25%">Section: {{ $data['section_name'] }} </td>
                                  <td style="width:25%">Department: {{ $data['department_name'] }} </td>
                                </tr>
                            </table>
                        </div>
                        <div class="form-group">                            
                            <table class="table table-bordered  dt-responsive" width="100%">
                                <tr>
                                    <td>Attendance Date: <strong>{{ $data['date_of_attendance'] }}</strong> </td>
                                    <td><a style="float:right;text-decoration: underline;" href="{{ url('/') }}/schoolAdmin/attendance/generatepdf/{{ $data['class_row_id'] }}/{{ $data['shift_row_id'] }}/{{ $data['section_row_id']}}/{{ $data['department_row_id'] }}/{{ $data['date_of_attendance'] }}" target="_blank">Genarate PDF</a></td>
                                </tr>
                            </table>
                        </div>
                                    
                        <div class="form-group">
                             <table class="table  table-bordered dt-responsive" width="100%" id="sample_1">
                                  <thead>
                                        <tr>                                            
                                            <th class="all">Roll </th>
                                            <th class="min-phone-l">Name</th>
                                            <th class="min-phone-l">In Time</th>
                                            <th class="min-phone-l">Out Time</th>
                                            <th class="min-phone-l">Attendance Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <div class="checkbox_wrapper">
                                            @foreach($data['students_list']  as $row)
                                            <?php 
                                                $login =  date( 'H:i', strtotime($row->first_login) );
                                                $present = 1;
                                                if($login == '00:00')   
                                                {
                                                    $present = 0;
                                                }
                                                
                                                $logout =  date( 'H:i', strtotime($row->last_logout) );
                                                
                                                if($logout == '00:00')
                                                {
                                                    $logout = 0;
                                                }

                                               ?> 
                                            <tr>
                                                <td>{{ $row->current_rollnumber}}</td>
                                                <td>{{ $row->student_name}}</td>
                                                <td>
                                                    {{ $present ? date('H:i a', strtotime($row->first_login)) : '' }}
                                                </td> 
                                                <td>
                                                    {{ ($row->first_login == $row->last_logout || !$logout) ? '' : date( 'h:i a', strtotime($row->last_logout) ) }}
                                                </td> 
                                                <td>
                                                    {{ $present ? 'Present' : 'Absent' }}
                                                </td>                                     
                                            </tr>
                                        @endforeach
                                        </div>
                                    </tbody>
                                </table>
                        </div> 
                                                    
                    </div>
                                     
                </div>
               
            </div>
        </div>
    </div>

@endsection

@section('page_js')

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


