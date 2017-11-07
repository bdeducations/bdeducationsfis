@extends('layouts.admin')
@section('page_css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
<style type="text/css">
    tr.disabled_area{
        color:#ccc4c4;
    }
</style>
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Manage Area</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Area List</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Budget Area List</h3>
                    <a href="{{ url('/') }}/areas/createArea">
                        <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                            <i class="fa fa-plus"></i> Add New Area
                        </button>
                    </a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="ut_budget_area_list" class="table table-responsive table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Area Name</th>
                                    <th>Area Code</th>
                                    <th class="text-center">Sort Order</th>
                                    <th class="no-sort text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($data['all_areas'])
                                @foreach($data['all_areas'] as $row)
                                <tr <?php
                                if ($row->status == 0): echo "class='disabled_area'";
                                endif;
                                ?>>
                                    <td>{{ $row->title }}</td>
                                    <td>{{ $row->area_code }}</td>
                                    <td class="text-center">{{ $row->sort_order }}</td>
                                    <td class="text-center">
                                        <a href="{{ url('/') }}/areas/editArea/{{ $row->area_row_id }}">Edit | </a>
                                        <?php if ($row->status == 1): ?>
                                            <a title="Click For Inactive This Area" onclick="return confirm('Are you sure to inactive the area: <?php echo $row->title; ?>')" href="{{ url('/') }}/areas/deleteArea/{{ $row->area_row_id }}">Inactive</a>
                                        <?php else: ?>
                                            <a title="Click For Active This Area" onclick="return confirm('Are you sure to active the area: <?php echo $row->title; ?>')" href="{{ url('/') }}/areas/deleteArea/{{ $row->area_row_id }}">Active</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th> Area Name</th>
                                    <th> Area Code</th>
                                    <th class="text-center">Sort Order</th>
                                    <th class="no-sort text-center">Actions</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@section('page_js')
<!-- page script -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#ut_budget_area_list').DataTable({
            paging: true,
            lengthMenu: [[-1, 100, 50, 25], ["All", 100, 50, 25]],
            ordering: true,
            order: [[2, 'asc']],
            columnDefs: [{
                    targets: 'no-sort',
                    orderable: false
                }]
        });
    });
</script>
@endsection

@endsection
