<!DOCTYPE html>
<html><head>
        <title>Budget Balance Monthly  Report PDF</title>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" href="{{ url('/')}}/public/adminlte/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
        <style type="text/css">
            body{
                font-size:9px !important;
                font-weight:100;
            }
            .page-break {
                /*page-break-before:always;*/
                page-break-before:auto;
                page-break-after:avoid;
                page-break-inside:avoid;
            }
            .table > tbody > tr > td,
            .table > tbody > tr > th,
            .table > tfoot > tr > td,
            .table > tfoot > tr > th,
            .table > thead > tr > td,
            .table > thead > tr > th {
                padding:3px !important;
            }
            @page {
                margin:5px 4px 0 6px;
            }
        </style>
</head><body>
        <div class="pdfcontent" style="text-align:center;">
            @if($data['balance_report_by_month_list'])
            <?php
            $parent_head_total_expense_by_month = array();
            $grand_parent_head_total_expense_by_month = array();
            $parent_serial = 1;
            $data_area_number_count = count($data['balance_report_by_month_list']);
            $child_serial = 1;
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
            $area_counter = 1;
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
            <h3 style="text-transform:uppercase;text-align:center;padding-bottom:10px;margin-bottom:10px !important;text-decoration:underline;font-size:16px !important;">
                <?php
                if (isset($data['report_title'])):
                    echo $data['report_title'];
                endif;
                ?>
            </h3>
            <div style="clear:both !important;"></div>
            <table class="table table-striped table-bordered table-hover table-checkable order-column">
                <thead>
                    <tr>
                        <th rowspan="2" style="vertical-align:middle;text-align:left;padding-left:7px">Head Name</th>
                        <th rowspan="2" style="vertical-align:middle;text-align:center;padding-left:7px">Allocation</th>
                        <th colspan="<?php echo $data['total_month']; ?>" width="50%" style="vertical-align:middle;text-align:center;padding-left:7px">Expense</th>
                        <th rowspan="2" style="vertical-align:middle;text-align:center;padding-left:7px">Total</th>
                        <th rowspan="2" style="vertical-align:middle;text-align:center;padding-left:7px">Balance</th>
                    </tr>
                    <tr>
                        <?php
                        $start_month = $data['from_month'];
                        for ($start_month; $start_month <= $data['to_month']; $start_month++):
                            ?>
                            <th style="text-align:center;padding-left:7px;border-right-width:1px !important;"><?php echo $data['month_list'][$start_month]; ?></th>
                        <?php endfor; ?>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mothly_balance_row as $head_row_id_key => $area_balance_row)
                    <tr>
                        <td style="text-align:left;padding-left:7px">
                            @if($area_balance_row['level'] == 0)
                            <strong style="font-size:12px !important;">
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
                                <strong style="font-size:13px;">
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
                        <td style="text-align:center;padding-left:7px">
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
                            <td style="text-align:center;padding-left:7px">&nbsp;</td>
                        <?php endfor; ?>
                        @else
                        @foreach($area_balance_row[0] as $month_key => $monthly_expense_row)
                        <td style="text-align:center;padding-left:7px">
                            {{ number_format($monthly_expense_row, 2) }}
                        </td>
                        @endforeach
                        @endif
                        <td style="text-align:center;padding-left:7px">
                            @if(isset($area_balance_row['head_total_expense']) && ($area_balance_row['head_total_expense'] != 0) && ($area_balance_row['has_child'] == 0))
                            {{ number_format($area_balance_row['head_total_expense'], 2) }}
                            @elseif(isset($area_balance_row['head_total_expense']) && ($area_balance_row['head_total_expense'] == 0) && ($area_balance_row['has_child'] == 0))
                            0.00
                            @endif
                        </td>
                        <td style="text-align:center;padding-left:7px">
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
                            <td style="text-align:center;padding-left:7px">
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
                            <td style="text-align:center;padding-left:7px">
                                <strong>{{ number_format($monthly_expense_row, 2) }}</strong>
                            </td>
                            @endforeach
                            <td class="text-center"><strong>{{ number_format($parent_total_expense, 2) }}</strong></td>
                            <td class="text-center"></td>
                        </tr>
                    <?php endif; ?>
                    <?php if (($grand_parent_child_number == $grand_parent_child_counter) && ($parent_child_number == $parent_child_counter) && ($area_balance_row['level'] == 2) && ($area_balance_row['has_child'] == 0)): ?>
                        <tr>
                            <td>
                                <strong>&nbsp;Total: </strong>
                            </td>
                            <td class="text-center"><strong>{{ number_format($grand_parent_total_allocation, 2) }}</strong></td>
                            @foreach($grand_parent_head_total_expense_by_month as $month_key => $monthly_expense_row)
                            <td style="text-align:center;padding-left:7px">
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
                            <td>
                                <strong>&nbsp;Area Total&nbsp;:</strong>
                            </td>
                            <td class="text-center"><strong>{{ number_format($data['total_allocation_by_area'][$area_row_id_key], 2) }}</strong></td>
                            <?php
                            $start_month = $data['from_month'];
                            for ($start_month; $start_month <= $data['to_month']; $start_month++):
                                ?>
                                <td style="text-align:center;padding-left:7px">
                                    <strong>{{ number_format($data['total_area_expense_by_month'][$area_row_id_key][$start_month], 2) }}</strong>
                                </td>
                            <?php endfor; ?>
                            <td class="text-center"><strong>{{ number_format($data['total_expense_by_area'][$area_row_id_key], 2) }}</strong></td>
                            <td class="text-center"><strong>{{ number_format($data['total_balance_by_area'][$area_row_id_key], 2) }}</strong></td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td width="40%">
                                <strong>&nbsp;Area Total&nbsp;:</strong>
                            </td>
                            <td class="text-center"><strong>{{ number_format($data['selected_list_head_total_allocation'][$area_row_id_key], 2) }}</strong></td>
                            <?php
                            $start_month = $data['from_month'];
                            for ($start_month; $start_month <= $data['to_month']; $start_month++):
                                ?>
                                <td style="text-align:center;padding-left:10px">
                                    @if(isset($data['selected_list_head_total_expense_by_month'][$area_row_id_key][$start_month]))
                                    <strong>{{ number_format($data['selected_list_head_total_expense_by_month'][$area_row_id_key][$start_month], 2) }}</strong>
                                    @else
                                    <strong>0.00</strong>
                                    @endif
                                </td>
                            <?php endfor; ?>
                            <td class="text-center"><strong>{{ number_format($data['selected_list_head_total_expense'][$area_row_id_key], 2) }}</strong></td>
                            <td class="text-center"><strong>{{ number_format($data['selected_list_head_total_balance'][$area_row_id_key], 2) }}</strong></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            @if(($area_counter < $data_area_number_count) && ($data['selected_area_row_id'] == -1) && ($data['selected_head_row_id'] == -1))
            <div class="page-break"></div>
            @endif
            <?php
            $area_counter++;
            $parent_serial = 1;
            ?>
            @endforeach
            <?php if ((in_array('-1', $data['selected_head_row_id'])) && ($data['selected_area_row_id'] == -1)): ?>
                <div class="table-responsive">
                    <table style="margin-top:10px;" class="table table-striped table-bordered table-hover table-checkable order-column">
                        <thead>
                            <tr>
                                <th rowspan="2" style="vertical-align:middle;text-align:center;padding-left:7px">Head Name</th>
                                <th rowspan="2" style="vertical-align:middle;text-align:center;padding-left:7px">Allocation</th>
                                <th colspan="<?php echo $data['total_month']; ?>" style="vertical-align:middle;text-align:center;padding-left:7px">Expense</th>
                                <th rowspan="2" style="vertical-align:middle;text-align:center;padding-left:7px">Total</th>
                                <th rowspan="2" style="vertical-align:middle;text-align:center;padding-left:7px">Balance</th>
                            </tr>
                            <tr>
                                <?php
                                for ($from_month = $data['from_month']; $from_month <= $data['to_month']; ++$from_month):
                                    ?>
                                    <th style="vertical-align:middle;text-align:center;padding-left:7px;border-right-width:1px !important;"><?php echo $data['month_list'][$from_month]; ?></th>
                                <?php endfor; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <strong>&nbsp;Grand Total&nbsp;( All Areas ) </strong>
                                </td>
                                <td class="text-center" style="vertical-align:middle;text-align:center;padding-left:7px">
                                    <?php if (isset($data['grand_total_allocation_all_area'])): ?>
                                        <strong>{{ number_format($data['grand_total_allocation_all_area'], 2) }}</strong>
                                    <?php endif; ?>
                                </td>
                                <?php
                                for ($start_month = $data['from_month']; $start_month <= $data['to_month']; $start_month++):
                                    ?>
                                    <td style="vertical-align:middle;text-align:center;padding-left:7px">
                                        <?php if (isset($data['grand_total_expense_by_month_all_area'][$start_month])): ?>
                                            <strong>{{ number_format($data['grand_total_expense_by_month_all_area'][$start_month], 2) }}</strong>
                                        <?php endif; ?>
                                    </td>
                                <?php endfor; ?>
                                <td class="text-center" style="vertical-align:middle;text-align:center;padding-left:7px">
                                    <?php if (isset($data['grand_total_expense_all_area'])): ?>
                                        <strong>{{ number_format($data['grand_total_expense_all_area'], 2) }}</strong>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center" style="vertical-align:middle;text-align:center;padding-left:7px">
                                    <?php if (isset($data['grand_total_balance_all_area'])): ?>
                                        <strong>{{ number_format($data['grand_total_balance_all_area'], 2) }}</strong>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
            <?php if ((!in_array('-1', $data['selected_head_row_id'])) && ($data['selected_area_row_id'] == -1)): ?>
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
            @endif
        </div>
</body></html>