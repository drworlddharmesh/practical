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
        <h2>Product</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ url('shop/shop') }}">Shop</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Product</strong>
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
                    <h5>Product List</h5>

                    <div class="ibox-tools">
                        <a href="{{ url('product/add-product').'/'.$id }}" class="btn btn-sm btn-primary m-t-n-xs">
                            Add New Product
                        </a>
                        <a href="{{ url('product/bulk-product').'/'.$id }}" class="btn btn-sm btn-primary m-t-n-xs">
                            Bulk Import
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
                        <table id="CategoryDatatable" class="table table-striped table-bordered table-hover dataTables-example" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Id</th>
                                    <th>shop_id</th>
                                    <th>Product Name</th>
                                    <th>Product Video</th>
                                    <th>price</th>
                                    <th>stock</th>
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
        var Id = {{$id}};
        var oTable = $('#CategoryDatatable').DataTable({
            proccessing: true,
            serverSide: true,
            ajax: '{!! url('product/productDataTable').'/' !!}'+Id,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false
                },
                {
                    data: 'id',
                    name: 'id',
                    searchable: false
                },
                {
                    data: 'shop_id',
                    name: 'shop_id',
                    searchable: false
                },
                {
                    data: 'product_name',
                    name: 'product_name',
                    searchable: false
                },
                {
                    data: 'video',
                    name: 'video',
                    "render": function(data, type, full, meta) {
                        return "<a href=\"" + data + "\" target='__blank'><video src=\"" + data + "\" width=\"100px\" height=\"100px\"></a>";
                    },
                    searchable: false
                },
                {
                    data: 'price',
                    name: 'price',
                },
                {
                    data: 'stock',
                    name: 'stock',
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    searchable: false
                },
                {
                    data: 'updated_at',
                    name: 'updated_at',
                    searchable: false
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
                'aTargets': [9]
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

    function DeleteProduct(id,ProductId) {
        swal({
            title: "Delete Product",
            text: "Are you sure you want to delete this Product?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function() {
            $.ajax({
                url: '{!! url("product/delete-product") !!}',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    ProductId: ProductId,
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