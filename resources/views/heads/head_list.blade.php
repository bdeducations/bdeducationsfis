@extends('layouts.admin')
@section('page_css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
<style type="text/css">
    tr.disabled_head{
        color:#ccc4c4;
    }
</style>
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="left-main-heading-breadcum">Manage Head</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Head List</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Budget Head List</h3>
                    <a href="{{ url('/') }}/heads/createHead">
                        <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                            <i class="fa fa-plus"></i> Add New Head
                        </button>
                    </a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="UT_budget_head_list" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Head Name</th>
                                    <th class="text-center">Sort Order</th>
                                    <th class="no-sort text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($data['all_heads'])
                                <?php $parent_serial = 1; ?>
                                @foreach($data['all_heads'] as $row)
                                <?php
                                if (isset($child_serial) && $child_serial > 26):
                                    $child_serial = 1;
                                endif;
                                if (isset($grand_child_serial) && $grand_child_serial > 26):
                                    $grand_child_serial = 1;
                                endif;
                                ?>
                                <tr <?php
                                if ($row->status == 0): echo "class='disabled_head'";
                                endif
                                ?>>
                                    <td style="text-align:left;padding-left:10px">
                                        @if($row->level == 0)
                                        <strong style="font-size:15px !important;">
                                            <?php
                                            $child_serial = 1;
                                            ?>
                                            <span>{{ $parent_serial }}&nbsp;.&nbsp;</span>
                                            <?php $parent_serial++ ?>
                                            @endif 
                                            @if($row->level == 1)
                                            &nbsp;
                                            @if($row->has_child == 1)
                                            <strong>
                                            @endif
                                            <?php
                                            $grand_child_serial = 1;
                                            echo $data['alphabets'][$child_serial] . ".";
                                            $child_serial++;
                                            ?>
                                            &nbsp;
                                            @endif   
                                            @if($row->level == 2) 
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <?php
                                            echo $data['roman'][$grand_child_serial] . ".";
                                            $grand_child_serial++;
                                            ?>&nbsp;
                                            @endif     
                                            @if($row->level == 3) &nbsp; &nbsp; &nbsp; - - - @endif       
                                            @if($row->level == 4) &nbsp; &nbsp; &nbsp; &nbsp; - - - - @endif       
                                            @if($row->level == 5) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  - - - - - @endif       
                                            @if($row->level > 5)  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - - - @endif
                                            {{ $row->title }}
                                            @if($row->level == 0) </strong>  @endif
                                            @if($row->level == 1)
                                                @if($row->has_child == 1)
                                                </strong>
                                                @endif
                                            @endif
                                    </td>
                                    <td class="text-center">{{ $row->sort_order }}</td>
                                    <td class="text-center">
                                        @if(($row->is_project == 1) && ($row->parent_id != 0))
                                        <a href="{{ url('/') }}/budget/project/head/edit/{{ $row->head_row_id }}">Edit</a>
                                        @else
                                        <a href="{{ url('/') }}/heads/editHead/{{ $row->head_row_id }}">Edit</a>
                                        @endif
                                        <?php if ($row->has_child == 0): ?>
                                            <?php if ($row->status == 1): ?>
                                                <a onclick="return confirm('Are you sure to Inactive the budget head: <?php echo $row->title; ?>')" href="{{ url('/') }}/heads/deleteHead/{{ $row->head_row_id }}"> | Inactive</a>
                                            <?php else: ?>
                                                <a onclick="return confirm('Are you sure to Active the budget head: <?php echo $row->title; ?>')" href="{{ url('/') }}/heads/deleteHead/{{ $row->head_row_id }}"> | Active</a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                                @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Head Name</th>
                                    <th class="text-center">Sort Order</th>
                                    <th class="no-sort text-center">Actions</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@section('page_js')
<!-- page script -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#UT_budget_head_list').DataTable({
            paging: true,
            lengthMenu: [[-1, 100, 50, 25], ["All", 100, 50, 25]],
            ordering: false,
            order: [[1, 'asc']],
            columnDefs: [{
                    targets: 'no-sort',
                    orderable: false
                }]
        });
    });
</script>
@endsection

@endsection
