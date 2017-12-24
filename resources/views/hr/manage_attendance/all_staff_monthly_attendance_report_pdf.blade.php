<!DOCTYPE html>
<html><head>
        <title>Attendance Report PDF</title>
        <meta charset="UTF-8">
        <style type="text/css">
            h2,h4{
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
                            <h2 style="margin-bottom: 0px;"><u>   Attendance Report</u></h2>
                            <h4 style="margin-top: 0px;"> {{ $data['attendance_month'] }}, {{ $data['attendance_year'] }}</h4>
                            <h4 style="margin-top: 0px;">Total Working days: {{ $data['total_working_days_this_month'] }} (up to 25th {{ $data['attendance_month'] }})</h4>
                        </td>
                        
                    </tr>
                </table>


            </div>
        </div>

        <div class="pdfcontent" style="text-align:center;">
           
            <div class="main" style="padding: 10px 15px 20px 15px;width: 100%">
                 <table class="table table-striped table-hover" cellpadding="4" cellspacing="0"  border="1" width="100%">
                  <thead>
                        <tr>
                            <th style="text-align: left;height: 30px;width:10px">Sl.</th>
                            <th style="text-align: left;height: 30px">Name</th>
                            <th style="text-align: left;height: 30px;">Present (days)</th>
                            <th style="text-align: left;height: 30px;">Absent (days)</th>
                            <th style="text-align: left;height: 30px;width:80px">Late Arrival (days)</th>
                            <th style="text-align: left;height: 30px;width:80px">Early Leave (days)</th>
                            <th style="text-align: left;height: 30px;">Effective Time</th>                            
                            <th style="text-align: left;height: 30px;">Comments</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; $countPresent = 0; $countAbsent = 0; @endphp
                        @foreach($data['staff_attendance_info']  as $row)
                        
                        <tr>
                            <td style="width:10px">{{ $i }}</td>
                            <td>{{ $row['employee_name'] }}</td>
                            <td>{{ $row['present_days'] }}</td> 
                            <td>{{ $row['absent_days'] }}</td>                             
                            <td style="width:62px">{{ $row['late_incoming'] }} </td>
                            <td style="width:62px">{{ $row['early_leave'] }} </td>
                            <td style="width:62px">{{ floor($row['total_time_present_in_a_month'] /3600 ) }}h
                            @php  $reminder = ceil($row['total_time_present_in_a_month'] % 3600);  echo  ceil($reminder/60) @endphp m</td>
                            <td style="width:60px"> &nbsp; </td>
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