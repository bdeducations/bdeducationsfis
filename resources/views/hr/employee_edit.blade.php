@extends('layouts.admin')

@section('page_css')

<style type="text/css">

/*custom font*/


/*basic reset*/
* {margin: 0; padding: 0;}

html {
	height: 100%;
	/*Image only BG fallback*/
	
	/*background = gradient + image pattern combo*/
	background: linear-gradient(rgba(196, 102, 0, 0.6), rgba(155, 89, 182, 0.6));
}

body {
	
}
/*form styles*/
label{
	font-weight: 0px;
	padding-top: 7px;
	padding-left: 10px;	
}

#sdtForm {
	width: 100%;
	padding: 10px;
	text-align: center;
	position: relative;
}
#sdtForm fieldset {
	background: white;
	border: 0 none;
	border-radius: 3px;
	box-shadow: 0 0 15px 1px rgba(0, 0, 0, 0.4);
	padding: 0px 30px;
	box-sizing: border-box;
	width: 95%;
	margin: 0% 2%;
	
	/*stacking fieldsets above each other*/
	position: inherit;
}
/*Hide all except first fieldset*/
#sdtForm fieldset:not(:first-of-type) {
	display: none;
}
/*inputs*/
#sdtForm input, #sdtForm textarea {
	padding: 15px;
	border: 1px solid #ccc;
	border-radius: 3px;
	margin-bottom: 10px;
	width: 100%;
	box-sizing: border-box;
	color: #2C3E50;
	font-size: 13px;
}
/*buttons*/
.button {
	width: 100px;
	background: #605CA8;
	font-weight: bold;
	color: white;
	border: 0 none;
	border-radius: 1px;
	cursor: pointer;
	padding: 10px 5px;
	margin: 15px 5px;
	}

#sdtForm .button:hover, #sdtForm .button:focus {
	box-shadow: 0 0 0 2px white, 0 0 0 3px #605CA8;
}
#sdtForm .action-button {
	width: 100px;
	background: #605CA8;
	font-weight: bold;
	color: white;
	border: 0 none;
	border-radius: 1px;
	cursor: pointer;
	padding: 10px 5px;
	margin: 15px 5px;
}
#sdtForm .action-button:hover, #sdtForm .action-button:focus {
	box-shadow: 0 0 0 2px white, 0 0 0 3px #605CA8;
}
/*headings*/
.fs-title {
	font-size: 15px;
	text-transform: uppercase;
	color: #2C3E50;
	margin-bottom: 10px;
}
.fs-subtitle {
	font-weight: normal;
	font-size: 13px;
	color: #666;
	margin-bottom: 20px;
}
/*progressbar*/
#progressbar {
	margin-bottom: 20px;
	overflow: hidden;
	/*CSS counters to number the steps*/
	counter-reset: step;
}
#progressbar li {
	list-style-type: none;
	color: #605CA8;
	text-transform: uppercase;
	font-size: 11px;
	width: 25%;
	float: left;
	position: relative;
    margin-top: 3px;
}
#progressbar li:before {
	content: counter(step);
	counter-increment: step;
	width: 20px;
	line-height: 20px;
	display: block;
	font-size: 10px;
	color: #333;
	background: white;
	border-radius: 3px;
	margin: 0 auto 5px auto;
}
/*progressbar connectors*/
#progressbar li:after {
	content: '';
	width: 100%;
	height: 2px;
	background: white;
	position: absolute;
	left: -50%;
	top: 9px;
	z-index: -1; /*put it behind the numbers*/
}
#progressbar li:first-child:after {
	/*connector not needed before the first step*/
	content: none; 
}
/*marking active/completed steps green*/
/*The number of the step and the connector before it = green*/
#progressbar li.active:before,  #progressbar li.active:after{
	background: #605CA8;
	color: white;
}

u, ins {
    text-decoration: underline;
}

select {
	padding: 15px;
    border: 1px solid #ccc;
    border-radius: 3px;
    margin-bottom: 10px;
    width: 100%;
    box-sizing: border-box;
    font-family: montserrat;
    color: #2C3E50;
    font-size: 13px;
    -webkit-appearance: textfield;
    background-color: white;
    -webkit-rtl-ordering: logical;
    user-select: text;
    cursor: auto;
}

.form-control {
    display: block;
    width: 100%;
    height: 45px;
    padding: 4px 12px;
    font-size: 13px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
}
.content-wrapper{
	min-height: 900px !important;
}
table th{
	text-align: center;
}

optgroup { font-size:14px; }

::-webkit-input-placeholder { /* Chrome/Opera/Safari */
  
   font-size: 11pt; 
}
::-moz-placeholder { /* Firefox 19+ */
  
   font-size: 11pt; 
}
:-ms-input-placeholder { /* IE 10+ */

   font-size: 11pt; 
}
:-moz-placeholder { /* Firefox 18- */

   font-size: 11pt;
}
messages{
	color:red;
}
</style>
@endsection

@section('content')
<form id="sdtForm" name="sdtForm" action="{{ url('/') }}/manage-employee/{{ $data['employee_info']->employee_row_id }}/update" method="POST" enctype="multipart/form-data">

{!! csrf_field() !!}  
<input type="hidden" name="edit_row_id" value="{{ $data['employee_info']->employee_row_id }}"> 
  <!-- progressbar -->
  <ul id="progressbar">
    <li class="active">Basic Information</li>
    <li>Address</li>
    <li>Educational Details</li>
    <li>Login Information</li>
  </ul>
  <!-- fieldsets -->
	<fieldset>
	    <h3 class="fs-title" style="color:#605CA8;"><strong>Basic Information</strong> </h3><br>
	    <div class="tab-pane active" id="tab1">
	        <div class="form-body">
	        	<div class="row">
	        		<div class="col-md-2">
	        			<label >Area</label>
	        		</div>
	        		<div class="col-md-4">
                        <select name="area_row_id" id="area_row_id" class="form-control area_row_id" required="required">>
                            <option value="">Select Area</option>
                            @foreach( $data['all_areas'] as $area_row)
                            <option <?php
                            if ($area_row->area_row_id == $data['employee_info']->area_row_id): echo "selected='selected'";
                            endif;
                            ?> value="{{ $area_row->area_row_id }}">{{ $area_row->title }}</option>
                            @endforeach
                        </select>
	        		</div>

	        		<div class="col-md-2">
	        			<label >Name</label>
	        		</div>
	        		<div class="col-md-4">
	        			<input type="text" name="employee_name" value="{{ $data['employee_info']->employee_name }}" placeholder="Enter name"/>
	        		</div>
	        		
	        	</div>

	        	<div class="row">
	        		<div class="col-md-2">
	        			<label >Name (বাংলা)</label>
	        		</div>
	        		<div class="col-md-4">
	        			<input type="text" name="employee_name_bangla" value="{{ $data['employee_info']->employee_name_bangla }}"/>
	        		</div>

	        		<div class="col-md-2">
	        			<label >Contact No-1</label>
	        		</div>
	        		<div class="col-md-4">
	        			<input type="text" name="contact_1" value="{{ $data['employee_info']->contact_1 }}"/>
	        		</div>
	        		
	        	</div>
	        	
	        	<div class="row">
	        		<div class="col-md-2">
	        			<label >Contact No-2</label>
	        		</div>
	        		<div class="col-md-4">
	        			<input type="text" name="contact_2" value="{{ $data['employee_info']->contact_2 }}"/>
	        		</div>

	        		<div class="col-md-2">
	        			<label >Blood Group</label>
	        		</div>
	        		<div class="col-md-4">
	        			<select class="form-control" name="blood_group">
	                        @foreach($data['blood_group'] as $key=>$val)
				                <option value="{{ $key }}"  @if($data['employee_info']->blood_group == $key) selected="selected" @endif >{{ $val }}</option>
				            @endforeach
			            </select>
	        		</div>
	        		
	        	</div>
			    
			    <div class="row">
			    	<div class="col-md-2">
	        			<label >Gender</label>
	        		</div>
	        		<div class="col-md-4">
	        			<select id="gender" class="form-control select2 gender" name="gender">
			            	<option>Select</option>
						    <option value="male" @if($data['employee_info']->gender == "male") selected="selected" @endif>Male</option>
						    <option value="female" @if($data['employee_info']->gender == "female") selected="selected" @endif>Female</option>
						</select>
	        		</div>
	        		<div class="col-md-2">
	        			<label >Religion</label>
	        		</div>
	        		<div class="col-md-4">
	        			<select class="form-control" name="religion">
	                        @foreach($data['religion'] as $key=>$val)
				            	<option value="{{ $key }}" @if($data['employee_info']->employeeDetails->religion == $key) selected="selected" @endif>{{ $val }}</option>
				            @endforeach
			            </select>
	        		</div>
			    		        		
	        	</div>
			    
			    <div class="row">
			    	<div class="col-md-2">
	        			<label >Nationality</label>
	        		</div>
	        		<div class="col-md-4">
	        			<input type="text" name="nationality" value="{{ $data['employee_info']->employeeDetails->nationality }}"/>
	        		</div>
	        		<div class="col-md-2">
	        			<label >Date Of Birth</label>
	        		</div>
	        		<div class="col-md-4">
	        			 <div class="form-group">
			                <div class="input-group date">
			                  <div class="input-group-addon">
			                    <i class="fa fa-calendar"></i>
			                  </div>
			                  <input type="text" class="form-control pull-right" name="dob" id="datepicker" value="{{ $data['employee_info']->employeeDetails->dob }}" style="margin-bottom: 0px;">
			                </div>
			                <!-- /.input group -->
			              </div>
	        		</div>
	        	</div>

			    <div class="row">
			    	<div class="col-md-2">
	        			<label >Next of Kin</label>
	        		</div>
	        		<div class="col-md-4">
	        			<input type="text" name="next_of_kin" value="{{ $data['employee_info']->employeeDetails->next_of_kin }}" placeholder="Next of kin"> 
	        		</div>
	        		<div class="col-md-2">
	        			<label >Kin Relationship</label>
	        		</div>
	        		<div class="col-md-4">
	        			<select id="single" class="form-control select2" name="kin_relationship">
	                       
	                        <option value="0">Select Relationship</option>
			                @foreach($data['relationship'] as $key=>$val)
								<option value="{{ $key }}" @if($data['employee_info']->employeeDetails->kin_relationship == $key) selected="selected" @endif>{{ $val }}</option>
							@endforeach
		                </select>
	        		</div>
	        	</div>
			    
			    <div class="row">
					<div class="col-md-2">
	        			<label >Sector</label>
	        		</div>
			    	<div class="col-md-4">
			    		<select class="form-control departments" name="departments" id="departments">
							<option value="0">Select</option>
						    @foreach($data['departments'] as $row)
								<option value="{{ $row->department_row_id }}" @if($row->department_row_id == $data['employee_info']->department_row_id) selected="selected" @endif>
			                    {{ $row->department_name }}
			                    </option>
							@endforeach   									
	                    </select>
	        		</div>
	        		<div class="col-md-2">
	        			<label >Designation</label>
	        		</div>
	        		<div class="col-md-4">
	        			<select class="form-control designation" name="designation_row_id" id="designation_row_id" current_designation_row_id ="{{ $data['employee_info']->designation_row_id }}">
	        				  
	        			</select>
	        		</div>
	        	</div>

	        	<div class="row">
	        		
	        		<div class="col-md-2">
	        			<label >Date Of Joining</label>
	        		</div>
	        		<div class="col-md-4">
	        			<div class="form-group">
			                <div class="input-group date">
				                <div class="input-group-addon">
				                	<i class="fa fa-calendar"></i>
				                </div>
			                	<input type="text" class="form-control pull-right" name="joining_date" id="datepicker2" value="{{ $data['employee_info']->joining_date }}" style="margin-bottom: 0px;">
			                </div>
			                <!-- /.input group -->
			            </div>
	        		</div>
	        		
	        		<div class="col-md-2">
	        			<label>National Id No</label>
	        		</div>
	        		<div class="col-md-4">
	        			<input type="text" name="nid" value="{{ $data['employee_info']->employeeDetails->nid }}" /> 
	        		</div>
	        	</div>
	        	 <div class="row">
	        	 	
	        		<div class="col-md-2">
	        			<label >National Id photo</label>
	        		</div>
	        		<div class="col-md-4">
	        			@if(isset($data['employee_info']->employeeDetails->nid_photo) && $data['employee_info']->employeeDetails->nid_photo)
		        			<div class="col-md-4">
			        				<a href="{{ url('/') }}/public/images/employee/{{ $data['employee_info']->employee_row_id }}/{{ $data['employee_info']->employeeDetails->nid_photo }}" target="_blank "><img src="{{ url('/') }}/public/images/employee/{{ $data['employee_info']->employee_row_id }}/{{ $data['employee_info']->employeeDetails->nid_photo }}" style="height: 50px;width: 40px;"></a>
			        			
		        			</div>
		        			<div class="col-md-8">
		        				<input type="file" id="exampleInputFile" name="national_id_photo">
		        			</div>
	        			
	        			@else
	        			<input type="file" id="exampleInputFile" name="national_id_photo">
	                    @endif	        			
	        		</div>
	        		<div class="col-md-2">
	        			<label >Employee photo</label>
	        		</div>
	        		<div class="col-md-4">
	        			@if(isset($data['employee_info']->photo_name) && $data['employee_info']->photo_name)
		        			<div class="col-md-4">
			        				<a href="{{ url('/') }}/public/images/employee/{{ $data['employee_info']->employee_row_id }}/{{ $data['employee_info']->photo_name }}" target="_blank"><img src="{{ url('/') }}/public/images/employee/{{ $data['employee_info']->employee_row_id }}/{{ $data['employee_info']->photo_name }}" style="height: 50px;width: 40px;"></a>
			        			
		        			</div>
		        			<div class="col-md-8">
		        				<input type="file" id="exampleInputFile" name="employee_image">
		        			</div>
	        			
	        			@else
	        			<input type="file" id="exampleInputFile" name="employee_image">
	                    @endif
	                    <div class="clearfix margin-top-10">
							<span class="label label-danger">NOTE!</span> Image size 300x300 preferable. 
						</div>
	        		</div>

	        	</div>
	        	<div class="row" style="padding-top: 10px;">
	        		
	        		<div class="col-md-2">
	        			<label >Signature photo</label>
	        		</div>
	        		<div class="col-md-4">
	        			@if(isset($data['employee_info']->photo_name) && $data['employee_info']->photo_name)
		        			<div class="col-md-4">
		        				<a href="{{ url('/') }}/public/images/employee/{{ $data['employee_info']->employee_row_id }}/{{ $data['employee_info']->signature_image_name }}" target="_blank"><img src="{{ url('/') }}/public/images/employee/{{ $data['employee_info']->employee_row_id }}/{{ $data['employee_info']->signature_image_name }}" style="height: 50px;width: 40px;"></a>
		        			</div>
		        			<div class="col-md-8">
		        				<input type="file" id="exampleInputFile" name="signature_image">
		        			</div>
	        			
	        			@else
	        			<input type="file" id="exampleInputFile" name="signature_image">
	                    @endif
	        			
	                    <div class="clearfix margin-top-10">
							<span class="label label-danger">NOTE!</span> Image size 300x80 preferable. 
						</div>    
	        		</div>

	        	</div>
	        </div>
	    </div>
	    <br>
	    <button type="button" class="button" onclick="window.location.href ='{{ url('/')}}//manage-employee'">Cancel</button>
	    <button type="submit" class="button">Submit</button>
	    <input type="button" id="firstNext" name="next" class="next action-button" value="Next" />
	</fieldset>


	<fieldset>
	    <h3 class="fs-title" style="color:#605CA8;"><strong>Address</strong> </h3><br>
	    <div class="row">
	    	<div class="col-md-2">
    			<label >Present Address</label>
    		</div>
			<div class="col-md-4">
				<input type="text" name="present_address" value="{{ $data['employee_info']->employeeDetails->present_address }}" />
			</div>
			<div class="col-md-2">
    			<label >Present Address(বাংলা)</label>
    		</div>
			<div class="col-md-4">
				<input type="text" name="present_address_bangla" value="{{ $data['employee_info']->employeeDetails->present_address_bangla }}" />
			</div>
		</div>

		<div class="row">
			<div class="col-md-2">
    			<label >Division Present</label>
    		</div>
			<div class="col-md-4">
				<select id="single" class="form-control  division_present" name="division_present" presentDivision="{{ $data['employee_info']->employeeDetails->present_division_id}}">
		            <option value="0" @if($data['employee_info']->employeeDetails->present_division_id== 0)  selected="selected" @endif>Select Division</option>
		            <option value="5" @if($data['employee_info']->employeeDetails->present_division_id == 5)  selected="selected" @endif>Barisal</option>
		            <option value="2" @if($data['employee_info']->employeeDetails->present_division_id == 2)  selected="selected" @endif>Chittagong</option>
		            <option value="1" @if($data['employee_info']->employeeDetails->present_division_id == 1)  selected="selected" @endif>Dhaka</option>
		            <option value="4" @if($data['employee_info']->employeeDetails->present_division_id == 4)  selected="selected" @endif>Khulna</option>
		            <option value="8" @if($data['employee_info']->employeeDetails->present_division_id == 8)  selected="selected" @endif>Mymensingh</option>
		            <option value="3" @if($data['employee_info']->employeeDetails->present_division_id == 3)  selected="selected" @endif>Rajshahi</option>
		            <option value="7" @if($data['employee_info']->employeeDetails->present_division_id == 7)  selected="selected" @endif>Rangpur</option>
		            <option value="6" @if($data['employee_info']->employeeDetails->present_division_id == 6)  selected="selected" @endif>Sylhet</option>
		        </select>
			</div>
			<div class="col-md-2">
    			<label >District Present</label>
    		</div>
			<div class="col-md-4">
				<select id="single" class="form-control select2 district_present" name="district_present" presentDistrict="{{ $data['employee_info']->employeeDetails->present_district_id}}"></select>
			</div>
		</div>

		<div class="row">
			<div class="col-md-2">
    			<label >Upazila Present</label>

    		</div>
			<div class="col-md-4">
				<select class="form-control upazila_present" name="upazila_present" presentUpazila="{{ $data['employee_info']->employeeDetails->present_upazila_id}}"></select>
			</div>
			<div class="col-md-2">
    			<label >Postcode Present</label>
    		</div>
			<div class="col-md-4">
				<input type="text" name="postcode_present" value="{{ $data['employee_info']->employeeDetails->present_post_code }}"/>
			</div>
		</div>	
	    <div class="row">
	    	<div class="col-md-2">
    			<label >Permanent Address</label>
    		</div>
			<div class="col-md-4">
				<input type="text" name="permanent_address" value="{{ $data['employee_info']->employeeDetails->permanent_address }}"/>
			</div>
			<div class="col-md-2">
    			<label >Permanent Address Bangla(বাংলা)</label>
    		</div>
			<div class="col-md-4">
				<input type="text" name="permanent_address_bangla" value="{{ $data['employee_info']->employeeDetails->permanent_address_bangla }}"/>
			</div>
		</div>
	    <div class="row">
	    	<div class="col-md-2">
    			<label >Division Permanent</label>
    		</div>
			<div class="col-md-4">
			 	<select id="single" class="form-control division_permanent" name="division_permanent" permanentDivision = "{{ $data['employee_info']->employeeDetails->permanent_division_id }}">
		            <option value="0" @if($data['employee_info']->employeeDetails->permanent_division_id== 0)  selected="selected" @endif>Select Division</option>
		            <option value="5" @if($data['employee_info']->employeeDetails->permanent_division_id == 5)  selected="selected" @endif>Barisal</option>
		            <option value="2" @if($data['employee_info']->employeeDetails->permanent_division_id == 2)  selected="selected" @endif>Chittagong</option>
		            <option value="1" @if($data['employee_info']->employeeDetails->permanent_division_id == 1)  selected="selected" @endif>Dhaka</option>
		            <option value="4" @if($data['employee_info']->employeeDetails->permanent_division_id == 4)  selected="selected" @endif>Khulna</option>
		            <option value="8" @if($data['employee_info']->employeeDetails->permanent_division_id == 8)  selected="selected" @endif>Mymensingh</option>
		            <option value="3" @if($data['employee_info']->employeeDetails->permanent_division_id == 3)  selected="selected" @endif>Rajshahi</option>
		            <option value="7" @if($data['employee_info']->employeeDetails->permanent_division_id == 7)  selected="selected" @endif>Rangpur</option>
		            <option value="6" @if($data['employee_info']->employeeDetails->permanent_division_id == 6)  selected="selected" @endif>Sylhet</option>
		        </select>
			</div>
			<div class="col-md-2">
    			<label >District Permanent</label>
    		</div>
			<div class="col-md-4">
				<select id="single" class="form-control district_permanent"  name="district_permanent" permanentDistrict = "{{ $data['employee_info']->employeeDetails->permanent_district_id }}">
					<option value="0">Select District</option>
				</select>
			</div>
		</div>
	    <div class="row">
	    	<div class="col-md-2">
    			<label >Upazila Permanent</label>
    		</div>
			<div class="col-md-4">
				<select class="form-control upazila_permanent" name="upazila_permanent" permanentUpazila = "{{ $data['employee_info']->employeeDetails->permanent_upazila_id }}"></select>
			</div>
			<div class="col-md-2">
    			<label >Postcode Permanent</label>
    		</div>
			<div class="col-md-4">
				<input type="text" name="postcode_permanent" value="{{ $data['employee_info']->employeeDetails->permanent_post_code }}" placeholder="Postcode Permanent" />
			</div>
		</div>
	    <input type="button" name="previous" class="previous action-button" value="Previous" />
	    <input type="button" name="next" class="next action-button" value="Next" />
	</fieldset>
	<fieldset>
	    <h3 class="fs-title" style="color:#605CA8;"><strong>Educational Details</strong> </h3>
	    <div class="portlet box blue">
			<div class="portlet-body">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th> Level </th>
								<th> Name of Exam </th>														
								<th> Group/Subject </th>
								<th> Result </th>
								<th> Board / University</th>
								<th> Year of Passing</th>
								<th> Certificate Scan Copy</th>												
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><label> SSC / Equivalent </label></td>
								<td> 
									<select class="form-control" name="ssc_exam_name">
			                        <option value="">Select</option>
										<option value="SSC" @if($data['employee_info']->employeeDetails->ssc_exam_name == 'SSC') selected="selected" @endif>SSC</option>
										<option value="Dakhil" @if($data['employee_info']->employeeDetails->ssc_exam_name == 'Dakhil') selected="selected" @endif>Dakhil</option>
										<option value="O Level" @if($data['employee_info']->employeeDetails->ssc_exam_name == 'O Level') selected="selected" @endif>O Level</option>
									</select>  
								</td>
								<td> 
									<select class="form-control" name="ssc_group">
			                        <option value="">Select</option>
										<option value="Science" @if($data['employee_info']->employeeDetails->ssc_group == 'Science') selected="selected" @endif>Science</option>
										<option value="Arts" @if($data['employee_info']->employeeDetails->ssc_group == 'Arts') selected="selected" @endif>Arts</option>
										<option value="Commerce" @if($data['employee_info']->employeeDetails->ssc_group == 'Commerce') selected="selected" @endif>Commerce</option>	
										<option value="Business Studies" @if($data['employee_info']->employeeDetails->ssc_group == 'Business Studies') selected="selected" @endif>Business Studies</option>
										<option value="Humanities" @if($data['employee_info']->employeeDetails->ssc_group == 'Humanities') selected="selected" @endif>Humanities</option>
										<option value="Others" @if($data['employee_info']->employeeDetails->ssc_group == 'Others') selected="selected" @endif>Others</option>
									</select> 
								</td>
								<td> <input type="text" class="form-control" name="ssc_result" value="{{ $data['employee_info']->employeeDetails->ssc_result }}"> </td>
								<td> <input type="text" class="form-control" value="{{ $data['employee_info']->employeeDetails->ssc_board }}" name="ssc_board"> </td>	
								<td> <input type="text" class="form-control" value="{{ $data['employee_info']->employeeDetails->ssc_passing_year }}" name="ssc_passing_year"> </td>
								<td>	
									@if(isset($data['employee_info']->employeeDetails->ssc_certificate_photo) && $data['employee_info']->employeeDetails->ssc_certificate_photo)
										<div class="row">
											<div class="col-md-4">
						        				<a href="{{ url('/') }}/public/images/employee/{{ $data['employee_info']->employee_row_id }}/{{ $data['employee_info']->employeeDetails->ssc_certificate_photo }}" target="_blank"><img src="{{ url('/') }}/public/images/employee/{{ $data['employee_info']->employee_row_id }}/{{ $data['employee_info']->employeeDetails->ssc_certificate_photo }}" style="height: 50px;width: 40px;"></a>
						        			</div>
						        			<div class="col-md-8">
						        				<input type="file" name="ssc_certificate_image" style="float: right;">
						        			</div>
										</div>
				        			@else
				        			<input type="file" name="ssc_certificate_image">
				                    @endif	
								</td>																			
							</tr>
							<tr>
								<td><label> HSC / Equivalent </label></td>
								<td> 
									<select class="form-control" name="hsc_exam_name">
			                        	<option value="">Select</option>
										<option value="HSC"  @if($data['employee_info']->employeeDetails->hsc_exam_name == 'HSC') selected="selected" @endif>HSC</option>
										<option value="Alim"  @if($data['employee_info']->employeeDetails->hsc_exam_name == 'Alim') selected="selected" @endif>Alim</option>
										<option value="ALevel"  @if($data['employee_info']->employeeDetails->hsc_exam_name == 'ALevel') selected="selected" @endif>A Level</option>	
										<option value="Diploma"  @if($data['employee_info']->employeeDetails->hsc_exam_name == 'Diploma') selected="selected" @endif>Diploma</option>
									</select> 
								</td>																			
								<td> 
									<select class="form-control" name="hsc_group">
		                             <option value="">Select</option>
											<option value="Science" @if($data['employee_info']->employeeDetails->hsc_group == 'Science') selected="selected" @endif>Science</option>
											<option value="Arts" @if($data['employee_info']->employeeDetails->hsc_group == 'Arts') selected="selected" @endif>Arts</option>
											<option value="Commerce" @if($data['employee_info']->employeeDetails->hsc_group == 'Commerce') selected="selected" @endif>Commerce</option>	
											<option value="Business Studies" @if($data['employee_info']->employeeDetails->hsc_group == 'Business Studies') selected="selected" @endif>Business Studies</option>
											<option value="Humanities" @if($data['employee_info']->employeeDetails->hsc_group == 'Humanities') selected="selected" @endif>Humanities</option>
											<option value="Others" @if($data['employee_info']->employeeDetails->hsc_group == 'Others') selected="selected" @endif>Others</option>	
									</select> 
								</td>
								<td> <input type="text" class="form-control" name="hsc_result" value="{{ $data['employee_info']->employeeDetails->hsc_result }}"> </td>
								<td> <input type="text" class="form-control" name="hsc_board" value="{{ $data['employee_info']->employeeDetails->hsc_board }}"> </td>	
								<td> <input type="text" class="form-control" name="hsc_passing_year" value="{{ $data['employee_info']->employeeDetails->hsc_passing_year }}"> </td>	

								@if(isset($data['employee_info']->employeeDetails->hsc_certificate_photo) && $data['employee_info']->employeeDetails->hsc_certificate_photo)
								<td>
									<div class="row">
										<div class="col-md-4">
					        				<a href="{{ url('/') }}/public/images/employee/{{ $data['employee_info']->employee_row_id }}/{{ $data['employee_info']->employeeDetails->hsc_certificate_photo }}" target="_blank"><img src="{{ url('/') }}/public/images/employee/{{ $data['employee_info']->employee_row_id }}/{{ $data['employee_info']->employeeDetails->hsc_certificate_photo }}" style="height: 50px;width: 40px;"></a>
					        			</div>
					        			<div class="col-md-8">
					        				<input type="file" name="hsc_certificate_image" style="float: right;">
					        			</div>
									</div>
			        			</td>
			        			@else
			        			<td> <input type="file" name="hsc_certificate_image"> </td>
			                    @endif																			
							</tr>
							<tr>
								<td><label> Graduation </label></td>
								<td>
								    <select class="form-control" name="graduation_exam_row_id">
										<option value="0">--Select--</option>
										@foreach($data['grad_exam_name'] as $exam_name)
											<option value="{{ $exam_name->grad_exam_row_id }}" @if( isset($data['employee_info']->employeeDetails->graduation_exam_row_id) && $data['employee_info']->employeeDetails->graduation_exam_row_id == $exam_name->grad_exam_row_id) selected="selected" @endif>{{ $exam_name->grad_exam_name }}</option>																							
										@endforeach	
								    </select>				
								</td>
								<td>
									<select class="form-control" name="graduation_subject_row_id">
										<option value="0">--Select--</option>
										@foreach($data['grad_postgrad_subject_name'] as $degree_name)
											<option value="{{ $degree_name->grad_postgrad_subject_name_row_id }}" @if( isset($data['employee_info']->employeeDetails->graduation_subject_row_id) && $data['employee_info']->employeeDetails->graduation_subject_row_id == $degree_name->grad_postgrad_subject_name_row_id ) selected="selected" @endif>{{ $degree_name->subject_title }}</option>																							
										@endforeach																							
									</select>
								</td>
								<td> <input type="text" class="form-control" value="{{ $data['employee_info']->employeeDetails->graduation_result }}" name="graduation_result"> </td>
								<td> <input type="text" class="form-control" name="graduation_board" value="{{ $data['employee_info']->employeeDetails->graduation_board }}"> </td>	
								<td> <input type="text" class="form-control" name="graduation_passing_year" value="{{ $data['employee_info']->employeeDetails->graduation_passing_year }}"> </td>																
								@if(isset($data['employee_info']->employeeDetails->graduation_certificate_photo) && $data['employee_info']->employeeDetails->graduation_certificate_photo)
								<td>
									<div class="row">
										<div class="col-md-4">
					        				<a href="{{ url('/') }}/public/images/employee/{{ $data['employee_info']->employee_row_id }}/{{ $data['employee_info']->employeeDetails->graduation_certificate_photo }}" target="_blank"><img src="{{ url('/') }}/public/images/employee/{{ $data['employee_info']->employee_row_id }}/{{ $data['employee_info']->employeeDetails->graduation_certificate_photo }}" style="height: 50px;width: 40px;"></a>
					        			</div>
					        			<div class="col-md-8">
					        				<input type="file" name="graduation_certificate_image" style="float: right;">
					        			</div>
									</div>
			        			</td>
			        			@else
			        			<td> <input type="file" name="graduation_certificate_image"> </td>
			                    @endif						
							</tr>
							<tr>
								<td><label> Post Graduation </label></td>
								<td> 
								    <select class="form-control" name="post_graduation_exam_row_id">
										<option value="0">--Select--</option>
										@foreach($data['post_grad_exam_name'] as $post_exam_name)
											<option value="{{ $post_exam_name->post_grad_exam_row_id }}" @if( isset($data['employee_info']->employeeDetails->post_graduation_exam_row_id) && $data['employee_info']->employeeDetails->post_graduation_exam_row_id == $post_exam_name->post_grad_exam_row_id) selected="selected" @endif>{{ $post_exam_name->post_grad_exam_name }}</option>				
										@endforeach												
								    </select>				
								</td>
								<td> 
									<select class="form-control" name="post_graduation_subject_row_id">
										<option value="0">--Select--</option>
										@foreach($data['grad_postgrad_subject_name'] as $degree_name)
											<option value="{{ $degree_name->grad_postgrad_subject_name_row_id }}" @if( isset($data['employee_info']->employeeDetails->post_graduation_subject_row_id) && $data['employee_info']->employeeDetails->post_graduation_subject_row_id == $degree_name->grad_postgrad_subject_name_row_id) selected="selected" @endif>{{ $degree_name->subject_title }}</option>																							
										@endforeach
									</select>
								</td>
								<td> <input type="text" class="form-control" name="post_graduation_result" value="{{ $data['employee_info']->employeeDetails->post_graduation_result }}"> </td>
								<td> <input type="text" class="form-control" name="post_graduation_board" value="{{ $data['employee_info']->employeeDetails->post_graduation_board }}"> </td>	
								<td> <input type="text" class="form-control" name="post_graduation_passing_year" value="{{ $data['employee_info']->employeeDetails->post_graduation_passing_year }}"> </td>	
								@if(isset($data['employee_info']->employeeDetails->post_graduation_certificate_photo) && $data['employee_info']->employeeDetails->post_graduation_certificate_photo)
								<td>
									<div class="row">
										<div class="col-md-4">
					        				<a href="{{ url('/') }}/public/images/employee/{{ $data['employee_info']->employee_row_id }}/{{ $data['employee_info']->employeeDetails->post_graduation_certificate_photo }}" target="_blank"><img src="{{ url('/') }}/public/images/employee/{{ $data['employee_info']->employee_row_id }}/{{ $data['employee_info']->employeeDetails->post_graduation_certificate_photo }}" style="height: 50px;width: 40px;"></a>
					        			</div>
					        			<div class="col-md-8">
					        				<input type="file" name="post_graduation_certificate_image" style="float: right;">
					        			</div>
									</div>
			        			</td>
			        			@else
			        			<td> <input type="file" name="post_graduation_certificate_image"> </td>
			                    @endif																		
							</tr>                                                                      
							<tr>
								<td><label> Higher Degree</label></td>
								<td> 
								    <select class="form-control" name="higher_degree_exam_name">
										<option value="0">--Select--</option>								
										<option value="MPhil"  @if($data['employee_info']->employeeDetails->higher_degree_exam_name == 'MPhil') selected="selected" @endif>MPhil</option>
										<option value="Ph.D"  @if($data['employee_info']->employeeDetails->higher_degree_exam_name == 'Ph.D') selected="selected" @endif>Ph.D</option>
										<option value="Others"  @if($data['employee_info']->employeeDetails->higher_degree_exam_name == 'Others') selected="selected" @endif>Others</option>					
								    </select>						
								</td>
								<td> 
									<select class="form-control" name="higher_degree_subject_row_id">
										<option value="0">--Select--</option>
										@foreach($data['grad_postgrad_subject_name'] as $degree_name)
											<option value="{{ $degree_name->grad_postgrad_subject_name_row_id }}" @if( isset($data['employee_info']->employeeDetails->higher_degree_subject_row_id) && $data['employee_info']->employeeDetails->higher_degree_subject_row_id == $degree_name->grad_postgrad_subject_name_row_id) selected="selected" @endif>{{ $degree_name->subject_title }}</option>																							
										@endforeach	
									</select>
								</td>
								<td> <input type="text" class="form-control" name="higher_degree_result" value="{{ $data['employee_info']->employeeDetails->higher_degree_result }}"> </td>
								<td> <input type="text" class="form-control" name="higher_degree_board" value="{{ $data['employee_info']->employeeDetails->higher_degree_board }}"> </td>	
								<td> <input type="text" class="form-control" name="higher_degree_passing_year" value="{{ $data['employee_info']->employeeDetails->higher_degree_passing_year }}"> </td>	
								@if(isset($data['employee_info']->employeeDetails->higher_degree_certificate_photo) && $data['employee_info']->employeeDetails->higher_degree_certificate_photo)
								<td>
									<div class="row">
										<div class="col-md-4">
					        				<a href="{{ url('/') }}/public/images/employee/{{ $data['employee_info']->employee_row_id }}/{{ $data['employee_info']->employeeDetails->higher_degree_certificate_photo }}" target="_blank"><img src="{{ url('/') }}/public/images/employee/{{ $data['employee_info']->employee_row_id }}/{{ $data['employee_info']->employeeDetails->higher_degree_certificate_photo }}" style="height: 50px;width: 40px;"></a>
					        			</div>
					        			<div class="col-md-8">
					        				<input type="file" name="higher_degree_certificate_image" style="float: right;">
					        			</div>
									</div>
			        			</td>
			        			@else
			        			<td> <input type="file" name="higher_degree_certificate_image"> </td>
			                    @endif		
							</tr>                                                                   
						</tbody>
					</table>
				</div>
			</div>
		</div>
	    <input type="button" name="previous" class="previous action-button" value="Previous" />
	    <input type="button" name="next" class="next action-button" value="Next" />
	</fieldset>
	<fieldset>
		<h3 class="fs-title" style="color:#605CA8;"><strong>Login Information</strong> </h3>
		<div class="row">
	    	<div class="col-md-3">
    			<label >Email</label>
    		</div>
			<div class="col-md-9">
				<input type="text" name="employee_email" value="{{ $data['employee_info']->employee_email }}"placeholder="Email" />
			</div>
		</div>
		<div class="row">
	    	<div class="col-md-3">
    			<label >Password</label>
    		</div>
			<div class="col-md-9">
				<input type="password" class="form-control" name="password" id="employee_password" value="{{ $data['employee_info']->plain_password }}" placeholder="Password"/>
			</div>
		</div>
		<div class="row">
	    	<div class="col-md-3">
    			<label >Confirm Password</label>
    		</div>
			<div class="col-md-9">
				<input type="password" class="form-control" name="staff_cpassword" placeholder="Confirm Password"/>
			</div>
		</div>
		<button type="button" class="button" onclick="window.location.href ='{{ url('/')}}//manage-employee'">Cancel</button>
		<input type="button" name="previous" class="previous action-button" value="Previous" />
		<!-- <input type="submit" name="submit" class="submit action-button" value="Submit" /> -->
		<button type="submit" class="button">Submit</button>
	</fieldset>
</form>
@endsection

@section('page_js')
<script src="{{ url('/')}}/public/js/jquery.easing.1.3.js"></script>
<script src="{{ url('/')}}/public/js/bootstrap-datepicker.min.js"></script>	
<script src="{{ url('/')}}/public/js/jquery.validate.min.js"></script>	
<script type="text/javascript">

//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$(".next").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	next_fs = $(this).parent().next();
	
	//activate next step on progressbar using the index of next_fs
	$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
	
	//show the next fieldset
	next_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale current_fs down to 80%
			scale = 1 - (1 - now) * 0.2;
			//2. bring next_fs from the right(50%)
			left = (now * 50)+"%";
			//3. increase opacity of next_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({
        'transform': 'scale('+scale+')',
        'position': 'absolute',

      });
			next_fs.css({'left': left, 'opacity': opacity});
		}, 
		duration: 1000, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
	$('html, body').animate({scrollTop: '0px'}, 0);
});

$(".previous").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	previous_fs = $(this).parent().prev();
	
	//de-activate current step on progressbar
	$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
	
	//show the previous fieldset
	previous_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'left': left});
			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity,});
		}, 
		duration: 1000, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
	$('html, body').animate({scrollTop: '0px'}, 0);
});

$(".submit").click(function(){
	return false;
});

$(document).ready(function() {
	$(".division_present").change(function(e){
		$('.divisionpresent').empty();
		$('.district_present').empty();
		var divisionid = $(this).val();
		var divisiontext = $(".division_present option:selected").text();

		$.ajax({
			url: "{{ url('getDistricts/') }}"+ '/'+ divisionid,
			type: "GET",
			dataType: "html",
			success: function(data){
			$('.district_present').append(data);
			}
		});
		$('.divisionpresent').append(divisiontext);
	}); 

	$(".district_present").change(function(e){
		$('.upazila_present').empty();
		var districtid = $(this).val();
		$.ajax({
			url: "{{ url('getUpazilas/') }}"+ '/'+ districtid,
			type: "GET",
			dataType: "html",
			success: function(data){
			$('.upazila_present').append(data);
			}
		});
	});

	$(".division_permanent").change(function(e){
		$('.divisionpermanent').empty();
		$('.district_permanent').empty();
		var divisionid = $(this).val();
		var divisiontext = $(".division_permanent option:selected").text();
		$.ajax({
			url: "{{ url('getDistricts/') }}"+ '/'+ divisionid,
			type: "GET",
			dataType: "html",
			success: function(data){
			$('.district_permanent').append(data);
			}
		});
		$('.divisionpermanent').append(divisiontext);
	});

	$(".district_permanent").change(function(e){
		$('.upazila_permanent').empty();
		var districtid = $(this).val();
		$.ajax({
			url: "{{ url('getUpazilas/') }}"+ '/'+ districtid,
			type: "GET",
			dataType: "html",
			success: function(data){
			$('.upazila_permanent').append(data);
			}
		});
});

$("#departments").change(function(e){
	var department_row_id = $(this).val();
	var area_row_id = $('#area_row_id').val();
	$('.institutions').empty();
	$.ajax({
		url: "{{ url('getInstitutions/') }}"+ '/'+ area_row_id +'/' + department_row_id,
		type: "GET",
		dataType: "html",
		success: function(data){
			$('.institutions').append(data);
		}
	});
});

$("#departments").change(function(e){
	var department_row_id = $(this).val();
	var designation_row_id = $('#designation_row_id').attr('current_designation_row_id');
	$('.designation').empty();
	$.ajax({
		url: "{{ url('getDesignation/') }}"+ '/'+ department_row_id + '/' + designation_row_id,
		type: "GET",
		dataType: "html",
		success: function(data){
			$('.designation').append(data);
		}
	});
});

  
});

$(window).on("load", function() {
var area_row_id = $('#area_row_id').val();
var department_row_id = $('#departments').val();
var current_institution_row_id = $('#institutions').attr('current_institution_row_id');
var designation_row_id = $('#designation_row_id').attr('current_designation_row_id');
var presentDivision = $('.division_present').attr('presentDivision');
var presentDistrict = $('.district_present').attr('presentDistrict');
var presentUpazila = $('.upazila_present').attr('presentUpazila');

var permanentDivision = $('.division_permanent').attr('permanentDivision');
var permanentDistrict = $('.district_permanent').attr('permanentDistrict');
var permanentUpazila = $('.upazila_permanent').attr('permanentUpazila');

$.ajax({
url: "{{ url('getInstitutions/') }}"+ '/' + area_row_id + '/' + department_row_id + '/' + current_institution_row_id,
type: "GET",
dataType: "html",
success: function(data){
$('.institutions').append(data);
}
});

$.ajax({
url: "{{ url('getDesignation/') }}"+ '/'+ department_row_id + '/' + designation_row_id,
type: "GET",
dataType: "html",
success: function(data){
$('.designation').append(data);
}
});

var divisiontext = $(".division_present option:selected").text();
$.ajax({
url: "{{ url('getDistricts/') }}"+ '/'+ presentDivision + '/' + presentDistrict,
type: "GET",
dataType: "html",
success: function(data){

$('.district_present').append(data);

}
});
$('.divisionpresent').append(divisiontext);

$.ajax({
url: "{{ url('getUpazilas/') }}"+ '/'+ presentDistrict + '/' + presentUpazila,
type: "GET",
dataType: "html",
success: function(data){
$('.upazila_present').append(data);
}
});


var divisiontext = $(".division_permanent option:selected").text();
$.ajax({
url: "{{ url('getDistricts/') }}"+ '/'+ permanentDivision + '/' + permanentDistrict,
type: "GET",
dataType: "html",
success: function(data){
console.log(data);
$('.district_permanent').append(data);
}
});
$('.divisionpermanent').append(divisiontext);

$.ajax({
url: "{{ url('getUpazilas/') }}"+ '/'+ permanentDistrict + '/' + permanentUpazila,
type: "GET",
dataType: "html",
success: function(data){
$('.upazila_permanent').append(data);
}
});

});


</script>
<script type="text/javascript">
	 $(function () {
    
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })  
  })	
</script>

<script type="text/javascript">
	 $(function () {
    
    //Date picker
    $('#datepicker2').datepicker({
      autoclose: true
    })  
  })	
</script>

<div class="daterangepicker dropdown-menu ltr show-calendar opensleft"><div class="calendar left"><div class="daterangepicker_input"><input class="input-mini form-control" type="text" name="daterangepicker_start" value=""><i class="fa fa-calendar glyphicon glyphicon-calendar"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"></div></div><div class="calendar right"><div class="daterangepicker_input"><input class="input-mini form-control" type="text" name="daterangepicker_end" value=""><i class="fa fa-calendar glyphicon glyphicon-calendar"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"></div></div><div class="ranges"><div class="range_inputs"><button class="applyBtn btn btn-sm btn-success" disabled="disabled" type="button">Apply</button> <button class="cancelBtn btn btn-sm btn-default" type="button">Cancel</button></div></div></div><div class="daterangepicker dropdown-menu ltr show-calendar opensleft"><div class="calendar left"><div class="daterangepicker_input"><input class="input-mini form-control" type="text" name="daterangepicker_start" value=""><i class="fa fa-calendar glyphicon glyphicon-calendar"></i><div class="calendar-time"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"></div></div><div class="calendar right"><div class="daterangepicker_input"><input class="input-mini form-control" type="text" name="daterangepicker_end" value=""><i class="fa fa-calendar glyphicon glyphicon-calendar"></i><div class="calendar-time"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"></div></div><div class="ranges"><div class="range_inputs"><button class="applyBtn btn btn-sm btn-success" disabled="disabled" type="button">Apply</button> <button class="cancelBtn btn btn-sm btn-default" type="button">Cancel</button></div></div></div><div class="daterangepicker dropdown-menu ltr opensleft"><div class="calendar left"><div class="daterangepicker_input"><input class="input-mini form-control" type="text" name="daterangepicker_start" value=""><i class="fa fa-calendar glyphicon glyphicon-calendar"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"></div></div><div class="calendar right"><div class="daterangepicker_input"><input class="input-mini form-control" type="text" name="daterangepicker_end" value=""><i class="fa fa-calendar glyphicon glyphicon-calendar"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"></div></div><div class="ranges"><ul><li data-range-key="Today">Today</li><li data-range-key="Yesterday">Yesterday</li><li data-range-key="Last 7 Days">Last 7 Days</li><li data-range-key="Last 30 Days">Last 30 Days</li><li data-range-key="This Month">This Month</li><li data-range-key="Last Month">Last Month</li><li data-range-key="Custom Range">Custom Range</li></ul><div class="range_inputs"><button class="applyBtn btn btn-sm btn-success" disabled="disabled" type="button">Apply</button> <button class="cancelBtn btn btn-sm btn-default" type="button">Cancel</button></div></div></div><div class="colorpicker dropdown-menu colorpicker-hidden colorpicker-with-alpha colorpicker-right"><div class="colorpicker-saturation"><i><b></b></i></div><div class="colorpicker-hue"><i></i></div><div class="colorpicker-alpha"><i></i></div><div class="colorpicker-color"><div></div></div><div class="colorpicker-selectors"></div></div><div class="colorpicker dropdown-menu colorpicker-hidden colorpicker-with-alpha colorpicker-right"><div class="colorpicker-saturation"><i><b></b></i></div><div class="colorpicker-hue"><i></i></div><div class="colorpicker-alpha"><i></i></div><div class="colorpicker-color"><div></div></div><div class="colorpicker-selectors"></div></div></body></html>

</script>
<style type="text/css">
	label{
	font-weight: 0px !important;
	padding-top: 7px;
	padding-left: 10px;	
}
</style>
@endsection