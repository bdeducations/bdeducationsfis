[@extends('backend.school_admin.layout_app')
@section('content')


<script src="{{ asset('/public')}}/scripts/moment.min.js"></script>
<script src="{{ asset('/public')}}/scripts/fullcalendar.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>

<div class="content">
    <div class="row">
    <div class="col-md-12">
        <div class="portlet light portlet-fit bordered">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <a style="float: right;margin:5px;" href='{!! url('/schoolAdmin/administrative/viewcalender'); !!}' class="btn btn-primary btn-xs" role="button">View As List</a>
                        {!! $calendar->calendar() !!}
                        {!! $calendar->script() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>


@endsection



