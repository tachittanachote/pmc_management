@extends('layouts.grain')

@section('title', 'รายการงาน')

@section('content')

<div class="row mt-4">
	<div class="col-12">
                    <div class="h3 mb-3">รายการงานในระบบของ {{$user->name}}</div>
                    <p>ข้อมูลระหว่าง {{$startDate->format('Y-m-d')}} ถึง {{$endDate->format('Y-m-d')}}</p>

                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                                <input class="form-control form-control-sm" type="text" name="daterange" readonly/>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-2"><button type="button" class="btn btn-primary btn-sm w-100" id="search">ค้นหา</button></div>
                        </div>
                    </div>
					@php
                        $count = 0;
                    @endphp

                    @if(count($works) > 0)
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
                                    <th class="font-weight-semi-bold border-top-0 py-2">{{$user->role == "tailor" ? "ช่างเย็บ" : "ช่างตัด"}}</th>
                                    <th class="font-weight-semi-bold border-top-0 py-2">ยอดสุทธิ</th>
                                    <th class="font-weight-semi-bold border-top-0 py-2">ราคางาน</th>
                                    <th class="font-weight-semi-bold border-top-0 py-2">ยอดรวม</th>
                                    <th class="font-weight-semi-bold border-top-0 py-2">รูปภาพประกอบ</th>
                                    <th class="font-weight-semi-bold border-top-0 py-2">รายละเอียด</th>
                                    <th class="font-weight-semi-bold border-top-0 py-2">เมื่อเวลา</th>
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
                                            @if($user->role == "tailor" )
                                            {{  \App\User::getUserNameByUserId($w->user_id) }}
                                            @else
                                            {!! $w->tailor_id ? \App\User::getUserNameByUserId($w->tailor_id) : 'งานแก้' !!}
                                            @endif
                                        </div>
                                    </td>
                                    <td class="align-middle py-3">
                                        <div class="d-flex align-items-center">
                                            <div id="quantity-{{$w->id}}">{{$w->quantity}}</div> <i class="ml-1 fas fa-pen quantity-edit clickable" data-id="{{$w->id}}"></i>
                                        </div>
                                    </td>
                                    <td class="align-middle py-3">
                                        <div class="d-flex align-items-center">
                                            @if($user->role == "tailor")
                                                <span id="price-{{$w->id}}">{{round(\App\Product::getTailorPriceByProductId($w->product_id))}}</span> บาท
                                            @else
                                                <span id="price-{{$w->id}}">{{round(\App\Product::getSeamstressPriceByProductId($w->product_id))}}</span> บาท
                                            @endif
                                        </div>
                                    </td>
                                    <td class="align-middle py-3">
                                        <div class="d-flex align-items-center">
                                            @if($user->role == "tailor")
                                                <span id="price-total-{{$w->id}}">{{round(\App\Product::getTailorPriceByProductId($w->product_id)) * $w->quantity}}</span> บาท
                                            @else
                                                <span id="price-total-{{$w->id}}">{{round(\App\Product::getSeamstressPriceByProductId($w->product_id)) * $w->quantity}}</span> บาท
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

                    @if($count == 0)
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
@endsection

@section('modal')
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

@endsection

@section('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.0/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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

        window.location.href = `/workview?id={{$user->id}}&startAt=${startDate}&endAt=${endDate}`

    })

    $('.quantity-edit').on('click', function () {

        var id = $(this).attr("data-id")

        if ($(this).hasClass('save')) {

            $(this).removeClass('save fa-save').addClass('fa-pen');
            $('#quantity-' + id).attr('contenteditable', 'false').css({
                'border': 'none',
                'border-radius': 'none',
                'outline': 'none',
                'padding': '4px',
                'width': '0%',
            })

            axios.post(`/work/quantity/update`, {
                id: id,
                quantity: $('#quantity-' + id).text()
            })
                .then(res => {
                    Swal.fire({
                        icon: res.data.status,
                        text: res.data.result,
                    })
                    if(res.data.status === "success") {
                        const quantity = parseInt($('#quantity-' + id).text());
                        const price = parseInt($('#price-' + id).text());

                        $('#price-total-' + id).text(price * quantity)

                    }
                }).catch((error) => {
                    Swal.fire({
                        icon: 'error',
                        text: 'เกิดข้อผิดพลาดกรุณาลองใหม่อีกครั้ง',
                    })
                })


        } else {

            $(this).addClass('save fa-save');

            $('#quantity-' + id).attr('contenteditable', 'true').css({
                'border': 'black solid 1px',
                'border-radius': 5,
                'outline': 'none',
                'padding': '4px',
                'width': '40%',
            })

            $('#quantity-' + id).focus();
            document.execCommand('selectAll', false, null);
            document.getSelection().collapseToEnd()

        }
    });
</script>
@endsection