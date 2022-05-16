@extends('layouts.grain')

@section('title', 'เพิ่มผู้ใช้งาน')

@section('content')
            <div class="card mb-3 mb-md-4">

                <div class="card-body">
                    <!-- Breadcrumb -->
                    <nav class="d-none d-md-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('user.profile')}}">ผู้ใช้งาน</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">เพิ่มผู้ใช้งาน</li>
                        </ol>
                    </nav>
                    <!-- End Breadcrumb -->

                    <div class="mb-3 mb-md-4 d-flex justify-content-between">
                        <div class="h3 mb-0">เพิ่มข้อมูลผู้ใช้งานเข้าสู่ระบบ</div>
                    </div>

                    <div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="name">ชื่อ</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="กำหนดชื่อ" value="" autocomplete="off">
                                    <div id="nameFeedback" class="invalid-feedback">
                                        โปรดระบุชื่อให้ครบถ้วน
                                    </div>
                                </div>
                            </div>

                    </div>

                    <div>
                            <div class="form-row">
                                <div class="form-group col-12 col-md-6">
                                    <label for="username">ชื่อผู้ใช้งาน</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="กำหนดชื่อผู้ใช้งาน" autocomplete="off">
                                    <div id="usernameFeedback" class="invalid-feedback">
                                        โปรดระบุชื่อผู้ใช้งานให้ครบถ้วน
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="password">รหัสผ่าน</label>
                                    <input type="text" class="form-control" id="password" name="password" placeholder="กำหนดรหัสผ่าน" autocomplete="off">
                                    <div id="passwordFeedback" class="invalid-feedback">
                                        โปรดระบุรหัสผ่านให้ครบถ้วน
                                    </div>
                                </div>
                            </div>
                    </div>

                    <div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="position">ตำแหน่ง</label>
                                <select class="form-control mb-2" id="position">
                                    <option value="" disabled selected hidden>เลือกตำแหน่ง</option>
                                    <option value="admin">ผู้ดูแลระบบ</option>
                                    <option value="tailor">ช่างตัด</option>
                                    <option value="seamstress">ช่างเย็บ</option>
                                </select>
                                <div id="positionFeedback" class="invalid-feedback">
                                    โปรดเลือกตำแหน่ง
                                </div>
                                <button type="button" class="btn btn-primary float-right" id="add-user">เพิ่มข้อมูล</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


@endsection
@section('scripts')
<script type="text/javascript" src="{{ mix('/js/user.js') }}"></script>
@endsection