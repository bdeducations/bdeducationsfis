@extends('layouts.admin')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Salary Configuration</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Salary Configuration</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="instruction">The componenets belows will be the Percantage of Basic Salary.</div>
                <!-- form start -->
                <form role="form" method="POST" class="form-horizontal" action="{{ url('/') }}/" >
                    {!! csrf_field() !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8">
                                @if( $data['head_wise_payments'])
                                    @foreach($data['head_wise_payments'] as $row)
                                    <div class="form-group">
                                        <label  class="col-md-4 control-label">{{ $row->salary_head_name }}</label>
                                        <div class="col-md-4">
                                            <input type="text" name="head_amount[]" class="form-control" value="{{ $row->amount_fixed ? $row->amount_fixed : ''  }} {{ $row->amount_percantage ? $row->amount_percantage : ''  }}"  /> 
                                        </div>
                                        <div class="col-md-4">
                                            <select name="percantage_fixed[]" class="form-control" required="required">
                                                <option value="">Select</option>
                                                <option value="1" @if($row->percantage_fixed == 1) selected @endif>Percent</option>
                                                <option value="2" @if($row->percantage_fixed == 2) selected @endif>Fixed Amount</option>
                                            </select>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
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