@extends('layouts.admin')
@section('page_css')
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datepicker/datepicker3.css">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Budget Expense Report</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Expense Report</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <!-- form start -->
                <form role="form" method="GET" class="form-horizontal" action="{{ url('/') }}/budgetReport/expense" >
                    {!! csrf_field() !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="area_row_id" class="col-md-5 control-label">Select Area</label>
                                    <div class="col-md-7">
                                        <select name="area_row_id" class ="form-control" required>
                                            <option value="">Select Area</option>
                                            <option value="-1" @if($data['selected_area_row_id'] == -1) selected="selected"  @endif>All Area</option>
                                            @foreach( $data['all_areas'] as $area_row)
                                            <option value="{{ $area_row->area_row_id }}" @if($area_row->area_row_id == $data['selected_area_row_id']) selected="selected"  @endif>{{ $area_row->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="head_row_id" class="col-md-3 control-label">Select Head</label>
                                    <div class="col-md-9">
                                        <select name="head_row_id" class ="form-control" required>
                                            <option value="">Select Head</option>
                                            @foreach( $data['all_heads'] as $row)
                                            <option value="{{ $row->head_row_id }}" @if($row->head_row_id == $data['selected_head_row_id']) selected="selected"  @endif>
                                                    @if($row->level == 0) <b>  @endif

                                                @if($row->level == 0) <b>  @endif 
                                                    @if($row->level == 1) &nbsp; - @endif   
                                                    @if($row->level == 2) &nbsp; &nbsp; - - @endif     
                                                    @if($row->level == 3) &nbsp; &nbsp; &nbsp; - - - @endif       
                                                    @if($row->level == 4) &nbsp; &nbsp; &nbsp; &nbsp; - - - - @endif       
                                                    @if($row->level == 5) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  - - - - - @endif       
                                                    @if($row->level > 5)  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - - - @endif

                                                    {{ $row->title }} 
                                                    @if($row->level == 0) </b>  @endif  
                                                </option>
                                                @endforeach                                                    
                                        </select>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="budget_year" class="col-md-5 control-label">Budget Year</label>
                                    <div class="col-md-7">
                                        <select name="budget_year" class ="form-control" required>
                                            <?php
                                            $year_array = budget_year_list();
                                            ?>
                                            <option value="">Select Year</option>
                                            <?php foreach ($year_array as $key => $value): ?>
                                                <option @if($key == $data['selected_budget_year']) selected="selected"  @endif value="<?php echo $key; ?>"><?php echo $value; ?></option> 
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="from_datepicker" class="col-md-3 control-label">From Date</label>
                                    <div class="col-md-3">
                                        <input type="text" name="from_date" class="form-control" id="from_datepicker" value="<?php echo isset($data['from_date']) ? $data['from_date'] : ''; ?>" />
                                    </div>
                                    <label for="to_datepicker" class="col-md-3 control-label">To Date</label>
                                    <div class="col-md-3">
                                        <input type="text" name="to_date" class="form-control" id="to_datepicker" value="<?php echo isset($data['to_date']) ? $data['to_date'] : ''; ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary pull-right">Submit</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-footer -->
                </form>
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
                @if($data['account_expense_list'])
                <div class="box-header">
                    <a target="_blank" class="btn btn-default" href="{{ url('/') }}/budgetReport/expenseReportDownload?head_row_id={{ $data['selected_head_row_id'] }}@if($pdf_area_qstring){{ $pdf_area_qstring }}@endif @if($pdf_date_qstring){{ $pdf_date_qstring }}@endif"><i class="fa fa-download"></i><strong> Download Report PDF</strong></a>
                </div>
                @endif
                <div class="box-body">
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="budget_expense_report">
                        <thead>
                            <tr>
                                <th width="40%" style="text-align:left;padding-left:10px"> Head Name </th> 
                                <th width="20%" style="text-align:left;padding-left:10px"> Expense amount </th>
                                <th width="20%" style="text-align:left;padding-left:10px"> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($data['account_expense_list'])
                            @foreach($data['account_expense_list'] as $expense_row)    
                            <tr>            
                                <td style="text-align:left;padding-left:10px">

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
                                <td style="text-align:left;padding-left:10px"> 
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
                                <td style="text-align:left;padding-left:10px"> 
                                    <?php
                                    $area_qstring = '';
                                    $date_qstring = '';
                                    $area_qstring = "&area_row_id=" . $data['selected_area_row_id'] . "&budget_year=" . $data['selected_budget_year'];
                                    if ($data['from_date']):
                                        $date_qstring = "&from_date=" . $data['from_date'];
                                    endif;
                                    if ($data['to_date']):
                                        $date_qstring .= "&to_date=" . $data['to_date'];
                                    endif;
                                    ?>
                                    @if($expense_row->total_expense)
                                    <a href="{{ url('/') }}/budgetReport/expenseReportDetails?head_row_id={{ $expense_row->head_row_id }}@if($area_qstring){{ $area_qstring }}@endif @if($date_qstring){{ $date_qstring }}@endif">Details</a>
                                    @endif
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
<!-- bootstrap datepicker -->
<script src="{{ url('/')}}/public/adminlte/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    $('#to_datepicker,#from_datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true
    });
});
</script>
@endsection