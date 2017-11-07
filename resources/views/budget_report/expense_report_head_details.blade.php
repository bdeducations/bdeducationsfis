@extends('layouts.admin')
@section('page_css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">{{  $data['head_name'] }}</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Expense Report List</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <?php
                $pdf_area_qstring = '';
                $pdf_date_qstring = '';
                $pdf_area_qstring = "&area_row_id=" . $data['selected_area_row_id'] . "&budget_year=" . $data['selected_budget_year'];
                if ($data['from_date']):
                    $pdf_date_qstring = "&from_date=" . $data['from_date'];
                endif;
                if ($data['to_date']):
                    $pdf_date_qstring .= "&to_date=" . $data['to_date'];
                endif;
                ?>
                @if($data['expense_list'])
                <div class="box-header">
                    <a target="_blank" class="btn btn-default" href="{{ url('/') }}/budgetReport/expenseReportDetailsDownload?head_row_id={{ $data['selected_head_row_id'] }}@if($pdf_area_qstring){{ $pdf_area_qstring }}@endif @if($pdf_date_qstring){{ $pdf_date_qstring }}@endif"><i class="fa fa-download"></i><strong> Download Report PDF</strong></a>
                </div>
                @endif
                <div class="box-body">
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="UT_budget_report_details_expense_list">
                        <thead>
                            <tr>
                                <th width="40%" style="text-align:left;padding-left:10px"> Area Name </th> 
                                <th width="20%" style="text-align:left;padding-left:10px"> Expense amount </th>
                                <th width="20%" style="text-align:left;padding-left:10px"> Expense Date </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($data['expense_list'])
                            @foreach($data['expense_list'] as $expense_row)    
                            <tr>            
                                <td style="text-align:left;padding-left:10px">
                                    {{ $expense_row->title }}
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    {{ $expense_row->amount ? number_format($expense_row->amount, 2) : '' }}

                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    <?php echo date('F j, Y', strtotime($expense_row->expense_at)); ?>
                                </td> 
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('page_js')
<!-- page script -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#UT_budget_report_details_expense_list').DataTable({
            paging: true,
            lengthMenu: [[-1, 100, 50, 25], ["All", 100, 50, 25]],
            ordering: false,
            columnDefs: [{
                    targets: 'no-sort',
                    orderable: false
                }]
        });
    });
</script>
@endsection