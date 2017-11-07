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
            @page {
                margin-bottom:0;
                margin-top:10px;
            }
        </style>
    </head>
    <body>
        <div class="pdfcontent" style="text-align:center;">
            <div style="margin-bottom:5px;">
                <h4 style="margin:0;padding:0;">Budget Balance Summary Sheet : <?php echo $data['selected_budget_year']; ?></h4>
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
                    $parent_serial = 1;
                    ?>
                    @foreach($data['account_expense_list'] as $expense_row)
                    <tr>
                        <td style="text-align:left;padding-left:10px">
                            <strong>
                                <span>{{ $parent_serial }}&nbsp;.&nbsp;</span>
                                {{ $expense_row->title }}
                            </strong>
                        </td>
                        <td style="text-align:center;padding-left:10px">
                            @if(isset($expense_row->parent_head_total_allocation) && ($expense_row->parent_head_total_allocation != 0))
                            {{ number_format($expense_row->parent_head_total_allocation, 2) }}
                            @else
                            0.00
                            @endif
                        </td>
                        <td style="text-align:center;padding-left:10px">
                            @if(isset($expense_row->parent_head_total_expense) && ($expense_row->parent_head_total_expense != 0))
                            {{ number_format($expense_row->parent_head_total_expense, 2) }}
                            @else
                            0.00
                            @endif
                        </td>
                        <td style="text-align:center;padding-left:10px">
                            @if(isset($expense_row->parent_head_current_balance) && ($expense_row->parent_head_current_balance != 0))
                            {{ number_format($expense_row->parent_head_current_balance, 2) }}
                            @else
                            0.00
                            @endif
                        </td>
                    </tr>
                    <?php ++$parent_serial; ?>
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