@extends('layouts.admin')
@section('page_css')
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Advanced Balance Report</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Balance Report By Month</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <!-- form start -->
                <form role="form" method="POST" class="form-horizontal" action="{{ url('/') }}/budgetReport/balance" >
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
                                            @foreach( $data['all_areas'] as $area_row)
                                            <option value="{{ $area_row->area_row_id }}" @if($area_row->area_row_id == $data['selected_area_row_id']) selected="selected"  @endif>{{ $area_row->title }}</option>
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
                                        <select name="head_row_id[]" multiple="multiple" class="ut_budget_head_drop_down form-control" required="required">
                                            <option value="">Select Head</option>
                                            <option value="-1">All Head</option>
                                            @foreach( $data['all_heads'] as $row)
                                            <option value="{{ $row->head_row_id }}">
                                                    @if($row->level == 1) &nbsp; - @endif
                                                    @if($row->level == 2) &nbsp; &nbsp; - - @endif
                                                    @if($row->level == 3) &nbsp; &nbsp; &nbsp; - - - @endif
                                                    @if($row->level == 4) &nbsp; &nbsp; &nbsp; &nbsp; - - - - @endif
                                                    @if($row->level == 5) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  - - - - - @endif
                                                    @if($row->level > 5)  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - - - @endif
                                                    {{ $row->title }}
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
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="report_title" class="col-md-3 control-label">Report Heading</label>
                                    <div class="col-md-9">
                                        <input type="text" name="report_title" class="form-control" placeholder="Report Heading Title" id="report_title" value="<?php echo isset($data['report_title']) ? $data['report_title'] : ''; ?>" />
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
                if (is_array($data['selected_head_row_id'])):
                    if (in_array('-1', $data['selected_head_row_id'])):
                        $head_row_list = -1;
                    else:
                        $head_row_list = implode('-', $data['selected_head_row_id']);
                    endif;
                else:
                    $head_row_list = -1;
                endif;
                ?>
                @if($data['balance_report_by_month_list'])
                <div class="box-header">
                    <a target="_blank" class="btn btn-default" href="{{ url('/') }}/budgetReport/balanceReportDownload?head_row_id={{ $head_row_list }}@if($pdf_area_qstring){{ $pdf_area_qstring }}@endif @if($pdf_date_qstring){{ $pdf_date_qstring }}@endif"><i class="fa fa-download"></i><strong> Download Report PDF</strong></a>
                    <a target="_blank" style="margin-left:10px;" class="btn btn-default" href="{{ url('/') }}/budgetReport/balanceReportCSVDownload?head_row_id={{ $head_row_list }}@if($pdf_area_qstring){{ $pdf_area_qstring }}@endif @if($pdf_date_qstring){{ $pdf_date_qstring }}@endif"><i class="fa fa-download"></i><strong> Download Report CSV</strong></a>
                </div>
                @endif
                <div class="box-body">
                    @if($data['balance_report_by_month_list'])
                    <?php
                    $parent_head_total_expense_by_month = array();
                    $grand_parent_head_total_expense_by_month = array();
                    $child_serial = 1;
                    $parent_serial = 1;
                    $grand_child_serial = 1;
                    $grand_parent_child_number = 0;
                    $grand_parent_child_counter = 0;
                    $grand_parent_total_allocation = 0;
                    $grand_parent_total_expense = 0;
                    $grand_parent_total_balance = 0;
                    $parent_child_number = 0;
                    $parent_child_counter = 0;
                    $parent_total_allocation = 0;
                    $parent_total_expense = 0;
                    $parent_total_balance = 0;
                    ?>
                    @foreach($data['balance_report_by_month_list'] as $area_row_id_key => $mothly_balance_row)
                    <?php
                    if (isset($child_serial) && $child_serial > 26):
                        $child_serial = 1;
                    endif;
                    if (isset($grand_child_serial) && $grand_child_serial > 26):
                        $grand_child_serial = 1;
                    endif;
                    ?>
                    <h3 style="text-transform:uppercase;text-align:center;text-decoration:underline;">
                        <?php
                        if (isset($data['report_title'])):
                            echo $data['report_title'];
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
                                        @if($area_balance_row['level'] == 0)
                                        <strong>
                                            <?php
                                            $grand_parent_child_counter = 0;
                                            $child_serial = 1;
                                            if ($area_balance_row['has_child'] == 1):
                                                $parent_child_number = $area_balance_row['parent_head_child_number'];
                                                $parent_total_allocation = $area_balance_row['parent_head_total_allocation'];
                                                $parent_total_expense = $area_balance_row['parent_head_total_expense'];
                                                $parent_total_balance = $area_balance_row['parent_head_current_balance'];
                                                $grand_parent_child_number = $area_balance_row['parent_head_child_number'];
                                                $grand_parent_total_allocation = $area_balance_row['parent_head_total_allocation'];
                                                $grand_parent_total_expense = $area_balance_row['parent_head_total_expense'];
                                                $grand_parent_total_balance = $area_balance_row['parent_head_current_balance'];
                                                $parent_child_counter = 0;
                                                foreach ($area_balance_row[0] as $month_key => $monthly_expense_row):
                                                    $parent_head_total_expense_by_month[$month_key] = $monthly_expense_row;
                                                endforeach;
                                                $grand_parent_head_total_expense_by_month = $parent_head_total_expense_by_month;
                                            endif;
                                            ?>
                                            <span>{{ $parent_serial }}&nbsp;.&nbsp;</span>
                                            <?php $parent_serial++; ?>
                                            @endif
                                            @if($area_balance_row['level'] == 1)
                                            &nbsp;
                                            @if($area_balance_row['has_child'] == 1)
                                                <strong>
                                            @endif
                                            <?php
                                            $grand_child_serial = 1;
                                            echo $data['alphabets'][$child_serial] . ".";
                                            $child_serial++;
                                            if ($area_balance_row['has_child'] == 1):
                                                $parent_child_number = $area_balance_row['parent_head_child_number'];
                                                $parent_total_allocation = $area_balance_row['parent_head_total_allocation'];
                                                $parent_total_expense = $area_balance_row['parent_head_total_expense'];
                                                $parent_total_balance = $area_balance_row['parent_head_current_balance'];
                                                $parent_child_counter = 0;
                                                $grand_parent_child_counter++;
                                                foreach ($area_balance_row[0] as $month_key => $monthly_expense_row):
                                                    $parent_head_total_expense_by_month[$month_key] = $monthly_expense_row;
                                                endforeach;
                                            else:
                                                $parent_child_counter++;
                                                $grand_parent_child_counter++;
                                            endif;
                                            ?>
                                            &nbsp;
                                            @endif
                                            @if($area_balance_row['level'] == 2)
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <?php
                                            echo $data['roman'][$grand_child_serial] . ".";
                                            $grand_child_serial++;
                                            $parent_child_counter++;
                                            ?>&nbsp;
                                            @endif
                                            @if($area_balance_row['level'] == 3) &nbsp; &nbsp; &nbsp; - - - @endif
                                            @if($area_balance_row['level'] == 4) &nbsp; &nbsp; &nbsp; &nbsp; - - - - @endif
                                            @if($area_balance_row['level'] == 5) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  - - - - - @endif
                                            @if($area_balance_row['level'] > 5)  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - - - @endif
                                            {{ $area_balance_row['title'] }}
                                            @if($area_balance_row['level'] == 0) </strong>  @endif
                                            @if($area_balance_row['level'] == 1)
                                                @if($area_balance_row['has_child'] == 1)
                                                    </strong>
                                                @endif
                                            @endif
                                    </td>
                                    <td style="text-align:center;padding-left:10px">
                                        @if(isset($area_balance_row['head_total_allocation']) && ($area_balance_row['head_total_allocation'] != 0) && ($area_balance_row['parent_id'] == 0))
                                        {{ number_format($area_balance_row['head_total_allocation'], 2) }}
                                        @elseif(isset($area_balance_row['head_total_allocation']) && ($area_balance_row['head_total_allocation'] == 0) && ($area_balance_row['parent_id'] == 0))
                                        0.00
                                        @endif
                                    </td>
                                    @if($area_balance_row['has_child'] == 1)
                                    <?php
                                    $start_month = $data['from_month'];
                                    for ($start_month; $start_month <= $data['to_month']; $start_month++):
                                        ?>
                                        <td style="text-align:center;padding-left:10px">&nbsp;</td>
                                    <?php endfor; ?>
                                    @else
                                    @foreach($area_balance_row[0] as $month_key => $monthly_expense_row)
                                    <td style="text-align:center;padding-left:10px">
                                        {{ number_format($monthly_expense_row, 2) }}
                                    </td>
                                    @endforeach
                                    @endif
                                    <td style="text-align:center;padding-left:10px">
                                        @if(isset($area_balance_row['head_total_expense']) && ($area_balance_row['head_total_expense'] != 0) && ($area_balance_row['has_child'] == 0))
                                        {{ number_format($area_balance_row['head_total_expense'], 2) }}
                                        @elseif(isset($area_balance_row['head_total_expense']) && ($area_balance_row['head_total_expense'] == 0) && ($area_balance_row['has_child'] == 0))
                                        0.00
                                        @endif
                                    </td>
                                    <td style="text-align:center;padding-left:10px">
                                        @if(isset($area_balance_row['head_current_balance']) && ($area_balance_row['head_current_balance'] != 0) && ($area_balance_row['parent_id'] == 0))
                                        {{ number_format($area_balance_row['head_current_balance'], 2) }}
                                        @elseif(isset($area_balance_row['head_current_balance']) && ($area_balance_row['head_current_balance'] == 0) && ($area_balance_row['parent_id'] == 0))
                                        0.00
                                        @endif
                                    </td>
                                </tr>
                                <?php if (($parent_child_number == $parent_child_counter) && ($area_balance_row['level'] == 1) && ($area_balance_row['has_child'] == 0)): ?>
                                    <tr>
                                        <td>
                                            <strong>&nbsp;&nbsp;&nbsp;Total: </strong>
                                        </td>
                                        <td class="text-center"><strong>{{ number_format($parent_total_allocation, 2) }}</strong></td>
                                        @foreach($parent_head_total_expense_by_month as $month_key => $monthly_expense_row)
                                        <td style="text-align:center;padding-left:10px">
                                            <strong>{{ number_format($monthly_expense_row, 2) }}</strong>
                                        </td>
                                        @endforeach
                                        <td class="text-center"><strong>{{ number_format($parent_total_expense, 2) }}</strong></td>
                                        <td class="text-center"><strong>{{ number_format($parent_total_balance, 2) }}</strong></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (($parent_child_number == $parent_child_counter) && ($area_balance_row['level'] == 2) && ($area_balance_row['has_child'] == 0)): ?>
                                    <tr>
                                        <td>
                                            <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total: </strong>
                                        </td>
                                        <td class="text-center"></td>
                                        @foreach($parent_head_total_expense_by_month as $month_key => $monthly_expense_row)
                                        <td style="text-align:center;padding-left:10px">
                                            <strong>{{ number_format($monthly_expense_row, 2) }}</strong>
                                        </td>
                                        @endforeach
                                        <td class="text-center"><strong>{{ number_format($parent_total_expense, 2) }}</strong></td>
                                        <td class="text-center"></strong></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (($grand_parent_child_number == $grand_parent_child_counter) && ($parent_child_number == $parent_child_counter) && ($area_balance_row['level'] == 2) && ($area_balance_row['has_child'] == 0)): ?>
                                    <tr>
                                        <td>
                                            <strong>&nbsp;Total: </strong>
                                        </td>
                                        <td class="text-center"><strong>{{ number_format($grand_parent_total_allocation, 2) }}</strong></td>
                                        @foreach($grand_parent_head_total_expense_by_month as $month_key => $monthly_expense_row)
                                        <td style="text-align:center;padding-left:10px">
                                            <strong>{{ number_format($monthly_expense_row, 2) }}</strong>
                                        </td>
                                        @endforeach
                                        <td class="text-center"><strong>{{ number_format($grand_parent_total_expense, 2) }}</strong></td>
                                        <td class="text-center"><strong>{{ number_format($grand_parent_total_balance, 2) }}</strong></td>
                                    </tr>
                                <?php endif; ?>
                                @endforeach
                                <?php if ((in_array('-1', $data['selected_head_row_id']))): ?>
                                    <tr>
                                        <td width="40%">
                                            <strong>&nbsp;Area Total&nbsp;:</strong>
                                        </td>
                                        <td class="text-center"><strong>{{ number_format($data['total_allocation_by_area'][$area_row_id_key], 2) }}</strong></td>
                                       <?php
                                        $start_month = $data['from_month'];
                                        for ($start_month; $start_month <= $data['to_month']; $start_month++):
                                        ?>
                                        <td style="text-align:center;padding-left:10px">
                                            @if(isset($data['total_area_expense_by_month'][$area_row_id_key][$start_month]))
                                                <strong>{{ number_format($data['total_area_expense_by_month'][$area_row_id_key][$start_month], 2) }}</strong>
                                            @else
                                            <strong>0.00</strong>
                                            @endif
                                        </td>
                                        <?php endfor; ?>
                                        <td class="text-center"><strong>{{ number_format($data['total_expense_by_area'][$area_row_id_key], 2) }}</strong></td>
                                        <td class="text-center"><strong>{{ number_format($data['total_balance_by_area'][$area_row_id_key], 2) }}</strong></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php $parent_serial = 1;?>
                    @endforeach
                    <?php if ((in_array('-1', $data['selected_head_row_id'])) && ($data['selected_area_row_id'] == -1)): ?>
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
    $(".ut_budget_year").change(function(){
            $('.ut_budget_head_drop_down').empty();
            var selected_head_row_id = null;
            var selected_budget_year = $(this).val();
            $.ajax({
                url: "{{ url('/budget/report/heads/dropdown') }}" + '/' + selected_budget_year + '/' + selected_head_row_id,
                type: "GET",
                dataType: "html",
                success: function(data){
                    $('.ut_budget_head_drop_down').append(data);
                }
            });
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
<script type='text/javascript'>
    var head_row_id_list = <?php echo json_encode($data['selected_head_row_id']); ?>;
    $('.ut_budget_head_drop_down').val(head_row_id_list);
</script>
@endsection