@extends('layouts.admin')
@section('page_css')
<!-- DataTables -->
<style type="text/css">
    #btn btn-default{
        
    }    
</style>

<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Manage Salary</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Salary Settings</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Salary Settings</h3>
                    
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  @php $i=1; @endphp
                  @if( $data['employee_list'])
                    @foreach($data['employee_list'] as $key=>$row)

                    <table id="UT_jakat_allocation_list_{{$i}}" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                              <th class="text-center" colspan="6" style="font-size: 22px">{{ $key }}</th>
                            </tr>
                            <tr>
                              <th class="text-center">Name</th>
                              <th class="text-center">Department</th>
                              <th class="text-center">Designation</th>
                              <th class="text-center">email</th>
                              <th class="text-center">Contact</th>
                              <th class="no-sort text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($row as $info)
                          <tr>
                              <td>
                                  {{ $info->employee_name }}
                              </td>                                  
                              <td>
                                 {{ $info->employeeDepartment->department_name }}
                              </td>

                              <td>
                                 {{ $info->employeeDesignation->designation_name }}
                              </td>
                              <td>
                                 {{ $info->employee_email }}
                              </td>
                              <td>
                                 {{ $info->contact_1 }}
                              </td>
                              <td>
                                 <a href="{{ url('/')}}/hr/employee-salary-settings/{{ $info->employee_row_id }}"> Salary Details </a>
                              </td>
                          </tr>
                          @endforeach
                        </tbody>
                    </table>
                    @php $i++; @endphp
                    @endforeach
                  @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div id="starting_salary_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Manage Salary(Tk/Per Month).</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ url('/')}}/hr/employee-list-payroll">
        {{ csrf_field() }}
        <input type="hidden" name="set_salary" value="1">
        <input type="hidden" name="employee_row_id" id="employee_row_id" value="">
        <table class="manage-salary">
            <tr><td width="50%"> Basic Salary </td> <td width="50%"> <input class="form-control" type="text" name="basic_salary" id="basic_salary"> </td></tr>
            
            @foreach( $data['head_wise_payments'] as $head_payAmount)
            <tr><td width="50%"> {{ $head_payAmount->salary_head_name }}</td> <td width="50%"> <input  type="text" class="form-control salary-parts" name="{{ $head_payAmount->salary_head_slug }}" id="salary-parts-{{$head_payAmount->salary_head_row_id}}" ></td></tr>
            @endforeach

            <tr id="total_amount_row" style="display: none"><td width="50%">Total</td><td width="50%"><div id="total_amount"></div></td></tr>
            
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
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<div id="increament_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Increament</h4>
      </div>
      <div class="modal-body">
        <table border="0" cellpadding="4" cellspacing="4" width="100%">
            <tr> 
                <td style="width: 50%;"> Current Salary <a href="#" style="margin-left: 90px"> View Past Salaries </a></td>
                <td style="width: 50%;padding-left: 30px">Increament Amount </td>
            </tr>
            <tr> 
                <td style="background-color: #367FA9; color: #fff; padding:10px"> 
                    <form method="post" action="">
                        <table class="manage-salary" cellspacing="4" cellpadding="4">
                            <tr><td width="60%"> Basic Salary </td> <td width="40%" style="padding-left: 10px"> 15,000</td></tr>
                            <tr><td width="60%"> House Rent</td> <td width="40%" style="padding-left: 10px"> 10,000</td></tr>
                            <tr><td width="60%"> Transport Allowance </td> <td width="40%" style="padding-left: 10px"> 1, 000 </td></tr>
                            <tr><td width="100%" colspan="2"> <hr  style="margin:0" /> </td></tr>
                            <tr><td width="60%">Total</td> <td width="40%" style="padding-left: 10px"> 26,000 tK. </td></tr>
                        </table>
                    </form>

                </td>
                <td style="padding-left:30px;vertical-align: top">

                    <div>
                        <table class="manage-salary">
                            <tr><td width="50%"> Basic Salary  (+) </td> <td width="50%"> <input type="text" name="basic_salary"> </td></tr>
                            <tr style="margin-top: 10px"><td width="50%"> House Rent  (+)</td> <td width="50%"> <input type="text" name="basic_salary"> </td></tr>
                            <tr style="margin-top:10px"><td width="50%"> Transport Allowance  (+) </td> <td width="50%"> <input type="text" name="basic_salary"> </td></tr>
                        </table>
                    </div>
                    <div style="margin-top: 10px"><button type="submit" class="btn btn-primary pull-left">Submit</button></div>
                 </td>
            </tr>
       </table>
           
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>



<div id="promotion_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Promotion</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="">
        <table class="manage-salary">
            <tr>
                <td width="50%"> Set Designation </td> 
                <td width="50%"> 
                    <select class="form-control">
                    <option value="">Select</option>
                    @foreach($data['designations_list'] as $designation)
                        <option value="{{ $designation->designation_row_id }}">{{ $designation->designation_name }} - {{ $designation->department_info->department_name }}</option>
                    @endforeach
                    </select>
                </td>
            </tr>
            <tr><td width="50%"> New Basic Salary </td> <td width="50%"> <input type="text" name="basic_salary"> </td></tr>
            <tr><td width="50%"> New  House Rent</td> <td width="50%"> <input type="text" name="basic_salary"> </td></tr>
            <tr><td width="50%"> New  Transport allowance </td> <td width="50%"> <input type="text" name="basic_salary"> </td></tr>
            <tr><td width="50%">&nbsp;</td> <td width="50%">  <button style="margin-top:10px" type="submit" class="btn btn-primary pull-left">Submit</button> </td></tr>
        </table>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

@endsection

@section('page_js')
<!-- page script -->
<script type="text/javascript">
    $(document).ready(function () {
      @php $i=1; @endphp
       @if( $data['employee_list'])
          @foreach($data['employee_list'] as $key=>$row)
        $('#UT_jakat_allocation_list_{{ $i }}').DataTable({
            paging: true,
            lengthMenu: [[-1, 100, 50, 25], ["All", 100, 50, 25]],
            ordering: false,
            columnDefs: [{
                    targets: 'no-sort',
                    orderable: false
                }]
        });
        @php $i++; @endphp
        @endforeach
        @endif

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
                   $('#total_amount').html(total_amount);
                   
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
           $('#total_amount').html(total_amount);
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

    });
</script>

<style type="text/css">
    .manage-salary tr{ height:40px; }
</style>
@endsection
