<html>
<head>
  <title>Year Calendar Events </title>
</head>

<body style="font-size: 14px;">

<div style="width:100%; border-bottom: 2px solid #000; margin-top: -50px;">
<div class="row">
<div class="col-sm-4"  style="margin-top: 20px; float: left;">
    <img src="{{ $data['school_logo_url'] }}" style="width: 200px">
</div>
<div class="col-sm-8" style="padding-top: 10px;">
    <div style="text-align:center; margin-top: 30px;margin-bottom: 30px">
       <h2 style="margin:0px;">{{strtoupper(session('school_name'))}}</h2>
       <p style="margin:0px;">{{ $data['school_address'] }}</p>
      <h3 style="margin-bottom:0px;"><u> Academic Calendar – 2017  </u></h3>
    </div>
</div>
</div>
</div> 
        <div>
          <table class="responstable" border="0" cellpadding="5" cellspacing="1" style="width:100%; background-color:#fff; border-collapse:collapse; text-align: center;">
            <thead>
              <tr>
                 <th style="text-align:center;width:5%;height:40px;padding-left: 5px;border: 1px solid;">#</th>    
                  <th style="text-align:left;width:40%;height:40px;padding-left: 5px;border: 1px solid;">Date</th>
                  <th style="text-align:left;width:55%;height:40px;padding-left: 5px;border: 1px solid;">
                      Event Title
                  </th>
              </tr>
            </thead>
            <tbody>
              <?php $i=1; ?>
                @foreach($data['event_list'] as $row)
                    <tr>
                        <td style="text-align:center;width:10%;padding-left: 5px;border: 1px solid;height:30px;"><?php echo $i.'.'; ?></td>    
                        <td style="text-align:left;width:30%;padding-left: 5px;border: 1px solid;height:30px;">
                            @if($row->event_end_date)
                                {{  date('j F, Y', strtotime($row->event_start_date) ) }} - {{  date('j F, Y', strtotime($row->event_end_date)) }}
                            @else 
                                {{  date('j F, Y', strtotime($row->event_start_date) ) }}
                            @endif
                        </td>
                        <td style="text-align:left;width:60%;padding-left: 5px;border: 1px solid;height:30px;">{{ $row->event_title }}</td>                             
                        
                    </tr>
                <?php $i++; ?>  
                @endforeach
            </tbody>
          </table>
</div>
<div class="footer-pdf" style="border-top: 1px dashed #000; text-align:right; margin-top:30px; font-style: italic; opacity:0.5">Powered By: bdeducations.org.bd</div>
</body>
</html>