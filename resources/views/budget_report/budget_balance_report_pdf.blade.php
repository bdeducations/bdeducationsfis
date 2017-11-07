<!DOCTYPE html>
<html>
    <head>
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
            @page {
                margin-bottom:0;
                margin-top:10px;
            }
        </style>
    </head>
    <body>
        <div class="pdfcontent" style="text-align:center;">
            <div style="margin-bottom:5px;">
                <h4 style="margin:0;padding:0;">Budget Balance Sheet : <?php echo $data['selected_budget_year']; ?></h4>
            </div>
            <h4 style="text-transform:uppercase;text-align:center;text-decoration:underline;"> {{ $data['area_name'] }}</h4>
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="UT_budget_report_balance_extended">
                <thead>
                    <tr>
                        <th width="55%" style="text-align:left;padding-left:10px">Head Name</th> 
                        <th width="15%" style="text-align:center;padding-left:10px">Allocation</th>
                        <th width="15%" style="text-align:center;padding-left:10px">Expense</th>
                        <th width="15%" style="text-align:center;padding-left:10px">Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @if($data['account_expense_list'])
                    <?php
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
                    @foreach($data['account_expense_list'] as $expense_row)
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
                            @if($expense_row->level == 0)
                            <strong>
                                <?php
                                $grand_parent_child_counter = 0;
                                $child_serial = 1;
                                if ($expense_row->has_child == 1):
                                    $parent_child_number = $expense_row->parent_head_child_number;
                                    $parent_total_allocation = $expense_row->parent_head_total_allocation;
                                    $parent_total_expense = $expense_row->parent_head_total_expense;
                                    $parent_total_balance = $expense_row->parent_head_current_balance;
                                    $grand_parent_child_number = $expense_row->parent_head_child_number;
                                    $grand_parent_total_allocation = $expense_row->parent_head_total_allocation;
                                    $grand_parent_total_expense = $expense_row->parent_head_total_expense;
                                    $grand_parent_total_balance = $expense_row->parent_head_current_balance;
                                    $parent_child_counter = 0;
                                endif;
                                ?>
                                <span>{{ $parent_serial }}&nbsp;.&nbsp;</span>
                                <?php $parent_serial++; ?>
                                @endif
                                @if($expense_row->level == 1)
                                &nbsp;
                                @if($expense_row->has_child == 1)
                                    <strong>
                                @endif
                                <?php
                                $grand_child_serial = 1;
                                echo $data['alphabets'][$child_serial] . ".";
                                $child_serial++;
                                if ($expense_row->has_child == 1):
                                    $parent_child_number = $expense_row->parent_head_child_number;
                                    $parent_total_allocation = $expense_row->parent_head_total_allocation;
                                    $parent_total_expense = $expense_row->parent_head_total_expense;
                                    $parent_total_balance = $expense_row->parent_head_current_balance;
                                    $parent_child_counter = 0;
                                    $grand_parent_child_counter++;
                                else:
                                    $parent_child_counter++;
                                endif;
                                ?>
                                &nbsp;
                                @endif
                                @if($expense_row->level == 2)
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <?php
                                echo $data['roman'][$grand_child_serial] . ".";
                                $grand_child_serial++;
                                $parent_child_counter++;
                                ?>&nbsp;
                                @endif 
                                @if($expense_row->level == 3) &nbsp; &nbsp; &nbsp; - - - @endif       
                                @if($expense_row->level == 4) &nbsp; &nbsp; &nbsp; &nbsp; - - - - @endif       
                                @if($expense_row->level == 5) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  - - - - - @endif       
                                @if($expense_row->level > 5)  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - - - @endif 
                                {{ $expense_row->title }} 
                                @if($expense_row->level == 0) </strong>  @endif
                                @if($expense_row->level == 1)
                                    @if($expense_row->has_child == 1)
                                        </strong>
                                    @endif
                                @endif
                        </td> 
                        <td style="text-align:center;padding-left:10px">
                            @if(isset($expense_row->total_allocation) && ($expense_row->total_allocation != 0) && ($expense_row->has_child == 0))
                            {{ number_format($expense_row->total_allocation, 2) }}
                            @elseif(isset($expense_row->total_allocation) && ($expense_row->total_allocation == 0) && ($expense_row->has_child == 0))
                            0.00
                            @endif
                        </td>
                        <td style="text-align:center;padding-left:10px">
                            @if(isset($expense_row->total_expense) && ($expense_row->total_expense != 0) && ($expense_row->has_child == 0))
                            {{ number_format($expense_row->total_expense, 2) }}
                            @elseif(isset($expense_row->total_expense) && ($expense_row->total_expense == 0) && ($expense_row->has_child == 0))
                            0.00
                            @endif
                        </td>
                        <td style="text-align:center;padding-left:10px">
                            @if(isset($expense_row->head_current_balance) && ($expense_row->head_current_balance != 0) && ($expense_row->has_child == 0))
                            {{ number_format($expense_row->head_current_balance, 2) }}
                            @elseif(isset($expense_row->head_current_balance) && ($expense_row->head_current_balance == 0) && ($expense_row->has_child == 0))
                            0.00
                            @endif
                        </td>
                    </tr>
                    <?php if (($parent_child_number == $parent_child_counter) && ($expense_row->level == 1) && ($expense_row->has_child == 0)): ?>
                        <tr>
                            <td>
                                <strong>&nbsp;&nbsp;&nbsp;Total: </strong>
                            </td>
                            <td class="text-center"><strong>{{ number_format($parent_total_allocation, 2) }}</strong></td>
                            <td class="text-center"><strong>{{ number_format($parent_total_expense, 2) }}</strong></td>
                            <td class="text-center"><strong>{{ number_format($parent_total_balance, 2) }}</strong></td>
                        </tr>
                    <?php endif; ?>
                    <?php if (($parent_child_number == $parent_child_counter) && ($expense_row->level == 2) && ($expense_row->has_child == 0)): ?>
                        <tr>
                            <td>
                                <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total: </strong>
                            </td>
                            <td class="text-center"><strong>{{ number_format($parent_total_allocation, 2) }}</strong></td>
                            <td class="text-center"><strong>{{ number_format($parent_total_expense, 2) }}</strong></td>
                            <td class="text-center"><strong>{{ number_format($parent_total_balance, 2) }}</strong></td>
                        </tr>
                    <?php endif; ?>
                    <?php if (($grand_parent_child_number == $grand_parent_child_counter) && ($parent_child_number == $parent_child_counter) && ($expense_row->level == 2) && ($expense_row->has_child == 0)): ?>
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
                    <?php if ($data['selected_head_row_id'] == -1): ?>
                        <tr>
                            <td>
                                <strong>&nbsp;Total&nbsp;( {{ $data['area_name'] }} ) </strong>
                            </td>
                            <td class="text-center">
                                <strong>{{ number_format($data['area_total_allocation'], 2) }}</strong>
                            </td>
                            <td class="text-center">
                                <strong>{{ number_format($data['area_total_expense'], 2) }}</strong>
                            </td>
                            <td class="text-center">
                                <strong>{{ number_format($data['area_total_balance'], 2) }}</strong>
                            </td>
                        </tr>
                    <?php endif; ?>
                    @endif
                </tbody>
            </table>
        </div>
    </body>
</html>