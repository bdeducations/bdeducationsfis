@extends('layouts.admin')
@section('page_css')
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Budget Allocation Report With Adjustment</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Allocation Report</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <!-- form start -->
                <form role="form" method="POST" class="form-horizontal" action="{{ url('/') }}/budget/allocation/adjustment/report" >
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
                                                <option @if($data['selected_budget_year'] != '')@if($key == $data['selected_budget_year']) selected="selected"  @endif @else @if($key == date('Y')) selected="selected" @endif @endif value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="head_row_id" class="col-md-3 control-label">Select Head <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-9">
                                        <select name="head_row_id" class="ut_budget_head_drop_down form-control" required="required">
                                            <option value="">Select Head</option>
                                            <option value="-1" @if($data['selected_head_row_id'] == -1) selected="selected"  @endif>All Head</option>
                                            @foreach( $data['all_heads'] as $row)
                                            <option value="{{ $row->head_row_id }}" @if($row->head_row_id == $data['selected_head_row_id']) selected="selected"  @endif>
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
                                    <label for="area_row_id" class="col-md-5 control-label">Select Area <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-7">
                                        <select name="area_row_id" class ="form-control" required="required">
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
                @if($data['account_allocation_list'])
                <div class="box-header">
                    <a target="_blank" class="btn btn-default" href="{{ url('/') }}/budget/allocation/adjustment/report/download?head_row_id={{ $data['selected_head_row_id'] }}@if($pdf_area_qstring){{ $pdf_area_qstring }}@endif @if($pdf_date_qstring){{ $pdf_date_qstring }}@endif"><i class="fa fa-download"></i><strong> Download Report PDF</strong></a>
                    <a target="_blank" style="margin-left:15px;" class="btn btn-default" href="{{ url('/') }}/budget/allocation/adjustment/report/downloadCSV?head_row_id={{ $data['selected_head_row_id'] }}@if($pdf_area_qstring){{ $pdf_area_qstring }}@endif @if($pdf_date_qstring){{ $pdf_date_qstring }}@endif"><i class="fa fa-download"></i><strong> Download Report CSV</strong></a>
                </div>
                @endif
                <div class="box-body">
                    @if($data['account_allocation_list'])
                    <?php
                    $child_serial = 1;
                    $parent_serial = 1;
                    $grand_child_serial = 1;
                    $grand_parent_child_number = 0;
                    $grand_parent_child_counter = 0;
                    $grand_parent_total_allocation = 0;
                    $grand_parent_total_donation = 0;
                    $grand_parent_head_total_adjustment = 0;
                    $grand_parent_head_current_total_allocation = 0;
                    $parent_child_number = 0;
                    $parent_child_counter = 0;
                    $parent_total_allocation = 0;
                    $parent_head_total_donation = 0;
                    $parent_head_total_adjustment = 0;
                    $parent_head_current_total_allocation = 0;
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
                    <h3 style="text-transform:uppercase;text-align:center;"> {{ $area_row_id_key }}</h3>
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
                                    @if($allocation_row['level'] == 0)
                                    <strong>
                                        <?php
                                        $grand_parent_child_counter = 0;
                                        $child_serial = 1;
                                        if ($allocation_row['has_child'] == 1):
                                            $parent_child_number = $allocation_row['parent_head_child_number'];
                                            $parent_total_allocation = $allocation_row['parent_head_total_allocation'];
                                            $grand_parent_total_allocation = $allocation_row['parent_head_total_allocation'];
                                            $grand_parent_total_donation = $allocation_row['parent_head_total_donation'];
                                            $parent_head_total_donation = $allocation_row['parent_head_total_donation'];
                                            $grand_parent_head_total_adjustment = $allocation_row['parent_head_total_adjustment'];
                                            $parent_head_total_adjustment = $allocation_row['parent_head_total_adjustment'];
                                            $grand_parent_head_current_total_allocation = $allocation_row['parent_head_current_total_allocation'];
                                            $parent_head_current_total_allocation = $allocation_row['parent_head_current_total_allocation'];
                                            $grand_parent_child_number = $allocation_row['parent_head_child_number'];
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
                                            $parent_head_total_donation = $allocation_row['parent_head_total_donation'];
                                            $parent_head_total_adjustment = $allocation_row['parent_head_total_adjustment'];
                                            $parent_head_current_total_allocation = $allocation_row['parent_head_current_total_allocation'];
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
                                <td style="text-align:center;padding-left:10px">
                                    @if(isset($allocation_row['head_total_donation']) && ($allocation_row['head_total_donation'] != 0) && ($allocation_row['has_child'] == 0))
                                    {{ number_format($allocation_row['head_total_donation'], 2) }}
                                    @elseif(isset($allocation_row['head_total_donation']) && ($allocation_row['head_total_donation'] == 0) && ($allocation_row['has_child'] == 0))
                                    0.00
                                    @endif
                                </td>
                                <td style="text-align:center;padding-left:10px">
                                    @if(isset($allocation_row['head_total_adjustment']) && ($allocation_row['head_total_adjustment'] != 0) && ($allocation_row['has_child'] == 0))
                                    {{ number_format($allocation_row['head_total_adjustment'], 2) }}
                                    @elseif(isset($allocation_row['head_total_adjustment']) && ($allocation_row['head_total_adjustment'] == 0) && ($allocation_row['has_child'] == 0))
                                    0.00
                                    @endif
                                </td>
                                <td style="text-align:center;padding-left:10px">
                                    @if(isset($allocation_row['head_current_total_allocation']) && ($allocation_row['head_current_total_allocation'] != 0) && ($allocation_row['has_child'] == 0))
                                    {{ number_format($allocation_row['head_current_total_allocation'], 2) }}
                                    @elseif(isset($allocation_row['head_current_total_allocation']) && ($allocation_row['head_current_total_allocation'] == 0) && ($allocation_row['has_child'] == 0))
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
                                    <td class="text-center"><strong>{{ number_format($parent_head_total_donation, 2) }}</strong></td>
                                    <td class="text-center"><strong>{{ number_format($parent_head_total_adjustment, 2) }}</strong></td>
                                    <td class="text-center"><strong>{{ number_format($parent_head_current_total_allocation, 2) }}</strong></td>
                                </tr>
                            <?php endif; ?>
                            <?php if (($parent_child_number == $parent_child_counter) && ($allocation_row['level'] == 2) && ($allocation_row['has_child'] == 0)): ?>
                                <tr>
                                    <td>
                                        <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total: </strong>
                                    </td>
                                    <td class="text-center"><strong>{{ number_format($parent_total_allocation, 2) }}</strong></td>
                                    <td class="text-center"><strong>{{ number_format($parent_head_total_donation, 2) }}</strong></td>
                                    <td class="text-center"><strong>{{ number_format($parent_head_total_adjustment, 2) }}</strong></td>
                                    <td class="text-center"><strong>{{ number_format($parent_head_current_total_allocation, 2) }}</strong></td>
                                </tr>
                            <?php endif; ?>
                            <?php if (($grand_parent_child_number == $grand_parent_child_counter) && ($parent_child_number == $parent_child_counter) && ($allocation_row['level'] == 2) && ($allocation_row['has_child'] == 0)): ?>
                                <tr>
                                    <td>
                                        <strong>&nbsp;Total: </strong>
                                    </td>
                                    <td class="text-center"><strong>{{ number_format($grand_parent_total_allocation, 2) }}</strong></td>
                                    <td class="text-center"><strong>{{ number_format($grand_parent_total_donation, 2) }}</strong></td>
                                    <td class="text-center"><strong>{{ number_format($grand_parent_head_total_adjustment, 2) }}</strong></td>
                                    <td class="text-center"><strong>{{ number_format($grand_parent_head_current_total_allocation, 2) }}</strong></td>
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
                    <?php $parent_serial = 1; ?>
                    @endforeach
                    <?php if (($data['selected_head_row_id'] == -1) && ($data['selected_area_row_id'] == -1)): ?>
                    <table style="margin-top:10px;" class="table table-striped table-bordered table-hover table-checkable order-column">
                        <tbody>
                            <tr>
                                <td width="50%">
                                    <strong>&nbsp;Grand Total&nbsp;( All Areas ) : </strong>
                                </td>
                                <td class="text-center"><strong>{{ number_format($data['grand_total_allocation'], 2) }}</strong></td>
                                <td class="text-center"><strong>{{ number_format($data['grand_total_reception'], 2) }}</strong></td>
                                <td class="text-center"><strong>{{ number_format($data['grand_total_donation'], 2) }}</strong></td>
                                <td class="text-center"><strong>{{ number_format($data['grand_total_current_allocation'], 2) }}</strong></td>
                            </tr>
                        </tbody>                        
                    </table>
                    <?php endif;?>
                    @else
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
                                <tr>
                                    <td colspan="5" style="text-align:center">
                                        <strong style="text-align:center">No Budget Allocation Adjustment Data Found</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
        todayHighlight: true,
    });
    $(".ut_budget_year").change(function(){
            $('.ut_budget_head_drop_down').empty();
            var selected_head_row_id = null;
            var selected_budget_year = $(this).val();
            $.ajax({
                url: "{{ url('/budget/report/heads/dropdown') }}" + '/' + selected_budget_year + '/' + selected_head_row_id,
                type: "GET",
                dataType: "html",
                success: function(data){
                $('.ut_budget_head_drop_down').append(data);
                }
            });
    });
});
</script>
@endsection