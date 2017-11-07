@extends('layouts.admin')
@section('page_css')
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Budget Allocation Summary Report</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Allocation Summary</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <!-- form start -->
                <form role="form" method="POST" class="form-horizontal" action="{{ url('/') }}/budget/allocation/summary/report" >
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="area_row_id" class="col-md-5 control-label">Select Area <span class="input-required-asterik">*</span></label>
                                    <div class="col-md-7">
                                        <select name="area_row_id" class ="form-control" required="required">
                                            <option value="">Select Area</option>
                                            <option value="-1" @if($data['selected_area_row_id'] == -1) selected="selected"  @endif>All Area</option>
                                            @foreach( $data['all_areas'] as $area_row)
                                            <option value="{{ $area_row->area_row_id }}" @if($area_row->area_row_id == $data['selected_area_row_id']) selected="selected"  @endif>{{ $area_row['title'] }}</option>
                                            @endforeach
                                        </select>
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
                $pdf_area_qstring = "area_row_id=" . $data['selected_area_row_id'] . "&budget_year=" . $data['selected_budget_year'];
                ?>
                @if($data['account_allocation_summary'])
                <div class="box-header">
                    <a target="_blank" class="btn btn-default" href="{{ url('/') }}/budget/allocation/summary/report/download?@if($pdf_area_qstring){{ $pdf_area_qstring }}@endif"><i class="fa fa-download"></i><strong> Download Report PDF</strong></a>
                    <a target="_blank" style="margin-left:15px;" class="btn btn-default" href="{{ url('/') }}/budget/allocation/summary/report/downloadCSV?@if($pdf_area_qstring){{ $pdf_area_qstring }}@endif"><i class="fa fa-download"></i><strong> Download Report CSV</strong></a>
                </div>
                @endif
                <div class="box-body">
                    @if($data['account_allocation_summary'])
                    <?php
                    $serial = 0;
                    ?>
                    <table class="table table-striped table-bordered table-hover table-checkable order-column">
                        <thead>
                            <tr>
                                <th style="text-align:center;padding-left:10px">Serial</th>
                                <th style="text-align:center;padding-left:10px">Area</th>
                                <th style="text-align:center;padding-left:10px">Sector Head</th>
                                <th style="text-align:center;padding-left:10px">Project Cost</th>
                                <th style="text-align:center;padding-left:10px">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['account_allocation_summary'] as $area_row_id_key => $area_allocation_row)
                            <?php ++$serial;?>
                            <tr>
                                <td style="text-align:center;padding-left:10px">
                                    {{ $serial }}
                                </td>
                                <td style="text-align:center;padding-left:10px">
                                    {{ $area_allocation_row['area_name'] }}
                                </td>
                                <td style="text-align:center;padding-left:10px">
                                    {{ number_format($area_allocation_row['sector_head_allocation'], 2) }}
                                </td>
                                <td style="text-align:center;padding-left:10px">
                                    {{ number_format($area_allocation_row['project_head_allocation'], 2) }}
                                </td>
                                <td style="text-align:center;padding-left:10px">
                                    {{ number_format($area_allocation_row['total_allocation'], 2) }}
                                </td>
                            </tr>
                            @endforeach
                            <?php if ($data['selected_area_row_id'] == -1): ?>
                                <tr>
                                    <td colspan="2">
                                        <strong>&nbsp;Total&nbsp;(All Areas) : </strong>
                                    </td>
                                    <td class="text-center"><strong>{{ number_format($data['all_area_sctor_head_total_allocation'], 2) }}</strong></td>
                                    <td class="text-center"><strong>{{ number_format($data['all_area_sctor_project_head_total_allocation'], 2) }}</strong></td>
                                    <td class="text-center"><strong>{{ number_format($data['grand_total_allocation'], 2) }}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <strong>&nbsp;Grand Total&nbsp;(Existing Estb and Projects) : </strong>
                                    </td>
                                    <td colspan="3" class="text-center"><strong>{{ number_format($data['grand_total_allocation'], 2) }}</strong></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection