<!DOCTYPE html>
<html>
    <head>
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
                page-break-before:always;
                page-break-after:auto;
                page-break-inside:auto;
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
    </head>
    <body>
        <div class="pdfcontent" style="text-align:center;">
            <div style="margin-bottom:0;">
                <h3 style="margin:0;padding:0;">Budget Expense Report : <?php echo $data['budget_year']; ?></h3>
            </div>
            <h4 style="text-transform:uppercase;text-align:center;text-decoration:underline;"> {{ $data['area_row_title'] }}</h4>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="text-align:left;padding-left:10px;width:80%;padding-bottom:5px;">Head Name </th>
                        <th style="text-align:center;padding-left:10px;width:20%;padding-bottom:5px;">Expense amount </th>
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
                    $grand_parent_total_expense = 0;
                    $parent_child_number = 0;
                    $parent_child_counter = 0;
                    $parent_total_expense = 0;
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
                        <td style="text-align:left;padding-left:10px;width:80%;">
                            @if($expense_row->level == 0)
                            <strong>
                                <?php
                                $grand_parent_child_counter = 0;
                                $child_serial = 1;
                                if ($expense_row->has_child == 1):
                                    $parent_child_number = $expense_row->parent_head_child_number;
                                    $parent_total_expense = $expense_row->parent_head_total_expense;
                                    $grand_parent_child_number = $expense_row->parent_head_child_number;
                                    $grand_parent_total_expense = $expense_row->parent_head_total_expense;
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
                                        $parent_total_expense = $expense_row->parent_head_total_expense;
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
                        <td style="text-align:center;padding-left:10px;width:20%;">
                            @if(isset($expense_row->total_expense) && ($expense_row->total_expense != 0) && ($expense_row->has_child == 0))
                            {{ number_format($expense_row->total_expense, 2) }}
                            @elseif(isset($expense_row->total_expense) && ($expense_row->total_expense == 0) && ($expense_row->has_child == 0))
                            0.00
                            @endif
                        </td>
                    </tr>
                    <?php if (($parent_child_number == $parent_child_counter) && ($expense_row->level == 1) && ($expense_row->has_child == 0)): ?>
                        <tr>
                            <td>
                                <strong>&nbsp;&nbsp;&nbsp;Total: </strong>
                            </td>
                            <td class="text-center"><strong>{{ number_format($parent_total_expense, 2) }}</strong></td>
                        </tr>
                    <?php endif; ?>
                    <?php if (($parent_child_number == $parent_child_counter) && ($expense_row->level == 2) && ($expense_row->has_child == 0)): ?>
                        <tr>
                            <td>
                                <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total: </strong>
                            </td>
                            <td class="text-center"><strong>{{ number_format($parent_total_expense, 2) }}</strong></td>
                        </tr>
                    <?php endif; ?>
                    <?php if (($grand_parent_child_number == $grand_parent_child_counter) && ($parent_child_number == $parent_child_counter) && ($expense_row->level == 2) && ($expense_row->has_child == 0)): ?>
                        <tr>
                            <td>
                                <strong>&nbsp;Total: </strong>
                            </td>
                            <td class="text-center"><strong>{{ number_format($grand_parent_total_expense, 2) }}</strong></td>
                        </tr>
                    <?php endif; ?>
                    @endforeach
                    @endif
                    <?php if ($data['selected_head_row_id'] == -1): ?>
                        <tr>
                            <td>
                                <strong>&nbsp;Total( {{$data['area_row_title']}} ) </strong>
                            </td>
                            <td class="text-center">
                                <?php if (isset($data['total_expense_by_area'])): ?>
                                    <strong>{{ number_format($data['total_expense_by_area'], 2) }}</strong>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </body>
</html>