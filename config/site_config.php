<?php

/*
|--------------------------------------------------------------------------
Some values/flags.
|--------------------------------------------------------------------------
*/

$config_admin_type ['system_admin'] = 1; //central staff
$config_admin_type ['school_admin'] = 2; //school staff

$config_subject_group ['sg_general'] = 1;
$config_subject_group ['sg_science'] = 2;
$config_subject_group ['sg_commerce'] = 3;
$config_subject_group ['sg_arts'] = 4;
//$config_base_url ['base_url']	= 'http://localhost/bdeducms/';


return  [
    'config_admin_type' => $config_admin_type,

    'config_subject_group' => $config_subject_group,

    'config_bdeducms_url' =>  'http://localhost/bdeducms',
	
	'blood_group' => [
		'0'=>	'Select Blood Group',
		'1' =>	'A+',
		'2' =>	'A-',
		'3' =>	'B+',
		'4' =>	'B-',
		'5' =>	'O+',
		'6'	=>	'O-',
		'7'	=>	'AB+',
		'8'	=>	'AB-',
	],
	
	'religion' => [
        '0' =>	'Select Religion',
		'1' =>	'Islam',
		'2' =>	'Hindu',
		'3' =>	'Christian',
		'4' =>	'Buddhist',
		'5'	=>	'Others',
	],
	
	'divisionlist' => [
        '0'=>	'None',
		'1' =>	'Dhaka',
		'2' =>	'Chittagong',
		'3' =>	'Rajshahi',
		'4' =>	'Khulna',
		'5' =>	'Barisal',
		'6'	=>	'Sylhet',
		'7'	=>	'Rangpur',
		'8'	=>	'Mymensingh',
	],
	
	'checklist' => [
        '0'	=>	'Class preparation',
		'1' =>	'Reached in time',
		'2' =>	'Followed the lesson plan',
		'3' =>	'Wear dress properly',
		'4' =>	'Hair is fine',
		'5'	=>	'Beard - clean shaved',
		'6'	=>	'Beard - properly arranged',
		'7'	=>	'Shoes are polished',		
	],

	'relationship' => [
        '0'	=>	'Select Relationship(kin)',
		'1' =>	'Uncle',
		'2' =>	'Aunt',
		'3' =>	'Brother',
		'4' =>	'Sister',
		'5'	=>	'Cousin',
		'6'	=>	'Grand Father',
		'7'	=>	'Grand Mother',
		'8'	=>	'Neighbour',
		'9'	=>	'Other',		
	],
	'next_kin_relationship' => [
	    '0'	=>	'Select Relationship(kin)',
		'2'	=>	'Spouse',
		'3'	=>	'Father',
		'4'	=>	'Mother',
		'5'	=>	'Father-in-law',
		'6'	=>	'Mother-in-law',
		'7' =>	'Uncle',
		'8' =>	'Aunt',
		'9' =>	'Brother',
		'10' =>	'Sister',
		'11'	=>	'Cousin',
		'12'	=>	'Grand Father',
		'13'	=>	'Grand Mother',
		'14'	=>	'Neighbour',
		'15'	=>	'Other',
	],
	'academic_department' => [
	    '0'	=>	'None',
		'1'	=>	'General',
		'2'	=>	'Science',
		'3'	=>	'Commerce',
		'4'	=>	'Arts',		
	],
	'daylist' => [
		'1' =>	'Saturday',
		'2' =>	'Sunday',
		'3' =>	'Monday',
		'4' =>	'Tuesday',
		'5' =>	'Wednesday',
		'6'	=>	'Thursday',
		'7'	=>	'Friday',	
	],
];

?>