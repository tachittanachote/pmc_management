@extends('layouts.grain')

@section('title', 'เพิ่มผู้ใช้งาน')

@section('content')
            <div class="card mb-3 mb-md-4">

                <div class="card-body">
                    <!-- Breadcrumb -->
                    <nav class="d-none d-md-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('user.profile')}}">ประเภทชุด</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">เพิ่มประเภทชุด</li>
                        </ol>
                    </nav>
                    <!-- End Breadcrumb -->

                    <div class="mb-3 mb-md-4 d-flex justify-content-between">
                        <div class="h3 mb-0">เพิ่มประเภทชุดเข้าสู่ระบบ</div>
                    </div>

                    <div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="product_name">ชื่อชุด</label>
                                    <input type="text" class="form-control" id="product_name" name="product_name" placeholder="กำหนดชื่อชุด" autocomplete="off">
                                    <div id="productNameFeedback" class="invalid-feedback">
                                        โปรดระบุนามสกุลให้ครบถ้วน
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="price_tailor">ราคาช่างตัด</label>
                                    <input type="number" class="form-control" id="price_tailor" name="price_tailor" placeholder="กำหนดราคาช่างตัด" autocomplete="off" min="0">
                                    <div id="priceTailorFeedback" class="invalid-feedback">
                                        โปรดระบุนามสกุลให้ครบถ้วน
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="price_seamstress">ราคาช่างเย็บ</label>
                                    <input type="number" class="form-control" id="price_seamstress" name="price_seamstress" placeholder="กำหนดราคาช่างเย็บ" autocomplete="off" min="0">
                                    <div id="priceSeamstressFeedback" class="invalid-feedback">
                                        โปรดระบุนามสกุลให้ครบถ้วน หรือ ราคาต้องมากกว่า 0 บาท
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input" id="is_fix">
                                        <label class="form-check-label" for="exampleCheck1">เป็นงานแก้?</label>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary float-right" id="add-product">เพิ่มข้อมูล</button>
                    </div>

                </div>
            </div>


@endsection
@section('scripts')
<script type="text/javascript" src="{{ mix('/js/product.js') }}"></script>
@endsection