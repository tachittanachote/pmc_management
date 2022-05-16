

@extends('layouts.grain')

@section('title', 'ตั้งค่าระบบประกาศ')

@section('content')
            
        @if(count($announce) == 0)
            <div class="card mb-3 mb-md-4">

                <div class="card-body">
                    <!-- Breadcrumb -->
                    <nav class="d-none d-md-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('announce')}}">ประกาศ</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">จัดการประกาศ</li>
                        </ol>
                    </nav>
                    <!-- End Breadcrumb -->

                    <div class="mb-3 mb-md-4 d-flex justify-content-between">
                        <div class="h3 mb-0">เพิ่มข้อมูลระบบประกาศ</div>
                    </div>

                    <div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="message">ข้อความประกาศ</label>
                                <input type="text" class="form-control" id="message" name="message" placeholder="ระบุข้อความประกาศ" autocomplete="off">
                                    <div id="messageFeedback" class="invalid-feedback">
                                        โปรดระบุข้อมูลให้ครบถ้วน
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="upload" aria-describedby="upload">
                                    <label class="custom-file-label" for="upload" id="upload-new-label">อัพโหลดภาพ</label>
                                </div> 
                            </div>
                        </div>
                    <button type="button" class="btn btn-primary float-right w-100" id="save-announce">บันทึก</button>
                    <!-- End Form -->
                </div>
            </div>
        @else 

        <div class="card mb-3 mb-md-4">

                <div class="card-body">
                    <!-- Breadcrumb -->
                    <nav class="d-none d-md-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('announce')}}">ประกาศ</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">จัดการประกาศ</li>
                        </ol>
                    </nav>
                    <!-- End Breadcrumb -->

                    <div class="mb-3 mb-md-4 d-flex justify-content-between">
                        <div class="h3 mb-0">จัดการข้อมูลประเภทชุดในระบบ</div>
                    </div>


                    @php
                        $count = 0;
                    @endphp


                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0">
                            <thead>
                            <tr>
                                <th class="font-weight-semi-bold border-top-0 py-2">ข้อความประกาศ</th>
                                <th class="font-weight-semi-bold border-top-0 py-2">แสดงผล</th>
                                <th class="font-weight-semi-bold border-top-0 py-2">ตัวอย่าง</th>
                                <th class="font-weight-semi-bold border-top-0 py-2"></th>
                                <th class="font-weight-semi-bold border-top-0 py-2"></th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($announce as $a)
                            @php
                                $count = $count + 1;
                            @endphp
                            <tr>
                                <td class="align-middle py-3">
                                    <div class="d-flex align-items-center">
                                        {{$a->message}}
                                    </div>
                                </td>
                                <td class="py-3">
                                    <select class="custom-select custom-select-sm" style="max-width: 30%;" id="status" data-id="{{$a->id}}">
                                        <option value="on" {{$a->status == "on" ? " selected" : ""}}>เปิดใช้งาน</option>
                                        <option value="off" {{$a->status == "off" ? " selected" : ""}}>ปิดใช้งาน</option>
                                    </select>
                                </td>
                                <td class="py-3"><i class="gd-eye icon-text" style="cursor: pointer;" data-toggle="modal" data-target="#announce-image"></i></td>
                                <td class="py-3">
                                    <div class="position-relative">
                                        <span class="link-dark d-inline-block" style="cursor: pointer;" data-id="{{$a->id}}" data-toggle="modal" data-target="#message-edit">
                                            <i class="gd-pencil icon-text"></i>
                                        </span>
                                    </div>
                                <td class="py-3">
                                    <div class="position-relative">
                                        <span class="link-dark d-inline-block remove" style="cursor: pointer;" data-id="{{$a->id}}">
                                            <i class="gd-trash icon-text"></i>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

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

        @endif               

@endsection

@if(count(\App\Announce::get()) > 0)
@section('modal')
<div class="modal fade" id="announce-image" tabindex="-1" aria-labelledby="announce-image-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="announce-image-label">รายละเอียดรูปภาพประกาศ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img src="/storage/upload/{{\App\Announce::first()->image_url}}" alt="ประกาศจากระบบ" class="img-fluid"/>
                <h4 class="text-center">{{$a->message}}</h4>                   
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary w-100" data-dismiss="modal">ตกลง</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="message-edit" tabindex="-1" aria-labelledby="message-edit-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="message-edit-label">แก้ไข้ข้อความประกาศ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="announce-text">ข้อความประกาศ</label>
                    <input type="text" class="form-control" id="announce-text" placeholder="ระบุข้อความประกาศ..." value="{{$a->message}}">
                    <div id="announce-textFeedback" class="invalid-feedback">
                        โปรดระบุข้อมูลให้ครบถ้วน
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="upload-update" aria-describedby="upload-update">
                        <label class="custom-file-label" for="upload-update" id="upload-update-label">อัพโหลดภาพ</label>
                   </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger w-100" data-dismiss="modal" data-id="{{$a->id}}">ยกเลิก</button>
                    <button type="button" class="btn btn-success w-100" id="update-text" data-id="{{$a->id}}">อัพเดต</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@endif

@section('scripts')
<script type="text/javascript" src="{{ mix('/js/announce.js') }}"></script>
@endsection
