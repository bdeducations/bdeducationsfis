@extends('layouts.admin')
@section('page_css')
<style type="text/css">
    content{
        text-align :left;
    }
</style>
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/iCheck/minimal/_all.css">
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Send SMS</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Send SMS</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Send SMS</h3><br>
                </div>
                <!-- form start -->
                <div>
                    <form role="form" method="post" action="{{ url('/') }}/hr/sendSMS/send">
		                {!! csrf_field() !!}
			                <div class="portlet-body form">
			                	<div class="form-body">						
								    <div class="form-group">
                                    	<input type="hidden" name="sms_to" value="students" >

										<div class="form-group" style="margin:10px 10px 10px 10px;">
					                    <label>Text For SMS </label>
					                        <div>   
					                          <textarea  required class="form-control" name="sms_text1" id="sms_text1" rows="2" cols="130" placeholder="Write SMS Text" required></textarea><br>
					                          <span id='currentC1'></span>
					                          <span id='remainingC1'></span>
					                          
					                        </div>
					                    </div>

									    <table class="table table-bordered table-striped" width="100%" id="sample_1">
										    <thead>
												<tr>
													<th class="min-phone-l">#</th>
													<th class="min-phone-l">Names </th>
													<th class="min-phone-l">Designation</th>
													<th class="min-phone-l">Phone</th>
													<th class="min-phone-l"><input type="checkbox" id="send_to_all" class="check_menu" value="send_all" chkclass="send_sms">  Send To All</th>
												</tr>
											</thead>
											<tbody>
											<div class="checkbox_wrapper">
												<?php
													$i=1;
												
												?>
												@foreach($data['staff_list'] as $row)
												<tr>	
													<td>{{ $i }}</td>										
													<td>{{ $row->employee_name}}</td>
													<td>
														@if(isset($row->employeeDesignation->designation_name)) {{ $row->employeeDesignation->designation_name }} @endif
													</td>	
													
													<td>
														@if(isset($row->contact_1)) {{ $row->contact_1 }} @endif
													</td>
													<td> 
														<input type="checkbox" style="margin-left: 30px;" name="send_sms[]" class="send_sms" value="{{ $row->contact_1 }}"> 
													</td>
												</tr>
												<?php
												$i++;
												?>
												<input type="hidden" name="staff_ids[]" value="{{ $row->employee_row_id}}" >
												@endforeach
												</div>
											</tbody>
										</table>
		                            </div>															
		                        </div>
		                        <div class="form-actions" style="padding-bottom:20px; ">
		                        	<button type="submit" value="submit" class="btn btn-primary" style="margin-left: 15px;">Submit</button>
		                            
		                            <button type="button" class="btn btn-primary" onclick="window.location.href='{{ url('/')}}/hr/attendance/all-staff-manual-attendance'">Cancel</button>
		                        </div>                   
			                </div>
		                </form>
            	</div>
            </div>
        </div>
    </div>
</section>

@section('page_js')

<script type="text/javascript">
	$(".check_menu").on("click", function() {
		var chkclass = $(this).attr('chkclass');
		$('.'+chkclass).prop('checked', ($(this).is(':checked'))).uniform('refresh');
	});

	$('#sms_text1').keypress(function(){

	    $("#currentC1").html("Typed characters : " +(this.value.length));
	    $("#remainingC1").html(",Remaining characters : " +(70 - this.value.length));
	    
	});

</script>

@endsection
@endsection

