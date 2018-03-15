<!DOCTYPE html>
<html><head>
        <title>Attendance Report PDF</title>
        <meta charset="UTF-8">
        <style type="text/css">
            h1,h3,h4{
                font-weight: none;
            }
        </style>           
</head><body style="font-size: 10px;">
        <div style="width:100%;margin-top: -50px;">
            <div class="row">
               <table class="table table-striped table-hover" cellpadding="4" cellspacing="0"   width="100%">
                    <tr> 
                        <td><img src="{{ asset('/public/img/bdeducation_logo.png') }}" style="width: 200px;margin:0px 10px 0px 0px;"></td>
                        <td style="vertical-align: center;width: 60%">
                            <h1 style="margin-bottom: 0px;margin-left: 30px;"><u>   Attendance Report</u></h1>
                            <h3 style="margin-top: 0px;">Date: {{ date('F j, Y', strtotime( $data['start_date'])) }} &nbsp;To&nbsp; {{ date('F j, Y', strtotime( $data['end_date'])) }}</h3>                            
                            <h4 style="margin-top: 0px; margin-bottom:20px; font-weight:bold">
                            Total Working Days: {{ $data['total_working_days_this_month'] }} &nbsp; &nbsp;
                            Total Working Hours: {{ $data['total_working_hours_this_month'] }}                             
                            </h4>                            
                        </td>                        
                    </tr>
                </table>
            </div>
        </div>

        <div class="pdfcontent" style="text-align:center; margin-top:15px">
           
            <div class="main" style="padding: 10px 15px 20px 15px;width: 100%">
                 <table class="table table-striped table-hover" cellpadding="4" cellspacing="0"  border="1" width="100%">
                  <thead>
                        <tr>
                            <th style="text-align: left;height: 30px;width:10px">Sl.</th>
                            <th style="text-align: left;height: 30px;width:120px">Name</th>
                            <th style="text-align: left;height: 30px;width:30px">Present</th>
                            <th style="text-align: left;height: 30px;width:30px">Late Arrival</th>
                            <th style="text-align: left;height: 30px;width:30px">Early Leave</th>
                            <th style="text-align: left;height: 30px;width:25px">Leave </th>
                            <th style="text-align: left;height: 30px;width:25px">Tour</th>
                            <th style="text-align: left;height: 30px;width:75px">UnAuth. Leave</th>
                            <th style="text-align: left;height: 30px;width:88px">Effective Office Time</th>
                            <th style="text-align: left;height: 30px;width:85px">Total Office Time</th>
                            <th style="text-align: left;height: 30px;">Comments</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; $countPresent = 0; $countAbsent = 0; @endphp
                        @foreach($data['staff_attendance_info']  as $row)                        
                        <tr>
                            <td style="width:10px">{{ $i }}</td>
                            <td>{{ $row['employee_name'] }} / {{ $row['employee_row_id'] }}</td>
                            <td>{{ $row['present_days'] }}</td>                             
                            <td style="width:62px">{{ $row['late_incoming'] }} </td>
                            <td style="width:62px">{{ $row['early_leave'] }} </td>
                            <td>{{ $row['number_of_leave'] }}</td>
                            <td>{{ $row['number_of_tour'] }}</td> 
                            <td>{{ $row['unauthorized_leave'] }}</td>
                            <td style="width:62px">{{ $row['total_time_present_in_a_month']}} H</td>
                            <td style="width:62px">{{ $row['total_hour_including_leave'] }} H</td>
                            <td style="width:60px">
                                @php 
                                    if(!$row['is_part_time']) {                                        
                                    $diff = 0;
                                    $diff = $data['total_working_hours_this_month'] - $row['total_hour_including_leave'];
                                    echo $diff > 0 ? '-'  : ($diff == 0 ? '' : '+');
                                    echo abs($diff);
                                    }
                                @endphp 
                            </td>
                        </tr>
                         @php $i++; @endphp
                    @endforeach
                    </tbody>
                </table>
                
                <div style="text-align: left;padding-top:40px;font-size: 16px;">
                    <div style="float:left;border-top:2px solid #000;width:135px">Admin's Signature</div> <div style="border-top:2px solid #000; float:left; margin-left:400px;width:135px">  Director's Signature </div>
                </div>
                <div style="clear:both"></div>
            </div>
             <?php echo getPoweredBy(); ?>
        </div>       
</body></html>