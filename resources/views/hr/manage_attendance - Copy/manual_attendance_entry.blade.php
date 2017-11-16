@extends('layouts.admin')
@section('page_css')
<style type="text/css">
    
</style>
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Manual Attendance</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Attendance Management</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <!-- form start -->
                @if(!$data['search_result'])
                <form role="form" method="POST" class="form-horizontal" action="{{ url('/') }}/hr/attendance/manual-attendance" >
                    {!! csrf_field() !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="budget_year" class="col-md-5 control-label">Select Employee of Area<span class="input-required-asterik">*</span></label>
                                    <div class="col-md-7">
                                        <select name="area_row_id" id="area_row_id" class ="form-control" required="required">
                                            <option value="">Select Area</option>
                                            <option value="-1" @if(isset($data['selected_area_row_id']) && $data['selected_area_row_id'] == -1) selected="selected"  @endif>All Area</option>
                                            @foreach( $data['all_areas'] as $area_row)
                                            <option value="{{ $area_row->area_row_id }}" @if(isset($data['selected_area_row_id']) && $area_row->area_row_id == $data['selected_area_row_id']) selected="selected"  @endif>{{ $area_row['title'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="head_row_id" class="col-md-3 control-label">Attendance Date <span class="input-required-asterik"></span></label>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control pull-right" name="date_of_attendance" id="datepicker2" required="" style="margin-bottom: 0px;">
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                    <div class="row">
                        <div class="col-md-11">
                            <button type="submit" class="btn btn-primary pull-right">Submit</button>
                        </div>
                    </div>
                </div>
                    <!-- /.box-footer -->
                </form>
                @endif
               
                    <!-- /.box-body -->
                    <!-- /.box-header -->
                @if($data['search_result'])
                <div class="box-body">
                    <div style="font-weight: bold;padding:10px">Attendance Date: {{ $data['date_of_attendance'] }}</div>
                <form role="form" id="attendance_form" method="post" action="{{ url('/') }}/hr/attendance/store-attendance">
                    {!! csrf_field() !!}
                 <input type="hidden" name="date_of_attendance" value="{{ $data['date_of_attendance'] }}">

                  @php $i=1; @endphp
                  @if( $data['employee_list'])
                    @foreach($data['employee_list'] as $key=>$row)

                    <table id="UT_jakat_allocation_list_{{$i}}" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                              <th class="text-center" colspan="6" style="font-size: 22px">{{ $key }}</th>
                            </tr>
                            <tr>
                              <th class="text-center">Name</th>
                              <th class="text-center">ID</th>
                              <th class="no-sort text-center">Is Present</th>
                             
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($row as $info)
                          <tr>
                              <td>
                                  {{ $info->employee_name }}
                              </td>
                              <td>
                                 {{ $info->employee_id }}
                              </td>
                              <td>
                                <input type="checkbox" name="is_present[{{ $info->employee_name }}]" value="1" checked="checked">
                              </td>
                              
                          </tr>
                          @endforeach
                        </tbody>
                    </table>
                    @php $i++; @endphp
                    @endforeach
                  @endif
                  <div class="box-footer">
                    <div class="row">
                        <div class="col-md-11">
                            <button type="submit" class="btn btn-primary pull-right">Submit</button>
                        </div>
                    </div>
                </div>
                    <!-- /.box-footer -->
                
                </form>
                </div>
                @endif
                
            </div>
        </div>
    </div>
</section>
@endsection
@section('page_js')
<!-- page script -->
<!-- bootstrap datepicker -->
<script src="{{ url('/')}}/public/adminlte/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        @if($data['search_result'])
            @php $i=1; @endphp
            @if( $data['employee_list'])
                @foreach($data['employee_list'] as $key=>$row)
                    $('#UT_jakat_allocation_list_{{ $i }}').DataTable({
                    paging: true,
                    lengthMenu: [[-1, 100, 50, 25], ["All", 100, 50, 25]],
                    ordering: false,
                    columnDefs: [{
                            targets: 'no-sort',
                            orderable: false
                        }]
                    });
                    @php $i++; @endphp
                @endforeach
            @endif
        @endif
    });

</script>
<script type="text/javascript">
     $(function () {
    
    //Date picker
    $('#datepicker1').datepicker({
      autoclose: true
    })  
  })    
</script>

<script type="text/javascript">
     $(function () {
    
    //Date picker
    $('#datepicker2').datepicker({
      autoclose: true
    })  
  })    
</script>
@endsection
