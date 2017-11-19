@extends('layouts.admin')

@section('content')
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Attendance Report</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Attendance</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12 ">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="box box-info">
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <i class="icon-settings font-red-sunglo"></i>
                        <span class="caption-subject bold uppercase">&nbsp;&nbsp;Staff Attendance Report  </span>
                    </div>
                    <div class="actions">
                    </div>
                </div>
                
                <div class="portlet-body form">
                    <div class="form-body">                     
                        <div class="form-group">                            
                            <table class="table table-bordered  dt-responsive" width="100%">
                                <tr>
                                    <td>Attendance Date: {{ $data['date_of_attendance'] }} </td>
                                    <td><a style="float:right;text-decoration: underline;" href="{{ url('/') }}/hr/attendance/all-staff-attendance-report-pdf/{{ $data['date_of_attendance'] }}" target="_blank">Genarate PDF</a></td>
                                </tr>
                            </table>
                        </div> 
                        <div class="form-group">
                             <table class="table  table-bordered dt-responsive" width="100%" id="sample_1">
                                  <thead>
                                        <tr>
                                            <th class="min-phone-l">Serial</th>
                                            <th class="min-phone-l">Name</th>
                                            <th class="min-phone-l">In Time</th>
                                            <th class="min-phone-l">Out Time</th>
                                            <th class="min-phone-l">Attendance Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <div class="checkbox_wrapper">
                                            @php $i = 1; @endphp

                                            @foreach($data['staff_list']  as $row)
                                            <?php 
                                                $presentmsg = 'Present'; $absentmsg = 'Absent';
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

                                                $is_offday = isEmployeeHoliday($row->employee_row_id, $data['date_of_attendance']);

                                                if($is_offday) {
                                                    $absentmsg = 'Not scheduled day';
                                                }

                                               ?> 
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $row->employee_name}}</td>
                                                <td>{{ $present ? date('h:i a', strtotime($row->first_login)) : '' }}</td> 
                                                <td>
                                                    {{ ($row->first_login == $row->last_logout || !$logout) ? '' : date( 'h:i a', strtotime($row->last_logout) ) }}
                                                </td> 
                                                 <td>
                                                    {!! $present ? '<div style="color:green !important;">Present</div>' : '<div style="color:red !important;">Absent</div>' !!}

                                                </td>
                                            </tr>
                                             @php $i++; @endphp
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
</section>

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


