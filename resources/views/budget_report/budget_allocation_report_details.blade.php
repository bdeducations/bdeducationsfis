@extends('layouts.admin')
@section('page_css')
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">{{  $data['head_name'] }}</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Allocation Report List</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
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
                    @if($data['allocation_list'])
                    <a class="btn btn-default" target="_blank" href="{{ url('/') }}/budget/allocation/report/details/download?head_row_id={{ $data['selected_head_row_id'] }}@if($pdf_area_qstring){{ $pdf_area_qstring }}@endif @if($pdf_date_qstring){{ $pdf_date_qstring }}@endif"><i class="fa fa-download"></i><strong> Download Report PDF</strong></a>
                    <a class="btn btn-default" style="margin-left:15px;" target="_blank" href="{{ url('/') }}/budget/allocation/report/details/downloadCSV?head_row_id={{ $data['selected_head_row_id'] }}@if($pdf_area_qstring){{ $pdf_area_qstring }}@endif @if($pdf_date_qstring){{ $pdf_date_qstring }}@endif"><i class="fa fa-download"></i><strong> Download Report CSV</strong></a>
                    @endif
                    <p style="padding-top:30px;text-align:left;">
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
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="UT_budget_report_details_expense_list">
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
            </div>
        </div>
    </div>
</section>
@endsection