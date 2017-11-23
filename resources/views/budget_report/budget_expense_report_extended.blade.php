@extends('layouts.admin')
@section('page_css')
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datepicker/datepicker3.css" />
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css" />
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Budget Expense Report</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Expense Report </li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <!-- form start -->
                <form role="form" method="POST" class="form-horizontal" action="{{ url('/') }}/budgetReport/expenseExtended" >
                    {!! csrf_field() !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="budget_year" class="col-md-5 control-label">Budget Year <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-7">
                                        <select name="budget_year" class="ut_budget_year form-control" required="required">
                                            <?php
                                            $year_array = budget_year_list();
                                            ?>
                                            <option value="">Select Year</option>
                                            <?php foreach ($year_array as $key => $value): ?>
                                                <option @if($data['selected_budget_year'] != '') @if($key == $data['selected_budget_year']) selected="selected"  @endif @else @if($key == date('Y')) selected="selected" @endif @endif value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="head_row_id" class="col-md-3 control-label">Select Head <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-9">
                                        <select id="budget_head_muliselect_dropdown" name="head_row_id[]" multiple="multiple" class="ut_budget_head_drop_down form-control" required="required">
                                            <option value="">Select Head</option>
                                            <option value="-1">All Head</option>
                                            @foreach( $data['all_heads'] as $row)
                                            <option value="{{ $row->head_row_id }}">
                                                @if($row->level == 1) &nbsp; - @endif
                                                @if($row->level == 2) &nbsp; &nbsp; - - @endif
                                                @if($row->level == 3) &nbsp; &nbsp; &nbsp; - - - @endif
                                                @if($row->level == 4) &nbsp; &nbsp; &nbsp; &nbsp; - - - - @endif
                                                @if($row->level == 5) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  - - - - - @endif
                                                @if($row->level > 5)  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - - - @endif
                                                {{ $row->title }}
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
                                    <label for="area_row_id" class="col-md-5 control-label">Select Area <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-7">
                                        <select name="area_row_id" class ="form-control" required="required">
                                            <option value="">Select Area</option>
                                            <option value="-1" @if($data['selected_area_row_id'] == -1) selected="selected" @endif>All Area</option>
                                            @foreach( $data['all_areas'] as $area_row)
                                            <option value="{{ $area_row->area_row_id }}" @if($area_row->area_row_id == $data['selected_area_row_id']) selected="selected"  @endif>{{ $area_row->title }}</option>
                                            @endforeach
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
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="report_title" class="col-md-3 control-label">Report Heading</label>
                                    <div class="col-md-9">
                                        <input type="text" name="report_title" class="form-control" placeholder="Report Heading Title" id="report_title" value="<?php echo isset($data['report_title']) ? $data['report_title'] : ''; ?>" />
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
                $pdf_area_qstring = "&area_row_id=" . $data['selected_area_row_id'] . "&budget_year=" . $data['selected_budget_year'] ."&report_title=" . $data['report_title'];
                if ($data['from_date']):
                    $pdf_date_qstring = "&from_date=" . $data['from_date'];
                endif;
                if ($data['to_date']):
                    $pdf_date_qstring .= "&to_date=" . $data['to_date'];
                endif;
                if (is_array($data['selected_head_row_id'])):
                    if(in_array('-1', $data['selected_head_row_id'])):
                        $head_row_list = -1;
                    else:
                        $head_row_list = implode('-', $data['selected_head_row_id']);
                    endif;
               else:
                    $head_row_list = -1;
                endif;
                
                ?>
                @if($data['account_expense_list'])
                <div class="box-header">
                    <a target="_blank" class="btn btn-default" href="{{ url('/') }}/budgetReport/expenseReportExtendedDownload?head_row_id={{ $head_row_list }}@if($pdf_area_qstring){{ $pdf_area_qstring }}@endif @if($pdf_date_qstring){{ $pdf_date_qstring }}@endif"><i class="fa fa-download"></i><strong> Download Report PDF</strong></a>
                    <a target="_blank" style="margin-left:15px;" class="btn btn-default" href="{{ url('/') }}/budgetReport/expenseReportExtendedCSVDownload?head_row_id={{ $head_row_list }}@if($pdf_area_qstring){{ $pdf_area_qstring }}@endif @if($pdf_date_qstring){{ $pdf_date_qstring }}@endif"><i class="fa fa-download"></i><strong> Download Report CSV</strong></a>
                </div>
                @endif
                <div class="box-body">
                    @if($data['account_expense_list'])
                    <?php
                    $child_serial = 1;
                    $parent_serial = 1;
                    $grand_child_serial = 1;
                    $grand_parent_child_number = 0;
                    $grand_parent_child_counter = 0;
                    $grand_parent_total_expense = 0;
                    $parent_child_number = 0;
                    $parent_child_counter = 0;
                    $parent_total_expense = 0;
                    ?>
                    @foreach($data['account_expense_list'] as $area_row_id_key => $expense_row)
                    <?php
                    if (isset($child_serial) && $child_serial > 26):
                        $child_serial = 1;
                    endif;
                    if (isset($grand_child_serial) && $grand_child_serial > 26):
                        $grand_child_serial = 1;
                    endif;
                    ?>
                    <h3 style="text-transform:uppercase;text-align:center;"> {{ $data['report_title'] }}</h3>
                    <table class="table table-striped table-bordered table-hover table-checkable order-column">
                        <thead>
                            <tr>
                                <th width="40%" style="text-align:left;padding-left:10px"> Head Name </th>
                                <th width="20%" style="text-align:center;padding-left:10px"> Expense amount </th>
                                <th width="20%" style="text-align:center;padding-left:10px"> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expense_row as $area_expense_row)
                            <tr>
                                <td style="text-align:left;padding-left:10px">
                                    @if($area_expense_row['level'] == 0)
                                    <strong>
                                        <?php
                                        $grand_parent_child_counter = 0;
                                        $child_serial = 1;
                                        if ($area_expense_row['has_child'] == 1):
                                            $parent_child_number = $area_expense_row['parent_head_child_number'];
                                            $parent_total_expense = $area_expense_row['parent_head_total_expense'];
                                            $grand_parent_child_number = $area_expense_row['parent_head_child_number'];
                                            $grand_parent_total_expense = $area_expense_row['parent_head_total_expense'];
                                            $parent_child_counter = 0;
                                        endif;
                                        ?>
                                        <span>{{ $parent_serial }}&nbsp;.&nbsp;</span>
                                        <?php $parent_serial++; ?>
                                        @endif
                                        @if($area_expense_row['level'] == 1)
                                        &nbsp;
                                        @if($area_expense_row['has_child'] == 1)
                                        <strong>
                                            @endif
                                            <?php
                                            $grand_child_serial = 1;
                                            echo $data['alphabets'][$child_serial] . ".";
                                            $child_serial++;
                                            if ($area_expense_row['has_child'] == 1):
                                                $parent_child_number = $area_expense_row['parent_head_child_number'];
                                                $parent_total_expense = $area_expense_row['parent_head_total_expense'];
                                                $parent_child_counter = 0;
                                                $grand_parent_child_counter++;
                                            else:
                                                $parent_child_counter++;
                                                $grand_parent_child_counter++;
                                            endif;
                                            ?>
                                            &nbsp;
                                            @endif
                                            @if($area_expense_row['level'] == 2)
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <?php
                                            echo $data['roman'][$grand_child_serial] . ".";
                                            $grand_child_serial++;
                                            $parent_child_counter++;
                                            ?>&nbsp;
                                            @endif
                                            @if($area_expense_row['level'] == 3) &nbsp; &nbsp; &nbsp; - - - @endif
                                            @if($area_expense_row['level'] == 4) &nbsp; &nbsp; &nbsp; &nbsp; - - - - @endif
                                            @if($area_expense_row['level'] == 5) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  - - - - - @endif
                                            @if($area_expense_row['level'] > 5)  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - - - @endif
                                            {{ $area_expense_row['title'] }}
                                            @if($area_expense_row['level'] == 0) </b>  @endif
                                            @if($area_expense_row['level'] == 1)
                                            @if($area_expense_row['has_child'] == 1)
                                        </strong>
                                        @endif
                                        @endif
                                </td>
                                <td style="text-align:center;padding-left:10px">
                                    @if(isset($area_expense_row['total_expense']) && ($area_expense_row['total_expense'] != 0) && ($area_expense_row['has_child'] == 0))
                                    {{ number_format($area_expense_row['total_expense'], 2) }}
                                    @elseif(isset($area_expense_row['total_expense']) && ($area_expense_row['total_expense'] == 0) && ($area_expense_row['has_child'] == 0))
                                    0.00
                                    @else
                                    @endif
                                </td>
                                <td style="text-align:center;padding-left:10px">
                                    <?php
                                    $area_qstring = '';
                                    $date_qstring = '';
                                    $area_qstring = "&area_row_id=" . $area_expense_row['area_row_id'] . "&budget_year=" . $data['selected_budget_year'];
                                    if ($data['from_date']):
                                        $date_qstring = "&from_date=" . $data['from_date'];
                                    endif;
                                    if ($data['to_date']):
                                        $date_qstring .= "&to_date=" . $data['to_date'];
                                    endif;
                                    ?>
                                    @if(isset($area_expense_row['total_expense'])  && ($area_expense_row['total_expense'] != 0) && ($area_expense_row['has_child'] == 0))
                                    <a target="_blank" href="{{ url('/') }}/budgetReport/expenseReportDetails?head_row_id={{ $area_expense_row['head_row_id'] }}@if($area_qstring){{ $area_qstring }}@endif @if($date_qstring){{ $date_qstring }}@endif">Details</a>
                                    @endif

                                </td>
                            </tr>
                            <?php if (($parent_child_number == $parent_child_counter) && ($area_expense_row['level'] == 1) && ($area_expense_row['has_child'] == 0)): ?>
                                <tr>
                                    <td>
                                        <strong>&nbsp;&nbsp;&nbsp;Total: </strong>
                                    </td>
                                    <td class="text-center"><strong>{{ number_format($parent_total_expense, 2) }}</strong></td>
                                    <td></td>
                                </tr>
                            <?php endif; ?>
                            <?php if (($parent_child_number == $parent_child_counter) && ($area_expense_row['level'] == 2) && ($area_expense_row['has_child'] == 0)): ?>
                                <tr>
                                    <td>
                                        <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total: </strong>
                                    </td>
                                    <td class="text-center"><strong>{{ number_format($parent_total_expense, 2) }}</strong></td>
                                    <td></td>
                                </tr>
                            <?php endif; ?>

                            <?php if (($grand_parent_child_number == $grand_parent_child_counter) && ($parent_child_number == $parent_child_counter) && ($area_expense_row['level'] == 2) && ($area_expense_row['has_child'] == 0)): ?>
                                <tr>
                                    <td>
                                        <strong>&nbsp;Total: </strong>
                                    </td>
                                    <td class="text-center"><strong>{{ number_format($grand_parent_total_expense, 2) }}</strong></td>
                                    <td></td>
                                </tr>
                            <?php endif; ?>
                            @endforeach
                            <?php if (in_array('-1', $data['selected_head_row_id'])): ?>
                                <tr>
                                    <td>
                                        <strong>&nbsp;Total </strong>
                                    </td>
                                    <td class="text-center">
                                        <?php if (isset($data['total_area_expense_list'][$area_row_id_key])): ?>
                                            <strong>{{ number_format($data['total_area_expense_list'][$area_row_id_key], 2) }}</strong>
                                        <?php endif; ?>
                                    </td>
                                    <td></td>
                                </tr>
                                <?php else:?>
                                <tr>
                                    <td>
                                        <strong>&nbsp;Total </strong>
                                    </td>
                                    <td class="text-center">
                                        <?php if (isset($data['all_head_total_expense'][$area_row_id_key])): ?>
                                            <strong>{{ number_format($data['all_head_total_expense'][$area_row_id_key], 2) }}</strong>
                                        <?php endif; ?>
                                    </td>
                                    <td></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    @endforeach
                    <?php if ((in_array('-1', $data['selected_head_row_id'])) && ($data['selected_area_row_id'] == -1)): ?>
                        <table style="margin-top:10px;" class="table table-striped table-bordered table-hover table-checkable order-column">
                            <tbody>
                                <tr>
                                    <td width="50%">
                                        <strong>&nbsp;Grand Total&nbsp;( All Areas ) : </strong>
                                    </td>
                                    <td width="25%" class="text-center"><strong>{{ number_format($data['grand_total_expense'], 2) }}</strong></td>
                                    <td width="25%"></td>
                                </tr>
                            </tbody>
                        </table>
                    <?php endif; ?>
                    @endif
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
    $(".ut_budget_year").change(function () {
        $('.ut_budget_head_drop_down').empty();
        var selected_head_row_id = null;
        var selected_budget_year = $(this).val();
        $.ajax({
            url: "{{ url('/budget/report/heads/dropdown') }}" + '/' + selected_budget_year + '/' + selected_head_row_id,
            type: "GET",
            dataType: "html",
            success: function (data) {
                $('.ut_budget_head_drop_down').append(data);
            }
        });
    });
});
</script>
<script type='text/javascript'>
    var head_row_id_list = <?php echo json_encode($data['selected_head_row_id']); ?>;
    $('#budget_head_muliselect_dropdown').val(head_row_id_list);
</script>
@endsection