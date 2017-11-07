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
                font-size:10px;
                font-weight:100;
            }
        </style>
    </head>
    <body>
        <div class="pdfcontent" style="text-align:center;">
            <div style="margin-bottom:20px;">
                <h4 style="margin:0;padding:0;">Budget Allocation Details Report</h4>
                <hr>
                <p style="margin:7px 0;text-align:left;">
                    <span style="float:left;margin-left:0;">
                        <strong>Area:</strong> <?php
                        if ($data['selected_area_row_id'] > 0):
                            echo $data['area_details_row']->title;
                        else:
                            echo "All Area";
                        endif;
                        ?>
                    </span>
                    <span style="float:right;margin-right:0;">
                        <strong>Year:</strong> <?php echo $data['selected_budget_year']; ?>
                    </span>
                </p>
                <div style="clear:both;"></div>
            </div>
            <div style="margin-bottom:10px;">
                <p><strong>{{ $data['head_name'] }}</strong></p>
            </div>
            <table class="table table-striped table-bordered table-hover table-checkable order-column" width="100%">
                <thead>
                    <tr>
                        <th width="70%" style="text-align:left;padding-left:10px"> Allocation amount </th>
                        <th width="30%" style="text-align:left;padding-left:10px"> Allocation Date </th>
                    </tr>
                </thead>
                <tbody>
                    @if($data['allocation_list'])
                    @foreach($data['allocation_list'] as $allocation_row)    
                    <tr>            
                        <td style="text-align:left;padding-left:10px"> 
                            {{ $allocation_row->amount ? number_format($allocation_row->amount, 2) : '' }}
                        </td> 
                        <td style="text-align:left;padding-left:10px"> 
                            <?php echo date('F j, Y', strtotime($allocation_row->allocation_at)); ?>
                        </td> 
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </body>
</html>