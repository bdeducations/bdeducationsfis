@extends('layouts.admin')
@section('page_css')
<!-- DataTables -->
<style type="text/css">
    content{
        text-align :left;
    }
</style>
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Manage Department</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Manage Department</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Department List</h3>
                    <a href="javascript:void(0)">
                        <button type="button" class="btn btn-primary pull-right" id="add_department_link" style="margin-right: 5px;">
                            <i class="fa fa-plus"></i> Add New Department
                        </button>
                    </a>
                </div>
                <div class="row" id="addDepartment" style="display:none">
                    <div class="col-md-8 col-md-offset-2">
                        <form role="form" method="POST" class="form-horizontal" action="{{ url('/') }}/hr/manage-departments" style="margin-left: 50px;">
                            {!! csrf_field() !!}
                            <input type="hidden" name="department_row_id" id="department_row_id" />
                            <div class="col-md-4">
                                <label>Department Name</label>
                                <input type="text" name="department_name" id="department_name"  required  style="height: 35px;width: 200px; padding-left: 10px">
                            </div>
                            <div class="col-md-3" >
                                <label style="margin-left: 0px;"> Sort Order </label>
                                <input type="number" name="sort_order" id="sort_order" required  style="height: 35px;width: 150px; padding-left: 10px; margin-left: 0px;" >
                            </div>
                            
                            <div class="col-md-5">
                                <input type="submit" class="btn btn-primary" value="Submit" style="margin:25px 0px;">
                                <input type="button" id="cancel" class="btn btn-danger" value="Cancel" style="margin-left: 5px;">
                            </div>
                            
                        </form>
                    </div>
                </div>
                <div class="row" id="addDepartment" style="display: none">
                    <div class="col-md-8 col-md-offset-2">
                        <form role="form" method="POST" class="form-horizontal" action="{{ url('/') }}/hr/manage-departments" style="margin-left: 50px;">
                            {!! csrf_field() !!}
                            <input type="hidden" name="department_row_id" id="department_row_id" />
                            <div class="col-md-4">
                                <label>Department Name </label>
                                <input type="text" name="department_name" id="department_name"  required  style="height: 35px;width: 200px;margin-left: 20px; padding-left: 10px">
                            </div>
                            <div class="col-md-4">
                                <label>Sort Order</label>
                                <input type="number" name="sort_order" id="sort_order" required  style="height: 35px;width: 100px;margin-left: 20px; padding-left: 10px">
                            </div>
                            <div class="col-md-4">
                                <input type="submit" class="btn btn-primary" value="Submit" style="margin-left: 5px;">
                                <input type="button" id="cancel" class="btn btn-danger" value="Cancel" style="margin-left: 5px;">
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="UT_jakat_allocation_list" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Department Name</th>
                                <th>Sort Order</th>
                                <th class="no-sort text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if( $data['departments_list'])
                                @foreach($data['departments_list'] as $row)
                                    <tr>
                                        <td>
                                            {{ $row->department_name }}
                                        </td>
                                        <td>
                                            @if(isset($row->sort_order) && $row->sort_order)
                                                {{ $row->sort_order }}
                                            @endif
                                        </td>                                        
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary btn-flat">Action</button>
                                                <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a href="javascript:void(0)" class="edit" department_row_id="{{ $row->department_row_id }}" department_name="{{ $row->department_name }}" @if(isset($row->sort_order) && $row->sort_order)
                                                    sort_order="{{ $row->sort_order }}"
                                                     @endif >Edit</a></li>
                                                    <li><a title="Click For Delete This designation" onclick="return confirm('Are you sure to delete the department: <?php echo $row->department_name; ?>')" href="{{ url('/') }}/hr/manage-departments/delete/{{ $row->department_row_id }}">Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@section('page_js')
<!-- page script -->
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
$('#cancel'). click(function(){
    $('#addDepartment').toggle();
    $('#department_name').empty();
    $('#sort_order').empty();
});

$('#add_department_link') .click( function() {  
 $('#addDepartment').toggle();
    $('#department_name').val('');
    $('#sort_order').val('');
});

$('.edit') .click( function() {
 var department_row_id = $(this).attr('department_row_id');
 var department_name =  $(this).attr('department_name');
 var sort_order = $(this).attr('sort_order');
 $('#department_row_id').val(department_row_id);
 $('#department_name').val(department_name);
 $('#sort_order').val(sort_order);
 $('#addDepartment').show();
 $('html, body').animate({scrollTop: '0px'}, 0);
});

</script>
@endsection
@endsection