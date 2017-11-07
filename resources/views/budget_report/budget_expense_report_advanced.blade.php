@extends('layouts.admin')
@section('page_css')
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Advanced Expense Report</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Expense Report Extended</li>
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
                                            <option value="-1" @if($data['selected_head_row_id'] == -1) selected="selected"  @endif>All Head</option>
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
                <div class="box-body">
                    <h3 style="text-align:left;"> Jamalpur Area</h3>
                    <table class="table table-striped table-bordered table-hover table-checkable order-column">
                        <thead>
                            <tr>
                                <th width="40%" style="text-align:left;padding-left:10px"> Head Name </th> 
                                <th width="20%" style="text-align:left;padding-left:10px"> Expense amount </th>
                                <th width="20%" style="text-align:left;padding-left:10px"> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>            
                                <td style="text-align:left;padding-left:10px">
                                    <b> Pay and Allowances </b>  
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    90,086.89   
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                </td> 
                            </tr>
                            <tr>            
                                <td style="text-align:left;padding-left:10px">
                                    &nbsp; -    
                                    Complex Staff Salary / Honorarium 
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    21,045.50
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    <a href="http://localhost/erp/budgetReport/expenseReportDetails?head_row_id=9&amp;area_row_id=1&amp;budget_year=2017 ">Details</a>
                                </td> 
                            </tr>
                            <tr>            
                                <td style="text-align:left;padding-left:10px">
                                    &nbsp; -    
                                    Trust Staff Salary / Honorarium 
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    15,590.89
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    <a href="http://localhost/erp/budgetReport/expenseReportDetails?head_row_id=10&amp;area_row_id=1&amp;budget_year=2017 ">Details</a>
                                </td> 
                            </tr>
                            <tr>            
                                <td style="text-align:left;padding-left:10px">
                                    &nbsp; -    
                                    Complex and Trust Admin/ Misc Exp / Food Allces 
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    53,450.50
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    <a href="http://localhost/erp/budgetReport/expenseReportDetails?head_row_id=11&amp;area_row_id=1&amp;budget_year=2017 ">Details</a>
                                </td> 
                            </tr>
                        </tbody>
                    </table>
                    <h3 style="text-align:left;">Kishoregonj Area</h3>
                    <table class="table table-striped table-bordered table-hover table-checkable order-column">
                        <thead>
                            <tr>
                                <th width="40%" style="text-align:left;padding-left:10px"> Head Name </th> 
                                <th width="20%" style="text-align:left;padding-left:10px"> Expense amount </th>
                                <th width="20%" style="text-align:left;padding-left:10px"> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>            
                                <td style="text-align:left;padding-left:10px">
                                    <b> Pay and Allowances </b>  
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    90,086.89   
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                </td> 
                            </tr>
                            <tr>            
                                <td style="text-align:left;padding-left:10px">
                                    &nbsp; -    
                                    Complex Staff Salary / Honorarium 
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    21,045.50
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    <a href="http://localhost/erp/budgetReport/expenseReportDetails?head_row_id=9&amp;area_row_id=1&amp;budget_year=2017 ">Details</a>
                                </td> 
                            </tr>
                            <tr>            
                                <td style="text-align:left;padding-left:10px">
                                    &nbsp; -    
                                    Trust Staff Salary / Honorarium 
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    15,590.89
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    <a href="http://localhost/erp/budgetReport/expenseReportDetails?head_row_id=10&amp;area_row_id=1&amp;budget_year=2017 ">Details</a>
                                </td> 
                            </tr>
                            <tr>            
                                <td style="text-align:left;padding-left:10px">
                                    &nbsp; -    
                                    Complex and Trust Admin/ Misc Exp / Food Allces 
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    53,450.50
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    <a href="http://localhost/erp/budgetReport/expenseReportDetails?head_row_id=11&amp;area_row_id=1&amp;budget_year=2017 ">Details</a>
                                </td> 
                            </tr>
                        </tbody>
                    </table>
                    <h3 style="text-align:left;">Munshigonj Area</h3>
                    <table class="table table-striped table-bordered table-hover table-checkable order-column">
                        <thead>
                            <tr>
                                <th width="40%" style="text-align:left;padding-left:10px"> Head Name </th> 
                                <th width="20%" style="text-align:left;padding-left:10px"> Expense amount </th>
                                <th width="20%" style="text-align:left;padding-left:10px"> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>            
                                <td style="text-align:left;padding-left:10px">
                                    <b> Pay and Allowances </b>  
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    90,086.89   
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                </td> 
                            </tr>
                            <tr>            
                                <td style="text-align:left;padding-left:10px">
                                    &nbsp; -    
                                    Complex Staff Salary / Honorarium 
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    21,045.50
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    <a href="http://localhost/erp/budgetReport/expenseReportDetails?head_row_id=9&amp;area_row_id=1&amp;budget_year=2017 ">Details</a>
                                </td> 
                            </tr>
                            <tr>            
                                <td style="text-align:left;padding-left:10px">
                                    &nbsp; -    
                                    Trust Staff Salary / Honorarium 
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    15,590.89
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    <a href="http://localhost/erp/budgetReport/expenseReportDetails?head_row_id=10&amp;area_row_id=1&amp;budget_year=2017 ">Details</a>
                                </td> 
                            </tr>
                            <tr>            
                                <td style="text-align:left;padding-left:10px">
                                    &nbsp; -    
                                    Complex and Trust Admin/ Misc Exp / Food Allces 
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    53,450.50
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    <a href="http://localhost/erp/budgetReport/expenseReportDetails?head_row_id=11&amp;area_row_id=1&amp;budget_year=2017 ">Details</a>
                                </td> 
                            </tr>
                        </tbody>
                    </table>
                    <h3 style="text-align:left;"> Feni Area</h3>
                    <table class="table table-striped table-bordered table-hover table-checkable order-column">
                        <thead>
                            <tr>
                                <th width="40%" style="text-align:left;padding-left:10px"> Head Name </th> 
                                <th width="20%" style="text-align:left;padding-left:10px"> Expense amount </th>
                                <th width="20%" style="text-align:left;padding-left:10px"> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>            
                                <td style="text-align:left;padding-left:10px">
                                    <b> Pay and Allowances </b>  
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    90,086.89   
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                </td> 
                            </tr>
                            <tr>            
                                <td style="text-align:left;padding-left:10px">
                                    &nbsp; -    
                                    Complex Staff Salary / Honorarium 
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    21,045.50
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    <a href="http://localhost/erp/budgetReport/expenseReportDetails?head_row_id=9&amp;area_row_id=1&amp;budget_year=2017 ">Details</a>
                                </td> 
                            </tr>
                            <tr>            
                                <td style="text-align:left;padding-left:10px">
                                    &nbsp; -    
                                    Trust Staff Salary / Honorarium 
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    15,590.89
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    <a href="http://localhost/erp/budgetReport/expenseReportDetails?head_row_id=10&amp;area_row_id=1&amp;budget_year=2017 ">Details</a>
                                </td> 
                            </tr>
                            <tr>            
                                <td style="text-align:left;padding-left:10px">
                                    &nbsp; -    
                                    Complex and Trust Admin/ Misc Exp / Food Allces 
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    53,450.50
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    <a href="http://localhost/erp/budgetReport/expenseReportDetails?head_row_id=11&amp;area_row_id=1&amp;budget_year=2017 ">Details</a>
                                </td> 
                            </tr>
                        </tbody>
                    </table>
                    <h3 style="text-align:left;"> Dhaka,Ashulia,Savar Area</h3>
                    <table class="table table-striped table-bordered table-hover table-checkable order-column">
                        <thead>
                            <tr>
                                <th width="40%" style="text-align:left;padding-left:10px"> Head Name </th> 
                                <th width="20%" style="text-align:left;padding-left:10px"> Expense amount </th>
                                <th width="20%" style="text-align:left;padding-left:10px"> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>            
                                <td style="text-align:left;padding-left:10px">
                                    <b> Pay and Allowances </b>  
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    90,086.89   
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                </td> 
                            </tr>
                            <tr>            
                                <td style="text-align:left;padding-left:10px">
                                    &nbsp; -    
                                    Complex Staff Salary / Honorarium 
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    21,045.50
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    <a href="http://localhost/erp/budgetReport/expenseReportDetails?head_row_id=9&amp;area_row_id=1&amp;budget_year=2017 ">Details</a>
                                </td> 
                            </tr>
                            <tr>            
                                <td style="text-align:left;padding-left:10px">
                                    &nbsp; -    
                                    Trust Staff Salary / Honorarium 
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    15,590.89
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    <a href="http://localhost/erp/budgetReport/expenseReportDetails?head_row_id=10&amp;area_row_id=1&amp;budget_year=2017 ">Details</a>
                                </td> 
                            </tr>
                            <tr>            
                                <td style="text-align:left;padding-left:10px">
                                    &nbsp; -    
                                    Complex and Trust Admin/ Misc Exp / Food Allces 
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    53,450.50
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    <a href="http://localhost/erp/budgetReport/expenseReportDetails?head_row_id=11&amp;area_row_id=1&amp;budget_year=2017 ">Details</a>
                                </td> 
                            </tr>
                        </tbody>
                    </table>
                    <h3 style="text-align:left;"> Other Areas</h3>
                    <table class="table table-striped table-bordered table-hover table-checkable order-column">
                        <thead>
                            <tr>
                                <th width="40%" style="text-align:left;padding-left:10px"> Head Name </th> 
                                <th width="20%" style="text-align:left;padding-left:10px"> Expense amount </th>
                                <th width="20%" style="text-align:left;padding-left:10px"> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>            
                                <td style="text-align:left;padding-left:10px">
                                    <b> Pay and Allowances </b>  
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    90,086.89   
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                </td> 
                            </tr>
                            <tr>            
                                <td style="text-align:left;padding-left:10px">
                                    &nbsp; -    
                                    Complex Staff Salary / Honorarium 
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    21,045.50
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    <a href="http://localhost/erp/budgetReport/expenseReportDetails?head_row_id=9&amp;area_row_id=1&amp;budget_year=2017 ">Details</a>
                                </td> 
                            </tr>
                            <tr>            
                                <td style="text-align:left;padding-left:10px">
                                    &nbsp; -    
                                    Trust Staff Salary / Honorarium 
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    15,590.89
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    <a href="http://localhost/erp/budgetReport/expenseReportDetails?head_row_id=10&amp;area_row_id=1&amp;budget_year=2017 ">Details</a>
                                </td> 
                            </tr>
                            <tr>            
                                <td style="text-align:left;padding-left:10px">
                                    &nbsp; -    
                                    Complex and Trust Admin/ Misc Exp / Food Allces 
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    53,450.50
                                </td> 
                                <td style="text-align:left;padding-left:10px"> 
                                    <a href="http://localhost/erp/budgetReport/expenseReportDetails?head_row_id=11&amp;area_row_id=1&amp;budget_year=2017 ">Details</a>
                                </td> 
                            </tr>
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
    });
});
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#UT_budget_report_expense_extended').DataTable({
            paging: false,
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