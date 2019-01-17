<!DOCTYPE html><html><head><title>Attendance Report PDF</title>
        <meta charset="UTF-8">
        <style type="text/css">
            h2,h3,h4{
                font-weight: none;
            }
        </style>
        </head><body style="font-size: 12px;">
        <div style="width:100%;margin-top: -50px;">
            <div class="row">
               <table class="table table-striped table-hover" cellpadding="4" cellspacing="0"   width="100%">
                    <tr> 
                        <td><img src="{{ asset('/public/img/bdeducation_logo.png') }}" style="width: 200px;margin:0px 10px 0px 0px;"></td>
                        <td style="vertical-align: center;width: 60%">
                            <h2 style="margin-bottom: 0px;"><u>Attendance Report</u></h2>
                            <h4 style="margin-top: 3px;margin-bottom:3px;">Name : {{ $data['person_info']->employee_name }}</h4>
                            <h4 style="margin-top: 0px;">Date :  {{ date('j-m-Y', strtotime($data['date_from_attendance'])) }}  To {{ date('j-m-Y', strtotime($data['date_to_attendance'])) }}</h4>
                            
                        </td>
                        
                    </tr>
                </table>


            </div>
        </div>
        
        <div class="pdfcontent" style="text-align:center;">
            <div class="main" style="padding: 30px 15px 20px 15px;">
                <table class="table table-striped table-hover" cellpadding="4" cellspacing="0"  border="1" width="100%">
                    <thead>
                        <tr>
                            <th style="text-align:left;width:20%;height: 20px"> Date </th> 
                            <th style="text-align:left;width:15%;"> Day </th>        
                            <th style="text-align: center;width:20%;"> Time In</th>
                            <th style="text-align: center; width:10%;">Time Out</th>                            
                            <th style="text-align: center; width:15%;">Manual Hour</th>
                            <th style="text-align: center; width:10%;">Duration</th>                            
                            <th style="text-align:left;width:10%;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $i = 1; $count_absent = 0; $total_duration = 0; @endphp
                        @foreach($data['attendance_list']  as  $key=>$row)
                            <?php
                            $presentmsg = 'Present'; $absentmsg = 'Absent';
                            $presentcolor = 'color:green !important;';
                            $absentcolor = 'color:red !important;';

                            $login = 0;
                            $absent = 0;
                            $duration = 0;
                            $count_manual_hours = isset ($row['count_manual_hours']) && $row['count_manual_hours'] ? 1 : 0;

                             if(!isset($row['first_login']))
                                $login = 0;
                             else
                             {
                                $login =  strtotime($row['first_login']);
                             }
                            if(!isset($row['last_logout']))
                                $logout = 0;
                            else {
                                $logout =  strtotime($row['last_logout']) ;
                            }

                            $is_offday = isEmployeeHoliday($data['card_id'], $key);
                            if($is_offday) {
                                $absentmsg = 'Not scheduled day';
                                $absentcolor = '';
                            }

                            if(!$count_manual_hours && !$login && !$logout && !( date( 'l', strtotime($key)) == 'Friday' || date( 'l', strtotime($key)) == 'Saturday' ) && !$is_offday)
                            {
                                $absent = 1;
                                $count_absent ++;
                            } 

                            
                            ?>
                            <tr <?php echo $absent ?  : ''; ?>>
                                                    <td>{{ $key }}</td>
                                                    <td>{{ date( 'l', strtotime($key) ) }}</td>
                                                    
                                                    <?php if(!$login && !$logout && ( date( 'l', strtotime($key)) == 'Friday' || date( 'l', strtotime($key)) == 'Saturday' ) ) {
                                                         echo '<td colspan="5" style="padding-left:120px;color:green" >Weekend</td>';
                                                    } else { ?>

                                                    <td>@if(!$count_manual_hours) {{ $login ? date('h:i a', $login) : '' }} @endif</td> 
                                                    <td>
                                                        @if(!$count_manual_hours)
                                                            <?php echo ( ($login == $logout) ||  !$logout ) ? '' : date('h:i a', $logout); ?>
                                                        @endif
                                                    </td> 
                                                    <td>
                                                        <?php 
                                                            if($count_manual_hours) {
                                                                 echo $row['count_manual_hours'] . ' Hours';
                                                            } 
                                                        ?>
                                                    </td>
                                                    <td>
                                                    <?php 
                                                    $manual_hour_counted= 0;
                                                    if($count_manual_hours) {
                                                        $total_duration =  $total_duration + (3600*$row['count_manual_hours']);
                                                    } else {
                                                         if($login && $logout) {
                                                            echo date('G:i', $logout - $login);
                                                            $duration = $logout - $login;
                                                            $total_duration = $total_duration + $duration;
                                                        }
                                                    }
                                                        
                                                     ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $login ? '<div style="' . $presentcolor.'">' . $presentmsg  .'</div>' : '<div style="' . $absentcolor. '">' . $absentmsg . '</div>'; ?>
                                                    </td>
                                                    <?php } ?>
                                                </tr>
                             @php $i++; @endphp                                        
                        @endforeach
                    </tbody>
                </table>
                <div style="float:left;text-align: left;margin-top:5px; margin-bottom: 5px">
                    Total Absent: {{ $count_absent ? $count_absent . ' days' : 'Nil' }}

                    Total Hour: {{ ceil($total_duration/3600) }}
                </div>
            </div>
            <div class="clear" style="margin-top:20px; "><?php echo getPoweredBy(); ?></div>
        </div>
        </body></html>