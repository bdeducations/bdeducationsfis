@extends('layouts.admin')

@section('page_css')

<style type="text/css">
	* {margin: 0; padding: 0;}
	html {
		height: 100%;
		/*Image only BG fallback*/
		
		/*background = gradient + image pattern combo*/
		background: linear-gradient(rgba(196, 102, 0, 0.6), rgba(155, 89, 182, 0.6));
	}
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
<form id="sdtForm" name="sdtForm" action="{{ url('/') }}/manage-employee" method="POST" enctype="multipart/form-data">
{!! csrf_field() !!}  
  <!-- progressbar -->
  <ul id="progressbar">
    <li class="active">Basic Information</li>
    <li>Address</li>
    <li>Educational Details</li>
    <li>Login Information</li>
  </ul>
  <!-- fieldsets -->
	<fieldset>
		<h3 class="fs-title" style="color:#605CA8;"><strong>Basic Information</strong> </h3>
	    <div class="tab-pane active" id="tab1" style="margin-bottom: 0">
	        <div class="form-body">
	        	<div class="row">
	        		<div class="col-md-2">
	        			<label >Area</label>
	        		</div>
	        		<div class="col-md-4">
                        <select name="area_row_id" id="area_row_id" class ="form-control" required="required">
                            <option value="">Select Area</option>
                            @foreach( $data['all_areas'] as $area_row)
                            <option value="{{ $area_row->area_row_id }}">{{ $area_row->title }}</option>
                            @endforeach
                        </select>
	        		</div>

	        		<div class="col-md-2">
	        			<label >Name</label>
	        		</div>
	        		<div class="col-md-4">
	        			<input type="text" name="employee_name" required />
	        		</div>
	        		
	        	</div>

	        	<div class="row">
	        		<div class="col-md-2">
	        			<label >Name (বাংলা)</label>
	        		</div>
	        		<div class="col-md-4">
	        			<input type="text" name="employee_name_bangla" required />
	        		</div>

	        		<div class="col-md-2">
	        			<label >Contact No-1</label>
	        		</div>
	        		<div class="col-md-4">
	        			<input type="text" name="contact_1"/>
	        		</div>
	        		
	        	</div>
	        	
	        	<div class="row">
	        		<div class="col-md-2">
	        			<label >Contact No-2</label>
	        		</div>
	        		<div class="col-md-4">
	        			<input type="text" name="contact_2"/>
	        		</div>

	        		<div class="col-md-2">
	        			<label >Blood Group</label>
	        		</div>
	        		<div class="col-md-4">
	        			<select class="form-control" name="blood_group">
			                 @foreach($data['blood_group'] as $key=>$val)
	                            <option value="{{ $key }}">{{ $val }}</option>
	                        @endforeach
			            </select>
	        		</div>
	        		
	        	</div>
			    
			    <div class="row">
			    	<div class="col-md-2">
	        			<label >Gender</label>
	        		</div>
	        		<div class="col-md-4">
	        			<select id="gender" class="form-control select2 division_permanent" name="gender">
			            	<option>Select</option>
						    <option value="male">Male</option>
						    <option value="female">Female</option>
						</select>
	        		</div>

			    	<div class="col-md-2">
	        			<label >Religion</label>
	        		</div>
	        		<div class="col-md-4">
	        			<select class="form-control" name="religion">
			                @foreach($data['religion'] as $key=>$val)
	                        	<option value="{{ $key }}">{{ $val }}</option>
	                        @endforeach
			            </select>
	        		</div>
	        		
	        	</div>

			   
			    <div class="row">
			    	<div class="col-md-2">
	        			<label >Nationality</label>
	        		</div>
	        		<div class="col-md-4">
	        			<input type="text" name="nationality" value="Bangladeshi"/>
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
			                  <input type="text" class="form-control pull-right" name="dob" id="datepicker" placeholder="Select" style="margin-bottom: 0px;">
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
	        			<input type="text" name="next_of_kin"> 
	        		</div>
	        		<div class="col-md-2">
	        			<label >Kin Relationship</label>
	        		</div>
	        		<div class="col-md-4">
	        			<select id="single" class="form-control select2" name="kin_relationship">
	                        @foreach($data['relationship'] as $key=>$val)
								<option value="{{ $key }}">{{ $val }}</option>
							@endforeach
		                </select>
	        		</div>
	        	</div>
			    
			    <div class="row">
			    	<div class="col-md-2">
	        			<label >Department</label>
	        		</div>
			    	<div class="col-md-4">
			    		<select class="form-control" name="departments" id="departments">
							<option value="">Select</option>
							@foreach($data['departments']  as $row)
								<option value="{{ $row->department_row_id }}">
                                    {{ $row->department_name }}
                                </option>
							@endforeach	   									
	                    </select>
	        		</div>
	        		<div class="col-md-2">
	        			<label >Designation</label>
	        		</div>
	        		<div class="col-md-4">
	        			<select class="form-control designation" name="designation_row_id" id="designation">
	        				<option value="">Select</option> 
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
			                	<input type="text" class="form-control pull-right" name="joining_date" id="datepicker2" style="margin-bottom: 0px;">
			                </div>
			                <!-- /.input group -->
			            </div>
	        		</div>
	        	 	<div class="col-md-2">
	        			<label>National Id No</label>
	        		</div>
	        		<div class="col-md-4">
	        			<input type="text" name="nid"/> 
	        		</div>
        		</div>
	        	<div class="row">

	        		<div class="col-md-2">
	        			<label >National Id photo</label>
	        		</div>
	        		<div class="col-md-4">
	        			<input type="file" id="exampleInputFile" name="national_id_photo">
	        		</div>
	        		<div class="col-md-2">
	        			<label >Employee photo</label>
	        		</div>
	        		<div class="col-md-4">
	        			<input type="file" id="exampleInputFile" name="employee_image">
	                    <div class="clearfix margin-top-10">
							<span class="label label-danger">NOTE!</span> Image size 300x300 preferable. 
						</div>
	        		</div>
	        	</div>

	        	<div class="row">
	        		<div class="col-md-2">
	        			<label >Signature photo</label>
	        		</div>
	        		<div class="col-md-4">
	        			<input type="file" id="exampleInputFile" name="signature_image">
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
				<input type="text" name="present_address" />
			</div>
			<div class="col-md-2">
    			<label >Present Address(বাংলা)</label>
    		</div>
			<div class="col-md-4">
				<input type="text" name="present_address_bangla"/>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
    			<label >Division Present</label>
    		</div>
			<div class="col-md-4">
				<select id="single" class="form-control select2 division_present" name="division_present">
			        <option value="0">Select</option>
			        <option value="5">Barisal</option>
			        <option value="2">Chittagong</option>
			        <option value="1">Dhaka</option>
			        <option value="4">Khulna</option>
			        <option value="8">Mymensingh</option>
			        <option value="3">Rajshahi</option>
			        <option value="7">Rangpur</option>
			        <option value="6">Sylhet</option>
			    </select>
			</div>
			<div class="col-md-2">
    			<label >District Present</label>
    		</div>
			<div class="col-md-4">
				<select id="single" class="form-control select2 district_present" name="district_present"></select>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
    			<label >Upazila Present</label>
    		</div>
			<div class="col-md-4">
				<select class="form-control upazila_present" name="upazila_present"></select>
			</div>
			<div class="col-md-2">
    			<label >Postcode Present</label>
    		</div>
			<div class="col-md-4">
				<input type="text" name="postcode_present" />
			</div>
		</div>	
	    <div class="row">
	    	<div class="col-md-2">
    			<label >Permanent Address</label>
    		</div>
			<div class="col-md-4">
				<input type="text" name="permanent_address"/>
			</div>
			<div class="col-md-2">
    			<label >Permanent Address Bangla(বাংলা)</label>
    		</div>
			<div class="col-md-4">
				<input type="text" name="permanent_address_bangla" />
			</div>
		</div>
	    <div class="row">
	    	<div class="col-md-2">
    			<label >Division Permanent</label>
    		</div>
			<div class="col-md-4">
			 	<select id="single" class="form-control select2 division_permanent" name="division_permanent">
				    <option value="0">Select</option>
				    <option value="5">Barisal</option>
				    <option value="2">Chittagong</option>
				    <option value="1">Dhaka</option>
				    <option value="4">Khulna</option>
				    <option value="8">Mymensingh</option>
				    <option value="3">Rajshahi</option>
				    <option value="7">Rangpur</option>
				    <option value="6">Sylhet</option>
				</select>
			</div>
			<div class="col-md-2">
    			<label >District Permanent</label>
    		</div>
			<div class="col-md-4">
				<select id="single" class="form-control select2 district_permanent" name="district_permanent"></select>
			</div>
		</div>
	    <div class="row">
	    	<div class="col-md-2">
    			<label >Upazila Permanent</label>
    		</div>
			<div class="col-md-4">
				<select class="form-control upazila_permanent" name="upazila_permanent"></select>
			</div>
			<div class="col-md-2">
    			<label >Postcode Permanent</label>
    		</div>
			<div class="col-md-4">
				<input type="text" name="postcode_permanent" />
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
										<option value="SSC">SSC</option>
										<option value="Dakhil">Dakhil</option>
										<option value="O Level">O Level</option>								
									</select> 
								</td>
								<td> 
									<select class="form-control" name="ssc_group">
		                                <option value="">Select</option>
										<option value="Science">Science</option>
										<option value="Arts">Arts</option>
										<option value="Commerce">Commerce</option>	
										<option value="Business Studies">Business Studies</option>
										<option value="Humanities">Humanities</option>
										<option value="Others">Others</option>									
									</select>
								</td>
								<td> <input type="text" class="form-control" name="ssc_result"> </td>
								<td> <input type="text" class="form-control" name="ssc_board"> </td>	
								<td> <input type="text" class="form-control" name="ssc_passing_year"></td>
								<td> <input type="file" name="ssc_certificate_image"> </td>		
							</tr>
							<tr>
								<td><label> HSC / Equivalent </label></td>
								<td> 
									<select class="form-control" name="hsc_exam_name">
		                             <option value="">Select</option>
										<option value="HSC">HSC</option>
										<option value="Alim">Alim</option>
										<option value="A Level">A Level</option>	
										<option value="Diploma">Diploma</option>			
									</select>
								</td>																			
								<td> 
									<select class="form-control" name="hsc_group">
		                             <option value="">Select</option>
											<option value="Science">Science</option>
											<option value="Arts">Arts</option>
											<option value="Commerce">Commerce</option>	
											<option value="Business Studies">Business Studies</option>
											<option value="Humanities">Humanities</option>
											<option value="Others">Others</option>								
									</select>  
								</td>
								<td> <input type="text" class="form-control" name="hsc_result"> </td>
								<td> <input type="text" class="form-control" name="hsc_board"> </td>	
								<td> <input type="text" class="form-control" name="hsc_passing_year"> </td>	
								<td> <input type="file" name="hsc_certificate_image"> </td>		
							</tr>
							<tr>
								<td><label> Graduation </label></td>
								<td>
								    <select class="form-control" name="graduation_exam_row_id">
										<option value="0">--Select--</option>
										@foreach($data['grad_exam_name'] as $exam_name)
											<option value="{{ $exam_name->grad_exam_row_id }}">{{ 	$exam_name->grad_exam_name }}</option>											
										@endforeach	
								    </select>						
								</td>
								<td>
									<select class="form-control" name="graduation_subject_row_id">
										<option value="0">--Select--</option>
										@foreach($data['grad_postgrad_subject_name'] as $degree_name)
											<option value="{{ $degree_name->grad_postgrad_subject_name_row_id }}">{{ $degree_name->subject_title }}</option>																							
										@endforeach									
									</select>
								</td>
								<td> <input type="text" class="form-control" name="graduation_result"> </td>
								<td> <input type="text" class="form-control" name="graduation_board"> </td>	
								<td> <input type="text" class="form-control" name="graduation_passing_year"> </td>	
								<td> <input type="file" name="graduation_certificate_image"> </td>																
							</tr>
							<tr>
								<td><label> Post Graduation </label></td>
								<td> 
								    <select class="form-control" name="post_graduation_exam_row_id">
										<option value="0">--Select--</option>
										@foreach($data['post_grad_exam_name'] as $post_exam_name)
											<option value="{{ $post_exam_name->post_grad_exam_row_id }}">{{ $post_exam_name->post_grad_exam_name }}</option>		
										@endforeach
								    </select>						
								</td>
								<td> 
									<select class="form-control" name="post_graduation_subject_row_id">
										<option value="0">--Select--</option>
										@foreach($data['grad_postgrad_subject_name'] as $degree_name)
											<option value="{{ $degree_name->grad_postgrad_subject_name_row_id }}">{{ $degree_name->subject_title }}</option>						
										@endforeach
									</select>
								</td>
								<td> <input type="text" class="form-control" name="post_graduation_result"> </td>
								<td> <input type="text" class="form-control" name="post_graduation_board"> </td>
								<td> <input type="text" class="form-control" name="post_graduation_passing_year"> </td>	
								<td> <input type="file" name="post_graduation_certificate_image"> </td>								
							</tr>                                                                             
							<tr>
								<td><label> Higher Degree </label></td>
								<td> 
								    <select class="form-control" name="higher_degree_exam_name">
										<option value="0">--Select--</option>																							
										<option value="MPhil">MPhil</option>
										<option value="Ph.D">Ph.D</option>
										<option value="Others">Others</option>							
								    </select>																
								</td>
								<td> 
									<select class="form-control" name="higher_degree_subject_row_id">
										<option value="0">--Select--</option>
										@foreach($data['grad_postgrad_subject_name'] as $degree_name)
											<option value="{{ $degree_name->grad_postgrad_subject_name_row_id }}">{{ $degree_name->subject_title }}</option>																		
										@endforeach	
									</select>
								</td>
								<td> <input type="text" class="form-control" name="higher_degree_result"> </td>
								<td> <input type="text" class="form-control" name="higher_degree_board"> </td>	
								<td> <input type="text" class="form-control" name="higher_degree_passing_year"> </td>	
								<td> <input type="file" name="higher_degree_certificate_image"> </td>																		
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
				<input type="text" name="employee_email" placeholder="Email" />
			</div>
		</div>
		<div class="row">
	    	<div class="col-md-3">
    			<label >Password</label>
    		</div>
			<div class="col-md-9">
				<input type="password" class="form-control" name="password" id="employee_password" placeholder="Password"/>
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
		$('.designation').empty();
		$.ajax({
			url: "{{ url('getDesignation/') }}"+ '/'+ department_row_id,
			type: "GET",
			dataType: "html",
			success: function(data){
				$('.designation').append(data);
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

<script type="text/javascript">
$(document).ready(function() {
	$("#sdtForm").validate({
	    rules: {
	        admin_name: "required",
	        admin_name_bangla : "required",
	        departments : "required"
	    },
	    messages: {
	        admin_name: "Name is required",
	        admin_name_bangla: "Name(Bangla) is required",
	        departments: "Departments is required"
	    }
	})
});
</script>
<div class="daterangepicker dropdown-menu ltr show-calendar opensleft"><div class="calendar left"><div class="daterangepicker_input"><input class="input-mini form-control" type="text" name="daterangepicker_start" value=""><i class="fa fa-calendar glyphicon glyphicon-calendar"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"></div></div><div class="calendar right"><div class="daterangepicker_input"><input class="input-mini form-control" type="text" name="daterangepicker_end" value=""><i class="fa fa-calendar glyphicon glyphicon-calendar"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"></div></div><div class="ranges"><div class="range_inputs"><button class="applyBtn btn btn-sm btn-success" disabled="disabled" type="button">Apply</button> <button class="cancelBtn btn btn-sm btn-default" type="button">Cancel</button></div></div></div><div class="daterangepicker dropdown-menu ltr show-calendar opensleft"><div class="calendar left"><div class="daterangepicker_input"><input class="input-mini form-control" type="text" name="daterangepicker_start" value=""><i class="fa fa-calendar glyphicon glyphicon-calendar"></i><div class="calendar-time"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"></div></div><div class="calendar right"><div class="daterangepicker_input"><input class="input-mini form-control" type="text" name="daterangepicker_end" value=""><i class="fa fa-calendar glyphicon glyphicon-calendar"></i><div class="calendar-time"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"></div></div><div class="ranges"><div class="range_inputs"><button class="applyBtn btn btn-sm btn-success" disabled="disabled" type="button">Apply</button> <button class="cancelBtn btn btn-sm btn-default" type="button">Cancel</button></div></div></div><div class="daterangepicker dropdown-menu ltr opensleft"><div class="calendar left"><div class="daterangepicker_input"><input class="input-mini form-control" type="text" name="daterangepicker_start" value=""><i class="fa fa-calendar glyphicon glyphicon-calendar"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"></div></div><div class="calendar right"><div class="daterangepicker_input"><input class="input-mini form-control" type="text" name="daterangepicker_end" value=""><i class="fa fa-calendar glyphicon glyphicon-calendar"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"></div></div><div class="ranges"><ul><li data-range-key="Today">Today</li><li data-range-key="Yesterday">Yesterday</li><li data-range-key="Last 7 Days">Last 7 Days</li><li data-range-key="Last 30 Days">Last 30 Days</li><li data-range-key="This Month">This Month</li><li data-range-key="Last Month">Last Month</li><li data-range-key="Custom Range">Custom Range</li></ul><div class="range_inputs"><button class="applyBtn btn btn-sm btn-success" disabled="disabled" type="button">Apply</button> <button class="cancelBtn btn btn-sm btn-default" type="button">Cancel</button></div></div></div><div class="colorpicker dropdown-menu colorpicker-hidden colorpicker-with-alpha colorpicker-right"><div class="colorpicker-saturation"><i><b></b></i></div><div class="colorpicker-hue"><i></i></div><div class="colorpicker-alpha"><i></i></div><div class="colorpicker-color"><div></div></div><div class="colorpicker-selectors"></div></div><div class="colorpicker dropdown-menu colorpicker-hidden colorpicker-with-alpha colorpicker-right"><div class="colorpicker-saturation"><i><b></b></i></div><div class="colorpicker-hue"><i></i></div><div class="colorpicker-alpha"><i></i></div><div class="colorpicker-color"><div></div></div><div class="colorpicker-selectors"></div></div></body></html>

</script>

@endsection