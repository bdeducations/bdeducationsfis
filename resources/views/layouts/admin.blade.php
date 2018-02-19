<?php
$route_name_arr = explode('.', Route::currentRouteName() ? Route::currentRouteName() : '');
$route_name = $route_name_arr[0];
?>
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}"><head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="{{ url('/')}}/public/adminlte/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- jvectormap -->
        <link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ url('/')}}/public/adminlte/dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{ url('/')}}/public/adminlte/dist/css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="{{ url('/')}}/public/css/style-custom.css">
        <!-- date_picker sdt-->
        <link rel="stylesheet" href="{{ url('/')}}/public/css/bootstrap-datepicker.min.css">
        <link rel="stylesheet" href="{{ url('/')}}/public/css/Montserrat.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        @yield('page_css')
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'bdeducations FIS') }}</title>
        <!-- Scripts -->
        <script type="text/javascript">
            window.Laravel = {!! json_encode([
                    'csrfToken' => csrf_token(),
            ]) !!}
            ;
        </script>
    </head><body class="hold-transition sidebar-mini skin-purple-light">
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="{{ url('/') }}/home" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>bdeducations </b>FIS</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>bdeducations </b>FIS</span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                   <!-- <img src="{{ url('/')}}/public/adminlte/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                                    -->
                                    <span class="hidden-xs">{{ Auth::user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <!--
                                        <img src="{{ url('/')}}/public/adminlte/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                        -->
                                        <p>
                                            {{ Auth::user()->name }}
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Sign out</a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!-- Control Sidebar Toggle Button -->
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="header">MAIN NAVIGATION</li>
                        <li class="{{ active_class((current_controller() == 'App\Http\Controllers\HomeController')? true:false) }}">
                            <a href="{{ url('/') }}/home">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="{{ active_class((current_controller() == 'App\Http\Controllers\AreasController')? true:false) }}">
                            <a href="{{ url('/') }}/areas">
                                <i class="fa fa-circle"></i> <span>Name Of Area</span>
                            </a>
                        </li>
                        <li class="{{ active_class((current_controller() == 'App\Http\Controllers\HeadsController')? true:false) }}">
                            <a href="{{ url('/') }}/budgetHeads">
                                <i class="fa fa-book"></i> <span>Name Of Head</span>
                            </a>
                        </li>
                        <!--li class="{{ active_class((current_controller() == 'App\Http\Controllers\ProjectHeadsController')? true:false) }}">
                            <a href="{{ url('/') }}/budget/project/head">
                                <i class="fa fa-hdd-o"></i> <span>Name Of Project Head</span>
                            </a>
                        </li-->
                        <li class="{{ active_class((current_controller() == 'App\Http\Controllers\AllocationController')? true:false) }}">
                            <a href="{{ url('/') }}/budgetAllocation">
                                <i class="fa fa-file"></i> <span>Budget Allocation</span>
                            </a>
                        </li>
                        <!--li class="{{ active_class((current_controller() == 'App\Http\Controllers\BudgetAdjustmentController')? true:false) }}">
                            <a href="{{ url('/') }}/budget/adjustment">
                                <i class="fa fa-adjust"></i> <span>Budget Adjustment</span>
                            </a>
                        </li-->
                        <li class="{{ active_class((current_controller() == 'App\Http\Controllers\ExpenseController')? true:false) }}">
                            <a href="{{ url('/') }}/budgetExpense">
                                <i class="fa fa-file-text"></i> <span>Budget Expenditure</span>
                            </a>
                        </li>
                        <li class="treeview {{ active_class((current_controller() == 'App\Http\Controllers\BudgetReportController' || current_controller() == 'App\Http\Controllers\BalanceReportController' || current_controller() == 'App\Http\Controllers\AdjustmentReportController' || current_controller() == 'App\Http\Controllers\AllocationReportController' || current_controller() == 'App\Http\Controllers\AllocationAdjustmentReportController' || current_controller() == 'App\Http\Controllers\AllocationSummaryReportController' || current_controller() == 'App\Http\Controllers\BalanceSummaryReportController')? true:false) }}">
                            <a href="#">
                                <i class="fa fa-th"></i>
                                <span>Reports</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="{{ active_class((current_controller() == 'App\Http\Controllers\AllocationReportController')? true:false) }}">
                                    <a href="{{ url('/') }}/budget/allocation/report">
                                        <i class="fa fa-circle-o"></i> Budget Allocation
                                    </a>
                                </li>
                                <!--li class="{{ active_class((current_controller() == 'App\Http\Controllers\AllocationSummaryReportController')? true:false) }}">
                                    <a href="{{ url('/') }}/budget/allocation/summary/report">
                                        <i class="fa fa-circle-o"></i> Budget Allocation Summary
                                    </a>
                                </li-->
                                <!--li class="{{ active_class((current_controller() == 'App\Http\Controllers\AllocationAdjustmentReportController')? true:false) }}">
                                    <a href="{{ url('/') }}/budget/allocation/adjustment/report">
                                        <i class="fa fa-circle-o"></i> Allocation With Adjustment
                                    </a>
                                </li>
                                <li class="{{ active_class((current_controller() == 'App\Http\Controllers\AdjustmentReportController')? true:false) }}">
                                    <a href="{{ url('/') }}/budget/adjustment/report">
                                        <i class="fa fa-circle-o"></i> Adjustment
                                    </a>
                                </li-->
                                <li class="{{ active_class((current_controller() == 'App\Http\Controllers\BudgetReportController')? true:false) }}">
                                    <a href="{{ url('/') }}/budgetReport/expenseExtended">
                                        <i class="fa fa-circle-o"></i>  Area and Date Wise Expense
                                    </a>
                                </li>
                                <!--
                                <li class="{{ active_class((current_controller() == 'App\Http\Controllers\BalanceReportController')? true:false) }}">
                                    <a href="{{ url('/') }}/budgetReport/balance">
                                        <i class="fa fa-circle-o"></i> Expenditure State
                                    </a>
                                </li>
                                <li class="{{ active_class((current_controller() == 'App\Http\Controllers\BalanceSummaryReportController')? true:false) }}">
                                    <a href="{{ url('/') }}/budgetReport/balance/summary">
                                        <i class="fa fa-circle-o"></i> Expenditure Summary State
                                    </a>
                                </li>
                                -->
                            </ul>
                        </li>
                        <!-- Manage Employee -->
                        <li class="treeview {{ active_class( (current_controller() == 'App\Http\Controllers\ManageEmployeeController' || current_controller() == 'App\Http\Controllers\ManageAttendanceController') ? true:false) }}">
                            <a href="{{ url('/') }}/manage-employee/create">
                                <i class="fa fa-users"></i> <span>Hr & Payroll</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="@if($route_name == 'hr-department') active @endif">
                                    <a href="{{ url('/') }}/hr/manage-departments">
                                        <i class="fa fa-book"></i> Manage Departments
                                    </a>
                                </li>
                                <li class="@if($route_name == 'hr-designation') active @endif">
                                    <a href="{{ url('/') }}/hr/manage-designations">
                                        <i class="fa fa-user-secret"></i> Manage Designations
                                    </a>
                                </li>
                                <li class="@if($route_name == 'hr-manage-employee') active @endif">
                                    <a href="{{ url('/') }}/manage-employee">
                                        <i class="fa fa-users"></i> Manage Employee
                                    </a>
                                </li>
                                <li class="@if($route_name == 'hr-salary-head') active @endif">
                                    <a href="{{ url('/') }}/hr/salary-heads">
                                        <i class="fa fa-money"></i> Salary Heads  
                                    </a>
                                </li>
                                <li class="@if($route_name == 'hr-salary-head-pay-setting') active @endif">
                                    <a href="{{ url('/') }}/hr/salary-heads-pay-setting">
                                        <i class="fa fa-circle-o"></i> Salary Head & Payments
                                    </a>
                                </li>
                                <li class="@if($route_name == 'hr-calender') active @endif">
                                    <a href="{{ url('/') }}/hr/calender">
                                        <i class="fa fa-calendar"></i>Manage Year calendar
                                    </a>
                                </li> 

                                <li class="@if($route_name == 'manual-attendance-select-date') active @endif">
                                    <a href="{{ url('/') }}/hr/attendance/manual-attendance">
                                        <i class="fa fa-circle-o"></i> Manual Attendance
                                    </a>
                                </li>  

                                <li class="@if($route_name == 'attendance-from-device') active @endif">
                                    <a href="{{ url('/') }}/hr/attendance/attendance-from-device">
                                        <i class="fa fa-circle-o"></i> Attendance From Device
                                    </a>
                                </li>
                              
                                <li class="@if($route_name == 'all-staff-attendance-report-option') active @endif">
                                    <a href="{{ url('/') }}/hr/attendance/all-staff-attendance-report-option">
                                        <i class="fa fa-circle-o"></i> Daily Attendance (All)
                                    </a>
                                </li>    
                                <li class="@if($route_name == 'all-staff-attendance-monthly-report-option') active @endif">
                                    <a href="{{ url('/') }}/hr/attendance/all-staff-attendance-monthly-report-option">
                                        <i class="fa fa-circle-o"></i> Monthly Attendance (All)
                                    </a>
                                </li>     
                                <li class="@if($route_name == 'individual-staff-attendance-report-option') active @endif">
                                    <a href="{{ url('/') }}/hr/attendance/individual-staff-attendance-report-option">
                                        <i class="fa fa-circle-o"></i> Individual Attendance
                                    </a>
                                </li>                      
                                <li class="@if($route_name == 'hr-manage-leave') active @endif">
                                    <a href="{{ url('/') }}/hr/employee-leave">
                                        <i class="fa fa-medkit" aria-hidden="true"></i> Leave Management
                                    </a>
                                </li>
                                <li class="@if($route_name == 'hr-employee-payroll') active @endif ">
                                    <a href="{{ url('/') }}//hr/employee-list-payroll">
                                        <i class="fa fa-circle-o"></i> Payroll
                                    </a>
                                </li>
                                <li class="@if($route_name == 'hr-manage-employee-performance') active @endif">
                                    <a href="{{ url('/') }}/hr/employee-performance">
                                        <i class="fa fa-bar-chart" aria-hidden="true"></i> Employee Performance
                                    </a>
                                </li>
                                <li class="@if($route_name == 'hr-manage-offday') active @endif">
                                    <a href="{{ url('/') }}/hr/institution-offday">
                                        <i class="fa fa-calendar" aria-hidden="true"></i> Manage Weekend
                                    </a>
                                </li>
                                <li class="@if($route_name == 'hr-sendSMS') active @endif">
                                    <a href="{{ url('/') }}/hr/sendSMS">
                                        <i class="fa fa-envelope-o" aria-hidden="true"></i> Send SMS
                                    </a>
                                </li> 
                            </ul>
                        </li>
                        <!-- Manage User -->
                        <!--li>
                            <a href="#">
                                <i class="fa fa-user"></i> <span>Manage User</span>
                            </a>
                        </li-->
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @if(Session::has('success-message'))
                <div class="alert alert-success alert-dismissible" role="alert" style="margin-top: 15px;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Success! </strong>{{ Session::get('success-message') }}
                </div>
                @endif

                @if(Session::has('error-message'))
                <div class="alert alert-danger alert-dismissable" role="alert" style="margin-top: 15px;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Error! </strong>{{ Session::get('error-message') }}
                </div>
                @endif
                @yield('content')
            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                <strong>
                    Copyright &copy; <?php echo date('Y'); ?> <a href="http://bdeducations.org.bd/">bdeducations</a>.
                </strong> All rights reserved.  
            </footer>
            <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->
        <!-- Scripts -->
        <!-- jQuery 2.2.3 -->
        <script src="{{ url('/')}}/public/adminlte/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="{{ url('/')}}/public/adminlte/bootstrap/js/bootstrap.min.js"></script>
        <!-- Data Table -->
        <script src="{{ url('/')}}/public/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.min.js"></script>
        <!-- FastClick -->
        <script src="{{ url('/')}}/public/adminlte/plugins/fastclick/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="{{ url('/')}}/public/adminlte/dist/js/app.min.js"></script>
        <!-- Sparkline -->
        <script src="{{ url('/')}}/public/adminlte/plugins/sparkline/jquery.sparkline.min.js"></script>
        <!-- jvectormap -->
        <script src="{{ url('/')}}/public/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="{{ url('/')}}/public/adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        <!-- SlimScroll 1.3.0 -->
        <script src="{{ url('/')}}/public/adminlte/plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{ url('/')}}/public/adminlte/dist/js/demo.js"></script>@yield('page_js')
        <script type="text/javascript">
            $(document).ready(function () {
                // show the alert
                setTimeout(function () {
                    $(".alert").alert('close');
                }, 2000);
            });
        </script>
    </body></html>