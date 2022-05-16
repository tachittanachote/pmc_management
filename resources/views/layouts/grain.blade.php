<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <!-- Styles -->
    <link href="{{ mix('graindashboard/css/graindashboard.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+New:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" integrity="sha512-BnbUDfEUfV0Slx6TunuB042k9tuKe3xrD6q4mg5Ed72LTgzDIcLPxg6yI2gcMFRyomt+yJJxE+zJwNmxki6/RA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" integrity="sha512-c42qTSw/wPZ3/5LBzD+Bw5f7bSF2oxou6wEb+I/lqeaKV5FDIfMvvRp772y4jcJLKuGUOpbJMdg/BTl50fJYAw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  </head>

  <body class="has-sidebar has-fixed-sidebar-and-header">
	@include('components.header')

    <main class="main">
	  @include('components.sidebar')
      

      <div class="content">
        <div class="py-4 px-3 px-md-4">

			    @yield('content')
      

        </div>
		
		    @include('components.footer')

      </div>
    </main>


@yield('modal')

@if(count(\App\Announce::get()) > 0 && Auth::user()->role != "admin")
  @if(\App\Announce::first()->status == "on")
    <div class="modal fade" id="announce" tabindex="-1" aria-labelledby="announce-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="announce-label">ประกาศจากระบบ</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body text-center">
              <img src="/storage/upload/{{\App\Announce::first()->image_url}}" alt="ประกาศจากระบบ" class="img-fluid"/>
              <h4 class="text-center mt-2">{{\App\Announce::first()->message}}</h4>         
              
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary w-100" id="close-popup" data-dismiss="modal">ตกลง</button>
                <div class="text-center w-100">
                  <input type="checkbox" class="form-check-input" id="understand">
                  <label class="form-check-label" for="understand">เข้าใจแล้วไม่ต้องแสดงอีก</label>
                </div>   
              </div>
            </div>
          </div>
        </div>
    </div>
  @endif
@endif

	<script src="{{ mix('graindashboard/js/graindashboard.js') }}"></script>
	<script src="{{ mix('graindashboard/js/graindashboard.vendor.js') }}"></script>
  <script src="{{ mix('js/app.js') }}" defer></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  @yield('scripts')

  @if(count(\App\Announce::get()) > 0 && Auth::user()->role != "admin")
    @if(\App\Announce::first()->status == "on")
      <script>
        $(document).ready(() => {
            const understand = localStorage.getItem("understand")
            const time = localStorage.getItem("time")

            const d = new Date();
            const now = Math.floor(d.getTime()/1000)
            var checkTime = now - parseInt(time)

            if(checkTime >= 2500) {
              localStorage.removeItem("understand")
              localStorage.removeItem("time")
            }

            if(!understand || understand !== "1") {
              $('#announce').modal('show')
            }
        })
      
      </script>
    @endif
  @endif
  
  </body>
</html>