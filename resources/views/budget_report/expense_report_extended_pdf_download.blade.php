<!DOCTYPE html>
<html><head>
        <title>Budget Expense Report PDF</title>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" href="{{ url('/')}}/public/adminlte/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
        <style type="text/css">
            body{
                font-size:9px;
                font-weight:100;
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
            .table > tbody > tr > td,
            .table > tbody > tr > th,
            .table > tfoot > tr > td,
            .table > tfoot > tr > th,
            .table > thead > tr > td,
            .table > thead > tr > th {
                padding:5px !important;
            }
        </style>
</head><body>
        <div class="pdfcontent" style="text-align:center;">
            <div style="margin-bottom:0;">
                <h3 style="margin:0;padding:0;">Budget Expense Report : <?php echo $data['budget_year']; ?> </h3>
            </div>
            @if($data['account_expense_list'])
            <?php
            $area_counter = 1;
            $data_area_number_count = count($data['account_expense_list']);
            $child_serial = 1;
            $grand_child_serial = 1;
            $grand_parent_child_number = 0;
            $grand_parent_child_counter = 0;
            $grand_parent_total_expense = 0;
            $parent_child_number = 0;
            $parent_child_counter = 0;
            $parent_total_expense = 0;
            ?>
            @foreach($data['account_expense_list'] as $area_row_id_key => $expense_row)
            <?php
            $parent_serial = 1;
            if (isset($child_serial) && $child_serial > 26):
                $child_serial = 1;
            endif;
            if (isset($grand_child_serial) && $grand_child_serial > 26):
                $grand_child_serial = 1;
            endif;
            ?>
            <h4 style="text-transform:uppercase;text-align:center;padding-top:0;text-decoration:underline;"> {{ $data['report_title'] }}</h4>
            <table class="table table-striped table-bordered table-hover" width="100%">
                <thead>
                    <tr>
                        <th style="text-align:left;padding-left:10px;width:80%;padding-bottom:5px;">Head Name</th>
                        <th style="text-align:center;padding-left:10px;width:20%;padding-bottom:5px;">Expense amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expense_row as $area_expense_row)
                    <tr>
                        <td style="text-align:left;padding-left:10px;width:80%;">
                            @if($area_expense_row['level'] == 0)
                            <strong>
                                <?php
                                $grand_parent_child_counter = 0;
                                $child_serial = 1;
                                if ($area_expense_row['has_child'] == 1):
                                    $parent_child_number = $area_expense_row['parent_head_child_number'];
                                    $parent_total_expense = $area_expense_row['parent_head_total_expense'];
                                    $grand_parent_child_number = $area_expense_row['parent_head_child_number'];
                                    $grand_parent_total_expense = $area_expense_row['parent_head_total_expense'];
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
                                    $parent_total_expense = $area_expense_row['parent_head_total_expense'];
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
                        <td style="text-align:center;padding-left:10px;width:20%;">
                            @if(isset($area_expense_row['total_expense']) && ($area_expense_row['total_expense'] != 0) && ($area_expense_row['has_child'] == 0))
                            {{ number_format($area_expense_row['total_expense'], 2) }}
                            @elseif(isset($area_expense_row['total_expense']) && ($area_expense_row['total_expense'] == 0) && ($area_expense_row['has_child'] == 0))
                            0.00
                            @endif
                        </td>
                    </tr><?php if (($parent_child_number == $parent_child_counter) && ($area_expense_row['level'] == 1) && ($area_expense_row['has_child'] == 0)): ?>
                        <tr>
                            <td>
                                <strong>&nbsp;&nbsp;&nbsp;Total: </strong>
                            </td>
                            <td class="text-center"><strong>{{ number_format($parent_total_expense, 2) }}</strong></td>
                        </tr>
                    <?php endif; ?>
                    <?php if (($parent_child_number == $parent_child_counter) && ($area_expense_row['level'] == 2) && ($area_expense_row['has_child'] == 0)): ?>
                        <tr>
                            <td>
                                <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total: </strong>
                            </td>
                            <td class="text-center"><strong>{{ number_format($parent_total_expense, 2) }}</strong></td>
                        </tr>
                    <?php endif; ?>
                    <?php if (($grand_parent_child_number == $grand_parent_child_counter) && ($parent_child_number == $parent_child_counter) && ($area_expense_row['level'] == 2) && ($area_expense_row['has_child'] == 0)): ?>
                        <tr>
                            <td>
                                <strong>&nbsp;Total: </strong>
                            </td>
                            <td class="text-center"><strong>{{ number_format($grand_parent_total_expense, 2) }}</strong></td>
                        </tr>
                    <?php endif; ?>
                    @endforeach
                   <?php if (in_array('-1', $data['selected_head_row_id'])): ?>
                        <tr>
                            <td>
                                <strong>&nbsp;Total&nbsp;</strong>
                            </td>
                            <td class="text-center">
                                <?php if (isset($data['total_area_expense_list'])): ?>
                                    <strong>{{ number_format($data['total_area_expense_list'][$area_row_id_key], 2) }}</strong>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php else:?>
                        <tr>
                            <td>
                                <strong>&nbsp;Total </strong>
                            </td>
                            <td class="text-center">
                                <?php if (isset($data['all_head_total_expense'][$area_row_id_key])): ?>
                                    <strong>{{ number_format($data['all_head_total_expense'][$area_row_id_key], 2) }}</strong>
                                <?php endif; ?>
                            </td>
                       </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            @if(($area_counter < $data_area_number_count) && (in_array('-1', $data['selected_head_row_id'])))
            <div class="page-break"></div>
            @endif
            <?php
            $area_counter++;
            ?>
            @endforeach
            <?php if ((in_array('-1', $data['selected_head_row_id'])) && ($data['selected_area_row_id'] == -1)): ?>
                <table style="margin-top:7px;" class="table table-striped table-bordered table-hover table-checkable order-column">
                    <tbody>
                        <tr>
                            <td width="80%">
                                <strong>&nbsp;Grand Total&nbsp;( All Areas ) : </strong>
                            </td>
                            <td class="text-center"><strong>{{ number_format($data['grand_total_expense'], 2) }}</strong></td>
                        </tr>
                    </tbody>                        
                </table>
            <?php endif;?>
            @endif
        </div>
</body></html>