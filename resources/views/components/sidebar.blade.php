<!-- Sidebar Nav -->
<aside id="sidebar" class="js-custom-scroll side-nav" style="overflow: visible;background: #f6f2ef;">
<ul id="sideNav" class="side-nav-menu side-nav-menu-top-level mb-0">
  <!-- Title -->
  <li class="sidebar-heading h6">แผงควบคุม</li>
  <!-- End Title -->

  <!-- Dashboard -->
  <li class="side-nav-menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
	<a class="side-nav-menu-link media align-items-center" href="{{route('dashboard')}}">
	  <span class="side-nav-menu-icon d-flex mr-3">
		<i class="gd-home"></i>
	  </span>
	  <span class="side-nav-fadeout-on-closed media-body">หน้าแรก</span>
	</a>
  </li>
  <!-- End Dashboard -->
  @if(Auth::user()->role == "seamstress")
  <li class="side-nav-menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
	<a class="side-nav-menu-link media align-items-center" href="{{route('work')}}">
	  <span class="side-nav-menu-icon d-flex mr-3">
		<i class="gd-plus"></i>
	  </span>
	  <span class="side-nav-fadeout-on-closed media-body">เพิ่มงาน</span>
	</a>
  </li>
  @endif

  @if(Auth::user()->role != "admin")
  <li class="side-nav-menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
	<a class="side-nav-menu-link media align-items-center" href="{{route('salary')}}">
	  <span class="side-nav-menu-icon d-flex mr-3">
		<i class="gd-bar-chart"></i>
	  </span>
	  <span class="side-nav-fadeout-on-closed media-body">รายงานยอด</span>
	</a>
  </li>
  @endif

  @if(Auth::user()->role == "admin")
  <!-- Title -->
  <li class="sidebar-heading h6">เมนู</li>
 
  <li class="side-nav-menu-item side-nav-has-menu {{ Request::is('user') ? 'active' : '' }}">
	<a class="side-nav-menu-link media align-items-center" href="#" data-target="#userMenu">
	  <span class="side-nav-menu-icon d-flex mr-3">
		<i class="gd-user"></i>
	  </span>
	  <span class="side-nav-fadeout-on-closed media-body">ผู้ใช้งาน</span>
	  <span class="side-nav-control-icon d-flex">
		<i class="gd-angle-right side-nav-fadeout-on-closed"></i>
	  </span>
	  <span class="side-nav__indicator side-nav-fadeout-on-closed"></span>
	</a>

	<ul id="userMenu" class="side-nav-menu side-nav-menu-second-level mb-0">
	  <li class="side-nav-menu-item {{ Request::is('user') ? 'active' : '' }}">
		<a class="side-nav-menu-link" href="{{route('users')}}">ผู้ใช้งานทั้งหมด</a>
	  </li>
	  <li class="side-nav-menu-item {{ Request::is('user') ? 'active' : '' }}">
		<a class="side-nav-menu-link" href="{{route('users.admin')}}">ผู้ดูแลระบบ</a>
	  </li>
	  	<li class="side-nav-menu-item {{ Request::is('user') ? 'active' : '' }}">
		<a class="side-nav-menu-link" href="{{route('users.tailor')}}">ช่างตัด</a>
	  </li>
		<li class="side-nav-menu-item {{ Request::is('user') ? 'active' : '' }}">
		<a class="side-nav-menu-link" href="{{route('users.seamstress')}}">ช่างเย็บ</a>
	  </li>
	  <li class="side-nav-menu-item {{ Request::is('user') ? 'active' : '' }}">
		<a class="side-nav-menu-link" href="{{route('users.view')}}">เพิ่มผู้ใช้งาน</a>
	  </li>
	</ul>
</li>

<li class="side-nav-menu-item side-nav-has-menu">
	<a class="side-nav-menu-link media align-items-center" href="#"
	   data-target="#productMenu">
	  <span class="side-nav-menu-icon d-flex mr-3">
		<i class="gd-view-grid"></i>
	  </span>
	  <span class="side-nav-fadeout-on-closed media-body">ประเภทชุด</span>
	  <span class="side-nav-control-icon d-flex">
		<i class="gd-angle-right side-nav-fadeout-on-closed"></i>
	  </span>
	  <span class="side-nav__indicator side-nav-fadeout-on-closed"></span>
	</a>
	
	<ul id="productMenu" class="side-nav-menu side-nav-menu-second-level mb-0">
	  <li class="side-nav-menu-item {{ Request::is('user') ? 'active' : '' }}">
		<a class="side-nav-menu-link" href="{{route('products')}}">จัดการประเภทชุด</a>
	  </li>
	  <li class="side-nav-menu-item {{ Request::is('user') ? 'active' : '' }}">
		<a class="side-nav-menu-link" href="{{route('products.view')}}">เพิ่มประเภทชุด</a>
	  </li>
	</ul>

  </li>

  <li class="side-nav-menu-item side-nav-has-menu">
	<a class="side-nav-menu-link media align-items-center" href="#"
	   data-target="#reportMenu">
	  <span class="side-nav-menu-icon d-flex mr-3">
		<i class="gd-layout-cta-btn-right"></i>
	  </span>
	  <span class="side-nav-fadeout-on-closed media-body">รายงาน</span>
	  <span class="side-nav-control-icon d-flex">
		<i class="gd-angle-right side-nav-fadeout-on-closed"></i>
	  </span>
	  <span class="side-nav__indicator side-nav-fadeout-on-closed"></span>
	</a>
	
	<ul id="reportMenu" class="side-nav-menu side-nav-menu-second-level mb-0">
	  <li class="side-nav-menu-item {{ Request::is('report') ? 'active' : '' }}">
		<a class="side-nav-menu-link" href="{{route('report')}}">รายงานยอดทั้งหมด</a>
	  </li>
	</ul>

  </li>

  <li class="side-nav-menu-item side-nav-has-menu">
	<a class="side-nav-menu-link media align-items-center" href="#"
	   data-target="#addWork">
	  <span class="side-nav-menu-icon d-flex mr-3">
		<i class="gd-layout-cta-btn-right"></i>
	  </span>
	  <span class="side-nav-fadeout-on-closed media-body">จัดการงาน</span>
	  <span class="side-nav-control-icon d-flex">
		<i class="gd-angle-right side-nav-fadeout-on-closed"></i>
	  </span>
	  <span class="side-nav__indicator side-nav-fadeout-on-closed"></span>
	</a>
	
	<ul id="addWork" class="side-nav-menu side-nav-menu-second-level mb-0">
	  <li class="side-nav-menu-item {{ Request::is('addworkadmin') ? 'active' : '' }}">
		<a class="side-nav-menu-link" href="{{route('addworkadmin')}}">เพิ่มงาน</a>
	  </li>
	</ul>

  </li>


	<li class="side-nav-menu-item side-nav-has-menu">
		<a class="side-nav-menu-link media align-items-center" href="#"
		data-target="#announceMenu">
		<span class="side-nav-menu-icon d-flex mr-3">
			<i class="gd-settings"></i>
		</span>
		<span class="side-nav-fadeout-on-closed media-body">ประกาศ</span>
		<span class="side-nav-control-icon d-flex">
			<i class="gd-angle-right side-nav-fadeout-on-closed"></i>
		</span>
		<span class="side-nav__indicator side-nav-fadeout-on-closed"></span>
		</a>
		
		<ul id="announceMenu" class="side-nav-menu side-nav-menu-second-level mb-0">
			<li class="side-nav-menu-item {{ Request::is('announce') ? 'active' : '' }}">
				<a class="side-nav-menu-link" href="{{route('announce')}}">จัดการประกาศ</a>
			</li>
		</ul>

	</li>


	@endif


  
</ul>
</aside>