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
    <h1 class="left-main-heading-breadcum">Manage Salary Head</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Salary Heads List</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Salary Head  List</h3>
                    <a href="javascript:void(0)">
                        <button type="button" class="btn btn-primary pull-right" id="add_head_link" style="margin-right: 5px;">
                            <i class="fa fa-plus"></i> Add New Head
                        </button>
                    </a>
                </div>
                <div class="row" id="addHead" style="display:none">
                    <div class="col-md-8 col-md-offset-2">
                        <form role="form" method="POST" class="form-horizontal" action="{{ url('/') }}/hr/salary-heads" style="margin-left: 50px;">
                            {!! csrf_field() !!}
                            <input type="hidden" name="salary_head_row_id" id="salary_head_row_id" />
                            <div class="col-md-4">
                                <label>Head Name</label>
                                <input type="text" name="salary_head_name" id="salary_head_name"  required  style="height: 35px;width: 200px; padding-left: 10px">
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
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="hr_head_list" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Head Name</th>
                                <th>Sort Order</th>                              
                                <th class="no-sort text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if( $data['salary_heads'])
                                @foreach($data['salary_heads'] as $row)
                                    <tr>
                                       <td>
                                            {{ $row->salary_head_name }}
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
                                                    <li><a href="javascript:void(0)" class="edit" salary_head_row_id="{{ $row->salary_head_row_id }}" salary_head_name="{{ $row->salary_head_name }}" @if(isset($row->sort_order) && $row->sort_order)
                                                    sort_order="{{ $row->sort_order }}"
                                                     @endif >Edit</a></li>
                                                    <li><a title="Click For Delete This head" onclick="return confirm('Are you sure to delete the head: <?php echo $row->salary_head_name; ?>')" href="{{ url('/') }}/hr/salary-heads/delete/{{ $row->salary_head_row_id }}">Delete</a></li>
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
        $('#hr_head_list').DataTable({
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
    $('#addHead').toggle();
    $('#salary_head_name').empty();
    $('#sort_order').empty();
});

$('#add_head_link') .click( function() {  
 $('#addHead').toggle();
    $('#salary_head_name').val('');
    $('#sort_order').val('');
});

$('.edit') .click( function() {
 var salary_head_row_id = $(this).attr('salary_head_row_id');
 var salary_head_name =  $(this).attr('salary_head_name');
 var sort_order = $(this).attr('sort_order');
 $('#salary_head_row_id').val(salary_head_row_id);
 $('#salary_head_name').val(salary_head_name);
 $('#sort_order').val(sort_order);
 $('#addHead').show();
 $('html, body').animate({scrollTop: '0px'}, 0);
});

</script>
@endsection
@endsection