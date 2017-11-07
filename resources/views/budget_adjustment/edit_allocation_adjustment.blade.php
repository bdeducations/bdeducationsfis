@extends('layouts.admin')
@section('page_css')
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datepicker/datepicker3.css">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Update Budget Adjustment</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit Adjustment</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <!-- form start -->
                <form role="form" method="POST" class="form-horizontal" action="{{ url('/') }}/budget/adjustment/update/{{ $allocation_row_detail->allocation_row_id }}" >
                    {!! csrf_field() !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="source_area_row_id" class="col-md-5 control-label">From Area <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-7">
                                        <select name="source_area_row_id" class="form-control" required="required">
                                            <option value="">Select From Area</option>
                                            @foreach( $data['all_areas'] as $area_row)
                                            <option value="{{ $area_row->area_row_id }}" @if($area_row->area_row_id == $allocation_row_detail->source_area_row_id) selected="selected"  @endif>{{ $area_row->title }}</option>
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
                                            @foreach( $data['all_heads'] as $row)
                                            <option value="{{ $row->head_row_id }}" @if($row->has_child == 1)disabled @endif @if($row->head_row_id == $allocation_row_detail->source_head_row_id) selected="selected"  @endif>
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
                                    <label for="area_row_id" class="col-md-5 control-label">To Area <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-7">
                                        <select name="area_row_id" class ="form-control" required="required">
                                            <option value="">Select To Area</option>
                                            @foreach( $data['all_areas'] as $area_row)
                                            <option value="{{ $area_row->area_row_id }}" @if($area_row->area_row_id == $allocation_row_detail->area_row_id) selected="selected"  @endif>{{ $area_row->title }}</option>
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
                                            @foreach( $data['all_heads'] as $row)
                                            <option value="{{ $row->head_row_id }}" @if($row->has_child == 1)disabled @endif @if($row->head_row_id == $allocation_row_detail->head_row_id)) selected="selected"  @endif>
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
                                    <label for="budget_year" class="ut_budget_year col-md-5 control-label">Budget Year <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-7">
                                        <select name="budget_year" class="ut_budget_year form-control" required="required">
                                            <?php
                                            $year_array = budget_year_list();
                                            ?>
                                            <option value="">Select Year</option>
                                            <?php foreach ($year_array as $key => $value): ?>
                                                <option @if($key == $allocation_row_detail->budget_year) selected="selected"  @endif value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="amount" class="col-md-3 control-label">Transfer amount <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-9">
                                        <input type="text" name="amount" value="{{ $allocation_row_detail->amount }}" class="form-control" id="adjustment_amount" placeholder="Amount Only Numeric Digit" required="required" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="adjustment_datepicker" class="col-md-5 control-label">Adjustment Date <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-7">
                                        <input type="text" name="allocation_at" value="{{ $allocation_row_detail->allocation_at }}" class="form-control" id="adjustment_datepicker" required="required"  />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="allocation_adjustment_remarks" class="col-md-3 control-label">Description</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="remarks" id="allocation_adjustment_remarks" rows="3" placeholder="Description">{{ $allocation_row_detail->remarks }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-default" onclick="window.location.href ='{{ url('/')}}/budget/adjustment'">Cancel</button>
                                <button type="submit" class="btn btn-primary pull-right">Submit</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-footer -->
                </form>
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
        });
        $(".ut_budget_year").change(function () {
            $('.ut_budget_from_head_drop_down').empty();
            $('.ut_budget_to_head_drop_down').empty();
            var selected_from_head_row_id = <?php echo isset($allocation_row_detail->source_head_row_id)? $allocation_row_detail->source_head_row_id: "null" ?>;
            var selected_to_head_row_id = <?php echo isset($allocation_row_detail->head_row_id)? $allocation_row_detail->head_row_id: "null" ?>;
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