<!DOCTYPE html>
<html>
    <head>
        <title>Budget Balance Summary Report PDF</title>
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
                page-break-before:avoid;
                page-break-after:always;
                page-break-inside:avoid;
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
                <h4 style="margin:0;padding:0;">Budget Balance Summary Report : <?php echo $data['selected_budget_year']; ?></h4>
            </div>
            @if($data['account_expense_list'])
            <?php
            $data_area_number_count = count($data['account_expense_list']);
            $area_counter = 0;
            $parent_serial = 1;
            ?>
            @foreach($data['account_expense_list'] as $area_row_id_key => $expense_row)
            <h4 style="text-transform:uppercase;text-align:center;text-decoration:underline;"> {{ $area_row_id_key }}</h4>
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
                        <td style="text-align:left;padding-left:10px">
                            <span>{{ $parent_serial }}&nbsp;.&nbsp;</span>
                            <?php $parent_serial++; ?>
                            <strong>
                                {{ $area_expense_row['title'] }}
                            </strong>
                        </td>
                        <td style="text-align:center;padding-left:10px">
                            @if(isset($area_expense_row['parent_head_total_allocation']) && ($area_expense_row['parent_head_total_allocation'] != 0))
                            {{ number_format($area_expense_row['parent_head_total_allocation'], 2) }}
                            @else
                            0.00
                            @endif
                        </td>
                        <td style="text-align:center;padding-left:10px">
                            @if(isset($area_expense_row['parent_head_total_expense']) && ($area_expense_row['parent_head_total_expense'] != 0))
                            {{ number_format($area_expense_row['parent_head_total_expense'], 2) }}
                            @else
                            0.00
                            @endif
                        </td>
                        <td style="text-align:center;padding-left:10px">
                            @if(isset($area_expense_row['parent_head_current_balance']) && ($area_expense_row['parent_head_current_balance'] != 0))
                            {{ number_format($area_expense_row['parent_head_current_balance'], 2) }}
                            @else
                            0.00
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    <?php if (($data['selected_head_row_id'] == -1) && ($data['selected_area_row_id'] == -1)): ?>
                        <tr>
                            <td>
                                <strong>&nbsp;Total&nbsp;( {{ $area_row_id_key }} ) </strong>
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
                <table style="margin-top:10px;" class="table table-striped table-bordered table-hover table-checkable order-column">
                    <tbody>
                        <tr>
                            <td width="50%">
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
    </body>
</html>