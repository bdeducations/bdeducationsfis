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
                            <h4 style="margin-top: 0px;">{{ date('j M (l), Y', strtotime($data['attendance_date'])) }}</h4>
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
                            <th style="text-align: left;height: 30px;"> Time In</th>
                            <th style="text-align: left;height: 30px;"> Time Out</th>
                            <th style="text-align: left;height: 30px;">Total Time</th>                            
                            <th style="text-align: left;height: 30px;">Late Arrival</th>
                            <th style="text-align: left;height: 30px;">Early Leave</th>                            
                            <th style="text-align: left;height: 30px"> Status</th>
                            <th style="text-align: left;height: 30px;">Comments</th>
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
                                $absentmsg = 'Not scheduled';
                                $absentcolor = '';
                            }
                            
                           ?> 
                        <tr>
                            <td style="width:10px">{{ $i }}</td>
                            <td style="width:120px">{{ $row->employee_name }}</td>
                           <td>{{ $present ? date('h:i a', strtotime($row->first_login)) : '' }}</td> 
                            <td>
                                @php 
                                $logoutStatus = 0;
                                if ($row->first_login == $row->last_logout || !$logout) {
                                        echo ''; //print something
                                    } else {
                                     $logoutStatus = 1;
                                     echo date( 'h:i a', strtotime($row->last_logout) );
                                    }
                                @endphp
                            </td> 
                            <td style="width:60px">
                                @if($login && $logout)
                                   {{ date( 'G', (strtotime($row->last_logout) - strtotime($row->first_login)) ) }}h
                                   {{ date( 'i', (strtotime($row->last_logout) - strtotime($row->first_login)) ) }}m
                                @endif
                            </td>
                            
                            <td style="width:62px">
                                @if(!$row->is_part_time && $present)                                    
                                    @php                                       

                                        $inTimeSupposedTo = strtotime($data['attendance_date'] . $row->in_time_supposed);
                                        $inTimeHeWas = strtotime($row->first_login);
                                        if($inTimeHeWas > $inTimeSupposedTo) {
                                            if($inTimeHeWas - $inTimeSupposedTo > 3600) {
                                              echo date('H', $inTimeHeWas - $inTimeSupposedTo) . 'h ' ;
                                            }
                                            echo date('i', $inTimeHeWas - $inTimeSupposedTo) . 'm';
                                        }
                                    @endphp
                                @endif 
                            </td>
                            <td style="width:60px">
                                  @if(!$row->is_part_time && $logoutStatus) 
                                    @php
                                        $outTimeSupposedTo = strtotime($data['attendance_date'] .  $row->out_time_supposed);
                                        $outTimeHeWas = strtotime($row->last_logout);
                                        if($outTimeSupposedTo > $outTimeHeWas) {
                                            if($outTimeSupposedTo - $outTimeHeWas > 3600) {
                                              echo date('H', $outTimeSupposedTo - $outTimeHeWas) . 'h ' ;
                                            }
                                            echo date('i', $outTimeSupposedTo - $outTimeHeWas) . 'm';
                                        }
                                    @endphp
                                @endif 
                            </td>                            
                            <td style="width:70px">                             
                                <?php echo $present ? '<div style="' . $presentcolor. '">' .$presentmsg . '</div>' : '<div style="' . $absentcolor. '">' . $absentmsg . '</div>'; ?>
                            </td>
                            <td style="width:100px"> </td>
                        </tr>
                         @php $i++; @endphp
                    @endforeach
                    </tbody>
                </table>
                <div style="text-align: left;padding-top:20px;font-size: 16px;">
                    <span style="color:green !important;">Total Present: {{ $countPresent }} persons, </span>  
                    <span style="color:red !important;">Total Absent: {{ $countAbsent }} persons </span>              
                </div>
               <div style="text-align: left;padding-top:40px;font-size: 16px;">
                    <div style="float:left;border-top:2px solid #000;width:135px">Admin's Signature</div> <div style="border-top:2px solid #000; float:left; margin-left:400px;width:135px">  Director's Signature </div>
                </div>
                <div style="clear:both"></div>
            </div>
             <?php echo getPoweredBy(); ?>
        </div>       
</body></html>