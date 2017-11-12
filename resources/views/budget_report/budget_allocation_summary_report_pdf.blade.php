<!DOCTYPE html>
<html><head>
        <title>Budget Allocation Summary Report PDF</title>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" href="{{ url('/')}}/public/adminlte/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
        <style type="text/css">
            body{
                font-size:11px;
                font-weight:100;
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
            <div style="margin-bottom:15px;">
                <h4 style="margin:0;padding:0;">Budget Allocation Summary Report: <?php echo $data['selected_budget_year']; ?></h4>
            </div>
            @if($data['account_allocation_summary'])
            <?php
            $serial = 0;
            ?>
            <table class="table table-striped table-bordered table-hover table-checkable order-column">
                <thead>
                    <tr>
                        <th style="text-align:center;padding-left:10px">Serial</th>
                        <th style="text-align:center;padding-left:10px">Area</th>
                        <th style="text-align:center;padding-left:10px">Sector Head</th>
                        <th style="text-align:center;padding-left:10px">Project Cost</th>
                        <th style="text-align:center;padding-left:10px">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['account_allocation_summary'] as $area_row_id_key => $area_allocation_row)
                    <?php ++$serial; ?>
                    <tr>
                        <td style="text-align:center;padding-left:10px">
                            {{ $serial }}
                        </td>
                        <td style="text-align:center;padding-left:10px">
                            {{ $area_allocation_row['area_name'] }}
                        </td>
                        <td style="text-align:center;padding-left:10px">
                            {{ number_format($area_allocation_row['sector_head_allocation'], 2) }}
                        </td>
                        <td style="text-align:center;padding-left:10px">
                            {{ number_format($area_allocation_row['project_head_allocation'], 2) }}
                        </td>
                        <td style="text-align:center;padding-left:10px">
                            {{ number_format($area_allocation_row['total_allocation'], 2) }}
                        </td>
                    </tr>
                    @endforeach
                    <?php if ($data['selected_area_row_id'] == -1): ?>
                        <tr>
                            <td colspan="2">
                                <strong>&nbsp;Total&nbsp;(All Areas) : </strong>
                            </td>
                            <td class="text-center"><strong>{{ number_format($data['all_area_sctor_head_total_allocation'], 2) }}</strong></td>
                            <td class="text-center"><strong>{{ number_format($data['all_area_sctor_project_head_total_allocation'], 2) }}</strong></td>
                            <td class="text-center"><strong>{{ number_format($data['grand_total_allocation'], 2) }}</strong></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <strong>&nbsp;Grand Total&nbsp;(Existing Estb and Projects) : </strong>
                            </td>
                            <td colspan="3" class="text-center"><strong>{{ number_format($data['grand_total_allocation'], 2) }}</strong></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            @endif
        </div>
</body></html>