

@extends('layouts.grain')

@section('title', 'รายงานยอดทั้งหมด')

@section('content')
<div class="card mb-3 mb-md-4">
    <div class="card-body">
                    <!-- Breadcrumb -->
                    <nav class="d-none d-md-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('announce')}}">รายงาน</a>
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
                
                    @php
                        $count = 0;
                    @endphp

                    @if(count($userListWithReport) > 0)
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0">
                            <thead>
                            <tr>
                                <th class="font-weight-semi-bold border-top-0 py-2">ชื่อ</th>
                                <th class="font-weight-semi-bold border-top-0 py-2">ตำแหน่ง</th>
                                <th class="font-weight-semi-bold border-top-0 py-2">รายการรับ</th>
                                <th class="font-weight-semi-bold border-top-0 py-2">รายการหัก</th>
                                <th class="font-weight-semi-bold border-top-0 py-2">จำนวนงาน</th>
                                <th class="font-weight-semi-bold border-top-0 py-2">รายละเอียดงาน</th>
                                <th class="font-weight-semi-bold border-top-0 py-2">จัดการรายการหัก</th>
                                <th class="font-weight-semi-bold border-top-0 py-2">ข้อมูลบัญชีธนาคาร</th>
                                <th class="font-weight-semi-bold border-top-0 py-2">ใบแจ้งเงินเดือน</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($userListWithReport as $report)
                            @php
                                $count = $count + 1;
                            @endphp
                            <tr>
                                <td class="align-middle py-3">
                                    <div class="d-flex align-items-center">
                                        {{$report->user_name}}
                                    </div>
                                </td>
                                <td class="py-3">
                                    @if($report->user_role == "tailor")
                                    <span class="badge badge-secondary">ช่างตัด</span>
                                    @endif
                                    @if($report->user_role == "seamstress")
                                    <span class="badge badge-success">ช่างเย็บ</span>
                                    @endif
                                </td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center">
                                        {{number_format($report->salary, 2, ".", ",")}} บาท
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center">
                                        @php
                                        $deductAmount = \App\Deduct::where('user_id', $report->user_id)->whereBetween('date', [\Carbon\Carbon::parse($startDate)->format('Y-m-d')." 00:00:00", \Carbon\Carbon::parse($endDate)->format('Y-m-d')." 23:59:59"])->sum('amount');
                                        @endphp
                                        {{number_format($deductAmount, 2, '.', ',')}} บาท
                                    </div>
                                </td>
                                <td class="align-middle py-3">
                                    <div class="d-flex align-items-center">
                                        {{$report->work_quantity}} งาน
                                    </div>
                                </td>
                                <td class="py-3">
                                    <a target="_blank" href="/workview?id={{$report->user_id}}&startAt={{$startDate->format('Y/m/d')}}&endAt={{$endDate->format('Y/m/d')}}" class="btn btn-primary btn-sm"><i class="gd-eye"></i> ตรวจสอบ</button>
                                </td>
                                <td class="align-middle py-3">
                                    <div class="d-flex align-items-center">
                                        <button type="button" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#deduct-{{$report->user_id}}"><i class="gd-pencil"></i> จัดการ</button>
                                        <!-- <button type="button" class="btn btn-success btn-sm clear" data-id="{{$report->user_id}}"><i class="gd-reload"></i> เคลียร์</button> !-->
                                    </div>
                                </td>
                                <td class="align-middle py-3">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#account-{{$report->user_id}}"><i class="gd-eye"></i> ตรวจสอบ</button>
                                </td>
                                <td class="py-3">
                                    <a target="_blank" href="/payslip?id={{$report->user_id}}&startAt={{$startDate->format('Y/m/d')}}&endAt={{$endDate->format('Y/m/d')}}" class="btn btn-danger btn-sm"><i class="gd-printer"></i> พิมพ์</button>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
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

                    <!-- End Form -->
    </div>
</div>
@endsection

@if(count($userListWithReport) > 0)
    
        @section('modal')
            @foreach($userListWithReport as $report)
            <div class="modal fade" id="account-{{$report->user_id}}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">ข้อมูลบัญชีธนาคารของ {{$report->user_name}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">    
                            @if(\App\BankAccount::getBankAccountDetailByUserId($report->user_id))
                            <h5 class="mb-0">ชื่อธนาคาร</h5>
                            <div class="mb-2">{{\App\BankAccount::getBankAccountDetailByUserId($report->user_id)->bank_name}}</diV>
                            <h5 class="mb-0">หมายเลขบัญชีธนาคาร</h5>
                            <div class="mb-2">{{\App\BankAccount::getBankAccountDetailByUserId($report->user_id)->bank_no}}</diV>
                            <h5 class="mb-0">ชื่อบัญชีธนาคาร</h5>
                            <div class="mb-2">{{\App\BankAccount::getBankAccountDetailByUserId($report->user_id)->account_name}}</diV>
                            @else
                                <div class="card">
                                    <div class="card-body pt-0">
                                        <div class="alert alert-warning" role="alert">
                                            ไม่พบรายการข้อมูลบัญชีธนาคาร
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary w-100" data-dismiss="modal">ตกลง</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            @foreach($userListWithReport as $report)
            <div class="modal fade" id="deduct-{{$report->user_id}}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">รายการหักของ {{$report->user_name}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">    
                        @php
                            $count = 0;
                            $deducts = \App\Deduct::where('user_id', $report->user_id)->whereBetween('date', [\Carbon\Carbon::parse($startDate)->format('Y-m-d')." 00:00:00", \Carbon\Carbon::parse($endDate)->format('Y-m-d')." 23:59:59"])->get();
                        @endphp

                        

                        @if(count($deducts) > 0)
                        <div class="table-responsive mb-4">
                            <table class="table text-nowrap mb-0">
                                <thead>
                                <tr>
                                    <th class="font-weight-semi-bold border-top-0 py-2">รายละเอียด</th>
                                    <th class="font-weight-semi-bold border-top-0 py-2">ยอดหัก</th>
                                    <th class="font-weight-semi-bold border-top-0 py-2"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($deducts as $deduct)
                                @php
                                    $count = $count + 1;
                                @endphp
                                <tr>
                                    <td class="py-3">
                                        <div class="d-flex align-items-center">
                                            {{$deduct->detail}}
                                        </div>
                                    </td>
                                    <td class="align-middle py-3">
                                        <div class="d-flex align-items-center">
                                            {{$deduct->amount}} บาท
                                        </div>
                                    </td>
                                    <td class="align-middle py-3">
                                        <div class="position-relative">
                                        <span class="link-dark d-inline-block remove" style="cursor: pointer;" data-id="{{$deduct->id}}">
                                            <i class="gd-trash icon-text"></i>
                                        </span>
                                    </div>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif

                        @if($count == 0)
                        <div class="card mb-4">
                            <div class="card-body pt-0">
                                <div class="mt-3 alert alert-warning" role="alert">
                                ไม่พบข้อมูลรายการหัก
                                </div>
                            </div>
                        </div>
                        @endif

                            <div class="form-group col-12">
                                <label for="deduct-detail-{{$report->user_id}}">รายละเอียดรายการหัก</label>
                                <input type="text" class="form-control" id="deduct-detail-{{$report->user_id}}" placeholder="ระบุรายละเอียดรายการหัก" value="">
                                <div id="deduct-detail-Feedback-{{$report->user_id}}" class="invalid-feedback">
                                    โปรดระบุรายละเอียดรายการหัก
                                </div>
                            </div>


                            <div class="form-group col-12">
                                <label for="deduct-amount-{{$report->user_id}}">ยอดหัก</label>
                                <input type="number" class="form-control" id="deduct-amount-{{$report->user_id}}" placeholder="ระบุยอดหัก" value="" min="0">
                                <div id="deduct-amount-Feedback-{{$report->user_id}}" class="invalid-feedback">
                                    โปรดระบุยอดหัก
                                </div>
                            </div>

                            <div class="form-group col-12">
                                <label for="deduct-date-{{$report->user_id}}">วันที่</label>
                                <input type="date" class="form-control" id="deduct-date-{{$report->user_id}}" placeholder="ระบุวันที่" value="" min="0">
                                <div id="deduct-date-Feedback-{{$report->user_id}}" class="invalid-feedback">
                                    โปรดระบุวันที่
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary w-100 add-deduct" data-id="{{$report->user_id}}">เพิ่มรายการหัก</button>
                            <button type="button" class="btn btn-danger w-100" data-dismiss="modal">ตกลง</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endsection
    
@endif
@section('scripts')
<script type="text/javascript" src="{{ mix('/js/report.js') }}"></script>
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

        window.location.href = `/report?startAt=${startDate}&endAt=${endDate}`

    })
</script>
@endsection