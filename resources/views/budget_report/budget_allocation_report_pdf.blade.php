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
                <h4 style="margin:0;padding:0;">Budget Allocation Report: <?php echo $data['selected_budget_year']; ?></h4>
            </div>
            @if($data['account_allocation_list'])
            <?php
            $area_counter = 1;
            $data_area_number_count = count($data['account_allocation_list']);
            $child_serial = 1;
            $parent_serial = 1;
            $grand_child_serial = 1;
            $grand_parent_child_number = 0;
            $grand_parent_child_counter = 0;
            $grand_parent_total_allocation = 0;
            $parent_child_number = 0;
            $parent_child_counter = 0;
            $parent_total_allocation = 0;
            ?>
            @foreach($data['account_allocation_list'] as $area_row_id_key => $area_allocation_row)
            <?php
            if (isset($child_serial) && $child_serial > 26):
                $child_serial = 1;
            endif;
            if (isset($grand_child_serial) && $grand_child_serial > 26):
                $grand_child_serial = 1;
            endif;
            ?>
            <h4 style="text-transform:uppercase;text-align:center;text-decoration:underline;"> {{ $area_row_id_key }}</h4>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="70%" style="text-align:left;padding-left:10px">Head Name</th>
                        <th width="30%" style="text-align:center;padding-left:10px">Allocation</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($area_allocation_row as $allocation_row)

                    <tr>
                        <td style="text-align:left;padding-left:10px">
                            @if($allocation_row['level'] == 0)
                            <strong>
                                <?php
                                $grand_parent_child_counter = 0;
                                $child_serial = 1;
                                if ($allocation_row['has_child'] == 1):
                                    $parent_child_number = $allocation_row['parent_head_child_number'];
                                    $parent_total_allocation = $allocation_row['parent_head_total_allocation'];
                                    $grand_parent_child_number = $allocation_row['parent_head_child_number'];
                                    $grand_parent_total_allocation = $allocation_row['parent_head_total_allocation'];
                                    $parent_child_counter = 0;
                                endif;
                                ?>
                                <span>{{ $parent_serial }}&nbsp;.&nbsp;</span>
                                <?php $parent_serial++; ?>
                                @endif
                                @if($allocation_row['level'] == 1)
                                &nbsp;
                                @if($allocation_row['has_child'] == 1)
                                <strong>
                                    @endif
                                    <?php
                                    $grand_child_serial = 1;
                                    echo $data['alphabets'][$child_serial] . ".";
                                    $child_serial++;
                                    if ($allocation_row['has_child'] == 1):
                                        $parent_child_number = $allocation_row['parent_head_child_number'];
                                        $parent_child_counter = 0;
                                        $parent_total_allocation = $allocation_row['parent_head_total_allocation'];
                                        $grand_parent_child_counter++;
                                    else:
                                        $parent_child_counter++;
                                    endif;
                                    ?>
                                    &nbsp;
                                    @endif
                                    @if($allocation_row['level'] == 2)
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php
                                    echo $data['roman'][$grand_child_serial] . ".";
                                    $grand_child_serial++;
                                    $parent_child_counter++;
                                    ?>&nbsp;
                                    @endif
                                    @if($allocation_row['level'] == 3) &nbsp; &nbsp; &nbsp; - - - @endif
                                    @if($allocation_row['level'] == 4) &nbsp; &nbsp; &nbsp; &nbsp; - - - - @endif
                                    @if($allocation_row['level'] == 5) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  - - - - - @endif
                                    @if($allocation_row['level'] > 5)  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - - - @endif
                                    {{ $allocation_row['title'] }}
                                    @if($allocation_row['level'] == 0) </strong>  @endif
                                @if($allocation_row['level'] == 1)
                                @if($allocation_row['has_child'] == 1)
                            </strong>
                            @endif
                            @endif
                        </td>
                        <td style="text-align:center;padding-left:10px">
                            @if(isset($allocation_row['head_total_allocation']) && ($allocation_row['head_total_allocation'] != 0) && ($allocation_row['has_child'] == 0))
                            {{ number_format($allocation_row['head_total_allocation'], 2) }}
                            @elseif(isset($allocation_row['head_total_allocation']) && ($allocation_row['head_total_allocation'] == 0) && ($allocation_row['has_child'] == 0))
                            0.00
                            @endif
                        </td>
                    </tr>
                    <?php if (($parent_child_number == $parent_child_counter) && ($allocation_row['level'] == 1) && ($allocation_row['has_child'] == 0)): ?>
                        <tr>
                            <td>
                                <strong>&nbsp;&nbsp;&nbsp;Total: </strong>
                            </td>
                            <td class="text-center"><strong>{{ number_format($parent_total_allocation, 2) }}</strong></td>
                        </tr>
                    <?php endif; ?>
                    <?php if (($parent_child_number == $parent_child_counter) && ($allocation_row['level'] == 2) && ($allocation_row['has_child'] == 0)): ?>
                        <tr>
                            <td>
                                <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total: </strong>
                            </td>
                            <td class="text-center"><strong>{{ number_format($parent_total_allocation, 2) }}</strong></td>
                        </tr>
                    <?php endif; ?>
                    <?php if (($grand_parent_child_number == $grand_parent_child_counter) && ($parent_child_number == $parent_child_counter) && ($allocation_row['level'] == 2) && ($allocation_row['has_child'] == 0)): ?>
                        <tr>
                            <td>
                                <strong>&nbsp;Total: </strong>
                            </td>
                            <td class="text-center"><strong>{{ number_format($grand_parent_total_allocation, 2) }}</strong></td>
                        </tr>
                    <?php endif; ?>
                    @endforeach
                    <?php if ($data['selected_head_row_id'] == -1): ?>
                        <tr>
                            <td>
                                <strong>&nbsp;Total&nbsp;( {{ $area_row_id_key }} ) </strong>
                            </td>
                            <td class="text-center">
                                <?php if (isset($data['total_allocation_by_area'][$area_row_id_key])): ?>
                                    <strong>{{ number_format($data['total_allocation_by_area'][$area_row_id_key], 2) }}</strong>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            @if(($area_counter < $data_area_number_count) && ($data['selected_area_row_id'] == -1))
            <div class="page-break"></div>
            @endif
            <?php $parent_serial = 1;
            ++$area_counter; ?>
            @endforeach
                <?php if (($data['selected_head_row_id'] == -1) && ($data['selected_area_row_id'] == -1)): ?>
                        <table style="margin-top:10px;" class="table table-striped table-bordered table-hover table-checkable order-column">
                            <tbody>
                                <tr>
                                    <td width="70%">
                                        <strong>&nbsp;Grand Total&nbsp;(All Areas) : </strong>
                                    </td>
                                    <td colspan="2" width="30%" class="text-center"><strong>{{ number_format($data['grand_total_allocation'], 2) }}</strong></td>
                                </tr>
                            </tbody>                        
                        </table>
                <?php endif;?>
            @endif
        </div>
</body></html>