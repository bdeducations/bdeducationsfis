@extends('layouts.admin')
@section('page_css')
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Balance Summary Report</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Balance Summary Report By Month</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <!-- form start -->
                <form role="form" method="POST" class="form-horizontal" action="{{ url('/') }}/budgetReport/balance/summary" >
                    {!! csrf_field() !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="area_row_id" class="col-md-5 control-label">Select Area <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-7">
                                        <select name="area_row_id" class ="form-control" required="required">
                                            <option value="">Select Area</option>
                                            <option value="-1" @if($data['selected_area_row_id'] == -1) selected="selected"  @endif>All Area</option>
                                            @foreach( $data['all_area_list'] as $area_row_id => $area_name)
                                            <option value="{{ $area_row_id }}" @if($area_row_id == $data['selected_area_row_id']) selected="selected"  @endif>{{ $area_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="budget_year" class="col-md-5 control-label">Budget Year <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-7">
                                        <select name="budget_year" class="ut_budget_year form-control" required="required">
                                            <?php
                                            $year_array = budget_year_list();
                                            ?>
                                            <option value="">Select Year</option>
                                            <?php foreach ($year_array as $key => $value): ?>
                                                <option @if($key == $data['selected_budget_year']) selected="selected"  @endif value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="head_row_id" class="col-md-3 control-label">Select Head <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-9">
                                        <select name="head_row_id" class="form-control" required="required">
                                            <option value="">Select Head</option>
                                            <option value="-1" @if($data['selected_head_row_id'] == -1) selected="selected"  @endif>All Main Head</option>
                                            @foreach( $data['all_heads'] as $row)
                                            <option value="{{ $row->head_row_id }}" @if($row->head_row_id == $data['selected_head_row_id']) selected="selected"  @endif>
                                                    @if($row->level == 0) <b>  @endif
                                                {{ $row->title }}
                                                @if($row->level == 0) </b>  @endif
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="date_type" class="col-md-5 control-label">Date Type</label>
                                    <div class="col-md-7">
                                        <select name="date_type" id="budget_balance_report_date_type" class="form-control">
                                            <?php
                                            $year_array = array(
                                                '1' => 'Month Range',
                                                '2' => 'Date Range'
                                            );
                                            ?>
                                            <option value="">Date Type</option>
                                            <?php foreach ($year_array as $key => $value): ?>
                                                <option @if($key == $data['selected_date_type']) selected="selected"  @endif value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="balance_report_month_range" style="display:none;">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="from_month" class="col-md-5 control-label">From Month</label>
                                        <div class="col-md-7">
                                            <select name="from_month" class ="form-control">
                                                <?php
                                                $month_array = array(
                                                    '1' => 'January',
                                                    '2' => 'February',
                                                    '3' => 'March',
                                                    '4' => 'April',
                                                    '5' => 'May',
                                                    '6' => 'June',
                                                    '7' => 'July',
                                                    '8' => 'August',
                                                    '9' => 'September',
                                                    '10' => 'October',
                                                    '11' => 'November',
                                                    '12' => 'December'
                                                );
                                                ?>
                                                <option value="">From Month</option>
                                                <?php foreach ($month_array as $key => $value): ?>
                                                    <option @if($key == $data['from_month']) selected="selected"  @endif value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="to_month" class="col-md-3 control-label">To Month</label>
                                        <div class="col-md-9">
                                            <select name="to_month" class ="form-control">
                                                <option value="">To Month</option>
                                                <?php foreach ($month_array as $key => $value): ?>
                                                    <option @if($key == $data['to_month']) selected="selected"  @endif value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="balance_report_date_range" style="display:none;">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="from_datepicker" class="col-md-5 control-label">From Date</label>
                                        <div class="col-md-7">
                                            <input type="text" name="from_date" class="form-control" id="from_datepicker" value="<?php echo isset($data['from_date']) ? $data['from_date'] : ''; ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="to_datepicker" class="col-md-3 control-label">To Date</label>
                                        <div class="col-md-9">
                                            <input type="text" name="to_date" class="form-control" id="to_datepicker" value="<?php echo isset($data['to_date']) ? $data['to_date'] : ''; ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary pull-right">Submit</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-footer -->
                </form>
                <?php
                $pdf_area_qstring = '';
                $pdf_date_qstring = '';
                $pdf_area_qstring = "&area_row_id=" . $data['selected_area_row_id'] . "&budget_year=" . $data['selected_budget_year'];
                if ($data['from_month']):
                    $pdf_date_qstring = "&date_type=1&from_month=" . $data['from_month'];
                endif;
                if ($data['to_month']):
                    $pdf_date_qstring .= "&to_month=" . $data['to_month'];
                endif;
                ?>
                @if($data['balance_report_by_month_list'])
                <div class="box-header">
                    <a target="_blank" class="btn btn-default" href="{{ url('/') }}/budgetReport/balance/summary/download?head_row_id={{ $data['selected_head_row_id'] }}@if($pdf_area_qstring){{ $pdf_area_qstring }}@endif @if($pdf_date_qstring){{ $pdf_date_qstring }}@endif"><i class="fa fa-download"></i><strong> Download Report PDF</strong></a>
                    <a target="_blank" style="margin-left:15px;" class="btn btn-default" href="{{ url('/') }}/budgetReport/balance/summary/downloadCSV?head_row_id={{ $data['selected_head_row_id'] }}@if($pdf_area_qstring){{ $pdf_area_qstring }}@endif @if($pdf_date_qstring){{ $pdf_date_qstring }}@endif"><i class="fa fa-download"></i><strong> Download Report CSV</strong></a>
                </div>
                @endif
                <div class="box-body">
                    @if($data['balance_report_by_month_list'])
                    <?php
                        $parent_serial = 1;
                    ?>
                    @foreach($data['balance_report_by_month_list'] as $area_row_id_key => $mothly_balance_row)
                    <h3 style="text-transform:uppercase;text-align:center;text-decoration:underline;">
                        <?php
                        if (isset($data['all_area_list'][$area_row_id_key])):
                            echo $data['all_area_list'][$area_row_id_key];
                        endif;
                        ?>
                    </h3>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column">
                            <thead>
                                <tr>
                                    <th rowspan="2" width="40%" style="vertical-align:middle;text-align:left;padding-left:10px">Head Name</th>
                                    <th rowspan="2" width="15%" style="vertical-align:middle;text-align:center;padding-left:10px">Allocation</th>
                                    <th colspan="<?php echo $data['total_month']; ?>" width="15%" style="vertical-align:middle;text-align:center;padding-left:10px">Expense</th>
                                    <th rowspan="2" width="15%" style="vertical-align:middle;text-align:center;padding-left:10px">Total</th>
                                    <th rowspan="2" width="15%" style="vertical-align:middle;text-align:center;padding-left:10px">Balance</th>
                                </tr>
                                <tr>
                                    <?php
                                    $start_month = $data['from_month'];
                                    for ($start_month; $start_month <= $data['to_month']; $start_month++):
                                        ?>
                                        <th style="text-align:center;padding-left:10px;border-right-width:1px !important;"><?php echo $data['month_list'][$start_month]; ?></th>
                                    <?php endfor; ?>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mothly_balance_row as $head_row_id_key => $area_balance_row)
                                <tr>
                                    <td style="text-align:left;padding-left:10px">
                                        <strong>
                                            <span>{{ $parent_serial }}&nbsp;.&nbsp;</span>
                                            <?php $parent_serial++; ?>
                                            {{ $area_balance_row['title'] }}
                                        </strong>
                                    </td>
                                    <td style="text-align:center;padding-left:10px">
                                        @if(isset($area_balance_row['parent_head_total_allocation']) && ($area_balance_row['parent_head_total_allocation'] != 0))
                                        {{ number_format($area_balance_row['parent_head_total_allocation'], 2) }}
                                        @else
                                        0.00
                                        @endif
                                    </td>
                                    @foreach($area_balance_row[0] as $month_key => $monthly_expense_row)
                                    <td style="text-align:center;padding-left:10px">
                                        {{ number_format($monthly_expense_row, 2) }}
                                    </td>
                                    @endforeach
                                    <td style="text-align:center;padding-left:10px">
                                        @if(isset($area_balance_row['parent_head_total_expense']) && ($area_balance_row['parent_head_total_expense'] != 0))
                                        {{ number_format($area_balance_row['parent_head_total_expense'], 2) }}
                                        @else
                                        0.00
                                        @endif
                                    </td>
                                    <td style="text-align:center;padding-left:10px">
                                        @if(isset($area_balance_row['parent_head_current_balance']) && ($area_balance_row['parent_head_current_balance'] != 0))
                                        {{ number_format($area_balance_row['parent_head_current_balance'], 2) }}
                                        @else
                                        0.00
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                <?php if (($data['selected_head_row_id'] == -1)): ?>
                                    <tr>
                                        <td width="40%">
                                            <strong>&nbsp;Total&nbsp;({{$data['all_area_list'][$area_row_id_key]}}):</strong>
                                        </td>
                                        <td class="text-center"><strong>{{ number_format($data['total_allocation_by_area'][$area_row_id_key], 2) }}</strong></td>
                                        <?php
                                        $start_month = $data['from_month'];
                                        for ($start_month; $start_month <= $data['to_month']; $start_month++):
                                            ?>
                                            <td style="text-align:center;padding-left:10px">
                                                <strong>{{ number_format($data['total_area_expense_by_month'][$area_row_id_key][$start_month], 2) }}</strong>
                                            </td>
                                        <?php endfor; ?>
                                        <td class="text-center"><strong>{{ number_format($data['total_expense_by_area'][$area_row_id_key], 2) }}</strong></td>
                                        <td class="text-center"><strong>{{ number_format($data['total_balance_by_area'][$area_row_id_key], 2) }}</strong></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php $parent_serial = 1; ?>
                    @endforeach
                    <?php if (($data['selected_head_row_id'] == -1) && ($data['selected_area_row_id'] == -1)): ?>
                        <div class="table-responsive">
                            <table style="margin-top:10px;" class="table table-striped table-bordered table-hover table-checkable order-column">
                                <thead>
                                    <tr>
                                        <th rowspan="2" width="25%" style="vertical-align:middle;text-align:left;padding-left:10px">Head Name</th>
                                        <th rowspan="2" width="15%" style="vertical-align:middle;text-align:center;padding-left:10px">Allocation</th>
                                        <th colspan="<?php echo $data['total_month']; ?>" width="30%" style="vertical-align:middle;text-align:center;padding-left:10px">Expense</th>
                                        <th rowspan="2" width="15%" style="vertical-align:middle;text-align:center;padding-left:10px">Total</th>
                                        <th rowspan="2" width="15%" style="vertical-align:middle;text-align:center;padding-left:10px">Balance</th>
                                    </tr>
                                    <tr>
                                        <?php
                                        for ($from_month = $data['from_month']; $from_month <= $data['to_month']; ++$from_month):
                                            ?>
                                            <th style="text-align:center;padding-left:10px;border-right-width:1px !important;"><?php echo $data['month_list'][$from_month]; ?></th>
                                        <?php endfor; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <strong>&nbsp;Grand Total&nbsp;( All Areas ) </strong>
                                        </td>
                                        <td class="text-center">
                                            <?php if (isset($data['grand_total_allocation_all_area'])): ?>
                                                <strong>{{ number_format($data['grand_total_allocation_all_area'], 2) }}</strong>
                                            <?php endif; ?>
                                        </td>
                                        <?php
                                        for ($start_month = $data['from_month']; $start_month <= $data['to_month']; $start_month++):
                                            ?>
                                            <td style="text-align:center;padding-left:10px">
                                                <?php if (isset($data['grand_total_expense_by_month_all_area'][$start_month])): ?>
                                                    <strong>{{ number_format($data['grand_total_expense_by_month_all_area'][$start_month], 2) }}</strong>
                                                <?php endif; ?>
                                            </td>
                                        <?php endfor; ?>
                                        <td class="text-center">
                                            <?php if (isset($data['grand_total_expense_all_area'])): ?>
                                                <strong>{{ number_format($data['grand_total_expense_all_area'], 2) }}</strong>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if (isset($data['grand_total_balance_all_area'])): ?>
                                                <strong>{{ number_format($data['grand_total_balance_all_area'], 2) }}</strong>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                    @else
                    <div class="table-responsive">
                        <table style="margin-top:10px;" class="table table-striped table-bordered table-hover table-checkable order-column">
                            <thead>
                                <tr>
                                    <th rowspan="2" width="25%" style="vertical-align:middle;text-align:left;padding-left:10px">Head Name</th>
                                    <th rowspan="2" width="15%" style="vertical-align:middle;text-align:center;padding-left:10px">Allocation</th>
                                    <th colspan="<?php echo $data['total_month']; ?>" width="30%" style="vertical-align:middle;text-align:center;padding-left:10px">Expense</th>
                                    <th rowspan="2" width="15%" style="vertical-align:middle;text-align:center;padding-left:10px">Total</th>
                                    <th rowspan="2" width="15%" style="vertical-align:middle;text-align:center;padding-left:10px">Balance</th>
                                </tr>
                                <tr>
                                    <?php
                                    for ($from_month = $data['from_month']; $from_month <= $data['to_month']; ++$from_month):
                                        ?>
                                        <th style="text-align:center;padding-left:10px;border-right-width:1px !important;"><?php echo $data['month_list'][$from_month]; ?></th>
                                    <?php endfor; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" style="text-align:center;"><strong>No Record Found</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
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
    $('#to_datepicker,#from_datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true
    });
});
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var selected_date_type = $('#budget_balance_report_date_type').val();
        if (selected_date_type == 1) {
            $('.balance_report_month_range').show();
            $('.balance_report_date_range').hide();
        } else if (selected_date_type == 2) {
            $('.balance_report_month_range').hide();
            $('.balance_report_date_range').show();
        } else {
            $('.balance_report_month_range').hide();
            $('.balance_report_date_range').hide();
        }
        $("#budget_balance_report_date_type").change(function () {
            $('.balance_report_month_range').hide();
            $('.balance_report_date_range').hide();
            var selected_date_type = $(this).val();
            if (selected_date_type == 1) {
                $('.balance_report_month_range').show();
                $('.balance_report_date_range').hide();
            } else if (selected_date_type == 2) {
                $('.balance_report_month_range').hide();
                $('.balance_report_date_range').show();
            } else {
                $('.balance_report_month_range').hide();
                $('.balance_report_date_range').hide();
            }
        });
    });
</script>
@endsection