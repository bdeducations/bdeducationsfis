<!DOCTYPE html>
<html>
    <head>
        <title>Budget Balance Summary Monthly  Report PDF</title>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" href="{{ url('/')}}/public/adminlte/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
        <style type="text/css">
            body{
                font-size:10px !important;
                font-weight:100;
            }
            .page-break {
                page-break-before:avoid;
                page-break-after:always;
                page-break-inside:avoid;
            }
            .table > tbody > tr > td,
            .table > tbody > tr > th,
            .table > tfoot > tr > td,
            .table > tfoot > tr > th,
            .table > thead > tr > td,
            .table > thead > tr > th {
                padding:7px !important;
            }
            @page {
                margin-bottom:0;
                margin-top:10px;
            }
        </style>
    </head>
    <body>
        <div class="pdfcontent" style="text-align:center;">
            <h1 style="margin:0;padding:0;font-size:22px !important;font-weight:bold;">Budget Balance Summary Sheet : <?php echo $data['selected_budget_year']; ?></h1>
            @if($data['balance_report_by_month_list'])
            <?php
            $parent_serial = 1;
            $data_area_number_count = count($data['balance_report_by_month_list']);
            $area_counter = 0;
            ?>
            @foreach($data['balance_report_by_month_list'] as $area_row_id_key => $mothly_balance_row)
            <h3 style="text-transform:uppercase;text-align:center;text-decoration:underline;font-weight:bold;font-size:16px !important;">
                <?php
                if (isset($data['all_area_list'][$area_row_id_key])):
                    echo $data['all_area_list'][$area_row_id_key];
                endif;
                ?>
            </h3>
            <table class="table table-striped table-bordered table-hover table-checkable order-column">
                <thead>
                    <tr>
                        <th rowspan="2" style="vertical-align:middle;text-align:left;padding-left:5px">Head Name</th>
                        <th rowspan="2" style="vertical-align:middle;text-align:center;padding-left:10px">Allocation</th>
                        <th colspan="<?php echo $data['total_month']; ?>" style="vertical-align:middle;text-align:center;padding-left:10px">Expense</th>
                        <th rowspan="2" style="vertical-align:middle;text-align:center;padding-left:10px">Total</th>
                        <th rowspan="2" style="vertical-align:middle;text-align:center;padding-left:10px">Balance</th>
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
                        <td style="text-align:left;padding-left:5px">
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
            <?php
            ++$area_counter;
            $parent_serial = 1;
            ?>
            @if(($area_counter%2 == 0) && ($area_counter < $data_area_number_count) && ($data['selected_area_row_id'] == -1) && ($data['selected_head_row_id'] == -1))
            <div class="page-break"></div>
            @endif
            @endforeach
            <?php if (($data['selected_head_row_id'] == -1) && ($data['selected_area_row_id'] == -1)): ?>
                <div class="table-responsive">
                    <table style="margin-top:10px;" class="table table-striped table-bordered table-hover table-checkable order-column">
                        <thead>
                            <tr>
                                <th rowspan="2" width="15%" style="vertical-align:middle;text-align:left;padding-left:10px">Head Name</th>
                                <th rowspan="2" width="15%" style="vertical-align:middle;text-align:center;padding-left:10px">Allocation</th>
                                <th colspan="<?php echo $data['total_month']; ?>" width="40%" style="vertical-align:middle;text-align:center;padding-left:10px">Expense</th>
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
            @endif
        </div>
    </body>
</html>