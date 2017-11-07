@extends('layouts.admin')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Update Budget Project Head</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Update Project Head</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <!-- form start -->
                <form role="form" method="POST" class="form-horizontal" action="{{ url('/') }}/budget/project/head/update/{{ $head_row_detail->head_row_id }}" >
                    {!! csrf_field() !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="budget_year" class="col-md-2 control-label">Budget Year <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-10">
                                        <select name="budget_year" class ="form-control" required="required">
                                            <option selected="selected" readonly="readonly" value="<?php echo $head_row_detail->budget_year; ?>"><?php echo $head_row_detail->budget_year; ?></option> 
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="parent_id" class="col-md-2 control-label">Select Head <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-10">
                                        <select name="parent_id" class ="form-control" required="required">
                                            <option value="">Select</option>
                                            @foreach( $data['all_heads'] as $row)
                                            <option <?php
                                            if ($row->head_row_id == $head_row_detail->parent_id): echo "selected='selected'";
                                            endif;
                                            ?> value="{{ $row->head_row_id}}">
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
                                <div class="form-group">
                                    <label for="head_name" class="col-md-2 control-label">Name <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" name="title" class="form-control" id="head_name" placeholder="Name" value="<?php echo isset($head_row_detail->title) ? $head_row_detail->title : ''; ?>" required="required" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="head_description" class="col-md-2 control-label">Description</label>
                                    <div class="col-md-10">
                                        <textarea class="form-control" name="description" id="head_description" rows="3" placeholder="Description"><?php echo isset($head_row_detail->description) ? $head_row_detail->description : ''; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sort_order" class="col-md-2 control-label">Sort Order <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" name="sort_order" class="form-control" pattern="(^\d+$)" required="required" value="<?php echo isset($head_row_detail->sort_order) ? $head_row_detail->sort_order : ''; ?>" id="sort_order" placeholder="Sort Order" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-8">
                                <button type="button" class="btn btn-default" onclick="window.location.href ='{{ url('/')}}/budget/project/head'">Cancel</button>
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