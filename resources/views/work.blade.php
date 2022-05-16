@extends('layouts.grain')

@section('title', 'เพิ่มงาน')

@section('content')

<div class="card mb-3 mb-md-4">

                <div class="card-body">
                    <!-- Breadcrumb -->
                    <nav class="d-none d-md-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('user.profile')}}">เพิ่มงาน</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">เพิ่มข้อมูลงานลงระบบ</li>
                        </ol>
                    </nav>
                    <!-- End Breadcrumb -->

                    <div class="mb-3 mb-md-4 d-flex justify-content-between">
                        <div class="h3 mb-0">เพิ่มข้อมูลงานลงระบบ</div>
                    </div>

                    <div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="productCode">รหัสสินค้า</label>
                                    <input type="text" class="form-control" id="productCode" name="productCode" placeholder="รหัสสินค้า" autocomplete="off">
                                    <div id="productCodeFeedback" class="invalid-feedback">
                                        โปรดระบุข้อมูลให้ครบถ้วน
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="productName">ชื่อสินค้า</label>
                                    <input type="text" class="form-control" id="productName" name="productName" placeholder="ชื่อสินค้า" autocomplete="off">
                                    <div id="productNameFeedback" class="invalid-feedback">
                                        โปรดระบุข้อมูลให้ครบถ้วน
                                    </div>
                                </div>
                            </div>

                    </div>
                        <div>
                            <div class="form-row">
                                    <label for="bankname">เลือกประเภทชุด</label>
                                    <select class="form-control mb-2" id="product">
                                        <option value="" disabled selected hidden>เลือกประเภทชุด</option>
                                        @foreach(\App\Product::get() as $product)
                                            <option value="{{$product->id}}" data-fix="{{$product->is_fix}}" data-tprice="{{$product->price_tailor}}">{{$product->product_name}}</option>
                                        @endforeach
                                    </select>
                                    <div id="productFeedback" class="invalid-feedback">
                                        โปรดเลือกประเภทชุด
                                    </div>
                                </div>
                        </div>
                        <div id="tailor-selection" style="display: none;">
                            <div class="form-row">
                                    <label for="tailor">เลือกช่างตัด</label>
                                    <select class="form-control mb-2" id="tailor">
                                        <option value="" disabled selected hidden>เลือกช่างตัด</option>
                                        @foreach(\App\User::where('role', 'tailor')->get() as $tailor)
                                            <option value="{{$tailor->id}}">{{$tailor->name}}</option>
                                        @endforeach
                                    </select>
                                    <div id="tailorFeedback" class="invalid-feedback">
                                        โปรดเลือกช่างตัด
                                    </div>
                                </div>
                        </div>
                        <div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="quantity">จำนวนที่เย็บ</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" placeholder="จำนวนที่เย็บ" autocomplete="off">
                                    <div id="quantityFeedback" class="invalid-feedback">
                                        โปรดระบุข้อมูลให้ครบถ้วน
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="detail">ไซส์และชื่อลูกค้า</label>
                                    <input type="text" class="form-control" id="detail" name="detail" placeholder="ไซส์และชื่อลูกค้า" autocomplete="off">
                                    <div id="detailFeedback" class="invalid-feedback">
                                        โปรดระบุข้อมูลให้ครบถ้วน
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="upload" aria-describedby="upload">
                                    <label class="custom-file-label" for="upload">เพิ่มรูปภาพงาน</label>
                                </div>
                            </div>
                    </div>
                    <button type="button" class="btn btn-primary float-right w-100" id="upload-work">เพิ่มงาน</button>
                    <!-- End Form -->
                </div>
            </div>




    


@endsection
@section('scripts')
<script>
            $('#upload').on('change',function(e){
                var fileName = e.target.files[0].name;
                $('.custom-file-label').html(fileName);
            })
        </script>
        <script type="text/javascript" src="{{ mix('/js/work.js') }}"></script>
@endsection
