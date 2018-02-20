@extends('layouts.admin')
@section('page_css')
<style type="text/css">
    content{
        text-align :left;
    }
</style>
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/iCheck/minimal/_all.css">
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Leave Management</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Leave Management</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Leave Record List</h3>
                    <a href="javascript:void(0)">
                        <button type="button" class="btn btn-primary pull-right" id="add_new_leave_record" >
                            <i class="fa fa-plus"></i> Add New Leave Record
                        </button>
                    </a>
                </div>
                <!-- form start -->
                <div id="leave_record_form" style="display: none">
                    <form role="form" method="POST" class="form-horizontal" action="{{ url('/') }}/hr/employee-leave/create" >
                        {!! csrf_field() !!}
                        <input type="hidden" name="leave_record_row_id" id="leave_record_row_id">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="head_row_id" class="col-md-5 control-label">Department <span class="input-required-asterik">*</span></label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="department_row_id" id="department_row_id" required>
                                                <option value="">Select</option>
                                                @foreach($data['departments']  as $row)
                                                    <option value="{{ $row->department_row_id }}">
                                                        {{ $row->department_name }}
                                                    </option>
                                                @endforeach                                     
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="head_row_id" class="col-md-3 control-label">Employee <span class="input-required-asterik">*</span></label>
                                        <div class="col-md-7">
                                            <select class="form-control" required name="employee_row_id" id="employee_row_id">
                                                        
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="budget_year" class="col-md-5 control-label">Date<span class="input-required-asterik">*</span></label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control pull-right" required name="date_from" id="datepicker1" style="margin-bottom: 0px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="head_row_id" class="col-md-3 control-label">To <span class="input-required-asterik">*</span></label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control pull-right" required name="date_to" id="datepicker2" style="margin-bottom: 0px;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="budget_year" class="col-md-5 control-label">Total Days<span class="input-required-asterik">*</span></label>
                                        <div class="col-md-7">
                                            <input type="text" required name="total_days" id="total_days" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="budget_year" class="col-md-3 control-label">Days Left</label>
                                        <div class="col-md-7">
                                            <input type="text" name="days_left" id="days_left" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="head_row_id" class="col-md-5 control-label">Leave Type <span class="input-required-asterik">*</span></label>
                                        <div class="col-md-7">
                                            <select class="form-control employee_row_id" name="leave_type" id="leave_type" required>
                                                <option value=""> Select</option>
                                                <option value="1"> Casual</option>
                                                <option value="2"> Sick</option>
                                                <option value="3"> On Tour</option>
                                                <option value="4"> Unauthorized</option>        
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Authorized" class="col-md-3 control-label">Authorized<span class="input-required-asterik">*</span></label>
                                        <div class="col-md-2">
                                            <input type="checkbox" checked class="minimal" name="is_authorized" style="margin-top: 10px;" id="is_authorized"  >
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="budget_year" class="col-md-5 control-label">Comment</label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" name="comment" id="comment" style="width: 280px;"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 20px;">
                                <div class="col-md-11">
                                    <input type="submit" class="btn btn-primary pull-right" value="Submit" style="margin-left: 5px">
                                    <input type="button" id="cancel" class="btn btn-danger pull-right" value="Cancel" >
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @if($data['leave_records'])
                <div style="padding: 5px;">
                    <table id="UT_jakat_allocation_list" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th>Name</th>
                                <th>Leave Type</th>
                                <th style="min-width: 45px;">From</th>
                                <th style="min-width: 45px;">To</th>
                                <th class="text-center">Total days</th>
                                <th>Contact</th>
                                <th class="no-sort text-center" style="min-width: 70px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; ?>
                            @foreach($data['leave_records'] as $row)
                                <tr>
                                    <td><?php echo $i.'.'; ?></td>
                                    <td>
                                        {{  isset($row->employeeDetails->employee_name) ? $row->employeeDetails->employee_name : ''  }}
                                    </td>
                                    <td>
                                        @if($row->leave_type == 1) Casual leave @endif

                                        @if($row->leave_type == 2) Sick @endif

                                        @if($row->leave_type == 3) On Tour @endif

                                        @if($row->leave_type == 4) Unauthorized @endif

                                    </td>
                                    <td>
                                       {{ date('d-m-Y', strtotime( $row->leave_date_from )) }}
                                    </td>
                                    <td>
                                        @if(isset($row->leave_date_to)) {{ date('d-m-Y', strtotime( $row->leave_date_to )) }}@endif
                                    </td>
                                    <td class="text-center">
                                        @if(isset($row->number_of_days)) {{ $row->number_of_days }} @endif
                                    </td>
                                    <td>
                                        @if(isset($row->employeeDetails->contact_1)) {{ $row->employeeDetails->contact_1 }} @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-flat">Action</button>
                                            <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="javascript:void(0)" class="edit"
                                                leave_record_row_id="{{ $row->leave_record_row_id }}"   employee_row_id = "{{ $row->employee_row_id }}" leave_type="{{ $row->leave_type }}" date_from="{{ $row->leave_date_from }}" is_authorized="{{ $row->is_authorized }}" total_days = "{{ $row->number_of_days }}" @if(isset($row->employeeDetails->department_row_id))
                                                department_row_id="{{ $row->employeeDetails->department_row_id }}" @endif 

                                                @if(isset($row->leave_date_to) && $row->leave_date_to)
                                                date_to="{{ $row->leave_date_to }}"
                                                @endif @if(isset($row->comment) && $row->comment)
                                                comment="{{ $row->comment }}"
                                                @endif >Edit</a></li>
                                                <li><a onclick="return confirm('Are you sure to delete this record')" href="{{ url('/') }}/hr/employee-leave/{{ $row->leave_record_row_id }}/delete">Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php $i++; ?>  
                            @endforeach
                        </tbody>
                    </table>
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
        $('#UT_jakat_allocation_list').DataTable({
            paging: true,
            lengthMenu: [[-1, 100, 50, 25], ["All", 100, 50, 25]],
            ordering: false,
            columnDefs: [{
                    targets: 'no-sort',
                    orderable: false
                }]
        });
    });

    $('#add_new_leave_record') .click( function() {  
        $('#leave_record_form').toggle();
        $('#leave_record_row_id').val('');
        $('#area_row_id').val('');
        $('#department_row_id').val('');
        $('#institution_row_id').val('');
        $('#employee_row_id').val('');
        $('#leave_type').val('');
        $('#datepicker1').val('');
        $('#datepicker2').val('');
        $('#comment').val('');
    });

    $('#cancel'). click(function(){
        $('#leave_record_form').toggle();
    });

    
    $("#department_row_id").change(function(e){
            var department_row_id = $(this).val();
            $('#employee_row_id').empty('');
            $.ajax({
                url: "{{ url('getEmployeeList/') }}"+ '/'+ department_row_id,
                type: "GET",
                dataType: "html",
                success: function(data){
                    $('#employee_row_id').append(data);
                }
            });
        });

    $("#employee_row_id").change(function(e){
        var employee_row_id = $(this).val();
        $('#days_left').empty('');
        $.ajax({
                url: "{{ url('getNumberOfLeaveLeft/') }}"+ '/'+ employee_row_id,
                type: "GET",
                dataType: "html",
                success: function(data){
                    $('#days_left').val(data);
                }
            });

    }); 


     $('.edit') .click( function() {
        var leave_record_row_id = $(this).attr('leave_record_row_id');
         var area_row_id = $(this).attr('area_row_id');
         var department_row_id =  $(this).attr('department_row_id');
         var institution_row_id = $(this).attr('institution_row_id');
         var employee_row_id = $(this).attr('employee_row_id');
         var leave_type = $(this).attr('leave_type');
         var is_authorized = $(this).attr('is_authorized');
         var date_from = $(this).attr('date_from');
         var date_to = $(this).attr('date_to');
         var comment = $(this).attr('comment');
         var total_days = $(this).attr('total_days');
         $('#leave_record_row_id').val(leave_record_row_id);
         $('#department_row_id').val(department_row_id);
         $('#employee_row_id').val(employee_row_id);
         $('#leave_type').val(leave_type);
         
         if(is_authorized == 0)
         {
            $('#is_authorized').prop('checked', false);
         }
         else{
            $('#is_authorized').prop('checked', true);
         }

         $('#total_days').val(total_days);
         $('#datepicker1').val(date_from);
         $('#datepicker2').val(date_to);
         $('#comment').val(comment);
         $('#leave_record_form').show();
         $('html, body').animate({scrollTop: '0px'}, 0);
            $.ajax({
                url: "{{ url('getEmployeeList/') }}"+ '/'+ department_row_id + '/' + employee_row_id,
                type: "GET",
                dataType: "html",
                success: function(data){
                    $('#employee_row_id').append(data);
                }
            });


          $('#employee_row_id').val(employee_row_id);
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

<script type="text/javascript">
    $("#datepicker2").change(function(e){
            var from_date = $("#datepicker1").val();
            console.log(m_from_date);
            var to_date = $("#datepicker2").val();
            var diffDays = to_date.getDate() - from_date.getDate();
            $('#total_days').empty('');
            $.ajax({
                success: function(data){
                    $('#total_days').append(diffDays);
                }
            });
        });
    
</script>

@endsection
