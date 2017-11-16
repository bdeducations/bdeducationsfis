<!DOCTYPE html>
<html><head>
        <title>Budget Allocation Report PDF</title>
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
            <div style="margin-bottom:5px;">
                <h4 style="margin:0;padding:0;">Budget Allocation Report With Adjustment : <?php echo $data['selected_budget_year']; ?></h4>
            </div>
            @if($data['account_allocation_list'])
            <?php
            $data_area_number_count = count($data['account_allocation_list']);
            $area_counter = 1;
            $parent_serial = 1;
            ?>
            @foreach($data['account_allocation_list'] as $area_row_id_key => $area_allocation_row)
            <h4 style="text-transform:uppercase;text-align:center;text-decoration:underline;">{{ $area_row_id_key }}</h4>
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="UT_budget_report_balance_extended">
                <thead>
                    <tr>
                        <th width="50%" style="text-align:left;padding-left:10px">Head Name</th>
                        <th width="15%" style="text-align:left;padding-left:10px">Allocation(original)</th>
                        <th width="10%" style="text-align:left;padding-left:10px">Donate</th>
                        <th width="10%" style="text-align:left;padding-left:10px">Receive</th>
                        <th width="15%" style="text-align:left;padding-left:10px">Allocation(Current)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($area_allocation_row as $allocation_row)
                    <tr>
                        <td style="text-align:left;padding-left:10px">
                            <strong>
                               <span>{{ $parent_serial }}&nbsp;.&nbsp;</span>
                                <?php $parent_serial++; ?>
                                {{ $allocation_row['title'] }}
                            </strong>
                        </td>
                        <td style="text-align:center;padding-left:10px">
                            @if(isset($allocation_row['head_total_allocation']) && ($allocation_row['head_total_allocation'] != 0))
                            {{ number_format($allocation_row['head_total_allocation'], 2) }}
                            @else
                            0.00
                            @endif
                        </td>
                        <td style="text-align:center;padding-left:10px">
                            @if(isset($allocation_row['head_total_donation']) && ($allocation_row['head_total_donation'] != 0))
                            {{ number_format($allocation_row['head_total_donation'], 2) }}
                            @else
                            0.00
                            @endif
                        </td>
                        <td style="text-align:center;padding-left:10px">
                            @if(isset($allocation_row['head_total_adjustment']) && ($allocation_row['head_total_adjustment'] != 0))
                            {{ number_format($allocation_row['head_total_adjustment'], 2) }}
                            @else
                            0.00
                            @endif
                        </td>
                        <td style="text-align:center;padding-left:10px">
                            @if(isset($allocation_row['head_current_total_allocation']) && ($allocation_row['head_current_total_allocation'] != 0))
                            {{ number_format($allocation_row['head_current_total_allocation'], 2) }}
                            @else
                            0.00
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    <?php if ($data['selected_head_row_id'] == -1): ?>
                        <tr>
                            <td>
                                <strong>&nbsp;Total( {{ $area_row_id_key }} ) </strong>
                            </td>
                            <td class="text-center">
                                <?php if (isset($data['total_allocation_by_area'][$area_row_id_key])): ?>
                                    <strong>{{ number_format($data['total_allocation_by_area'][$area_row_id_key], 2) }}</strong>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if (isset($data['total_donation_by_area'][$area_row_id_key])): ?>
                                    <strong>{{ number_format($data['total_donation_by_area'][$area_row_id_key], 2) }}</strong>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if (isset($data['total_reception_by_area'][$area_row_id_key])): ?>
                                    <strong>{{ number_format($data['total_reception_by_area'][$area_row_id_key], 2) }}</strong>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if (isset($data['total_current_allocation_by_area'][$area_row_id_key])): ?>
                                    <strong>{{ number_format($data['total_current_allocation_by_area'][$area_row_id_key], 2) }}</strong>
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
            <?php if (($data['selected_head_row_id'] == -1) && ($data['selected_area_row_id'] == -1)): ?>
                <table style="margin-top:10px;" class="table table-striped table-bordered table-hover table-checkable order-column">
                    <tbody>
                        <tr>
                            <td width="50%">
                                <strong>&nbsp;Grand Total&nbsp;( All Areas ) : </strong>
                            </td>
                            <td class="text-center"><strong>{{ number_format($data['grand_total_allocation'], 2) }}</strong></td>
                            <td class="text-center"><strong>{{ number_format($data['grand_total_donation'], 2) }}</strong></td>
                            <td class="text-center"><strong>{{ number_format($data['grand_total_reception'], 2) }}</strong></td>
                            <td class="text-center"><strong>{{ number_format($data['grand_total_current_allocation'], 2) }}</strong></td>
                        </tr>
                    </tbody>                        
                </table>
            <?php endif;?>
            @endif
        </div>
</body></html>