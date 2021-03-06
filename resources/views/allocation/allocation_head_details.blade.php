@extends('layouts.admin')
@section('page_css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">{{  $data['head_name'] }}</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Allocation List</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Budget Allocation List</h3>
                    <a href="{{ url('/') }}/budgetAllocation">
                        <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                            <i class="fa fa-plus"></i> Back Allocation
                        </button>
                    </a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="UT_budget_details_allocation_list" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Area Name</th>
                                <th class="text-center">Amount</th>
                                <th class="no-sort text-center">Allocation Date</th>
                                <th class="no-sort text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($data['allocation_list'])
                            @foreach($data['allocation_list'] as $row)
                            <tr>
                                <td style="text-align:left;padding-left:10px">
                                    {{ $row->title }}
                                </td>
                                <td class="text-center">{{ $row->amount ? number_format($row->amount, 2) : '' }}</td>
                                <td class="text-center">
                                   <?php echo date('F j, Y', strtotime($row->allocation_at)); ?>
                                </td>
                                <td class="text-center">
                                    @if($row->remarks)
                                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="{{ $row->remarks }}">Remarks | </a>
                                    @endif
                                    <a href="{{ url('/') }}/allocation/edit/{{ $row->allocation_row_id }}">Edit | </a>
                                    <a onclick="return confirm('Are you sure to delete the allocation')" href="{{ url('/') }}/allocation/delete/{{ $row->allocation_row_id }}">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Head Name</th>
                                <th class="text-center">Amount</th>
                                <th class="no-sort text-center">Allocation Date</th>
                                <th class="no-sort text-center">Action</th>
                            </tr>
                        </tfoot>
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
        $('#UT_budget_details_allocation_list').DataTable({
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
