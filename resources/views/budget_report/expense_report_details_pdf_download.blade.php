<!DOCTYPE html>
<html>
    <head>
        <title>Budget Expense Report Details PDF</title>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" href="{{ url('/')}}/public/adminlte/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
        <style type="text/css">
            body{
                font-size:12px;
                font-weight:100;
            }
        </style>
    </head>
    <body>
        <div class="pdfcontent" style="text-align:center;">
            <div style="margin-bottom:20px;">
                <h3 style="margin:0;padding:0;">Budget Expense Report Details</h3>
                <hr>
                <p style="margin:7px 0;text-align:left;">
                    <span style="margin-left:15px;font-size:13px;">
                        <strong>Area:</strong> <?php
                        if ($data['selected_area_row_id'] > 0):
                            echo $data['area_row_detail']->title;
                        else:
                            echo "All Area";
                        endif;
                        ?>
                    </span>
                    <span style="float:right;font-size:13px;">
                        <strong>Year:</strong> <?php echo $data['selected_budget_year']; ?>
                    </span>
                </p>
                <strong>{{ $data['head_name'] }}</strong>
            </div>
            <table class="table table-striped table-bordered table-hover" width="100%">
                <thead>
                    <tr>
                        <th style="text-align:left;padding-left:10px;width:60%;padding-bottom:10px;">Area Name </th>
                        <th style="text-align:center;padding-left:10px;width:20%;padding-bottom:10px;">Expense amount </th>
                        <th style="text-align:center;padding-left:10px;width:20%;padding-bottom:10px;">Expense Date </th>
                    </tr>
                </thead>
                <tbody>
                    @if($data['expense_list'])
                    @foreach($data['expense_list'] as $expense_row)

                    <tr>            
                        <td style="text-align:left;padding-left:10px">
                            {{ $expense_row->title }}
                        </td> 
                        <td style="text-align:center;padding-left:10px"> 
                            {{ $expense_row->amount ? number_format($expense_row->amount, 2) : '' }}

                        </td> 
                        <td style="text-align:center;padding-left:10px"> 
                            <?php echo date('F j, Y', strtotime($expense_row->expense_at)); ?>
                        </td> 
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </body>
</html>