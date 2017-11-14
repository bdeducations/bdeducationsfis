@extends('layouts.admin')
@section('page_css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Manage Budget Allocation</h1>
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
                    <a href="{{ url('/') }}/createAllocation">
                        <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                            <i class="fa fa-plus"></i> Add New Allocation
                        </button>
                    </a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="UT_budget_allocation_list" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Head Name</th>
                                <th class="text-center">Amount</th>
                                <th class="no-sort text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($data['all_heads'])
                            <?php
                            $parent_serial = 1;
                            $parent_total_allocation = 0;
                            ?>
                            @foreach($data['all_heads'] as $row)
                            @if($row->parent_id == 0)
                            <tr>
                                <td style="text-align:left;padding-left:10px">
                                    <strong style="font-size:15px !important;">
                                        <span>{{ $parent_serial }}&nbsp;.&nbsp;</span>
                                        <?php $parent_serial++; ?>
                                        {{ $row->title }}
                                    </strong>
                                </td>
                                <td class="text-center">
                                    @if(isset($row->parent_head_total_allocation) && ($row->parent_head_total_allocation != 0))
                                    {{ number_format($row->parent_head_total_allocation, 2) }}
                                    @else
                                    0.00
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(isset($row->parent_head_total_allocation) && ($row->parent_head_total_allocation != 0))
                                    <a href="{{ url('/') }}/allocationDetails/{{ $row->head_row_id }} "> Details </a>
                                    @endif
                                </td>
                            </tr>
                            @endif
                            @endforeach
                            <tr>
                                <td>
                                    <strong>&nbsp;Grand Total(All Areas): </strong>
                                </td>
                                <td class="text-center"><strong>{{ number_format($data['grand_total_allocation'], 2) }}</strong></td>
                                <td></td>
                            </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Head Name</th>
                                <th class="text-center">Amount</th>
                                <th class="no-sort text-center">Actions</th>
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
        $('#UT_budget_allocation_list').DataTable({
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