[@extends('backend.school_admin.layout_app')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-red-sunglo">
                    <i class="icon-settings font-red-sunglo"></i>
                    <span class="caption-subject bold uppercase">Year Calendar</span>
                </div>
            </div>
        <a style="float: right;margin:5px;" href='{!! url('/schoolAdmin/administrative/viewcalender/viewAsCalendar'); !!}' class="btn btn-primary btn-xs" role="button">View As Calendar</a>
        <a style="float: right;margin:5px;" class="btn green btn-xs" role="button" href="{{ url('/') }}/schoolAdmin/administrative/calender/pdf/download">Download PDF</a>

        <div class="calendar_area" >
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="event_list" style="border: 1px solid;">
                    <thead>
                <tr>
                    <th style="text-align:center;height: 45px; width: 10%;padding-left: 10px; border: 1px solid #d8d7d0;">SL</th>  
                    <th style="text-align:left;height: 45px; width: 30%;padding-left: 10px; border: 1px solid #d8d7d0;">Date</th>
                    <th style="text-align:left;height: 45px; width: 60%;padding-left: 10px; border: 1px solid #d8d7d0;">
                        Event
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1;?>
                @foreach($event_list as $row)
                    <tr>
                        <td style="text-align:center;height: 40px; width: 10%;padding-left: 10px;border: 1px solid #d8d7d0;">  <?php echo $i; $i++; ?></td>
                        <td style="text-align:left;height: 40px; width: 30%;padding-left: 10px;border: 1px solid #d8d7d0;">
                            @if($row->event_end_date && $row->event_end_date != $row->event_start_date)
                                {{  date('j F, Y', strtotime($row->event_start_date) ) }} - {{  date('j F, Y', strtotime($row->event_end_date)) }}
                            @elseif($row->event_end_date == $row->event_start_date)
                                 {{  date('j F, Y', strtotime($row->event_start_date) ) }}
                            @else 
                                {{  date('j F, Y', strtotime($row->event_start_date) ) }}
                            @endif
                        </td>
                        <td style="text-align:left;height: 40px; width: 60%;padding-left: 10px;border: 1px solid #d8d7d0;">{{ $row->event_title }}
                        </td>                         
                    </tr>
               
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
  </div>
</div>

@endsection

