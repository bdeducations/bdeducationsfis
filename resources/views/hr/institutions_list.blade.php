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
    <h1 class="left-main-heading-breadcum">Manage Institutions</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Manage Institutions</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Institutions  List</h3>
                    <a href="javascript:void(0)">
                        <button type="button" class="btn btn-primary pull-right" id="add_institution_link" style="margin-right: 5px;">
                            <i class="fa fa-plus"></i> Add New Institution
                        </button>
                    </a>
                </div>
                <div class="row" id="addInstitution" style="display:none">
                    <div class="col-md-10" col-md-offset-1>
                        <form role="form" method="POST" class="form-horizontal" action="{{ url('/') }}/hr/manage-institutions">
                            {!! csrf_field() !!}
                            <input type="hidden" name="institution_row_id" id="institution_row_id" />
                            <div class="col-md-3">
                                <label>Area</label>
                                <select name="area_row_id" id="area_row_id" class ="form-control" required="required">
                                    <option value="">Select Area</option>
                                    @foreach( $data['all_areas'] as $area_row)
                                    <option value="{{ $area_row->area_row_id }}">{{ $area_row->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Sector</label>
                                <select class="form-control" name="department_row_id" id="departments">
                                    <option value="">Select</option>
                                    @foreach($data['departments']  as $row)
                                        <option value="{{ $row->department_row_id }}">
                                            {{ $row->department_name }}
                                        </option>
                                    @endforeach                                     
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Institution Name </label>
                                <input type="text" name="institution_name" id="institution_name"  required  class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label>Short Name</label>
                                <input type="text" name="short_name" id="short_name"  class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-12" >
                                    <input type="submit" class="btn btn-primary pull-right" value="Submit" style="margin: 12px;margin-left: 3px">
                                    <input type="button" id="cancel" class="btn btn-danger pull-right" value="Cancel" style="margin-top: 12px">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="hr_designation_list" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Institution Name</th>
                                <th>Sector Name</th>
                                <th>Area</th>
                                <th>Short Name</th>
                                <th class="no-sort text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if( $data['institution_list'])
                                @foreach($data['institution_list'] as $row)
                                    <tr>
                                        <td>
                                            {{ $row->institution_name }}
                                        </td> 
                                          
                                         <td>
                                            @if(isset($row->sector_info->department_name) && $row->sector_info->department_name)
                                                {{ $row->sector_info->department_name }}
                                            @endif
                                        </td>   
                                        <td>
                                            @if(isset($row->area_name->title) && $row->area_name->title)
                                                {{ $row->area_name->title }}
                                            @endif
                                        </td> 
                                        <td>
                                            @if(isset($row->short_name) && $row->short_name)
                                                {{ $row->short_name }}
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
                                                    <li><a href="javascript:void(0)" class="edit" institution_row_id="{{ $row->institution_row_id }}" institution_name="{{ $row->institution_name }}" department_row_id="{{ $row->department_row_id }}"  @if(isset($row->area_row_id) && $row->area_row_id)
                                                    area_row_id="{{ $row->area_row_id }}"
                                                    @endif  @if(isset($row->short_name) && $row->short_name)
                                                    short_name="{{ $row->short_name }}"
                                                    @endif >Edit</a></li>
                                                    <li><a title="Click For Delete This designation" onclick="return confirm('Are you sure to delete the institution: <?php echo $row->institution_name; ?>')" href="{{ url('/') }}/hr/manage-institutions/delete/{{ $row->institution_row_id }}">Delete</a></li>
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
    $('#addInstitution').toggle();
});

$('#add_institution_link') .click( function() {  
 $('#addInstitution').toggle();
    $('#area_row_id').val('');
    $('#designation_row_id').empty();
    $('#institution_name').val('');
    $('#departments').val('');
    $('#short_name').val('');
});

$('.edit') .click( function() {
 var area_row_id = $(this).attr('area_row_id');
 var institution_row_id = $(this).attr('institution_row_id');
 var institution_name =  $(this).attr('institution_name');
 var department_row_id = $(this).attr('department_row_id');
 var short_name = $(this).attr('short_name');
 $('#area_row_id').val(area_row_id);
 $('#institution_row_id').val(institution_row_id);
 $('#institution_name').val(institution_name);
 $('#departments').val(department_row_id);
 $('#short_name').val(short_name);
 $('#addInstitution').show();
 $('html, body').animate({scrollTop: '0px'}, 0);

});

</script>
@endsection
@endsection