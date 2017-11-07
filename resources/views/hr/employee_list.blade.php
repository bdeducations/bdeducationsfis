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
    <h1 class="left-main-heading-breadcum">Manage Employee</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Employee List</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Employee List</h3>
                    <a href="{{ url('/') }}/manage-employee/create">
                        <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                            <i class="fa fa-plus"></i> Add New Employee
                        </button>
                    </a>


                    <form role="form" method="POST" class="form-horizontal" action="{{ url('/') }}/manage-employee/search" >
                    {!! csrf_field() !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="area_row_id" class="col-md-5 control-label">Select Department <span class="input-required-asterik">*</span></label>
                                        <div class="col-md-7">
                                            <select class="form-control" required name="department_row_id" id="departments">
                                                <option value="">Select</option>
                                                <option value="-1" @if ($data['department_row_id'] == -1) selected="selected" @endif>All</option>
                                                @foreach($data['departments']  as $row)
                                                    <option value="{{ $row->department_row_id }}" @if ($data['department_row_id'] == $row->department_row_id) selected="selected" @endif>
                                                        {{ $row->department_name }}
                                                    </option>
                                                @endforeach                                     
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <div class="col-md-7">
                                            <button type="submit" class="btn btn-primary pull-left">Search</button>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                                                      
                        </div>
                    </div>
                    <!-- /.box-body -->
                    
                    <!-- /.box-footer -->
                </form>

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @if($data['search_result'] == 1)
                        @if( $data['list_all'] == 1)
                            <table id="UT_jakat_allocation_list" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width:20%">Name</th>
                                        <th style="width:20%;">Department</th>
                                        <th style="width:20%">Designation</th>
                                        <th style="width:25%;text-align: center;">Contact</th>
                                        <th style="width:20%" class="no-sort text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if( $data['employee_list'])
                                        @foreach($data['employee_list'] as $row)
                                            <tr>
                                                <td>
                                                    {{ $row->employee_name }}
                                                </td>
                                                <td style="width:20%; ">
                                                   @if(isset($row->employeeDepartment->department_name)&& $row->employeeDepartment->department_name) {{ $row->employeeDepartment->department_name }} @endif
                                                </td>

                                                <td>
                                                    @if(isset($row->employeeDesignation->designation_name)) {{ $row->employeeDesignation->designation_name }} @endif
                                                </td>
                                                <td style="width:25%;text-align: center;">
                                                   {{ $row->contact_1 }}
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-primary btn-flat">Action</button>
                                                        <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">
                                                            <span class="caret"></span>
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href="{{ url('/') }}/manage-employee/{{ $row->employee_row_id }}/edit">Edit</a></li>
                                                            
                                                            <li><a href="{{ url('/') }}/manage-employee/{{ $row->employee_row_id }}/employeeDetailsPdf" target="_blank">PDF</a></li>
                                                            <li><a href="#">Inactive</a></li>
                                                            <li><a href="{{ url('/') }}/hr/manage-employee/{{ $row->employee_row_id }}/download">Documents</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        @else
                        <table id="UT_jakat_allocation_list" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width:30%">Name</th>
                                    <th style="width:25%">Designation</th>
                                    <th style="width:25%;text-align: center;">Contact</th>
                                    <th style="width:20%" class="no-sort text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if( $data['employee_list'])
                                    @foreach($data['employee_list'] as $row)
                                        <tr>
                                            <td>
                                                {{ $row->employee_name }}
                                            </td>
                                            

                                            <td>
                                                @if(isset($row->employeeDesignation->designation_name)) {{ $row->employeeDesignation->designation_name }} @endif
                                            </td>
                                            <td style="width:25%;text-align: center;">
                                               {{ $row->contact_1 }}
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-primary btn-flat">Action</button>
                                                    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">
                                                        <span class="caret"></span>
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="{{ url('/') }}/manage-employee/{{ $row->employee_row_id }}/edit">Edit</a></li>
                                                        
                                                        <li><a href="{{ url('/') }}/manage-employee/{{ $row->employee_row_id }}/employeeDetailsPdf" target="_blank">PDF</a></li>
                                                        <li><a href="#">Inactive</a></li>
                                                        <li><a href="{{ url('/') }}/hr/manage-employee/{{ $row->employee_row_id }}/download">Documents</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>    
                        @endif
                    @endif
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
</script>
@endsection
@endsection