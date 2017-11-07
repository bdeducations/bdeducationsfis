@extends('layouts.admin')
@section('page_css')
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datepicker/datepicker3.css">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Create New Allocation</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Allocation</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <!-- form start -->
                <form role="form" method="POST" class="form-horizontal" action="{{ url('/') }}/allocation/store" >
                    {!! csrf_field() !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="budget_year" class="col-md-2 control-label">Budget Year <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-10">
                                        <select name="budget_year" class="ut_budget_year form-control" required="required">
                                            <?php
                                            $year_array = budget_year_list();
                                            ?>
                                            <option value="">Select Budget Year</option>
                                            <?php foreach ($year_array as $key => $value): ?>
                                                <option @if($key == date('Y'))selected="selected" @endif value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="area_row_id" class="col-md-2 control-label">Budget Area <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-10">
                                        <select name="area_row_id" class ="form-control" required="required">
                                            <option value="">Select Area</option>
                                            @foreach( $data['all_areas'] as $area_row)
                                            <option @if($data['prev_allocation_area_row_id']) @if($data['prev_allocation_area_row_id'] == $area_row->area_row_id) selected="selected" @endif @endif value="{{ $area_row->area_row_id }}">{{ $area_row->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="head_row_id" class="col-md-2 control-label">Budget Head <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-10">
                                        <select name="head_row_id" id="budget_create_allocation_head_dropdown" class="ut_budget_head_drop_down form-control" required="required">
                                            <option value="">Select Head</option>
                                            @foreach( $data['all_heads'] as $row)
                                            <option value="{{ $row->head_row_id }}" @if($row->has_child == 1)disabled @endif >
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
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-10 head_ancestor_selection">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="amount" class="col-md-2 control-label">Amount <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" name="amount" pattern="(\d+(\.\d+)?)" class="form-control" id="amount" placeholder="Amount Only Numeric Digit" required="required" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="allocation_remarks" class="col-md-2 control-label">Description</label>
                                    <div class="col-md-10">
                                        <textarea class="form-control" name="remarks" id="allocation_remarks" rows="3" placeholder="Description"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="allocation_at" class="col-md-2 control-label">Date <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-10 date">
                                        <input type="text" name="allocation_at" class="form-control" id="datepicker" required="required" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-8">
                                <button type="button" class="btn btn-default" onclick="window.location.href ='{{ url('/')}}/budgetAllocation'">Cancel</button>
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
    $(document).ready(function(){
        $('#datepicker').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            todayHighlight: true,
        });
        $("#budget_create_allocation_head_dropdown").change(function(){
            $('.head_ancestor_selection').empty();
            var selected_head_row_id = $(this).val();
            $.ajax({
            url: "{{ url('/heads/getHeadAncestor') }}" + '/' + selected_head_row_id,
                    type: "GET",
                    dataType: "html",
                    success: function(data){
                    $('.head_ancestor_selection').append(data);
                    }
            });
        });
        $(".ut_budget_year").change(function(){
            $('.ut_budget_head_drop_down').empty();
            var selected_head_row_id = null;
            var selected_budget_year = $(this).val();
            $.ajax({
                url: "{{ url('/budget/heads/dropdown') }}" + '/' + selected_budget_year + '/' + selected_head_row_id,
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