@extends('template.master')

@section('header-css')
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
            <li class="breadcrumb-item">
                <a href="{{ url('shop/shop') }}">Shop</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Edit Shop</strong>
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
                    <h5>Edit Shop</h5>

                    <div class="ibox-tools">
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

                    <form role="form" id="editForm" method="post" enctype="multipart/form-data" action="{{ url('shop/update-shop') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" id="id" value="{{$ShopData->id}}">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Shop Name:</label>
                                <input type="text" name="shop_name" id="shop_name" placeholder="Please Enter Shop Name" class="form-control" autofocus value="{{$ShopData->shop_name}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Address:</label>
                                <textarea type="text" name="address" id="address" placeholder="Please Enter Address" class="form-control">{{$ShopData->address}}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Email :</label>
                                <input type="text" name="email" id="email" placeholder="Please Enter Email " class="form-control" autofocus value="{{$ShopData->email}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Shop Image:</label>
                                <input type="file" name="image" id="image" placeholder="Please Enter Image" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6">
                            <button type="submit" id="sbmt" class="btn btn-sm btn-primary m-t-n-xs disable">
                                <strong>Submit</strong>
                            </button>
                        </div>
                </div>
            </div>

            </form>

        </div>
    </div>
</div>
</div>
</div>

@endsection

@section('footer')

<script>
    $(document).ready(function() {
        $("#editForm").validate({
            rules: {
                shop_name: {
                    required: true
                },
                address: {
                    required: true
                },
                email: {
                    required: true,
                    email: true,
                },
                image: {
                    extension: "jpg|jpeg|png|ico|bmp"
                },
            },
            messages: {

            }
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
</script>
@endsection