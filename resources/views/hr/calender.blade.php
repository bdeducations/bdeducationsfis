@extends('layouts.admin')
@section('page_css')
<style type="text/css">
    content{
        text-align :left;
    }
</style>
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Year Calender Management</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Year Calender</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Year Calender</h3>
                    <a href="javascript:void(0)">
                        <button type="button" class="btn btn-primary pull-right" id="add_event_link" style="margin-right: 5px;">
                            <i class="fa fa-plus"></i> Add New Event
                        </button>
                    </a>
                </div>
                <div class="row" id="addEvent" style="display:none">
                    <div class="col-md-10 col-md-offset-1">
                        <form role="form" method="POST" class="form-horizontal" action="{{ url('/') }}/hr/manageCalender/storeEventDetails" style="margin-left: 50px;">
                            {!! csrf_field() !!}
                            <input type="hidden" name="event_row_id" id="event_row_id">
                            <div class="col-md-3">
                                <label>Event Title<span class="input-required-asterik">*</span></label>
                                <input type="text" required class="form-control" name="event_title" id="event_title">
                            </div>
                            <div class="col-md-3">
                                <label style="margin-left: 10px;">Date From<span class="input-required-asterik">*</span></label>
                                <input type="text" class="form-control pull-right" required name="start_date" id="datepicker1" placeholder="Date From">
                            </div>
                            <div class="col-md-3">
                                <label style="margin-left: 10px;">Date To</label>
                                <input type="text" class="form-control pull-right" name="end_date" id="datepicker2" placeholder="Date To">
                            </div>
                            <div class="col-md-3">
                                <input type="submit" class="btn btn-primary" value="Submit" style="margin:25px 0px;">
                                <input type="button" id="cancel" class="btn btn-danger" value="Cancel" style="margin-left: 5px;">
                            </div>  
                        </form>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="UT_jakat_allocation_list" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th>Date</th>
                                <th>Event Title</th>
                                <th class="no-sort text-center" style="min-width: 70px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; ?>
                            @foreach($event_list as $row)
                                <tr>
                                    <td><?php echo $i.'.'; ?></td>
                                    <td>
                                        @if($row->event_end_date && $row->event_end_date != $row->event_start_date)
                                            {{  date('j F, Y', strtotime($row->event_start_date) ) }} - {{  date('j F, Y', strtotime($row->event_end_date)) }}
                                        @elseif($row->event_end_date == $row->event_start_date)
                                             {{  date('j F, Y', strtotime($row->event_start_date) ) }}
                                        @else 
                                            {{  date('j F, Y', strtotime($row->event_start_date) ) }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $row->event_title }}
                                    </td>                
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-flat">Action</button>
                                            <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="javascript:void(0)" class="edit" event_row_id="{{ $row->event_row_id }}" event_title = "{{ $row->event_title }}" event_start_date="{{ $row->event_start_date }}"  @if(isset($row->event_end_date) && $row->event_end_date)
                                                event_end_date="{{ $row->event_end_date }}"
                                                @endif >Edit</a></li> 
                                                <li><a title="Click For Delete This designation" onclick="return confirm('Are you sure to delete the event:')" href="{{ url('/') }}/hr/calender/deleteEvent/{{ $row->event_row_id }}">Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php $i++; ?>  
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('page_js')
<!-- page script -->
<!-- bootstrap datepicker -->
<script src="{{ url('/')}}/public/adminlte/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#UT_jakat_allocation_list').DataTable({
            paging: true,
            lengthMenu: [[-1, 100, 50, 25], ["All", 100, 50, 25]],
            ordering: false,
            columnDefs: [{
                    targets: 'no-sort',
                    orderable: false
                }]
        });
    });
    $('#add_event_link') .click( function() {  
        $('#addEvent').toggle();
        $('#event_row_id').val('');
        $('#event_title').val('');
        $('#datepicker1').val('');
        $('#datepicker2').val('');
    });

    $('#cancel'). click(function(){
        $('#addEvent').toggle();
        $('#event_row_id').val('');
        $('#event_title').val('');
        $('#datepicker1').val('');
        $('#datepicker2').val('');
    });

    $("#area_row_id").change(function(e){
        $('#employee_row_id').empty('');
        $('#department_row_id').val(''); 
    });

    $('.edit') .click( function() {
        var event_row_id = $(this).attr('event_row_id');
        var event_title = $(this).attr('event_title');
        var event_start_date =  $(this).attr('event_start_date');
        var event_end_date = $(this).attr('event_end_date');
        $('#event_row_id').val(event_row_id);
        $('#event_title').val(event_title);
        $('#datepicker1').val(event_start_date);
        $('#datepicker2').val(event_end_date);
        $('#addEvent').show();
        $('html, body').animate({scrollTop: '0px'}, 0);

        });

</script>
<script type="text/javascript">
     $(function () {
    
    //Date picker
    $('#datepicker1').datepicker({
      autoclose: true
    })  
  })    
</script>

<script type="text/javascript">
     $(function () {
    
    //Date picker
    $('#datepicker2').datepicker({
      autoclose: true
    })  
  })    
</script>
@endsection