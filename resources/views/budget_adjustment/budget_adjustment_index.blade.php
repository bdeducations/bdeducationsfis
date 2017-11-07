@extends('layouts.admin')
@section('page_css')
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datepicker/datepicker3.css">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Budget Adjustment</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Adjustment</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <!-- form start -->
                <form role="form" method="POST" class="form-horizontal" action="{{ url('/') }}/budget/adjustment/store" >
                    {!! csrf_field() !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="source_area_row_id" class="col-md-5 control-label">From Area <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-7">
                                        <select name="source_area_row_id" class ="form-control" required="required">
                                            <option value="">Select From Area</option>
                                            @foreach( $data['all_areas'] as $area_row)
                                            <option value="{{ $area_row->area_row_id }}" @if($area_row->area_row_id == old('source_area_row_id')) selected="selected"  @endif>{{ $area_row->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="source_head_row_id" class="col-md-3 control-label">From Head <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-9">
                                        <select name="source_head_row_id" class="ut_budget_from_head_drop_down form-control" required="required">
                                            <option value="">Select From Head</option>
                                            @foreach( $data['all_heads'] as $adjustment_row)
                                            <option value="{{ $adjustment_row->head_row_id }}" @if($adjustment_row->has_child == 1)disabled @endif @if($adjustment_row->head_row_id == old('source_head_row_id')) selected="selected"  @endif>
                                                    @if($adjustment_row->level == 0) <b>  @endif 
                                                    @if($adjustment_row->level == 1) &nbsp; - @endif   
                                                    @if($adjustment_row->level == 2) &nbsp; &nbsp; - - @endif     
                                                    @if($adjustment_row->level == 3) &nbsp; &nbsp; &nbsp; - - - @endif       
                                                    @if($adjustment_row->level == 4) &nbsp; &nbsp; &nbsp; &nbsp; - - - - @endif       
                                                    @if($adjustment_row->level == 5) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  - - - - - @endif       
                                                    @if($adjustment_row->level > 5)  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - - - @endif
                                                    {{ $adjustment_row->title }} 
                                                    @if($adjustment_row->level == 0) </b>  @endif  
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
                                    <label for="area_row_id" class="col-md-5 control-label">To Area <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-7">
                                        <select name="area_row_id" class ="form-control" required="required">
                                            <option value="">Select To Area</option>
                                            @foreach( $data['all_areas'] as $area_row)
                                            <option value="{{ $area_row->area_row_id }}" @if($area_row->area_row_id == old('area_row_id')) selected="selected"  @endif>{{ $area_row->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="head_row_id" class="col-md-3 control-label">To Head <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-9">
                                        <select name="head_row_id" class="ut_budget_to_head_drop_down form-control" required="required">
                                            <option value="">Select To Head</option>
                                            @foreach( $data['all_heads'] as $adjustment_row)
                                            <option value="{{ $adjustment_row->head_row_id }}" @if($adjustment_row->has_child == 1)disabled @endif @if($adjustment_row->head_row_id == old('head_row_id')) selected="selected"  @endif>
                                                    @if($adjustment_row->level == 0) <b>  @endif 
                                                    @if($adjustment_row->level == 1) &nbsp; - @endif   
                                                    @if($adjustment_row->level == 2) &nbsp; &nbsp; - - @endif     
                                                    @if($adjustment_row->level == 3) &nbsp; &nbsp; &nbsp; - - - @endif       
                                                    @if($adjustment_row->level == 4) &nbsp; &nbsp; &nbsp; &nbsp; - - - - @endif       
                                                    @if($adjustment_row->level == 5) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  - - - - - @endif       
                                                    @if($adjustment_row->level > 5)  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - - - @endif
                                                    {{ $adjustment_row->title }} 
                                                    @if($adjustment_row->level == 0) </b>  @endif  
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
                                    <label for="budget_year" class="col-md-5 control-label">Budget Year <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-7">
                                        <select name="budget_year" class="ut_budget_year form-control" required="required">
                                            <?php
                                            $year_array = budget_year_list();
                                            ?>
                                            <option value="">Select Year</option>
                                            <?php foreach ($year_array as $key => $value): ?>
                                                <option @if(old('budget_year') != '')@if($key == old('budget_year')) selected="selected" @endif @else @if($key == date('Y')) selected="selected" @endif @endif value="<?php echo $key; ?>"><?php echo $value; ?></option> 
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="amount" class="col-md-3 control-label">Transfer amount <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-9">
                                        <input type="text" name="amount" value="{{ old('amount') }}" pattern="(\d+(\.\d+)?)" class="form-control" id="adjustment_amount" placeholder="Amount Only Numeric Digit" required="required" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="adjustment_datepicker" class="col-md-5 control-label">Adjustment Date <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-7">
                                        <input type="text" name="allocation_at" value="{{ old('allocation_at') }}" class="form-control" id="adjustment_datepicker" required="required"  />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="allocation_adjustment_remarks" class="col-md-3 control-label">Description</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="remarks" id="allocation_adjustment_remarks" rows="3" placeholder="Description">{{ old('remarks') }}</textarea>
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
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="budget_adjustment_list">
                        <thead>
                            <tr>
                                <th width="50%" style="text-align:left;padding-left:10px"> Head Name </th> 
                                <th width="20%" style="text-align:center;padding-left:10px"> Adjustment Amount </th>
                                <th width="20%" style="text-align:center;padding-left:10px"> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($data['account_adjustment_list'])
                            <?php
                            $parent_serial = 1;
                            $grand_parent_child_number = 0;
                            $grand_parent_child_counter = 0;
                            $grand_parent_total_allocation = 0;
                            $parent_child_number = 0;
                            $parent_child_counter = 0;
                            $parent_total_allocation = 0;
                            ?>
                            @foreach($data['account_adjustment_list'] as $adjustment_row)
                            <?php
                            if (isset($child_serial) && $child_serial > 26):
                                $child_serial = 1;
                            endif;
                            if (isset($grand_child_serial) && $grand_child_serial > 26):
                                $grand_child_serial = 1;
                            endif;
                            ?>
                            <tr>            
                                <td style="text-align:left;padding-left:10px">
                                    @if($adjustment_row->level == 0)
                                    <strong style="font-size:15px !important;">
                                        <?php
                                        $grand_parent_child_counter = 0;
                                        $child_serial = 1;
                                        if ($adjustment_row->has_child == 1):
                                            $parent_child_number = $adjustment_row->parent_head_child_number;
                                            $parent_total_allocation = $adjustment_row->parent_head_total_adjustment;
                                            $grand_parent_child_number = $adjustment_row->parent_head_child_number;
                                            $grand_parent_total_allocation = $adjustment_row->parent_head_total_adjustment;
                                            $parent_child_counter = 0;
                                        endif;
                                        ?>
                                        <span>{{ $parent_serial }}&nbsp;.&nbsp;</span>
                                        <?php $parent_serial++; ?>
                                        @endif 
                                        @if($adjustment_row->level == 1)
                                        &nbsp;
                                        @if($adjustment_row->has_child == 1)
                                        <strong>
                                            @endif
                                            <?php
                                            $grand_child_serial = 1;
                                            echo $data['alphabets'][$child_serial] . ".";
                                            $child_serial++;
                                            if ($adjustment_row->has_child == 1):
                                                $parent_child_number = $adjustment_row->parent_head_child_number;
                                                $parent_child_counter = 0;
                                                $parent_total_allocation = $adjustment_row->parent_head_total_adjustment;
                                                $grand_parent_child_counter++;
                                            else:
                                                $parent_child_counter++;
                                            endif;
                                            ?>
                                            &nbsp;
                                            @endif   
                                            @if($adjustment_row->level == 2)
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <?php
                                            echo $data['roman'][$grand_child_serial] . ".";
                                            $grand_child_serial++;
                                            $parent_child_counter++;
                                            ?>&nbsp;
                                            @endif     
                                            @if($adjustment_row->level == 3) &nbsp; &nbsp; &nbsp; - - - @endif       
                                            @if($adjustment_row->level == 4) &nbsp; &nbsp; &nbsp; &nbsp; - - - - @endif       
                                            @if($adjustment_row->level == 5) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  - - - - - @endif       
                                            @if($adjustment_row->level > 5)  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - - - @endif 
                                            {{ $adjustment_row->title }} 
                                            @if($adjustment_row->level == 0) </strong>  @endif
                                        @if($adjustment_row->level == 1)
                                        @if($adjustment_row->has_child == 1)
                                    </strong>
                                    @endif
                                    @endif
                                </td> 
                                <td style="text-align:center;padding-left:10px">
                                    @if(isset($adjustment_row->total_adjustment) && ($adjustment_row->total_adjustment != 0) && ($adjustment_row->has_child == 0))
                                    {{ number_format($adjustment_row->total_adjustment, 2) }}
                                    @elseif(empty($adjustment_row->total_adjustment) && ($adjustment_row->has_child == 0))
                                    0.00
                                    @endif
                                </td> 
                                <td style="text-align:center;padding-left:10px"> 
                                    @if(isset($adjustment_row->total_adjustment) && ($adjustment_row->has_child == 0))
                                    <a href="{{ url('/') }}/budget/adjustment/details/{{ $adjustment_row->head_row_id }}">Details</a>
                                    @endif
                                </td> 
                            </tr>
                            <?php if (($parent_child_number == $parent_child_counter) && ($adjustment_row->level == 1) && ($adjustment_row->has_child == 0) && ($parent_total_allocation != 0)): ?>
                                <tr>
                                    <td>
                                        <strong>&nbsp;&nbsp;&nbsp;Total: </strong>
                                    </td>
                                    <td class="text-center"><strong>{{ number_format($parent_total_allocation, 2) }}</strong></td>
                                    <td></td>
                                </tr>
                            <?php endif; ?>
                            <?php if (($parent_child_number == $parent_child_counter) && ($adjustment_row->level == 2) && ($adjustment_row->has_child == 0) && ($parent_total_allocation != 0)): ?>
                                <tr>
                                    <td>
                                        <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total: </strong>
                                    </td>
                                    <td class="text-center"><strong>{{ number_format($parent_total_allocation, 2) }}</strong></td>
                                    <td></td>
                                </tr>
                            <?php endif; ?>
                            <?php if (($grand_parent_child_number == $grand_parent_child_counter) && ($parent_child_number == $parent_child_counter) && ($adjustment_row->level == 2) && ($adjustment_row->has_child == 0) && ($grand_parent_total_allocation != 0)): ?>
                                <tr>
                                    <td>
                                        <strong>&nbsp;Total: </strong>
                                    </td>
                                    <td class="text-center"><strong>{{ number_format($grand_parent_total_allocation, 2) }}</strong></td>
                                    <td></td>
                                </tr>
                            <?php endif; ?>
                            @endforeach
                            <tr>
                                <td>
                                    <strong>&nbsp;Grand Total(All Areas): </strong>
                                </td>
                                <td class="text-center"><strong>{{ number_format($data['grand_total_adjustment_reciption'], 2) }}</strong></td>
                                <td></td>
                            </tr>
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
    $('#adjustment_datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true,
    });
    $(".ut_budget_year").change(function () {
        $('.ut_budget_from_head_drop_down').empty();
        $('.ut_budget_to_head_drop_down').empty();
        var selected_from_head_row_id = null;
        var selected_to_head_row_id = null;
        var selected_budget_year = $(this).val();
        $.ajax({
            url: "{{ url('/budget/heads/dropdown') }}" + '/' + selected_budget_year + '/' + selected_from_head_row_id,
            type: "GET",
            dataType: "html",
            success: function (data) {
                $('.ut_budget_from_head_drop_down').append(data);
            }
        });
        $.ajax({
            url: "{{ url('/budget/heads/dropdown') }}" + '/' + selected_budget_year + '/' + selected_to_head_row_id,
            type: "GET",
            dataType: "html",
            success: function (data) {
                $('.ut_budget_to_head_drop_down').append(data);
            }
        });
    });
});
</script>
@endsection