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
    <h1 class="left-main-heading-breadcum">Performance Management</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Performance Management</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Performance Record List</h3>
                    <a href="javascript:void(0)">
                        <button type="button" class="btn btn-primary pull-right" id="add_new_performance_record" >
                            <i class="fa fa-plus"></i> Add New Performance Record
                        </button>
                    </a>
                </div>
                <!-- form start -->
                <div id="performance_record_form" style="display: none">
                    <form role="form" method="POST" class="form-horizontal" action="{{ url('/') }}/hr/employee-performance/store" >
                        {!! csrf_field() !!}
                        <input type="hidden" name="employee_performance_comment_row_id" id="employee_performance_comment_row_id">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-8">
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
                                
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="head_row_id" class="col-md-5 control-label">Employee <span class="input-required-asterik">*</span></label>
                                        <div class="col-md-7">
                                            <select class="form-control" required name="employee_row_id" id="employee_row_id">
                                                        
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="budget_year" class="col-md-5 control-label">Performance Note</label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" name="comment_text" id="comment_text" style="width: 405px;height: 80px;"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 20px;">
                                <div class="col-md-8">
                                    <input type="submit" class="btn btn-primary pull-right" value="Submit" style="margin-left: 5px">
                                    <input type="button" id="cancel" class="btn btn-danger pull-right" value="Cancel" >
                                </div>
                            </div>
                        </div>
                    </form>
                </div>  
                @if( $data['performance_records'])
                <div style="padding: 5px;">
                    <table id="UT_jakat_allocation_list" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th width="20%">Name</th>
                                <th>Performance</th>
                                <th class="no-sort text-center" style="min-width: 70px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; ?>
                            @foreach($data['performance_records'] as $row)
                                <tr>
                                    <td><?php echo $i.'.'; ?></td>
                                    <td>{{ $row->employee_name }}</td>
                                    <td>{{ $row->comment_text }}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-flat">Action</button>
                                            <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="javascript:void(0)" class="edit" employee_performance_comment_row_id="{{ $row->employee_performance_comment_row_id }}"  department_row_id ="{{ $row->department_row_id }}" employee_row_id = "{{ $row->employee_row_id }}"  comment_text = "{{ $row->   comment_text }}">Edit</a></li>

                                                <li><a onclick="return confirm('Are you sure to delete this record')" href="{{ url('/') }}/hr/employee-performance/delete/{{ $row->employee_performance_comment_row_id }}">Delete</a></li>
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

    $('#add_new_performance_record') .click( function() {  
        $('#performance_record_form').toggle();
        $('#leave_record_row_id').val('');
        $('#department_row_id').val('');
        $('#employee_row_id').val('');
        $('#comment_text').val('');
    });

    $('#cancel'). click(function(){
        $('#performance_record_form').toggle();
    });

    $("#area_row_id").change(function(e){
        $('#employee_row_id').empty('');
        $('#department_row_id').val(''); 
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


    $('.edit') .click( function() {
        var employee_performance_comment_row_id = $(this).attr('employee_performance_comment_row_id');
         var department_row_id =  $(this).attr('department_row_id');
         var employee_row_id = $(this).attr('employee_row_id');
         var comment_text = $(this).attr('comment_text');
         $('#employee_performance_comment_row_id').val(employee_performance_comment_row_id);
         $('#department_row_id').val(department_row_id);
         $('#employee_row_id').val(employee_row_id);
         $('#comment_text').val(comment_text);
         $('#performance_record_form').show();
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
@endsection
