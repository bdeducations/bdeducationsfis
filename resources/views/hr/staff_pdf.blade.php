<!DOCTYPE html>
<html><head>
  <title></title>
  <meta charset="UTF-8">

<style>
span.bangla_text {
	 font-family: 'kalpurush';
}

@font-face {
  font-family: 'kalpurush';
  font-style: normal;
  font-weight: normal;
  src: url("{{ url('/') }}public/solaiman.ttf") format('truetype');
} 
</style></head><body>
<div class="studentcontent">
	<div style="width:100%; border-bottom: 2px solid #000;">
		<table border="0" cellpadding="5" cellspacing="1" style="width:100%;">
			<tbody>
				<tr>
					<td>
						<div style="text-align:center;">
							<h2 style="margin:0px;"><?php echo $data['employeeInfo']['employeeInstitution']['institution_name']; ?></h2>
							<p style="margin:0px;"><?php echo $data['employeeInfo']['areaName']['title']; ?></p>
							
						</div>
						
					</td>
					<div style="text-align:left;">
							<p style="font-weight: bold">DETAILS INFORMATION</p>
						</div>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div style="float:left; width:69%;">
	<table border="0" cellpadding="5" cellspacing="1" style="width:100%;background-color:#fff;border-collapse:collapse;">	<tbody>
			<tr>
				<td>Name: <?php echo $data['employeeInfo']['employee_name'];?></td>
			</tr>
			
			<tr>
				<td>Contact No: <?php echo $data['contact'];  ?></td>									
			</tr>
			<tr>
				<td>Email Adress: <?php echo $data['employeeInfo']['employee_email'];  ?></td>									
			</tr>

			<tr>									
				<td width="50%">Designation: <?php echo $data['employeeInfo']['employeeDesignation']['designation_name'];?></td>
			</tr>

		</tbody>
	</table>
</div>
<div style="float:right; width:30%; border-left:2px solid #000; padding:5px;">
	<table border="0" style="width:100%;background-color:#fff;border-collapse:collapse; margin-left:20px;">
		<tbody>
			<tr>
				<td><img src="<?php  echo $data['imageurl']; ?>" width="150" height="175" /></td>
			</tr>
		</tbody>
	</table>
</div>

<div style="clear:both;"></div>

<div style="border-bottom: 2px solid #000;"></div>
	<div>&nbsp;</div>	
	<div style="margin-top:5px; padding:5px; background-color: #eee;"> BIODATA</div>
	
	<div>
		<table border="0" cellpadding="5" cellspacing="1" style="width:100%;background-color:#fff;border-collapse:collapse;">
			<tbody>						
				<tr>
					<td width="50%">Blood Group: <?php echo $data['bloodgroup'];?></td>
					<td width="50%">National ID No: <?php  echo $data['employeeInfo']['employeeDetails']['nid'];?></td>
				</tr>
				<tr>
					<td width="50%">Religion: <?php echo $data['religion']; ?> </td>
					<td width="50%">Nationaly: <?php echo $data['employeeInfo']['employeeDetails']['nationality']; ?></td>
				</tr>
				<tr>
					<td width="50%">Date Of Birth: <?php  echo $data['employeeInfo']['employeeDetails']['dob'];?></td>
					<td width="50%">Gender: <?php  echo $data['employeeInfo']['gender'];?></td>
				</tr>
				<tr>
					<td width="50%">Next Of Kin: <?php echo $data['employeeInfo']['employeeDetails']['next_of_kin'];?></td>
					<td width="50%">Relationship (kin): <?php echo $data['next_kin_relationship'];?></td>
				</tr>					
			</tbody>
		</table>
	</div>

	<div style="margin-top:20px; padding:5px; background-color: #eee; text-transform:uppercase;">Present Address</div>
	<div>
		<table border="0" cellpadding="5" cellspacing="1" style="width:100%;background-color:#fff;border-collapse:collapse;">
					<tbody>
						<tr>
							<td colspan="2">Present Address: <?php echo $data['employeeInfo']['employeeDetails']['present_address'];?></td>
						</tr>
						
						<tr>
							<td width="50%">Division: <?php echo $data['presentdivision']; ?></td>
							<td width="50%">District: <?php echo  $data['presentdistrict']; ?></td>
						</tr>
						<tr>
							<td width="50%">Upazila: <?php echo $data['presentupazila']; ?> </td>
							<td width="50%">Post Code: <?php echo $data['employeeInfo']['employeeDetails']['present_post_code']; ?></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
					</tbody>
		</table>
	</div>

	<div style="margin-top:0px; padding:5px; background-color: #eee; text-transform:uppercase;">Permanent Address</div>
	<div>
		<table border="0" cellpadding="5" cellspacing="1" style="width:100%;background-color:#fff;border-collapse:collapse;">
			<tbody>
					<tr>
						<td colspan="2">Permanent Address: <?php echo $data['employeeInfo']['employeeDetails']['permanent_address'];?></td>
					</tr>

					<tr>
						<td width="50%">Division: <?php echo $data['permanentdivision']; ?> </td>
						<td width="50%">District: <?php echo  $data['permanentdistrict']; ?> </td>
					</tr>
					<tr>
						<td width="50%">Upazila: <?php echo $data['permanentupazila']; ?> </td>
						<td width="50%">Post Code: <?php echo $data['permanentpostcode'];?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</tbody>
			</table>
	</div>
	<div style="margin-top:0px; padding:5px; background-color: #eee; text-transform:uppercase;">Educational Background
	</div>
	<div>
		<table border="0" cellpadding="5" cellspacing="1" style="width:100%;background-color:#fff;border-collapse:collapse;">
					<tbody>
						<tr>							
							<td>Exam Name</td>
							<td>Group</td>
							<td>Result</td>
							<td>Board/University</td>
							<td>Year of Passing</td>
						</tr>
						<tr>
							<td><?php echo $data['employeeInfo']['employeeDetails']['ssc_exam_name'];?></td>
							<td><?php echo $data['employeeInfo']['employeeDetails']['ssc_group'];?></td>
							<td><?php echo $data['employeeInfo']['employeeDetails']['ssc_result'];?></td>
							<td><?php echo $data['employeeInfo']['employeeDetails']['ssc_board'];?></td>
							<td><?php echo $data['employeeInfo']['employeeDetails']['ssc_passing_year'];?></td>
						</tr>
						<tr>
							<td><?php echo $data['employeeInfo']['employeeDetails']['hsc_exam_name'];?></td>
							<td><?php echo $data['employeeInfo']['employeeDetails']['hsc_group'];?></td>
							<td><?php echo $data['employeeInfo']['employeeDetails']['hsc_result'];?></td>
							<td><?php echo $data['employeeInfo']['employeeDetails']['hsc_board'];?></td>
							<td><?php echo $data['employeeInfo']['employeeDetails']['hsc_passing_year'];?></td>
						</tr>
						<?php echo $data['grad_info_row'];?>
						<?php echo $data['post_grad_info_row'];?>
						<?php echo $data['higher_education_info_row'];?>
						<tr>
							<td>&nbsp;</td>
						</tr>
					</tbody></table>
	</div>
		<div class="footer-pdf" style="border-top: 2px solid #000; text-align:right; margin-top:30px; font-style: italic; opacity:0.5">Powered By: bdeducations.org
		</div>			
</body></html>