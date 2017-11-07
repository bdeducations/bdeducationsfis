@extends('layouts.admin')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Update Budget Expense</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Update Expense</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <!-- form start -->
                <form role="form" method="POST" class="form-horizontal" action="{{ url('/') }}/expense/update/{{ $expense_row_detail->expense_row_id }}" >
                    {!! csrf_field() !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="area_row_id" class="col-md-2 control-label">Select Area <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-10">
                                        <select name="area_row_id" class ="form-control" required="required">
                                            <option value="">Select Area</option>
                                            @foreach( $data['all_areas'] as $area_row)
                                            <option <?php
                                            if ($area_row->area_row_id == $expense_row_detail->area_row_id): echo "selected='selected'";
                                            endif;
                                            ?> value="{{ $area_row->area_row_id }}">{{ $area_row->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="budget_year" class="col-md-2 control-label">Budget Year <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-10">
                                        <select name="budget_year" class="ut_budget_year form-control" required="required">
                                            <?php
                                            $year_array = budget_year_list();
                                            ?>
                                            <option value="">Select Budget Year</option>
                                            <?php foreach ($year_array as $key => $value): ?>
                                                <option <?php
                                                if ($key == $expense_row_detail->budget_year): echo "selected='selected'";
                                                endif;
                                                ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="head_row_id" class="col-md-2 control-label">Select Head <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-10">
                                        <select name="head_row_id" id="budget_edit_expense_head_dropdown" class="ut_budget_head_drop_down form-control" required="required">
                                            <option value="">Select Head</option>
                                            @foreach( $data['all_heads'] as $row)
                                            <option <?php
                                            if ($row->head_row_id == $expense_row_detail->head_row_id): echo "selected='selected'";
                                            endif;
                                            ?> value="{{ $row->head_row_id }}" @if($row->has_child == 1)disabled @endif >
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
                                        <?php 
                                       if(isset($data['head_name'])):
                                           echo $data['head_name'];
                                       endif;
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="amount" class="col-md-2 control-label">Amount <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" name="amount" pattern="(\d+(\.\d+)?)" class="form-control" id="amount" value="<?php echo isset($expense_row_detail->amount) ? $expense_row_detail->amount : ''; ?>" placeholder="Amount" required="required" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="allocation_remarks" class="col-md-2 control-label">Description</label>
                                    <div class="col-md-10">
                                        <textarea class="form-control" name="remarks" id="allocation_remarks" rows="3" placeholder="Description"><?php echo isset($expense_row_detail->remarks) ? $expense_row_detail->remarks : ''; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-8">
                                <button type="button" class="btn btn-default" onclick="window.location.href ='{{ url('/')}}/budgetExpense'">Cancel</button>
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
<script type="text/javascript">
    $(document).ready(function(){
        $("#budget_edit_expense_head_dropdown").change(function(){
            $('.head_ancestor_selection').empty();
            var selected_head_row_id = $(this).val();
            $.ajax({
                    url: "{{ url('/heads/getHeadAncestor') }}"+ '/'+ selected_head_row_id,
                    type: "GET",
                    dataType: "html",
                    success: function(data){
                        $('.head_ancestor_selection').append(data);
                    }
                });
        });
        $(".ut_budget_year").change(function(){
            $('.ut_budget_head_drop_down').empty();
            var selected_head_row_id = <?php echo isset($expense_row_detail->head_row_id)? $expense_row_detail->head_row_id: "null" ?>;
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