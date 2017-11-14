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
        <div style="width:100%;margin-top: -50px;">
            <div class="row">
            <div class="col-sm-6"  style="margin-top: 20px; float: left;">
                <img src="{{ $data['school_logo_url'] }}" style="width: 200px">
            </div>
            <div class="col-sm-6">
                <div style="text-align:center; margin-top: 50px;">
                    <h2 style="margin:0px;">{{strtoupper(session('school_name'))}}</h2>
                    <p style="margin:0px;">{{ $data['school_address'] }}</p>
                    <h3 style="margin-bottom:0px;margin-top: 30px;"><u>Staff Attendance Report</u></h3>
                    <h4 style="margin-top:-50px;margin-bottom:0px">Date :  {{ date('F j, Y', strtotime($data['attendance_date'])) }}</h4>
                    
                </div>
            </div>
            </div>
        </div>

        <div class="pdfcontent" style="text-align:center;">
           
            <div class="main" style="padding: 10px 15px 20px 15px;">
                 <table class="table table-striped table-hover" cellpadding="4" cellspacing="0"  border="1" width="100%">
                  <thead>
                        <tr>
                            <th style="text-align: left;">Serialssss</th>
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
                            <td>{{ $row->admin_name}}</td>
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