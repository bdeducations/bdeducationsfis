@extends('layouts.admin')

@section('page_css')
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Salary Settings</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Salary Settings</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Salary Setting</h3>
                    <div style="margin:10px; border:1px solid #ccc; padding:10px"><b>Employee:</b>  {{ $data['employee_info']->employee_name }} ( {{ $data['employee_info']->employeeDesignation->designation_name }} )</div>
                    
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Initail Salary</a></li>
                      @if($data['current_basic_salary'])
                      <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Increament & Promotion</a></li>
                      @endif
                      <li><a href="#tab_3" data-toggle="tab" aria-expanded="true">Performance Note</a></li>
                      
                      <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                    </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">


                <b>Set Salary Per Month in Taka</b>
                <form method="post" action="{{ url('/')}}/hr/employee-salary-settings/{{ $data['employee_row_id'] }}">
                    {{ csrf_field() }}

                    <input type="hidden" name="set_salary" value="1">
                    <input type="hidden" name="employee_row_id" id="employee_row_id" value="{{ $data['employee_row_id'] }}">
                      <table class="manage-salary" width="50%">
                        <tr>
                          <td style="width:10%"> Basic Salary </td>
                          <td style="width:25%"> <input class="form-control" type="text" name="basic_salary" id="basic_salary" value="{{ $data['basic_salary'] ? $data['basic_salary'] : '' }}" required="required"> </td>
                        </tr>
                        @foreach( $data['head_wise_payments'] as $head_payAmount)
                        <tr>
                          <td> {{ $head_payAmount->salary_head_name }}</td> 
                          <td><input  type="text" class="form-control salary-parts" name="{{ $head_payAmount->salary_head_slug }}" id="salary-parts-{{$head_payAmount->salary_head_row_id}}" value="{{ isset($data['salary_parts'][$head_payAmount->salary_head_row_id]) && ($data['salary_parts'][$head_payAmount->salary_head_row_id]) ? $data['salary_parts'][$head_payAmount->salary_head_row_id] : ''  }}">
                          </td>
                        </tr>
                        @endforeach

                        <tr>
                          <td>Effective From</td>
                          <td><input type="text" required="required" name="salary_effected_from" class="form-control" id="salary_effected_from" value="{{ $data['salary_effected_from'] ? $data['salary_effected_from'] : '' }}" /></td>
                        </tr>

                        <tr id="total_amount_row">
                          <td>Total</td>
                          <td><div id="total_amount">{{ $data['gross_salary'] ? number_format($data['gross_salary'], 2 ) : ''}} Tk/Month</div></td>
                        </tr>

                        <tr>
                        <td> &nbsp; </td>
                        <td>
                            <div style="margin-top: 10px">
                                <button type="submit" class="btn btn-primary pull-left">Submit</button>
                            </div> 
                        </td> 
                        </tr>
                      </table>
                </form>               
              </div>
              <!-- /.tab-pane -->
              @if($data['current_basic_salary'])
                <div class="tab-pane" id="tab_2">
                  <form method="post" action="{{ url('/')}}/hr/save-increament/{{ $data['employee_row_id'] }}">
                      {{ csrf_field() }}
                       <input type="hidden" name="set_increament" value="1">
                      <table class="manage-salary" width="50%">
                          <tr>
                            <td width="10%"> Department </td> 
                            <td width="25%"> 
                                <select class="form-control" id="departments" name="department_row_id" required="">
                                <option value="">Select</option>
                                @foreach($data['departments'] as $departmentInfo)
                                    <option value="{{ $departmentInfo->department_row_id }}" @if($departmentInfo->department_row_id == $data['employee_info']->employeeDepartment->department_row_id ) selected="selected" @endif>{{ $departmentInfo->department_name }} </option>
                                @endforeach
                                </select>
                            </td>
                          </tr>

                          <tr>
                            <td width="10%"> Change Designation </td> 
                            <td width="25%"> 
                                <select class="form-control designation"  name="designation_row_id" id="designation_row_id" current_designation_row_id ="{{ $data['employee_info']->designation_row_id }}" required="">
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td style="width:10%"> Increase Basic Salary </td>
                            <td style="width:25%"> <input class="form-control" type="text" name="basic_salary" id="increamented_basic_salary" value="" required=""> </td>
                          </tr>


                           @foreach( $data['head_wise_payments'] as $head_payAmount)
                          <tr>
                            <td> {{ $head_payAmount->salary_head_name }}</td> 
                            <td><input  type="text" class="form-control increamented-salary-parts" name="{{ $head_payAmount->salary_head_slug }}" id="increamented-salary-parts-{{$head_payAmount->salary_head_row_id}}">
                            </td>
                          </tr>
                          @endforeach

                          <!--tr id="increamented_total_amount_row">
                            <td>Total</td>
                            <td><div id="increamented_total_amount">{{ $data['gross_salary'] ? number_format($data['gross_salary'], 2 ) : ''}} Tk/Month</div></td>
                          </tr-->

                          <tr>
                            <td>Effective From</td>
                            <td><input type="text" name="increament_effected_from" class="form-control" id="increament_effected_from" required="" /></td>
                          </tr>


                          <tr>
                            <td>&nbsp;</td> 
                            <td>
                            <button style="margin-top:10px" type="submit" class="btn btn-primary pull-left">Submit</button> 
                            </td>
                          </tr>
                      </table>
                  </form>
                 
                 
                 
                  <table id="data_list" class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                   <th class="text-center">Department  Name</th>
                                    <th class="text-center">Desgination Name</th>
                                    <th class="text-center"> Date</th>
                                    <th class="text-center"> Basic Salary</th>
                                    <th class="text-center"> Gross Salary</th>                             
                                  <th class="no-sort text-center">Actions</th>
                              </tr>
                          </thead>
                          <tbody>
                          @php $no_count = count($data['all_salary_records']); $c=0; @endphp
                              @if( $data['all_salary_records'])
                                  @foreach($data['all_salary_records'] as $increament_promotion_record)
                                      <tr>
                                          <td class="text-center">
                                            {{ $increament_promotion_record->employeeDepartment->department_name}}
                                          </td>    
                                          <td class="text-center">
                                            {{ $increament_promotion_record->employeeDesignation->designation_name }}
                                          </td>
                                          <td class="text-center">
                                            {{ $increament_promotion_record->salary_effected_from }}
                                            
                                          </td> 
                                          <td class="text-center">
                                            {{ $increament_promotion_record->basic_salary}}
                                          </td>    
                                          <td class="text-center">
                                            {{ $increament_promotion_record->gross_salary }}
                                          </td>
                                          <td class="text-center">
                                              <div class="btn-group">
                                                @if( $c == 0)  
                                                  <button type="button" class="btn btn-primary btn-flat">Action</button>
                                                  <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">
                                                      <span class="caret"></span>
                                                      <span class="sr-only">Toggle Dropdown</span>
                                                  </button>
                                                  <ul class="dropdown-menu" role="menu">
                                                      <li><a href="{{ url('/') }}/hr/employee-increament-edit/{{ $increament_promotion_record->employee_history_row_id}}">Edit</a></li>
                                                      
                                                  </ul>
                                                @else
                                                Not Editable 
                                                @endif
                                              </div>
                                          </td>
                                      </tr>
                                      @php $c++; @endphp
                                  @endforeach
                              @endif
                          </tbody>
                      </table>
                </div>
              @endif
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">

                @foreach($data['performance_comments'] as $row)
                 <div style="margin:0 0 10px 0; padding:10px; background-color:#ECF0F5;">
                    <div style="font-weight:bold"> <i class="fa fa-comment" aria-hidden="true" style="color:#605CA8"></i> {{  $row->comment_text }}</div>
                    <div style="padding-top: 10px"> Comment By: {{  $row->userInfo->name }} ({{  $row->userInfo->email }}) </div>
                    <div>  Comment Provided: {{ date('Y-m-d', strtotime($row->created_at) ) }} </div>
                 </div>
                @endforeach
                 
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->

<style>
button.accordion {
    background-color: #eee;
    color: #444;
    cursor: pointer;
    padding: 18px;   
    border: none;
    text-align: left;
    outline: none;
    font-size: 15px;
    transition: 0.4s;
}

button.accordion.active, button.accordion:hover {
    background-color: #ddd; 
}

div.panel {
    padding: 0 18px;
  
    background-color: white;
}
</style>
@endsection

@section('page_js')
<!-- page script -->
<script src="{{ url('/')}}/public/adminlte/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">

    $(document).ready(function () {

        $('#salary_effected_from,#increament_effected_from').datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd',
          todayHighlight: true,
        });

        $('#data_list').DataTable({
            paging: true,
            lengthMenu: [[-1, 100, 50, 25], ["All", 100, 50, 25]],
            ordering: false,
            columnDefs: [{
                    targets: 'no-sort',
                    orderable: false
                }]
        });

        // basic salary text box change action.
        $("#basic_salary").change(function(e) {
            var basic_salary = $(this).val();            
            $.ajax({
                url: "{{ url('/hr/get-salary-head-amount/') }}"+ '/'+ basic_salary,
                type: "GET",
                dataType: "text",
                success: function(data) {
                   var parsedData = JSON.parse(data);
                   var total_amount = parseFloat(basic_salary);
                   $.each(parsedData, function(index, item) {
                        total_amount = total_amount + parseFloat(item);
                        $('#salary-parts-' + index).val(item);
                    });
                   total_amount = total_amount.toFixed(2);
                   $('#total_amount_row').show();
                   $('#total_amount').html(total_amount + ' Tk/Month');
                   
                }
            });
        });

        $("#increamented_basic_salary").change(function(e) {
            var basic_salary = $(this).val();            
            $.ajax({
                url: "{{ url('/hr/get-salary-head-amount/') }}"+ '/'+ basic_salary,
                type: "GET",
                dataType: "text",
                success: function(data) {
                   var parsedData = JSON.parse(data);
                   var total_amount = parseFloat(basic_salary);
                   $.each(parsedData, function(index, item) {
                        total_amount = total_amount + parseFloat(item);
                        $('#increamented-salary-parts-' + index).val(item);
                    });
                   total_amount = total_amount.toFixed(2);
                   //$('#increament_total_amount_row').show();
                  // $('#increamented_total_amount').html(total_amount + ' Tk/Month');
                   
                }
            });
        });

        

        // other than basic salary text box change value action
        $(".salary-parts").change(function(e) {
            var basic_salary = parseFloat ($('#basic_salary').val());    
            var  total_amount = 0;
            $('.salary-parts').each(function( index ) {
                
                // if any element is '' then make it to have zero.
                if($(this).val() == '')            
                $(this).val(0);

              total_amount = total_amount + parseFloat( $(this).val() );
            });      
            total_amount = total_amount + basic_salary;
            total_amount = total_amount.toFixed(2);
           $('#total_amount').html(total_amount + ' Tk/Month');
        });

       
        // when starting slary is clicked then load employee current salary.
        $('.starting_salary') .click(function() {
           var employee_row_id =  $(this).attr('employee_row_id');
           $('#employee_row_id') .val(employee_row_id);
           $('#basic_salary').val('');
           $('.salary-parts').val('');
           $('#total_amount_row').show();
           $('#total_amount').html('');

           $.ajax({
                url: "{{ url('/hr/get-employee-starting-salary/') }}"+ '/'+ employee_row_id,
                type: "GET",
                dataType: "text",
                success: function(data) {
                   var parsedData = JSON.parse(data);
                    $.each(parsedData, function(key,value) {
                      if(key== 'basic_salary') {
                        $('#basic_salary').val(value);
                      }
                      else if(key== 'gross_salary') {
                        $('#total_amount').html(value.toFixed(2));
                      } else {
                         $('#salary-parts-' + key).val(value);
                      }
                    }); 
                   
                }
            });

        });

    
    // make designation selected first in promotion-increament section
    var department_row_id = $('#departments').val();    
    var designation_row_id = $('#designation_row_id').attr('current_designation_row_id');
    $.ajax({
      url: "{{ url('getDesignation/') }}"+ '/'+ department_row_id + '/' + designation_row_id,
      type: "GET",
      dataType: "html",
      success: function(data){
      $('.designation').append(data);
      }
    });

    $("#departments").change(function(e){
      var department_row_id = $(this).val();
      var designation_row_id = $('#designation_row_id').attr('current_designation_row_id');      
      $('.designation').empty();
      $.ajax({
        url: "{{ url('getDesignation/') }}"+ '/'+ department_row_id + '/' + designation_row_id,
        type: "GET",
        dataType: "html",
        success: function(data){
          $('.designation').append(data);
        }
      });
    });



    });

  
</script>

<style type="text/css">
    .manage-salary tr{ height:40px; }
    .tabDiv {display: inline-block;}
</style>
@endsection
