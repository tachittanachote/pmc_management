@extends('layouts.grain')

@section('title', 'ข้อมูลผู้ใช้งาน')

@section('content')

<div class="card mb-3 mb-md-4">

                <div class="card-body">
                    <!-- Breadcrumb -->
                    <nav class="d-none d-md-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('user.profile')}}">ข้อมูลผู้ใช้งาน</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">ตั้งค่าข้อมูลผู้ใช้งาน</li>
                        </ol>
                    </nav>
                    <!-- End Breadcrumb -->

                    <div class="mb-3 mb-md-4 d-flex justify-content-between">
                        <div class="h3 mb-0">ตั้งค่าข้อมูลผู้ใช้งาน</div>
                    </div>

                    <div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="username">ชื่อผู้ใช้งาน</label>
                                    <input type="text" class="form-control" value="" id="username" name="username" placeholder="{{Auth::user()->username}}" readonly>

                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="name">ชื่อ</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="ชื่อ" value="{{Auth::user()->name}}" autocomplete="off">
                                    <div id="nameFeedback" class="invalid-feedback">
                                        โปรดระบุข้อมูลให้ครบถ้วน
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary float-right" id="update-name">บันทึกข้อมูล</button>
                    </div>

                    <!-- End Form -->
                </div>
            </div>

            @if(Auth::user()->role != "admin")
            <div class="card mb-3 mb-md-4">

                <div class="card-body">

                    <!-- Form -->
                    <div>

                            
                            <div class="form-row mt-4">
                                <div class="col-12">
                                    <div class="font-weight-semi-bold h5 mb-3">ตั้งค่าบัญชีธนาคาร</div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="bankname">บัญชีธนาคาร</label>
                                    <select class="form-control mb-2" id="bankname">
                                                        <option value="" disabled {{$bankAccount && $bankAccount->bank_name ? '' : 'selected'}} hidden>เลือกธนาคาร</option>
                                                        <option value="ธนาคารกสิกรไทย" {{$bankAccount && $bankAccount == "ธนาคารกสิกรไทย" ? 'selected' : ''}}>ธนาคารกสิกรไทย</option>
                                                        <option value="ธนาคารกรุงเทพ" {{$bankAccount && $bankAccount->bank_name == "ธนาคารกรุงเทพ" ? 'selected' : ''}}>ธนาคารกรุงเทพ</option>
                                                        <option value="ธนาคารกรุงไทย" {{$bankAccount && $bankAccount->bank_name == "ธนาคารกรุงไทย" ? 'selected' : ''}}>ธนาคารกรุงไทย</option>
                                                        <option value="ธนาคารกรุงศรี" {{$bankAccount && $bankAccount->bank_name == "ธนาคารกรุงศรี" ? 'selected' : ''}}>ธนาคารกรุงศรี</option>
                                                        <option value="ธนาคารซีไอเอ็มบี" {{$bankAccount && $bankAccount->bank_name == "ธนาคารซีไอเอ็มบี" ? 'selected' : ''}}>ธนาคารซีไอเอ็มบี</option>
                                                        <option value="ธนาคารทหารไทยธนชาต" {{$bankAccount && $bankAccount->bank_name == "ธนาคารทหารไทยธนชาต" ? 'selected' : ''}}>ธนาคารทหารไทยธนชาต</option>
                                                        <option value="ธนาคารไทยพาณิชย์" {{$bankAccount && $bankAccount->bank_name == "ธนาคารไทยพาณิชย์" ? 'selected' : ''}}>ธนาคารไทยพาณิชย์</option>
                                                        <option value="ธนาคารยูโอบี" {{$bankAccount && $bankAccount->bank_name == "ธนาคารยูโอบี" ? 'selected' : ''}}>ธนาคารยูโอบี</option>
                                                        <option value="ธนาคารแลนด์ แอนด์ เฮ้าส์" {{$bankAccount && $bankAccount->bank_name == "ธนาคารแลนด์ แอนด์ เฮ้าส์" ? 'selected' : ''}}>ธนาคารแลนด์ แอนด์ เฮ้าส์</option>
                                                        <option value="ธนาคารสแตนดาร์ดฯ" {{$bankAccount && $bankAccount->bank_name == "ธนาคารสแตนดาร์ดฯ" ? 'selected' : ''}}>ธนาคารสแตนดาร์ดฯ</option>
                                                        <option value="ธนาคารออมสิน" {{$bankAccount && $bankAccount->bank_name == "ธนาคารออมสิน" ? 'selected' : ''}}>ธนาคารออมสิน</option>
                                                        <option value="ธนาคารเกียรตินาคินภัทร" {{$bankAccount && $bankAccount->bank_name == "ธนาคารเกียรตินาคินภัทร" ? 'selected' : ''}}>ธนาคารเกียรตินาคินภัทร</option>
                                                        <option value="ธนาคารซิตี้แบงก์" {{$bankAccount && $bankAccount->bank_name == "ธนาคารซิตี้แบงก์" ? 'selected' : ''}}>ธนาคารซิตี้แบงก์</option>
                                                        <option value="ธนาคารอาคารสงเคราะห์" {{$bankAccount && $bankAccount->bank_name == "ธนาคารอาคารสงเคราะห์" ? 'selected' : ''}}>ธนาคารอาคารสงเคราะห์</option>
                                                        <option value="ธนาคาร ธ.ก.ส." {{$bankAccount && $bankAccount->bank_name == "ธนาคาร ธ.ก.ส." ? 'selected' : ''}}>ธนาคาร ธ.ก.ส.</option>
                                                        <option value="ธนาคารมิซูโอ" {{$bankAccount && $bankAccount->bank_name == "ธนาคารมิซูโอ" ? 'selected' : ''}}>ธนาคารมิซูโอ</option>
                                                        <option value="ธนาคารอิสลาม" {{$bankAccount && $bankAccount->bank_name == "ธนาคารอิสลาม" ? 'selected' : ''}}>ธนาคารอิสลาม</option>
                                                        <option value="ธนาคารทิสโก้" {{$bankAccount && $bankAccount->bank_name == "ธนาคารทิสโก้" ? 'selected' : ''}}>ธนาคารทิสโก้</option>
                                                        <option value="ธนาคารไอซีบีซี (ไทย)" {{$bankAccount && $bankAccount->bank_name == "ธนาคารไอซีบีซี (ไทย)" ? 'selected' : ''}}>ธนาคารไอซีบีซี (ไทย)</option>
                                                        <option value="ธนาคารไทยเครดิต" {{$bankAccount && $bankAccount->bank_name == "ธนาคารไทยเครดิต" ? 'selected' : ''}}>ธนาคารไทยเครดิต</option>
                                                        <option value="ธนาคารซูมิโตโม มิตซุย" {{$bankAccount && $bankAccount->bank_name == "ธนาคารซูมิโตโม มิตซุย" ? 'selected' : ''}}>ธนาคารซูมิโตโม มิตซุย</option>
                                                        <option value="ธนาคารเอชเอสบีซี" {{$bankAccount && $bankAccount->bank_name == "ธนาคารเอชเอสบีซี" ? 'selected' : ''}}>ธนาคารเอชเอสบีซี</option>
                                                        <option value="ธนาคารดอยซ์แบงก์ เอจี" {{$bankAccount && $bankAccount->bank_name == "ธนาคารดอยซ์แบงก์ เอจี" ? 'selected' : ''}}>ธนาคารดอยซ์แบงก์ เอจี</option>
                                                        <option value="ธนาคารแห่งประเทศจีน" {{$bankAccount && $bankAccount->bank_name == "ธนาคารแห่งประเทศจีน" ? 'selected' : ''}}>ธนาคารแห่งประเทศจีน</option>
                                                        <option value="ธนาคารเอเอ็นแซด" {{$bankAccount && $bankAccount->bank_name == "ธนาคารเอเอ็นแซด" ? 'selected' : ''}}>ธนาคารเอเอ็นแซด</option>
                                                        <option value="ธนาคารอินเดียนโอเวอร์ซี" {{$bankAccount && $bankAccount->bank_name == "ธนาคารอินเดียนโอเวอร์ซี" ? 'selected' : ''}}>ธนาคารอินเดียนโอเวอร์ซี</option>

                                    </select>
                                    <div id="banknameFeedback" class="invalid-feedback">
                                        โปรดเลือกธนาคาร
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="bankno">เลขบัญชีธนาคาร</label>
                                    <input type="text" class="form-control" id="bankno" name="bankno" placeholder="เลขบัญชีธนาคาร" value="{{$bankAccount ? $bankAccount->bank_no : ''}}">
                                    <div id="banknoFeedback" class="invalid-feedback">
                                        โปรดระบุเลขบัญชีธนาคาร
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="accountName">ชื่อบัญชีธนาคาร</label>
                                    <input type="text" class="form-control" id="accountName" name="accountName" placeholder="ชื่อบัญชีธนาคาร" value="{{$bankAccount ? $bankAccount->account_name : ''}}" autocomplete="off">
                                    <div id="banknoFeedback" class="invalid-feedback">
                                        โปรดระบุชื่อบัญชีธนาคาร
                                    </div>
                                </div>
                            </div>
                            
                            <button type="button" class="btn btn-primary float-right" id="update-bank">บันทึกข้อมูล</button>
                    </div>

                    <!-- End Form -->
                </div>
            </div>
            @endif

            <div class="card mb-3 mb-md-4">

                <div class="card-body">

                    <!-- Form -->
                    <div>
                            <div class="form-row mt-4">
                                <div class="col-12">
                                    <div class="font-weight-semi-bold h5 mb-3">ตั้งค่ารหัสผ่าน</div>
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <label for="old_password">รหัสผ่านปัจจุบัน</label>
                                    <input type="text" class="form-control" value="" id="old_password" name="old_password" placeholder="รหัสผ่านปัจจุบัน">
                                    <div id="old_passwordFeedback" class="invalid-feedback">
                                        โปรดระบุรหัสผ่านให้ครบถ้วน หรือ ต้องมากกว่า 4 ตัวอักษร
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <label for="password">รหัสผ่านใหม่</label>
                                    <input type="text" class="form-control" value="" id="password" name="password" placeholder="รหัสผ่านใหม่">
                                    <div id="passwordFeedback" class="invalid-feedback">
                                        โปรดระบุรหัสผ่านให้ครบถ้วน หรือ ต้องมากกว่า 4 ตัวอักษร
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <label for="password_confirm">ยืนยันรหัสผ่านใหม่</label>
                                    <input type="text" class="form-control" value="" id="password_confirm" name="password_confirm" placeholder="ยืนยันรหัสผ่านใหม่">
                                    <div id="password_confirmFeedback" class="invalid-feedback">
                                        รหัสผ่านให้ครบถ้วน หรือ รหัสผ่านไม่ตรงกัน
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-primary float-right" id="update-password">บันทึกข้อมูล</button>
                    </div>

                    <!-- End Form -->
                </div>
            </div>

            


@endsection
@section('scripts')
<script type="text/javascript" src="{{ mix('/js/profile.js') }}"></script>
@endsection