<?php

?>
@extends('template.master')

@section('header-css')
<link href="{{ url('inspinia/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
<link href="{{ url('inspinia/css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
@endsection

@section('main-content')

<!-- Breadcromb Row Start -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>Shop</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Shop</strong>
            </li>
        </ol>
    </div>
</div>
<!-- End Breadcromb Row -->

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Shop List</h5>

                    <div class="ibox-tools">
                        <a href="{{ url('shop/add-shop') }}" class="btn btn-sm btn-primary m-t-n-xs">
                            Add New Shop
                        </a>
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <div class="sk-spinner sk-spinner-double-bounce">
                        <div class="sk-double-bounce1"></div>
                        <div class="sk-double-bounce2"></div>
                    </div>

                    <div class="table-responsive">
                        <table id="ShopDatatable" class="table table-striped table-bordered table-hover dataTables-example" style="width: 100%;">
                            <thead>
                                <tr>

                                    <th>#</th>
                                    <th>Shop Id</th>
                                    <th>Shop Name</th>
                                    <th>Shop Address</th>
                                    <th>Shop Email</th>
                                    <th>Shop Img</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script src="{{ url('inspinia/js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ url('inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ url('inspinia/js/plugins/sweetalert/sweetalert.min.js') }}"></script>



<script>
    $(document).ready(function() {
        // Show Data Table Datas
        var oTable = $('#ShopDatatable').DataTable({
            proccessing: true,
            serverSide: true,
            ajax: '{!! route('ShopDataTable') !!}',
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },
                {
                    data: 'id',
                    name: 'id',
                },
                {
                    data: 'shop_name',
                    name: 'shop_name',
                },
                {
                    data: 'address',
                    name: 'address',
                },
                {
                    data: 'email',
                    name: 'email',
                },
                {
                    data: 'image',
                    name: 'image',
                    "render": function(data, type, full, meta) {
                        return "<img src=\"" + data + "\" width=\"50px\" height=\"50px\">";
                    },
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                },
                {
                    data: 'updated_at',
                    name: 'updated_at',
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false
                },
            ],
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [],
            "aaSorting": [],
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [8]
            }],
        });



        @if(Session::has('SuccessMessage'))
        setTimeout(function() {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: 'slideDown',
                timeOut: 3000
            };

            toastr.success('{!! Session::get("SuccessMessage") !!}', '');
        }, 1000);
        @endif

        @if(Session::has('ErrorMessage'))
        setTimeout(function() {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: 'slideDown',
                timeOut: 3000
            };

            toastr.error('{!! Session::get("ErrorMessage") !!}', '');
        }, 1000);
        @endif
    });

    function DeleteShop(id) {
        swal({
            title: "Delete Shop",
            text: "Are you sure you want to delete this Shop?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function() {
            $.ajax({
                url: 'delete-shop',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id,
                },
                success: function(data) {
                    location.reload();
                }
            });

            swal.close();
        });
    }
</script>
@endsection