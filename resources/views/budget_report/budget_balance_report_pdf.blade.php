<!DOCTYPE html>
<html><head>
        <title>Budget Balance Report PDF</title>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" href="{{ url('/')}}/public/adminlte/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
        <style type="text/css">
            body{
                font-size:9px;
                font-weight:100;
            }
            .table > tbody > tr > td,
            .table > tbody > tr > th,
            .table > tfoot > tr > td,
            .table > tfoot > tr > th,
            .table > thead > tr > td,
            .table > thead > tr > th {
                padding:5px !important;
            }
            .page-break {
                /*page-break-before:always;*/
                page-break-before:auto;
                page-break-after:auto;
                page-break-inside:avoid;
            }
            @page {
                margin-bottom:0;
                margin-top:10px;
            }
        </style>
</head><body>
        <div class="pdfcontent" style="text-align:center;">
            @if($data['account_expense_list'])
            <?php
            $data_area_number_count = count($data['account_expense_list']);
            $area_counter = 1;
            $child_serial = 1;
            $grand_child_serial = 1;
            $parent_serial = 1;
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
            @foreach($data['account_expense_list'] as $area_row_id_key => $expense_row)
            <?php
            if (isset($child_serial) && $child_serial > 26):
                $child_serial = 1;
            endif;
            if (isset($grand_child_serial) && $grand_child_serial > 26):
                $grand_child_serial = 1;
            endif;
            ?>
            <h4 style="text-transform:uppercase;text-align:center;text-decoration:underline;"> {{ $data['report_title'] }}</h4>
            <table class="table table-striped table-bordered table-hover table-checkable order-column">
                <thead>
                    <tr>
                        <th width="55%" style="text-align:left;padding-left:7px">Head Name</th>
                        <th width="15%" style="text-align:center;padding-left:7px">Allocation</th>
                        <th width="15%" style="text-align:center;padding-left:7px">Expense</th>
                        <th width="15%" style="text-align:center;padding-left:7px">Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expense_row as $area_expense_row)
                    <tr>
                        <td style="text-align:left;padding-left:7px">
                            @if($area_expense_row['level'] == 0)
                            <strong>
                                <?php
                                $grand_parent_child_counter = 0;
                                $child_serial = 1;
                                if ($area_expense_row['has_child'] == 1):
                                    $parent_child_number = $area_expense_row['parent_head_child_number'];
                                    $parent_total_allocation = $area_expense_row['parent_head_total_allocation'];
                                    $parent_total_expense = $area_expense_row['parent_head_total_expense'];
                                    $parent_total_balance = $area_expense_row['parent_head_current_balance'];
                                    $grand_parent_child_number = $area_expense_row['parent_head_child_number'];
                                    $grand_parent_total_allocation = $area_expense_row['parent_head_total_allocation'];
                                    $grand_parent_total_expense = $area_expense_row['parent_head_total_expense'];
                                    $grand_parent_total_balance = $area_expense_row['parent_head_current_balance'];
                                    $parent_child_counter = 0;
                                endif;
                                ?>
                                <span>{{ $parent_serial }}&nbsp;.&nbsp;</span>
                                <?php $parent_serial++; ?>
                                @endif
                                @if($area_expense_row['level'] == 1)
                                &nbsp;
                                @if($area_expense_row['has_child'] == 1)
                                <strong>
                                    @endif
                                    <?php
                                    $grand_child_serial = 1;
                                    echo $data['alphabets'][$child_serial] . ".";
                                    $child_serial++;
                                    if ($area_expense_row['has_child'] == 1):
                                        $parent_child_number = $area_expense_row['parent_head_child_number'];
                                        $parent_total_allocation = $area_expense_row['parent_head_total_allocation'];
                                        $parent_total_expense = $area_expense_row['parent_head_total_expense'];
                                        $parent_total_balance = $area_expense_row['parent_head_current_balance'];
                                        $parent_child_counter = 0;
                                        $grand_parent_child_counter++;
                                    else:
                                        $parent_child_counter++;
                                        $grand_parent_child_counter++;
                                    endif;
                                    ?>
                                    &nbsp;
                                    @endif
                                    @if($area_expense_row['level'] == 2)
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php
                                    echo $data['roman'][$grand_child_serial] . ".";
                                    $grand_child_serial++;
                                    $parent_child_counter++;
                                    ?>&nbsp;
                                    @endif
                                    @if($area_expense_row['level'] == 3) &nbsp; &nbsp; &nbsp; - - - @endif
                                    @if($area_expense_row['level'] == 4) &nbsp; &nbsp; &nbsp; &nbsp; - - - - @endif
                                    @if($area_expense_row['level'] == 5) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  - - - - - @endif
                                    @if($area_expense_row['level'] > 5)  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - - - @endif
                                    {{ $area_expense_row['title'] }}
                                    @if($area_expense_row['level'] == 0) </strong>  @endif
                                @if($area_expense_row['level'] == 1)
                                @if($area_expense_row['has_child'] == 1)
                            </strong>
                            @endif
                            @endif
                        </td>
                        <td style="text-align:center;padding-left:7px">
                            @if(isset($area_expense_row['total_allocation']) && ($area_expense_row['total_allocation'] != 0) && ($area_expense_row['parent_id'] == 0))
                            {{ number_format($area_expense_row['total_allocation'], 2) }}
                            @elseif(isset($area_expense_row['total_allocation']) && ($area_expense_row['total_allocation'] == 0) && ($area_expense_row['parent_id'] == 0))
                            0.00
                            @endif
                        </td>
                        <td style="text-align:center;padding-left:7px">
                            @if(isset($area_expense_row['total_expense']) && ($area_expense_row['total_expense'] != 0) && ($area_expense_row['has_child'] == 0))
                            {{ number_format($area_expense_row['total_expense'], 2) }}
                            @elseif(isset($area_expense_row['total_expense']) && ($area_expense_row['total_expense'] == 0) && ($area_expense_row['has_child'] == 0))
                            0.00
                            @endif
                        </td>
                        <td style="text-align:center;padding-left:7px">
                            @if(isset($area_expense_row['head_current_balance']) && ($area_expense_row['head_current_balance'] != 0) && ($area_expense_row['parent_id'] == 0))
                            {{ number_format($area_expense_row['head_current_balance'], 2) }}
                            @elseif(isset($area_expense_row['head_current_balance']) && ($area_expense_row['head_current_balance'] == 0) && ($area_expense_row['parent_id'] == 0))
                            0.00
                            @endif
                        </td>
                    </tr>
                    <?php if (($parent_child_number == $parent_child_counter) && ($area_expense_row['level'] == 1) && ($area_expense_row['has_child'] == 0)): ?>
                        <tr>
                            <td>
                                <strong>&nbsp;&nbsp;&nbsp;Total: </strong>
                            </td>
                            <td class="text-center"><strong>{{ number_format($parent_total_allocation, 2) }}</strong></td>
                            <td class="text-center"><strong>{{ number_format($parent_total_expense, 2) }}</strong></td>
                            <td class="text-center"><strong>{{ number_format($parent_total_balance, 2) }}</strong></td>
                        </tr>
                    <?php endif; ?>
                    <?php if (($parent_child_number == $parent_child_counter) && ($area_expense_row['level'] == 2) && ($area_expense_row['has_child'] == 0)): ?>
                        <tr>
                            <td>
                                <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total: </strong>
                            </td>
                            <td class="text-center"></td>
                            <td class="text-center"><strong>{{ number_format($parent_total_expense, 2) }}</strong></td>
                            <td class="text-center"></td>
                        </tr>
                    <?php endif; ?>
                    <?php if (($grand_parent_child_number == $grand_parent_child_counter) && ($parent_child_number == $parent_child_counter) && ($area_expense_row['level'] == 2) && ($area_expense_row['has_child'] == 0)): ?>
                        <tr>
                            <td>
                                <strong>&nbsp;Total: </strong>
                            </td>
                            <td class="text-center"><strong>{{ number_format($grand_parent_total_allocation, 2) }}</strong></td>
                            <td class="text-center"><strong>{{ number_format($grand_parent_total_expense, 2) }}</strong></td>
                            <td class="text-center"><strong>{{ number_format($grand_parent_total_balance, 2) }}</strong></td>
                        </tr>
                    <?php endif; ?>
                    @endforeach
                    <?php if ((in_array('-1', $data['selected_head_row_id']))): ?>
                        <tr>
                            <td>
                                <strong>&nbsp;Area Total&nbsp;</strong>
                            </td>
                            <td class="text-center">
                                <?php if (isset($data['total_allocation_by_area'][$area_row_id_key])): ?>
                                    <strong>{{ number_format($data['total_allocation_by_area'][$area_row_id_key], 2) }}</strong>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if (isset($data['total_expense_by_area'][$area_row_id_key])): ?>
                                    <strong>{{ number_format($data['total_expense_by_area'][$area_row_id_key], 2) }}</strong>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if (isset($data['total_balance_by_area'][$area_row_id_key])): ?>
                                    <strong>{{ number_format($data['total_balance_by_area'][$area_row_id_key], 2) }}</strong>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td>
                                <strong>&nbsp;Area Total&nbsp;</strong>
                            </td>
                            <td class="text-center">
                                <?php if (isset($data['selected_list_head_total_allocation'][$area_row_id_key])): ?>
                                    <strong>{{ number_format($data['selected_list_head_total_allocation'][$area_row_id_key], 2) }}</strong>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if (isset($data['selected_list_head_total_expense'][$area_row_id_key])): ?>
                                    <strong>{{ number_format($data['selected_list_head_total_expense'][$area_row_id_key], 2) }}</strong>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if (isset($data['selected_list_head_total_balance'][$area_row_id_key])): ?>
                                    <strong>{{ number_format($data['selected_list_head_total_balance'][$area_row_id_key], 2) }}</strong>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            @if(($area_counter < $data_area_number_count) && ($data['selected_area_row_id'] == -1))
            <div class="page-break"></div>
            @endif
            <?php
            ++$area_counter;
            $parent_serial = 1;
            ?>
            @endforeach
            <?php if ((in_array('-1', $data['selected_head_row_id'])) && ($data['selected_area_row_id'] == -1)): ?>
                <table style="margin-top:10px;" class="table table-striped table-bordered table-hover table-checkable order-column">
                    <tbody>
                        <tr>
                            <td width="55%">
                                <strong>&nbsp;Grand Total&nbsp;( All Areas ) </strong>
                            </td>
                            <td class="text-center">
                                <?php if (isset($data['grand_total_allocation'])): ?>
                                    <strong>{{ number_format($data['grand_total_allocation'], 2) }}</strong>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if (isset($data['grand_total_expense'])): ?>
                                    <strong>{{ number_format($data['grand_total_expense'], 2) }}</strong>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if (isset($data['grand_total_balance'])): ?>
                                    <strong>{{ number_format($data['grand_total_balance'], 2) }}</strong>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </tbody>                        
                </table>
            <?php endif; ?>
            <?php if (!(in_array('-1', $data['selected_head_row_id'])) && ($data['selected_area_row_id'] == -1)): ?>
                <table style="margin-top:10px;" class="table table-striped table-bordered table-hover table-checkable order-column">
                    <tbody>
                        <tr>
                            <td width="55%">
                                <strong>&nbsp;Grand Total&nbsp;( All Areas ) </strong>
                            </td>
                            <td class="text-center">
                                <?php if (isset($data['grand_total_allocation'])): ?>
                                    <strong>{{ number_format($data['grand_total_allocation'], 2) }}</strong>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if (isset($data['grand_total_expense'])): ?>
                                    <strong>{{ number_format($data['grand_total_expense'], 2) }}</strong>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if (isset($data['grand_total_balance'])): ?>
                                    <strong>{{ number_format($data['grand_total_balance'], 2) }}</strong>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </tbody>                        
                </table>
            <?php endif; ?>
            @endif
        </div>
</body></html>