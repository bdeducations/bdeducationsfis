<!DOCTYPE html>
<html><head>
        <title>Attendance Report PDF</title>
        <meta charset="UTF-8">
        <style type="text/css">
            h2,h4{
                font-weight: none;
            }
        </style>           
</head><body style="font-size: 14px;">
        <div style="width:100%;margin-top: -50px;">
            <div class="row">
               <table class="table table-striped table-hover" cellpadding="4" cellspacing="0"   width="100%">
                    <tr> 
                        <td><img src="{{ asset('/public/img/bdeducation_logo.png') }}" style="width: 200px;margin:0px 10px 0px 0px;"></td>
                        <td style="vertical-align: center;width: 60%">
                            <h2 style="margin-bottom: 0px;"><u>   Attendance Report</u></h2>
                            <h4 style="margin-top: 0px;">{{ date('j M (l), Y', strtotime($data['attendance_date'])) }}</h4>
                        </td>
                        
                    </tr>
                </table>


            </div>
        </div>

        <div class="pdfcontent" style="text-align:center;">
           
            <div class="main" style="padding: 10px 15px 20px 15px;">
                 <table class="table table-striped table-hover" cellpadding="4" cellspacing="0"  border="1" width="100%">
                  <thead>
                        <tr>
                            <th style="text-align: left;height: 30px">Serial</th>
                            <th style="text-align: left;height: 30px">Name</th>
                            <th style="text-align: left;height: 30px;">In Time</th>
                            <th style="text-align: left;height: 30px;">Out Time</th>
                            <th style="text-align: left;height: 30px;">Total Time</th>
                            <th style="text-align: left;height: 30px"> Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; $countPresent = 0; $countAbsent = 0; @endphp
                        @foreach($data['staff_attendance_info']  as $row)
                        <?php 
                            $presentmsg = 'Present'; $absentmsg = 'Absent';
                            $presentcolor = 'color:green !important;';
                            $absentcolor = 'color:red !important;';

                            $login =  date( 'H:i', strtotime($row->first_login) );
                            $present = 1;
                            if($login == '00:00')
                            {
                                $present = 0;
                                $countAbsent++;                                
                            } else {
                                $countPresent++;
                            }
                            
                            $logout =  date( 'H:i', strtotime($row->last_logout) );
                            
                            if($logout == '00:00')
                            {
                                $logout = 0;
                            }
                            $is_offday = isEmployeeHoliday($row->employee_row_id, $data['attendance_date']);
                            if($is_offday) {
                                $absentmsg = 'Not scheduled day';
                                $absentcolor = '';
                            }
                            
                           ?> 
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $row->employee_name }}</td>
                           <td>{{ $present ? date('h:i a', strtotime($row->first_login)) : '' }}</td> 
                            <td>
                                {{ ($row->first_login == $row->last_logout || !$logout) ? '' : date( 'h:i a', strtotime($row->last_logout) ) }}
                            </td> 
                            <td>
                                @if($login && $logout)
                                   {{ date( 'g', (strtotime($row->last_logout) - strtotime($row->first_login)) ) }} Hours 
                                   {{ date( 'i', (strtotime($row->last_logout) - strtotime($row->first_login)) ) }} Minutes
                               
                                @endif
                            </td>
                            <td>                             
                                <?php echo $present ? '<div style="' . $presentcolor. '">' .$presentmsg . '</div>' : '<div style="' . $absentcolor. '">' . $absentmsg . '</div>'; ?>
                            </td>
                        </tr>
                         @php $i++; @endphp
                    @endforeach
                    </tbody>
                </table>
                <div style="text-align: left;padding-top:20px;font-size: 16px;">
                    <span style="color:green !important;">Total Present: {{ $countPresent }} persons, </span>  
                    <span style="color:red !important;">Total Absent: {{ $countAbsent }} persons </span>              
                </div>
               
            </div>
             <?php echo getPoweredBy(); ?>
        </div>       
</body></html>