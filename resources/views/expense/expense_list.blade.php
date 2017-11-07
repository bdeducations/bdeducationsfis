@extends('layouts.admin')
@section('page_css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Manage Budget Expense</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Expense List</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Budget Expense List</h3>
                    <a href="{{ url('/') }}/createExpense">
                        <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                            <i class="fa fa-plus"></i> Add New Expense
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
                            $grand_parent_child_number = 0;
                            $grand_parent_child_counter = 0;
                            $grand_parent_total_expense = 0;
                            $parent_child_number = 0;
                            $parent_child_counter = 0;
                            $parent_total_expense = 0;
                            ?>

                            @foreach($data['all_heads'] as $row)
                            <?php
                            if (isset($child_serial) && $child_serial > 26):
                                $child_serial = 1;
                            endif;
                            if (isset($grand_child_serial) && $grand_child_serial > 26):
                                $grand_child_serial = 1;
                            endif;
                            ?>
                            <tr>
                                <td style="text-align:left;padding-left:10px">
                                    @if($row->level == 0)
                                    <strong style="font-size:15px !important;">
                                        <?php
                                        $grand_parent_child_counter = 0;
                                        $child_serial = 1;
                                        if ($row->has_child == 1):
                                            $parent_child_number = $row->parent_head_child_number;
                                            $parent_total_expense = $row->parent_head_total_expense;
                                            $grand_parent_child_number = $row->parent_head_child_number;
                                            $grand_parent_total_expense = $row->parent_head_total_expense;
                                            $parent_child_counter = 0;
                                        endif;
                                        ?>
                                        <span>{{ $parent_serial }}&nbsp;.&nbsp;</span>
                                        <?php $parent_serial++; ?>
                                        @endif
                                        @if($row->level == 1)
                                        &nbsp;
                                        @if($row->has_child == 1)
                                            <strong>
                                        @endif
                                        <?php
                                        $grand_child_serial = 1;
                                        echo $data['alphabets'][$child_serial] . ".";
                                        $child_serial++;
                                        if ($row->has_child == 1):
                                            $parent_child_number = $row->parent_head_child_number;
                                            $parent_child_counter = 0;
                                            $parent_total_expense = $row->parent_head_total_expense;
                                            $grand_parent_child_counter++;
                                        else:
                                            $parent_child_counter++;
                                        endif;
                                        ?>
                                        &nbsp;
                                        @endif
                                        @if($row->level == 2)
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <?php
                                        echo $data['roman'][$grand_child_serial] . ".";
                                        $grand_child_serial++;
                                        $parent_child_counter++;
                                        ?>&nbsp;
                                        @endif
                                        @if($row->level == 3) &nbsp; &nbsp; &nbsp; - - - @endif
                                        @if($row->level == 4) &nbsp; &nbsp; &nbsp; &nbsp; - - - - @endif
                                        @if($row->level == 5) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  - - - - - @endif
                                        @if($row->level > 5)  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - - - @endif
                                        {{ $row->title }}
                                        @if($row->level == 1)
                                        @endif
                                        @if($row->level == 0) </strong>  @endif
                                        @if($row->level == 1)
                                            @if($row->has_child == 1)
                                            </strong>
                                            @endif
                                        @endif
                                </td>
                                <td class="text-center">
                                    @if(isset($row->total_expense) && ($row->total_expense != 0) && ($row->has_child == 0))
                                    {{ number_format($row->total_expense, 2) }}
                                    @elseif(empty($row->total_expense) && ($row->has_child == 0))
                                    0.00
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(isset($row->total_expense) && ($row->total_expense != 0) && ($row->has_child == 0))
                                    <a href="{{ url('/') }}/expenseDetails/{{ $row->head_row_id }} "> Details </a>
                                    @endif
                                </td>
                            </tr>
                            <?php if (($parent_child_number == $parent_child_counter) && ($row->level == 1) && ($row->has_child == 0) && ($parent_total_expense != 0)): ?>
                                <tr>
                                    <td>
                                        <strong>&nbsp;&nbsp;&nbsp;Total: </strong>
                                    </td>
                                    <td class="text-center"><strong>{{ number_format($parent_total_expense, 2) }}</strong></td>
                                    <td></td>
                                </tr>
                            <?php endif; ?>
                            <?php if (($parent_child_number == $parent_child_counter) && ($row->level == 2) && ($row->has_child == 0) && ($parent_total_expense != 0)): ?>
                                <tr>
                                    <td>
                                        <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total: </strong>
                                    </td>
                                    <td class="text-center"><strong>{{ number_format($parent_total_expense, 2) }}</strong></td>
                                    <td></td>
                                </tr>
                            <?php endif; ?>
                            <?php if (($grand_parent_child_number == $grand_parent_child_counter) && ($parent_child_number == $parent_child_counter) && ($row->level == 2) && ($row->has_child == 0) && ($grand_parent_total_expense != 0)): ?>
                                <tr>
                                    <td>
                                        <strong>&nbsp;Total: </strong>
                                    </td>
                                    <td class="text-center"><strong>{{ number_format($grand_parent_total_expense, 2) }}</strong></td>
                                    <td></td>
                                </tr>
                            <?php endif; ?>
                            @endforeach
                            <tr>
                                <td>
                                    <strong>&nbsp;Grand Total(All Areas): </strong>
                                </td>
                                <td class="text-center"><strong>{{ number_format($data['grand_total_expense'], 2) }}</strong></td>
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
