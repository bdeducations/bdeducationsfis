@extends('layouts.admin')
@section('page_css')
<style type="text/css">
    content{
        text-align :left;
    }
</style>
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/iCheck/minimal/_all.css">
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Weekend Management</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Weekend Management</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Weekend List</h3>
                    <a href="javascript:void(0)">
                        <button type="button" class="btn btn-primary pull-right" id="add_new_leave_record" >
                            <i class="fa fa-plus"></i> Set Weekend 
                        </button>
                    </a>
                </div>
                <!-- form start -->
                <div id="off_day_form" style="display: none">
                    <form role="form" method="POST" class="form-horizontal" action="{{ url('/') }}/hr/institution-offday/create" >
                        {!! csrf_field() !!}
                        <input type="hidden" name="off_day_row_id" id="off_day_row_id">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="budget_year" class="col-md-3 control-label">Weekend</label>
                                        <div class="col-md-7">
                                            <div class="icheckbox_flat-green checked" aria-checked="false" aria-disabled="false" style="position: relative;">
                                                <input type="checkbox" class="flat-red" checked="" style="position: absolute; opacity: 0;">
                                                <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;">
                                                    
                                                </ins>
                                            </div>

                                            <input type="checkbox" name="institutions_offday[]" value="Saturday">Saturday
                                            <input type="checkbox" name="institutions_offday[]" value="Sunday">Sunday
                                            <input type="checkbox" name="institutions_offday[]" value="Monday">Monday
                                            <input type="checkbox" name="institutions_offday[]" value="Tuesday">Tuesday
                                            <input type="checkbox" name="institutions_offday[]" value="Wednesday">Wednesday
                                            <input type="checkbox" name="institutions_offday[]" value="Thursday">Thursday
                                            <input type="checkbox" name="institutions_offday[]" value="Friday">Friday

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 20px;">
                                <div class="col-md-11">
                                    <input type="submit" class="btn btn-primary pull-right" value="Submit" style="margin-left: 5px">
                                    <input type="button" id="cancel" class="btn btn-danger pull-right" value="Cancel" >
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @if( $data['offday_list'])
                <div style="padding: 5px;">
                    <table id="UT_jakat_allocation_list" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th>Area</th>
                                <th>Institution</th>
                                <th>Weekend</th>
                                <th class="no-sort text-center" style="min-width: 70px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; ?>
                            @foreach($data['offday_list'] as $row)
                                <tr>
                                    <td><?php echo $i.'.'; ?></td>
                                    <td>{{ $row->areaName->title}}</td>
                                    <td>
                                        {{ $row->institutionName->institution_name }}
                                    </td>
                                    <td>
                                        @if(isset($row->declared_day_name)) {{ $row->declared_day_name }} @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-flat">Action</button>
                                            <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="javascript:void(0)" class="edit" off_day_row_id ="{{ $row->off_day_row_id }}"
                                                area_row_id = "{{ $row->area_row_id }}" department_row_id = "{{ $row->department_row_id }}" institution_row_id = "{{ $row->institution_row_id }}" institutions_offday = "{{ $row->declared_day_name }}"  >Edit</a></li>
                                                <li><a onclick="return confirm('Are you sure to delete this record')" href="{{ url('/') }}/hr/institution-offday/delete/{{ $row->off_day_row_id }}">Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php $i++; ?>  
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
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

    $('#add_new_leave_record') .click( function() {  
        $('#off_day_form').toggle();
        $('#leave_record_row_id').val('');
        $('#area_row_id').val('');
        $('#department_row_id').val('');
        $('#institution_row_id').val('');
        $('#comment').val('');
        //$('#is_authorized').val('');
        $('#institutions_offday').val('');
    });

    $('#cancel'). click(function(){
        $('#off_day_form').toggle();
    });

    $("#area_row_id").change(function(e){
        $('#employee_row_id').empty('');
        $('#department_row_id').val(''); 
    });

    $("#department_row_id").change(function(e){
        var department_row_id = $(this).val();
        var area_row_id = $('#area_row_id').val();
        $('#institution_row_id').empty();
        $.ajax({
            url: "{{ url('getInstitutions/') }}"+ '/'+ area_row_id + '/'+ department_row_id,
            type: "GET",
            dataType: "html",
            success: function(data){
                $('#institution_row_id').append(data);
            }
        });
    });

    $("#institution_row_id").change(function(e){
            var institution_row_id = $(this).val();
            $('#employee_row_id').empty('');
            $.ajax({
                url: "{{ url('getEmployeeList/') }}"+ '/'+ institution_row_id,
                type: "GET",
                dataType: "html",
                success: function(data){
                    $('#employee_row_id').append(data);
                }
            });
        });

    $("#employee_row_id").change(function(e){
        var employee_row_id = $(this).val();
        $('#days_left').empty('');
        $.ajax({
                url: "{{ url('getNumberOfLeaveLeft/') }}"+ '/'+ employee_row_id,
                type: "GET",
                dataType: "html",
                success: function(data){
                    $('#days_left').val(data);
                }
            });

    }); 

    $('.edit') .click( function() {
         var off_day_row_id = $(this).attr('off_day_row_id');
         var area_row_id = $(this).attr('area_row_id');
         var department_row_id =  $(this).attr('department_row_id');
         var institution_row_id = $(this).attr('institution_row_id');
         var institutions_offday = $(this).attr('institutions_offday');
         $('#off_day_row_id').val(off_day_row_id);
         $('#area_row_id').val(area_row_id);
         $('#department_row_id').val(department_row_id);
         $('#institution_row_id').val(institution_row_id);
         $('#institutions_offday').val(institutions_offday);
         $('#off_day_form').show();
         $('html, body').animate({scrollTop: '0px'}, 0);
            $.ajax({
                url: "{{ url('getInstitutions/') }}"+ '/' + area_row_id + '/' + department_row_id + '/' + institution_row_id,
                type: "GET",
                dataType: "html",
                success: function(data){
                $('#institution_row_id').append(data);
                }
                });
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
