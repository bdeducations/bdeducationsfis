<!DOCTYPE html><html><head><title>Attendance Report PDF</title>
        <meta charset="UTF-8">
        <style type="text/css">
            h2,h3,h4{
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
                            <th style="text-align:left;width:20%;"> Day </th>        
                            <th style="text-align: center;width:20%;"> In Time</th>
                            <th style="text-align: center; width:20%;">Out Time</th>
                            <th style="text-align:left;width:20%;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $i = 1; $count_absent = 0; @endphp
                        @foreach($data['attendance_list']  as  $key=>$row)
                            <?php
                             $login = 0;
                             $absent = 0;

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

                            if(!$login && !$logout && !( date( 'l', strtotime($key)) == 'Friday' || date( 'l', strtotime($key)) == 'Saturday' ) )
                             {
                                $absent = 1;
                                $count_absent ++;
                             } 
                            ?>
                            <tr style="font-size:12px; <?php echo $absent ?  : ''; ?> ">
                                <td>{{ $key }}</td>
                                <td>{{ date( 'l', strtotime($key) ) }}</td>
                                <?php
                                    if(!$login && !$logout && ( date( 'l', strtotime($key)) == 'Friday' || date( 'l', strtotime($key)) == 'Saturday' ) )
                                    {
                                        echo '<td colspan="3" style="padding-left:120px;color:green" >Weekend</td>';
                                    } 
                                    else { ?>

                                <td style="text-align: center;">{{ $login ? date('h:i a', $login) : '' }} </td> 
                                <td style="text-align: center;">
                                <?php 
                                 echo ( ($login == $logout) ||  !$logout ) ? '' : date('h:i a', $logout);
                                // ($row['first_login'] == $row['last_logout'] || !$logout) ? '' : date( 'h:i a', strtotime($row['last_logout']) ) ?>
                                </td> 
                                
                                <td>
                                    {!! $login ? '<div style="color:green !important;">Present</div>' : '<div style="color:red !important;">Absent</div>' !!}
                                </td>
                              <?php } ?>
                            </tr>
                             @php $i++; @endphp                                        
                        @endforeach
                   
                    </tbody>
                </table>
                <div style="float:left;text-align: left;margin-top:5px; margin-bottom: 5px">
                    Total Absent: {{ $count_absent ? $count_absent . ' days' : 'Nil' }}
                </div>
            </div>
            <div class="clear" style="margin-top:20px; "><?php echo getPoweredBy(); ?></div>
        </div>
        </body></html>