<!DOCTYPE html>
<html><head>
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
</head><body>
        <div class="pdfcontent" style="text-align:center;">
            <div style="">
                <div style="float:left;width:130px;margin-bottom:10px;">
                    <img src="{{ url('/')}}/public/img/logo.png" width="115" height="40" />
                </div>
                <div style="float:right;margin-right:95px;text-align:left;margin-bottom:10px;">
                    <h2 style="margin:0;">United Trust MIS</h2>
                </div>
            </div>
            <div style="clear:both;"></div>
            <div style="margin-bottom:20px;">
                <h4 style="margin:0;padding:0;">Budget Expense Report</h4>
                <hr>
                <p style="margin:7px 0;text-align:left;">
                    <span style="margin-left:10px;">
                        <strong>Area:</strong> <?php
                        if ($data['area_row_id'] > 0):
                            echo $data['area_row_detail']->title;
                        else:
                            echo "All Area";
                        endif;
                        ?>
                    </span>
                    <span style="margin-left:300px;">
                        <strong>Year:</strong> <?php echo $data['budget_year']; ?>
                    </span>
                </p>
            </div>
            <table class="table table-striped table-bordered table-hover" width="100%">
                <thead>
                    <tr>
                        <th style="text-align:left;padding-left:10px;width:60%;padding-bottom:10px;"> Head Name </th> 
                        <th style="text-align:left;padding-left:10px;width:40%;padding-bottom:10px;"> Expense amount </th>
                    </tr>
                </thead>
                <tbody>
                    @if($data['account_expense_list'])
                    @foreach($data['account_expense_list'] as $expense_row)    
                    <tr>            
                        <td style="text-align:left;padding-left:10px;width:60%;">

                            @if($expense_row->level == 0) <b>  @endif 
                                @if($expense_row->level == 1) &nbsp; - @endif   
                                @if($expense_row->level == 2) &nbsp; &nbsp; - - @endif     
                                @if($expense_row->level == 3) &nbsp; &nbsp; &nbsp; - - - @endif       
                                @if($expense_row->level == 4) &nbsp; &nbsp; &nbsp; &nbsp; - - - - @endif       
                                @if($expense_row->level == 5) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  - - - - - @endif       
                                @if($expense_row->level > 5)  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - - - @endif 
                                {{ $expense_row->title }} 
                                @if($expense_row->level == 0) </b>  @endif

                        </td> 
                        <td style="text-align:left;padding-left:10px;width:40%;"> 
                            @if(isset($expense_row->total_expense) && ($expense_row->total_expense != 0) && ($expense_row->has_child == 0))
                            {{ number_format($expense_row->total_expense, 2) }}
                            @elseif(!isset($expense_row->total_expense) && ($expense_row->total_expense == 0) && ($expense_row->has_child == 0))
                            0.00
                            @elseif(isset($expense_row->parent_head_total_expense) && ($expense_row->parent_head_total_expense != 0) && ($expense_row->has_child == 1))
                            {{ number_format($expense_row->parent_head_total_expense, 2) }}   
                            @else
                            0.00
                            @endif

                        </td> 
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>       
</body></html>