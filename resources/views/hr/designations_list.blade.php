@extends('layouts.admin')
@section('page_css')
<style type="text/css">
    content{
        text-align :left;
    }
</style>
<!-- DataTables -->
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Manage Designation</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Manage Designation</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Designation  List</h3>
                    <a href="javascript:void(0)">
                        <button type="button" class="btn btn-primary pull-right" id="add_designation_link" style="margin-right: 5px;">
                            <i class="fa fa-plus"></i> Add New Desgination
                        </button>
                    </a>
                </div>
                <div class="row" id="addDesgination" style="display:none">
                    <div class="col-md-10 col-md-offset-1">
                        <form role="form" method="POST" class="form-horizontal" action="{{ url('/') }}/hr/manage-designations" style="margin-left: 50px;">
                            {!! csrf_field() !!}
                            <input type="hidden" name="designation_row_id" id="designation_row_id" />
                            <div class="col-md-3">
                                <label>Sector</label>
                                <select class="form-control" required name="department_row_id" id="departments">
                                    <option value="">Select</option>
                                    @foreach($data['departments']  as $row)
                                        <option value="{{ $row->department_row_id }}">
                                            {{ $row->department_name }}
                                        </option>
                                    @endforeach                                     
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Designation Name </label>
                                <input type="text" required name="designation_name" id="designation_name" style="height: 35px;width: 200px; padding-left: 10px">
                            </div>
                            <div class="col-md-2">
                                <label style="margin-left: 10px;">Sort Order</label>
                                <input type="number" name="sort_order" id="sort_order"  style="height: 35px;width: 100px;margin-left: 10px; padding-left: 10px">
                            </div>
                            <div class="col-md-4">
                                <input type="submit" class="btn btn-primary" value="Submit" style="margin:25px 0px;">
                                <input type="button" id="cancel" class="btn btn-danger" value="Cancel" style="margin-left: 5px;">
                            </div>  
                        </form>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="hr_designation_list" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Desgination Name</th>
                                <th>Sector Name</th>
                                <th>Sort Order</th>
                                <th >Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if( $data['designations_list'])
                                @foreach($data['designations_list'] as $row)
                                    <tr>
                                        <td>
                                            {{ $row->designation_name }}
                                        </td>    
                                        <td>
                                            @if(isset($row->department_info->department_name) && $row->department_info->department_name)
                                                {{ $row->department_info->department_name }}
                                            @endif
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
                                                    <li><a href="javascript:void(0)" class="edit" designation_row_id="{{ $row->designation_row_id }}" designation_name="{{ $row->designation_name }}" department_row_id="{{ $row->department_row_id }}" @if(isset($row->sort_order) && $row->sort_order)
                                                    sort_order="{{ $row->sort_order }}"
                                                    @endif >Edit</a></li>
                                                    <li><a title="Click For Delete This designation" onclick="return confirm('Are you sure to delete the designation: <?php echo $row->designation_name; ?>')" href="{{ url('/') }}/hr/manage-designations/delete/{{ $row->designation_row_id }}">Delete</a></li>
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
        $('#hr_designation_list').DataTable({
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
        $('#addDesgination').toggle();
    });

    $('#add_designation_link') .click( function() {  
     $('#addDesgination').toggle();
        $('#designation_row_id').empty();
        $('#designation_name').val('');
        $('#departments').val('');
        $('#sort_order').val('');
    });

    $('.edit') .click( function() {
        var designation_row_id = $(this).attr('designation_row_id');
        var designation_name =  $(this).attr('designation_name');
        var department_row_id = $(this).attr('department_row_id');
        var sort_order = $(this).attr('sort_order');
        $('#designation_row_id').val(designation_row_id);
        $('#designation_name').val(designation_name);
        $('#departments').val(department_row_id);
        $('#sort_order').val(sort_order);
        $('#addDesgination').show();
        $('html, body').animate({scrollTop: '0px'}, 0);
    });
</script>
@endsection
@endsection