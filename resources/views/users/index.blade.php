

@extends('layouts.grain')

@section('title', 'ผู้ใช้งานทั้งหมด')

@section('content')
            <div class="card mb-3 mb-md-4">

                <div class="card-body">
                    <!-- Breadcrumb -->
                    <nav class="d-none d-md-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">ผู้ใช้งาน</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">ผู้ใช้งานทั้งหมด</li>
                        </ol>
                    </nav>
                    <!-- End Breadcrumb -->

                    <div class="mb-3 mb-md-4 d-flex justify-content-between">
                        <div class="h3 mb-0">ข้อมูลผู้ใช้งานในระบบ</div>
                    </div>


                    <!-- Users -->
                    @php
                        $count = 0;
                    @endphp

                    @if(count($users) > 0)
                    <div class="table-responsive-xl">
                        <table class="table text-nowrap mb-0">
                            <thead>
                            <tr>
                                <th class="font-weight-semi-bold border-top-0 py-2">อันดับ</th>
                                <th class="font-weight-semi-bold border-top-0 py-2">ชื่อ</th>

                                <th class="font-weight-semi-bold border-top-0 py-2">ตำแหน่ง</th>
                                <th class="font-weight-semi-bold border-top-0 py-2">ข้อมูลบัญชีธนาคาร</th>
                                <th class="font-weight-semi-bold border-top-0 py-2">ชื่อผู้ใช้งาน</th>
                                <th class="font-weight-semi-bold border-top-0 py-2">รหัสผ่าน</th>
                                <th class="font-weight-semi-bold border-top-0 py-2"></th>
                                <th class="font-weight-semi-bold border-top-0 py-2"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $u)
                            @php
                                $count = $count + 1;
                            @endphp
                            <tr>
                                <td class="py-3">{{$u->id}}</td>
                                <td class="align-middle py-3">
                                    <div class="d-flex align-items-center">
                                        {{$u->name}}
                                    </div>
                                </td>
                                <td class="py-3">
                                    @if($u->getRole() == "ผู้ดูแลระบบ")
                                    <span class="badge badge-danger">{{$u->getRole()}}</span>
                                    @endif
                                    @if($u->getRole() == "ช่างตัด")
                                    <span class="badge badge-primary">{{$u->getRole()}}</span>
                                    @endif
                                    @if($u->getRole() == "ช่างเย็บ")
                                    <span class="badge badge-success">{{$u->getRole()}}</span>
                                    @endif
                                </td>
                                <td class="py-3">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#account-{{$u->id}}"><i class="gd-eye"></i> ตรวจสอบ</button>
                                </td>
                                <td class="align-middle py-3">
                                    <div class="d-flex align-items-center">
                                        {{$u->username}}
                                    </div>
                                </td>
                                <td class="align-middle py-3">
                                    <div class="d-flex align-items-center">
                                        {{$u->password}}
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="position-relative">
                                        <span class="link-dark d-inline-block" data-toggle="modal" data-target="#edit-{{$u->id}}" style="cursor: pointer;" data-id="{{$u->id}}">
                                            <i class="gd-pencil icon-text"></i>
                                        </span>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="position-relative">
                                        <span class="link-dark d-inline-block remove" style="cursor: pointer;" data-id="{{$u->id}}">
                                            @if(Auth::user()->id != $u->id)<i class="gd-trash icon-text"></i>@endif
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="card-footer d-block d-md-flex align-items-center d-print-none">
                            <!--<div class="d-flex mb-2 mb-md-0">Showing 1 to 8 of 24 Entries</div> !-->

                            <nav class="d-flex ml-md-auto d-print-none" aria-label="Pagination">
                                {{$users}}
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
                    <!-- End Users -->
                </div>
            </div>

@endsection

@section('modal')
@foreach($users as $u)
<div class="modal fade" id="account-{{$u->id}}" tabindex="-1" aria-labelledby="account-{{$u->id}}-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="account-{{$u->id}}-label">รายละเอียดข้อมูลบัญชีธนาคาร</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if(!\App\BankAccount::where('user_id', $u->id)->first())
                    <div class="card">
                        <div class="card-body pt-0">
                            <div class="alert alert-warning" role="alert">
                                ไม่พบรายการข้อมูลบัญชีธนาคาร
                            </div>
                        </div>
                    </div>
                @endif

                @if(\App\BankAccount::where('user_id', $u->id)->first())
                    @php
                        $bankAccount = \App\BankAccount::where('user_id', "=", $u->id)->first();
                    @endphp

                    <div class="form-group col-12">
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
                        <div id="banknameFeedback" class="invalid-feedback">โปรดเลือกธนาคาร</div>
                    </div>
                                        <div class="form-group col-12">
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

                @endif
            </div>
            <div class="modal-footer">
                @if(\App\BankAccount::where('user_id', $u->id)->first())
                <button type="button" class="btn btn-primary update-bank" data-id="{{$u->id}}">บันทึกข้อมูล</button>
                @endif
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>
@endforeach





@foreach($users as $u)
<div class="modal fade" id="edit-{{$u->id}}" tabindex="-1" aria-labelledby="edit-{{$u->id}}-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-{{$u->id}}-label">รายละเอียดข้อมูลผู้ใช้งาน</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group col-12">
                    <label for="edit-name-{{$u->id}}">ชื่อ</label>
                    <input type="text" class="form-control" id="edit-name-{{$u->id}}" name="edit-name-{{$u->id}}" placeholder="ชื่อ" value="{{$u->name}}">
                    <div id="edit-nameFeedback-{{$u->id}}" class="invalid-feedback">
                        โปรดระบุชื่อ
                    </div>
                </div>
                <div class="form-group col-12">
                    <label for="edit-role-{{$u->id}}">ตำแหน่ง</label>
                    <select class="form-control mb-2" id="edit-role-{{$u->id}}">
                        <option {{$u->role == "admin" ? "selected" : ""}} value="admin">ผู้ดูแลระบบ</option>
                        <option {{$u->role == "tailor" ? "selected" : ""}} value="admin">ช่างตัด</option>
                        <option {{$u->role == "seamstress" ? "selected" : ""}} value="admin">ช่างเย็บ</option>
                    </select>
                    <div id="edit-roleFeedback-{{$u->id}}" class="invalid-feedback">โปรดเลือกตำแหน่ง</div>
                </div>
                <div class="form-group col-12">
                    <label for="edit-username-{{$u->id}}">ชื่อผู้ใช้งาน</label>
                    <input type="text" class="form-control" id="edit-username-{{$u->id}}" name="edit-username-{{$u->id}}" placeholder="ชื่อผู้ใช้งาน" value="{{$u->username}}" autocomplete="off">
                    <div id="edit-usernameFeedback-{{$u->id}}" class="invalid-feedback">
                        โปรดระบุชื่อชื่อผู้ใช้งาน
                    </div>
                </div>
                <div class="form-group col-12">
                    <label for="edit-password-{{$u->id}}">รหัสผ่าน</label>
                    <input type="text" class="form-control" id="edit-password-{{$u->id}}" name="edit-password-{{$u->id}}" placeholder="รหัสผ่าน" value="{{$u->password}}" autocomplete="off">
                    <div id="edit-passwordFeedback-{{$u->id}}" class="invalid-feedback">
                        โปรดระบุรหัสผ่าน
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary update-account" data-id="{{$u->id}}">บันทึกข้อมูล</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

@section('scripts')
<script type="text/javascript" src="{{ mix('/js/user-list.js') }}"></script>
@endsection