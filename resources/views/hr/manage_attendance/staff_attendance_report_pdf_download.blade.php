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
    <body style="font-size: 14px;">
        <div style="width:100%;">
            <div class="row">
                <table>
                    <tr> 
                       <td style="vertical-align: top">
                            <img src="{{ asset('/public/img/bdeducation_logo.png') }}" style="width: 200px">
                        </td>
                        <td style="vertical-align: top;">
                            <h2>bdeducations</h2>
                            <p>House-7, Road-4, Gulshan -1, Dhaka.</p>
                            <h3><u>Attendance Report</u></h3>
                            <h4>Date :  {{ date('F j, Y', strtotime($data['attendance_date'])) }}</h4>
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
                            <th style="text-align: left;">Serial</th>
                            <th style="text-align: left;">Name</th>
                            <th style="text-align: left;">In Time</th>
                            <th style="text-align: left;">Out Time</th>
                            <th style="text-align: left;"> Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1 @endphp
                        @foreach($data['staff_attendance_info']  as $row)
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
                            <td>{{ $i }}</td>
                            <td>{{ $row->employee_name}}</td>
                           <td>{{ $present ? date('H:i a', strtotime($row->first_login)) : '' }}</td> 
                            <td>
                                {{ ($row->first_login == $row->last_logout || !$logout) ? '' : date( 'h:i a', strtotime($row->last_logout) ) }}
                            </td> 
                            <td>
                                {!! $present ? 'Present' : '<div style="color:red">Absent</div>' !!}
                            </td>
                        </tr>
                         @php $i++; @endphp
                    @endforeach
                   
                    </tbody>
                </table>
            </div>
             <?php echo getPoweredBy(); ?>
        </div>       
    </body>
</html>