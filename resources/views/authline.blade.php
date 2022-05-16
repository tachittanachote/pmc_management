@extends('layouts.grain')

@section('title', 'ยืนยันตัวตน')

@section('content')

<div class="card mb-3 mb-md-4">
    @if(Auth::user()->line_id)
    <div class="card-body">
        <div class="alert alert-success" role="alert">ยืนยันตัวตนเรียบร้อยแล้ว</div>
    </div>
    @else
    <div class="card-body">
        <button class="btn btn-success w-100" id="auth">ยืนยันตัวตน</button>  
    </div>
    @endif
</div>



    


@endsection
@section('scripts')
<script type="text/javascript" src="{{ mix('/js/line.js') }}"></script>
@endsection
