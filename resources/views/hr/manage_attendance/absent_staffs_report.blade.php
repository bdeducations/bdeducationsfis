@extends('backend.school_admin.layout_app')

@section('content')

    <div class="row">
        <div class="col-md-12 ">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <i class="icon-settings font-red-sunglo"></i>
                        <span class="caption-subject bold uppercase"> Staffs Absent Report   </span>
                    </div>
                    <div class="actions">
                    </div>
                </div>
                
                <div class="portlet-body form">
                    <div class="form-body">                     
                        <div class="form-group">
                            
                        </div>
                        <div class="form-group">                            
                            <table class="table table-bordered  dt-responsive" width="100%">
                                <tr>
                                    <td> Date: <strong>{{ $data['date_of_attendance'] }}</strong> </td>
                                    <td> Total Absent: <strong>{{ count($data['student_absent']) }}</strong> </td>
                                    <td>
                                    <!--
                                    <a style="float:right;text-decoration: underline;" href="{{ url('/schoolAdmin/attendance/absentStudentsToday/1') }}" target="_blank">Genarate PDF</a>
                                    -->
                                    </td>
                                </tr>
                            </table>
                        </div>
                                    
                        <div class="form-group">
                             <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="table_1">
                                  <thead>
                                        <tr>                                            
                                            <th class="all">Serial </th>                                            
                                            <th class="min-phone-l">Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <div class="checkbox_wrapper">
                                        @php $i=1; @endphp
                                            @foreach($data['student_absent']  as $row)
                                            <tr>               
                                                <td>{{ $i }}</td>                                
                                                <td>{{ $row->admin_name}}</td>
                                            </tr>
                                           @php  $i++; @endphp
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

    <link href="{{ asset('/public')}}/metronic/global/plugins/bootstrap-datepickwer/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
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
    <script src="{{ asset('/public')}}/metronic/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="{{ asset('/public')}}/metronic/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="{{ asset('/public')}}/metronic/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
    <script src="{{ asset('/public')}}/metronic/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#table_1').dataTable({
                  "aoColumnDefs": [
                      { 'bSortable': false, 'aTargets': [-1] }
                   ]
            });
           
        });

    </script>
     <!-- BEGIN PAGE LEVEL SCRIPTS -->
      
        <!-- END PAGE LEVEL SCRIPTS -->
 @endsection 



