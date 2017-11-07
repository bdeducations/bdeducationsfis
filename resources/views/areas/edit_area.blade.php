@extends('layouts.admin')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Update Budget Area</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Update Area</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <!-- form start -->
                <form role="form" method="POST" class="form-horizontal" action="{{ url('/') }}/areas/update/{{ $area_row_detail->area_row_id }}" >
                    {!! csrf_field() !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="area_name" class="col-md-2 control-label">Name <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" name="title" class="form-control" id="area_name" placeholder="Name" value="<?php echo isset($area_row_detail->title) ? $area_row_detail->title : ''; ?>" required="required" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="area_name" class="col-md-2 control-label">Code</label>
                                    <div class="col-md-10">
                                        <input type="text" name="area_code" class="form-control" id="area_code" placeholder="Code" value="<?php echo isset($area_row_detail->area_code) ? $area_row_detail->area_code : ''; ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="area_description" class="col-md-2 control-label">Description</label>
                                    <div class="col-md-10">
                                        <textarea class="form-control" name="description" id="area_description" rows="3" placeholder="Description"><?php echo isset($area_row_detail->description) ? $area_row_detail->description : ''; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sort_order" class="col-md-2 control-label">Sort Order <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" name="sort_order" pattern="(^\d+$)" class="form-control" required="required" value="<?php echo isset($area_row_detail->sort_order) ? $area_row_detail->sort_order : ''; ?>" id="sort_order" placeholder="Sort Order" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-8">
                                <button type="button" class="btn btn-default" onclick="window.location.href='{{ url('/')}}/areas'">Cancel</button>
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