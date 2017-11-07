<!DOCTYPE html>
<html>
    <head>
        <title>Attendance Report PDF</title>
        <meta charset="UTF-8">
        <style type="text/css">
            h4{
                font-weight: none;
            }
        </style>           
    </head>
    <body>
        <div style="width:100%;margin-top: -50px;">
            <div class="row">
            <div class="col-sm-4"  style="margin-top: 20px; float: left;">
                <img src="{{ $data['school_logo_url'] }}" style="width: 200px">
            </div>
            <div class="col-sm-8">
                <div style="text-align:center; margin-top: 50px;">
                    <h2 style="margin:0px;">{{strtoupper(session('school_name'))}}</h2>
                    <p style="margin:0px;">{{ $data['school_address'] }}</p>
                    <h3 style="margin-bottom:0px;margin-top: 30px"><u>Staff Attendance Report</u></h3>
                    <h4 style="margin-top:-50px;margin-bottom:0px">Name: {{ $data['person_name'] }} </h4>
                    <h4 style="margin-top:-50px;margin-bottom:0px">Date: {{ date('F j, Y', strtotime( $data['date_from_attendance'])) }} &nbsp;To&nbsp; {{ date('F j, Y', strtotime( $data['date_to_attendance'])) }}   </h4>
                </div>
            </div>
            </div>
        </div>

        <div class="pdfcontent" style="text-align:center;">
            <div class="main" style="padding: 10px 15px 20px 15px;">
                <table class="table table-striped table-hover" cellpadding="4" cellspacing="0"  border="1" width="100%">
                    <thead>
                        <tr>
                            <th style="text-align:left;width:20%;"> Date </th>                             
                            <th style="text-align:left;width:15%;"> In Time</th>
                            <th style="text-align:left;width:15%;">Out Time</th>
                            <th style="text-align:left;width:10%;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                         @foreach($data['attendance_list']  as $row)   
                         <?php 
                                $login =  date( 'H:i', strtotime($row->first_login) );
                                $present = 1;
                                if($login == '00:00')
                                {
                                    $present = 0;
                                }
                                
                                $logout =  date( 'H:i', strtotime($row->last_logout) );
                                
                                if($logout == '00:00')
                                {
                                    $logout = 0;
                                }

                               ?> 
                        <tr>           
                                                 
                            <td style="padding-left: 5px;"> 
                                {{ date('j F , Y', strtotime( $row->attendance_date)) }}
                            </td>

                            <?php 
                                if(date('l', strtotime( $row->attendance_date)) == 'Friday') {
                                             echo '<td colspan="3" style="padding-left:130px;color:green" >Weekend</td>';
                                }  
                            else { ?>

                            <td>
                                {{ $present ? date('H:i a', strtotime($row->first_login)) : '' }}
                            </td> 
                            <td>
                                {{ ($row->first_login == $row->last_logout || !$logout) ? '' : date( 'h:i a', strtotime($row->last_logout) ) }}
                            </td> 
                            <td>
                                <?php echo $present ? 'Present' : '<div style="color:red">Absent</div>'; ?>
                            </td>    
                                        
                            <?php } ?>

                        </tr>
                        @endforeach
                   
                    </tbody>
                </table>
            </div>
            <?php echo getPoweredBy(); ?>
        </div>       
    </body>
</html>