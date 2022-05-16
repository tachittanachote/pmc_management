@extends('layouts.grain')

@section('title', 'หน้าแรก')

@section('content')

<div class="mb-3 mb-md-4">
	<div class="h3 mb-0 animate__animated animate__fadeInLeft">หน้าแรก</div>
    <div class="h3 py-2 font-weight-bold animate__animated animate__fadeInLeft animate__slow">ยินดีตอนรับ {{ auth()->user()->name }}!</div>
</div>


@if(Auth::user()->role == "admin")
    @include('stats.admin')
@else
    @include('stats.user')
@endif


@if(!\App\BankAccount::where('user_id', Auth::user()->id)->first() && Auth::user()->role != "admin")
<div class="row">
    <div class="col-12">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div><strong>แจ้งเตือนสำคัญ!</strong> โปรดดำเนินการเพิ่มข้อมูลบัญชีธนาคารของคุณ</div>
            <div><a href="{{route('user.profile')}}" class="btn btn-primary btn-sm mt-2">คลิกเพือเพิ่มบัญชี</a></div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
</div>
@endif

<div class="row mt-4">
	<div class="col-12">
        
					@php
                        $count = 0;
                    @endphp

                    @if(Auth::user()->role != 'admin')

                    @if(count($works) > 0)

                    <div class="h3 mb-3">รายการงานในระบบ</div>


                    <!-- Users -->
                    <div class="card">
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0">
                            <thead>
                            <tr>
                                <th class="font-weight-semi-bold border-top-0 py-2">อันดับ</th>
                                <th class="font-weight-semi-bold border-top-0 py-2">ชื่องาน</th>
                                <th class="font-weight-semi-bold border-top-0 py-2">รหัสสินค้า</th>
                                <th class="font-weight-semi-bold border-top-0 py-2">ประเภทสินค้า</th>
                                <th class="font-weight-semi-bold border-top-0 py-2">{{Auth::user()->role == "tailor" ? "ช่างเย็บ" : "ช่างตัด"}}</th>
                                <th class="font-weight-semi-bold border-top-0 py-2">จำนวนงาน</th>
                                <th class="font-weight-semi-bold border-top-0 py-2">ราคางาน</th>
                                <th class="font-weight-semi-bold border-top-0 py-2">ยอดรวม</th>
                                <th class="font-weight-semi-bold border-top-0 py-2">รูปภาพประกอบ</th>
                                <th class="font-weight-semi-bold border-top-0 py-2">รายละเอียด</th>
                                <th class="font-weight-semi-bold border-top-0 py-2">เมื่อเวลา</th>
                                <th class="font-weight-semi-bold border-top-0 py-2"></th>
                                <th class="font-weight-semi-bold border-top-0 py-2"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($works as $w)
                            @php
                                $count = $count + 1;
                            @endphp
                            <tr>
                                <td class="py-3">{{$w->id}}</td>
                                <td class="align-middle py-3">
                                    <div class="d-flex align-items-center">
                                        {{$w->name}}
                                    </div>
                                </td>
                                <td class="align-middle py-3">
                                    <div class="d-flex align-items-center">
                                        {{$w->product_code}}
                                    </div>
                                </td>
                                <td class="align-middle py-3">
                                    <div class="d-flex align-items-center">
                                        {{\App\Product::getProductNameByProductId($w->product_id)}}
                                    </div>
                                </td>
                                <td class="align-middle py-3">
                                    <div class="d-flex align-items-center">
                                        @if(Auth::user()->role == "tailor" )
                                        {!!  $w->user_id ?\App\User::getUserNameByUserId($w->user_id) : 'งานเพิ่มโดยแอดมิน' !!}
                                        @else
                                        {!! $w->tailor_id ? \App\User::getUserNameByUserId($w->tailor_id) : 'งานแก้' !!}
                                        @endif
                                    </div>
                                </td>
                                <td class="align-middle py-3">
                                    <div class="d-flex align-items-center">
                                        {{$w->quantity}}
                                    </div>
                                </td>
                                <td class="align-middle py-3">
                                    <div class="d-flex align-items-center">
                                        @if(Auth::user()->role == "tailor")
                                            {{round(\App\Product::getTailorPriceByProductId($w->product_id))}} บาท
                                        @else
                                            {{round(\App\Product::getSeamstressPriceByProductId($w->product_id))}} บาท
                                        @endif
                                    </div>
                                </td>
                                <td class="align-middle py-3">
                                    <div class="d-flex align-items-center">
                                        @if(Auth::user()->role == "tailor")
                                            {{round(\App\Product::getTailorPriceByProductId($w->product_id)) * $w->quantity}} บาท
                                        @else
                                            {{round(\App\Product::getSeamstressPriceByProductId($w->product_id)) * $w->quantity}} บาท
                                        @endif
                                    </div>
                                </td>
                                <td class="align-middle py-3">
                                    <div class="d-flex align-items-center">
                                        @if($w->image_url)
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#image-{{$w->id}}"><i class="gd-eye"></i> ตรวจสอบ</button>
                                        @else 
                                        ไม่มีรูปภาพ
                                        @endif
                                    </div>
                                </td>
                                <td class="align-middle py-3">
                                    <div class="d-flex align-items-center">
                                        {{$w->detail}}
                                    </div>
                                </td>
                                <td class="align-middle py-3">
                                    <div class="d-flex align-items-center">
                                        {{$w->created_at->format('Y-m-d H:i:s')}}
                                    </div>
                                </td>
                                <td class="py-3">
                                    @if(Auth::user()->role == "seamstress")
                                    <div class="position-relative">
                                        <span class="link-dark d-inline-block" data-toggle="modal" data-target="#edit-{{$w->id}}" data-id="{{$w->id}}" style="cursor: pointer;">
                                            <i class="gd-pencil icon-text"></i>
                                        </span>
                                    </div>
                                    @endif
                                </td>
                                <td class="py-3">
                                    @if(Auth::user()->role == "seamstress")
                                    <div class="position-relative">
                                        <span class="link-dark d-inline-block remove" style="cursor: pointer;" data-id="{{$w->id}}">
                                            <i class="gd-trash icon-text"></i>
                                        </span>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="card-footer d-block d-md-flex align-items-center d-print-none">
                            <!--<div class="d-flex mb-2 mb-md-0">Showing 1 to 8 of 24 Entries</div> !-->

                            <nav class="d-flex ml-md-auto d-print-none" aria-label="Pagination">
                                {{$works}}
                            </nav>
                        </div>
                    </div>
                    </div>
                    @endif
                     @endif

                    @if($count == 0 && Auth::user()->role != 'admin')
                    <div class="card">
                        <div class="card-body pt-0">
                            <div class="mt-3 alert alert-warning" role="alert">
                            ไม่พบรายการข้อมูลในขณะนี้
                            </div>
                        </div>
                    </div>
                    @endif
		</div>
        
</div>


<div class="row mt-4">
	<div class="col-12">
        

                    
					@php
                        $count = 0;
                    @endphp

                    @if(Auth::user()->role != 'admin')
                    <div class="h3 mb-3">รายการหักล่าสุด</div>
                    @if(count(\App\Deduct::where('user_id', Auth::user()->id)->get()) > 0)

                    @php
                        $deducts = \App\Deduct::where('user_id', Auth::user()->id)->paginate(10);
                    @endphp

                    


                    <!-- Users -->
                    <div class="card">
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0">
                            <thead>
                            <tr>
                                <th class="font-weight-semi-bold border-top-0 py-2">รายละเอียด</th>
                                <th class="font-weight-semi-bold border-top-0 py-2">ยอดหัก</th>
                                <th class="font-weight-semi-bold border-top-0 py-2">เมื่อวันที่</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($deducts as $d)
                            @php
                                $count = $count + 1;
                            @endphp
                            <tr>
                                <td class="align-middle py-3">
                                    <div class="d-flex align-items-center">
                                        {{$d->detail}}
                                    </div>
                                </td>
                                <td class="align-middle py-3">
                                    <div class="d-flex align-items-center">
                                        {{$d->amount}}
                                    </div>
                                </td>
                                <td class="align-middle py-3">
                                    <div class="d-flex align-items-center">
                                        {{$d->created_at->format('Y-m-d')}}
                                    </div>
                                </td>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="card-footer d-block d-md-flex align-items-center d-print-none">
                            <!--<div class="d-flex mb-2 mb-md-0">Showing 1 to 8 of 24 Entries</div> !-->

                            <nav class="d-flex ml-md-auto d-print-none" aria-label="Pagination">
                                {{$deducts}}
                            </nav>
                        </div>
                    </div>
                    </div>
                    @endif
                     @endif

                    @if($count == 0 && Auth::user()->role != 'admin')
                    <div class="card">
                        <div class="card-body pt-0">
                            <div class="mt-3 alert alert-warning" role="alert">
                            ไม่พบข้อมูลรายการหักในขณะนี้
                            </div>
                        </div>
                    </div>
                    @endif
		</div>
        
</div>

@endsection

@section('modal')
    @if(Auth::user()->role != 'admin')
        @foreach($works as $w)
            @if($w->image_url)
            <div class="row">
                <div class="modal fade" id="image-{{$w->id}}" tabindex="-1" aria-labelledby="image-{{$w->id}}-label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="image-{{$w->id}}-label">รายละเอียดรูปภาพ</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                <img class="img-fluid" src="/storage/upload/{{$w->image_url}}"></img>
                                <div class="text-center mt-2">{{$w->name}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    @endif


    @if(Auth::user()->role == 'seamstress')
    @foreach($works as $w)
        <div class="modal fade" id="edit-{{$w->id}}" tabindex="-1" aria-labelledby="edit-{{$w->id}}-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="edit-{{$w->id}}-label">รายละเอียดข้อมูลงาน</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group col-12">
                            <label for="name-{{$w->id}}">ชื่องาน</label>
                            <input type="text" class="form-control" id="name-{{$w->id}}" name="name-{{$w->id}}" placeholder="ชื่องาน" value="{{$w->name}}">
                            <div id="nameFeedback-{{$w->id}}" class="invalid-feedback">
                                โปรดระบุชื่องาน
                            </div>
                        </div>
                        <div class="form-group col-12">
                            <label for="code-{{$w->id}}">รหัสสินค้า</label>
                            <input type="text" class="form-control" id="code-{{$w->id}}" placeholder="รหัสสินค้า" value="{{$w->product_code}}">
                            <div id="codeFeedback-{{$w->id}}" class="invalid-feedback">
                                โปรดระบุรหัสสินค้า
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group col-12">
                                <label for="product">ประเภทสินค้า</label>
                                <select class="form-control mb-2" id="product-{{$w->id}}">
                                    @if(\App\Product::isFixProduct($w->product_id) == "yes" || \App\Product::getTailorPriceByProductId($w->product_id) <= 0)
                                        @foreach(\App\Product::where('is_fix', 'yes')->get() as $product)
                                            <option value="{{$product->id}}" {{$w->id == $product->id ? 'selected' : ''}}>{{$product->product_name}}</option>
                                        @endforeach
                                    @endif
                                    @if(\App\Product::isFixProduct($w->product_id) == "no" || \App\Product::getTailorPriceByProductId($w->product_id) > 0)
                                        @foreach(\App\Product::where('is_fix', 'no')->get() as $product)
                                            <option value="{{$product->id}}" {{$w->id == $product->id ? 'selected' : ''}}>{{$product->product_name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <div id="productFeedback-{{$w->id}}" class="invalid-feedback">
                                    โปรดเลือกประเภทสินค้า
                                </div>
                            </div>
                        </div>
                        @if($w->tailor_id)
                        <div class="form-group">
                            <div class="form-group col-12">
                                <label for="tailor-{{$w->id}}">ช่างตัด</label>
                                <select class="form-control mb-2" id="tailor-{{$w->id}}">
                                    @foreach(\App\User::get() as $user)
                                        @if($user->role == "tailor")
                                            <option value="{{$user->id}}" {{$w->tailor_id == $user->id ? 'selected' : ''}}>{{$user->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <div id="tailorFeedback-{{$w->id}}" class="invalid-feedback">
                                    โปรดเลือกช่างตัด
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="form-group col-12">
                            <label for="detail-{{$w->id}}">ไซส์และชื่อลูกค้า</label>
                            <input type="text" class="form-control" id="detail-{{$w->id}}" placeholder="ไซส์และชื่อลูกค้า" value="{{$w->detail}}">
                            <div id="detailFeedback-{{$w->id}}" class="invalid-feedback">
                                โปรดระบุไซส์และชื่อลูกค้า
                            </div>
                        </div>
                        <div class="form-group col-12">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="upload-{{$w->id}}" aria-describedby="upload-{{$w->id}}">
                                    <label class="custom-file-label" for="upload-{{$w->id}}" id="upload-filename-{{$w->id}}">เพิ่มรูปภาพงานอันใหม่</label>
                                </div>
                            </div>
                            
                        @if($w->image_url)
                        <div class="form-group col-12">
                            <div class="text-center">
                                <img src="/storage/upload/{{$w->image_url}}" alt="ตัวอย่าง" class="img-fluid"/>
                                <div>รูปภาพงาน</div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary update-work" data-id="{{$w->id}}">บันทึกข้อมูล</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @endif


@endsection

@section('scripts')
<script type="text/javascript" src="{{ mix('/js/dashboard.js') }}"></script>
@endsection