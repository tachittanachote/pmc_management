

@extends('layouts.grain')

@section('title', 'จัดการประเภทชุด')

@section('content')
            <div class="card mb-3 mb-md-4">

                <div class="card-body">
                    <!-- Breadcrumb -->
                    <nav class="d-none d-md-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('products')}}">ประเภทชุด</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">จัดการประเภทชุด</li>
                        </ol>
                    </nav>
                    <!-- End Breadcrumb -->

                    <div class="mb-3 mb-md-4 d-flex justify-content-between">
                        <div class="h3 mb-0">จัดการข้อมูลประเภทชุดในระบบ</div>
                    </div>


                    @php
                        $count = 0;
                    @endphp

                    @if(count($products) > 0)
                    <div class="table-responsive-xl">
                        <table class="table text-nowrap mb-0">
                            <thead>
                            <tr>
                                <th class="font-weight-semi-bold border-top-0 py-2">อันดับ</th>
                                <th class="font-weight-semi-bold border-top-0 py-2">ชื่อประเภทชุด</th>
                                <th class="font-weight-semi-bold border-top-0 py-2">ราคาช่างตัด</th>
                                <th class="font-weight-semi-bold border-top-0 py-2">ราคาช่างเย็บ</th>
                                <th class="font-weight-semi-bold border-top-0 py-2"></th>
                                <th class="font-weight-semi-bold border-top-0 py-2"></th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($products as $p)
                            @php
                                $count = $count + 1;
                            @endphp
                            <tr>
                                <td class="py-3">{{$p->id}}</td>
                                <td class="align-middle py-3">
                                    <div class="d-flex align-items-center">
                                        {{$p->product_name}}
                                    </div>
                                </td>
                                <td class="py-3">{{$p->price_tailor}}</td>
                                <td class="py-3">{{$p->price_seamstress}}</td>
                                <td class="py-3">
                                    <div class="position-relative">
                                        <span class="link-dark d-inline-block" style="cursor: pointer;" data-id="{{$p->id}}" data-toggle="modal" data-target="#edit-{{$p->id}}">
                                            <i class="gd-pencil icon-text"></i>
                                        </span>
                                    </div>
                                <td class="py-3">
                                    <div class="position-relative">
                                        <span class="link-dark d-inline-block remove" style="cursor: pointer;" data-id="{{$p->id}}">
                                            <i class="gd-trash icon-text"></i>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="card-footer d-block d-md-flex align-items-center d-print-none">
                            <!--<div class="d-flex mb-2 mb-md-0">Showing 1 to 8 of 24 Entries</div>!-->

                            <nav class="d-flex ml-md-auto d-print-none" aria-label="Pagination">
                                {{$products}}
                            </nav>
                            
                        </div>
                    </div>
                    @endif

                    @if($count == 0)
                    <div class="card">
                        <div class="card-body pt-0">
                            <div class="alert alert-warning" role="alert">
                            ไม่พบรายการข้อมูลในขณะนี้
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>


@endsection

@if(count($products) > 0)
@section('modal')
@foreach($products as $p)
<div class="modal fade" id="edit-{{$p->id}}" tabindex="-1" aria-labelledby="edit-{{$p->id}}-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-{{$p->id}}-label">รายละเอียดข้อมูลผู้ใช้งาน</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group col-12">
                    <label for="edit-name-{{$p->id}}">ชื่อประเภทชุด</label>
                    <input type="text" class="form-control" id="edit-name-{{$p->id}}" name="edit-name-{{$p->id}}" placeholder="ชื่อประเภทชุด" value="{{$p->product_name}}">
                    <div id="edit-nameFeedback-{{$p->id}}" class="invalid-feedback">
                        โปรดระบุชื่อประเภทชุด
                    </div>
                </div>
                <div class="form-group col-12">
                    <label for="edit-tprice-{{$p->id}}">ราคาช่างตัด</label>
                    <input type="number" class="form-control" id="edit-tprice-{{$p->id}}" name="edit-tprice-{{$p->id}}" placeholder="ราคาช่างตัด" value="{{$p->price_tailor}}" autocomplete="off">
                    <div id="edit-tpriceFeedback-{{$p->id}}" class="invalid-feedback">
                        โปรดระบุราคาช่างตัดให้ถูกต้อง
                    </div>
                </div>
                <div class="form-group col-12">
                    <label for="edit-sprice-{{$p->id}}">ราคาช่างเย็บ</label>
                    <input type="number" class="form-control" id="edit-sprice-{{$p->id}}" name="edit-sprice-{{$p->id}}" placeholder="ราคาช่างเย็บ" value="{{$p->price_seamstress}}" autocomplete="off">
                    <div id="edit-spriceFeedback-{{$p->id}}" class="invalid-feedback">
                        โปรดระบุราคาช่างเย็บให้ถูกต้อง
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary update-product" data-id="{{$p->id}}">บันทึกข้อมูล</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
@endif

@section('scripts')
<script type="text/javascript" src="{{ mix('/js/product.js') }}"></script>
@endsection