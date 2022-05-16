

@extends('layouts.grain')

@section('title', 'รายงานยอดทั้งหมด')

@section('content')
<div class="card mb-3 mb-md-4">
    <div class="card-body">
                    <!-- Breadcrumb -->
                    <nav class="d-none d-md-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('announce')}}">รายงานยอด</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">รายงานยอดทั้งหมด</li>
                        </ol>
                    </nav>
                    <!-- End Breadcrumb -->

                    <div class="mb-3 mb-md-4">
                        <div class="h3 mb-2">ข้อมูลระหว่าง {{$startDate->format('Y/m/d')}} ถึง {{$endDate->format('Y/m/d')}} </div>
                    </div>

                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                                <input class="form-control form-control-sm" type="text" name="daterange" readonly/>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-2"><button type="button" class="btn btn-primary btn-sm w-100" id="search">ค้นหา</button></div>
                        </div>
                    </div>
                

                    @if(count($workList) > 0)
                    <!-- End Form -->
                    <div class="table-responsive">
                    <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ชื่องาน</th>
                            <th scope="col">จำนวน</th>
                            <th scope="col">ราคา</th>
                        </tr>
                    </thead>
                    <tbody>
                         @if(count($workList) > 0)
								@php
                                $productList = array();
								@endphp
								@foreach($workList as $work)
									@if(!in_array($work->product_name, $productList))
										@php 
											array_push($productList, $work->product_name); 
										@endphp
									@endif
								@endforeach
								
								
								@foreach($productList as $proudct)
									@php
										$productCount[$loop->index] = 0;
										$productPrice[$loop->index] = 0;
									@endphp
								@endforeach
								
								@foreach($workList as $work)
									@if(in_array($work->product_name, $productList))
										@php
											$productIndex = array_search($work->product_name, $productList);
											$productCount[$productIndex] = $productCount[$productIndex] + 1;
											$productPrice[$productIndex] = $work->product_price;
										@endphp
									@endif
                                @endforeach
								
								@foreach($productList as $product)
								@php
									$productIndex = array_search($product, $productList);
								@endphp
                                <tr>
                                    <td>{{$product}}</td>
                                    <td>{{$productCount[$productIndex]}}</td>
                                    <td>{{$productPrice[$productIndex]}}</td>
                                </tr>
                                @endforeach
								
                            @endif
                    </tbody>
                    </table>
                </div>
                @else
                <div class="mt-3 alert alert-warning" role="alert">
                    ไม่พบข้อมูลในช่วงเวลานี้
                </div>
                @endif
    </div>
</div>

<div class="row mt-4">
	<div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card">
            <div class="card-body font-weight-bold h5">
                ยอดรวม: {{number_format($totalIncome, 2, ".", ",")}} บาท
            </div>
        </div>
	</div>
    <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card">
            <div class="card-body font-weight-bold h5">
                ยอดรายการหัก: {{number_format($totalDeduct, 2, ".", ",")}} บาท
            </div>
        </div>
	</div>
    <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card">
            <div class="card-body font-weight-bold h5">
                ยอดรวมทั้งหมด: {{number_format($totalIncome - $totalDeduct, 2, ".", ",")}} บาท
            </div>
        </div>
	</div>
</div>

<div class="row mt-4">
	<div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card">
            <div class="card-body font-weight-bold h5">
                จำนวนงานทั้งหมด: {{count($workList)}} งาน
            </div>
        </div>
	</div>
</div>

<div class="row mt-4">
	<div class="col-12">
                    
					@php
                        $count = 0;
                    @endphp

                    @if(Auth::user()->role != 'admin')
                    <div class="h3 mb-3">รายการหักล่าสุด</div>
                    @if(count($deducts) > 0)
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


@section('scripts')
<script>

    var startDate = moment("{{$startDate->format('Y-m-d')}}").format("YYYY-MM-DD");
    var endDate = moment("{{$endDate->format('Y-m-d')}}").format("YYYY-MM-DD");

    $('input[name="daterange"]').daterangepicker({
        "startDate": moment("{{$startDate->format('Y-m-d')}}").format("DD/MM/YYYY"),
        "endDate": moment("{{$endDate->format('Y-m-d')}}").format("DD/MM/YYYY"),
        opens: 'center',
        "locale": {
                "format": "DD/MM/YYYY",
                "separator": " ถึง ",
                "applyLabel": "ตกลง",
                "cancelLabel": "ยกเลิก",
                "fromLabel": "จาก",
                "toLabel": "ถึง",
                "customRangeLabel": "Custom",
                "weekLabel": "W",
                "daysOfWeek": [
                    "อา",
                    "จ",
                    "อ",
                    "พ",
                    "พฤ",
                    "ศ",
                    "ส"
                ],
                "monthNames": [
                    "มกราคม",
                    "กุมภาพันธ์",
                    "มีนาคม",
                    "เมษายน",
                    "พฤษภาคม",
                    "มิถุนายน",
                    "กรกฎาคม",
                    "สิงหาคม",
                    "กันยายน",
                    "ตุลาคม",
                    "พฤศจิกายน",
                    "ธันวาคม"
                ],
                "firstDay": 1
            },
    }, function(start, end, label) {
        startDate = start.format("YYYY-MM-DD")
        endDate = end.format("YYYY-MM-DD")
    });


    $("#search").on("click", function(e) {
        e.preventDefault();

        console.log(startDate)
        console.log(endDate)

        window.location.href = `/salary?startDate=${startDate}&endDate=${endDate}`

    })
</script>
@endsection