@extends('layouts.admin')

@section('content')
	<!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{ asset('/public')}}/metronic/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/public')}}/metronic/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
	
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-dark">
						<i class="icon-settings font-dark"></i>
						<span class="caption-subject bold uppercase">Send SMS</span>
					</div>
				</div>
				<div class="portlet-body">	
					<div class="table-toolbar">
						<div class="row">
							<div class="col-md-6">
								<div class="btn-group">
									<a id="sample_editable_2_new" href="javascript:void(0)" class="btn sbold yellow sendToStaff"> Send To Staff  <i class="fa fa-plus"></i></a>
								</div>
							</div>
							<div class="col-md-6">
								<div class="btn-group">
									<a id="sample_editable_1_new" href="javascript:void(0)" class="btn sbold red others"> Send To Othar Number  <i class="fa fa-plus"></i></a>
								</div>
							</div>
						</div>
					</div> 

					<div class="sendToStaffForm" style="display:none;">
						<div class="portlet light bordered">
							<div class="portlet-body form">
								<form action="#" method="POST" class="form-horizontal">
									 <div class="form-group" style="margin:10px 10px 10px 10px;">
				                     <label>Text For SMS </label>
				                        <div>   
				                          <textarea  name="sms_text" id="sms_text" rows="4" cols="165" placeholder="Write SMS Text"> </textarea><br>
				                          <span id='currentC'></span>
				                          <span id='remainingC'></span>
				                          
				                        </div>
				                    </div>
				                    <div class="caption">
										<i class="icon-equalizer font-red-sunglo"></i>
										<span class="caption-subject font-red-sunglo bold uppercase">Send To All/Select</span>
									</div>  
									<table class="table table-striped table-bordered table-hover table-checkable order-column" id="exam_category_list">
									<thead>
			                        <tr>				
			                            <th style="text-align:center;">Name</th>
										<th style="text-align:center;">Check </th>
			                        </tr>
			                        </thead>
			                        <tbody>
			                        @foreach($data['staff_list'] as $row)
			                            <tr>
			                                <td style="text-align:center;">{{ $row->employee_name }}</td>                              
			                                <td style="text-align:center;">
												<input type="checkbox" name="staff">
											</td>
			                            </tr>
			                        @endforeach
			                        </tbody>
									</table>
									<div class="form-actions">
										<div class="row">
											<div class="col-md-4">
												<button type="submit" class="btn green">Send</button>
												<button type="button" class="btn default discardOther">Cancel</button>
											</div>
										</div>
									</div>
								</form><!-- END FORM-->
							</div>
						</div>
					</div> 

					<div class="othersForm" style="display:none;">
						<div class="portlet light bordered">
							<div class="portlet-title">
								<div class="caption">
									<i class="icon-equalizer font-red-sunglo"></i>
									<span class="caption-subject font-red-sunglo bold uppercase">Send To All/Select</span>
								</div>
							</div>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form action="#" method="POST" class="form-horizontal">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<div class="form-body">
										<div class="form-group">
										<label class="col-md-3 control-label">Text For SMS </label>
											<div class="col-md-8">
												<textarea  name="sms_text" id="sms_text" rows="4" cols="108" placeholder="Write SMS Text"> </textarea><br>
						                        <span id='currentC'></span>
						                        <span id='remainingC'></span>
											</div>
					                    </div>
										<div class="form-group">
											<label class="col-md-3 control-label">Mobile Number</label>
											<div class="col-md-8">
												<input type="text" class="form-control examshorttag" name="exam_short_tag" placeholder="Enter Mobile Number">
											</div>
										</div>
									</div>
									<div class="form-actions">
										<div class="row">
											<div class="col-md-offset-3 col-md-4">
												<button type="submit" class="btn green">Submit</button>
												<button type="button" class="btn default discardOther">Cancel</button>
											</div>
										</div>
									</div>
								</form>
								<!-- END FORM-->
							</div>
						</div>
					</div>


					
					
					
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
	
@section('page_js')
	<script src="{{ asset('/public')}}/metronic/global/scripts/datatable.js" type="text/javascript"></script>
	<script src="{{ asset('/public')}}/metronic/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
	<script src="{{ asset('/public')}}/metronic/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
	<script src="{{ asset('/public')}}/metronic/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
	<script src="{{ asset('/public')}}/metronic/global/plugins/jquery-ui/jquery-ui.min.js"></script>
	<script src="{{ asset('/public')}}/metronic/pages/scripts/ui-modals.min.js" type="text/javascript"></script>
@endsection	
	<script type="text/javascript">
	$(document).ready(function() {
		
		$('.sendToStudents').click(function(e){
			$('.sendToStudentForm').slideToggle();
			$(this).children('.fa-minus, .fa-plus').toggleClass("fa-minus fa-plus");
		});
		
		$('.discardexam').click(function(e){	
			$('.sendToStudentForm').slideToggle();
			$('.sendToStudents').children('.fa-plus, .fa-minus').toggleClass("fa-plus fa-minus");
			$("input[name=exam_category_title]").val('');
			$("input[name=exam_short_tag]").val('');
			$("input[name=exam_master_term_row_id]").val('');
		});

		$('.sendToStaff').click(function(e){
			$('.sendToStaffForm').slideToggle();
			$(this).children('.fa-minus, .fa-plus').toggleClass("fa-minus fa-plus");
		});
		
		$('.discardexam').click(function(e){	
			$('.sendToStaffForm').slideToggle();
			$('.sendToStaff').children('.fa-plus, .fa-minus').toggleClass("fa-plus fa-minus");
			$("input[name=exam_category_title]").val('');
			$("input[name=exam_short_tag]").val('');
			$("input[name=exam_master_term_row_id]").val('');
		});

		$('.others').click(function(e){
			$('.othersForm').slideToggle();
			$(this).children('.fa-minus, .fa-plus').toggleClass("fa-minus fa-plus");
		});
		
		$('.discardOther').click(function(e){	
			$('.othersForm').slideToggle();
			$('.others').children('.fa-plus, .fa-minus').toggleClass("fa-plus fa-minus");
		});

		$(document).ready(function() {
		$('#sms_text').keypress(function(){
		    if(this.value.length > 70){
		        return false;
		    }
		    $("#currentC").html("Typed characters : " +(this.value.length));
		    $("#remainingC").html("Remaining characters : " +(70 - this.value.length));
		    
		});
		});

	} );
	</script>
@endsection