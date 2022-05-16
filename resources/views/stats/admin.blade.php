<div class="row">
	<div class="col-md-6 col-xl-4 mb-3 mb-xl-4">
		<!-- Widget -->
		<div class="card flex-row align-items-center p-3 p-md-4 animate__animated animate__fadeInUp">
			<div class="icon icon-lg bg-primary-darker rounded-circle mr-3">
				<i class="gd-crown icon-text d-inline-block text-white"></i>
			</div>
			<div>
				<h4 class="lh-1 mb-1">{{Auth::user()->getRole()}}</h4>
				<h6 class="mb-0">ตำแหน่ง</h6>
			</div>
		</div>
		<!-- End Widget -->
	</div>

	<div class="col-md-6 col-xl-4 mb-3 mb-xl-4">
		<!-- Widget -->
		<div class="card flex-row align-items-center p-3 p-md-4 animate__animated animate__fadeInUp">
			<div class="icon icon-lg bg-secondary rounded-circle mr-3">
				<i class="gd-layers-alt icon-text d-inline-block text-white"></i>
			</div>
			<div>
				<h4 class="lh-1 mb-1">{{$tworkCount + $sworkCount}} งาน</h4>
				<h6 class="mb-0">จำนวนงานทั้งหมดในรอบบิลนี้</h6>
			</div>
		</div>
		<!-- End Widget -->
	</div>

	<div class="col-md-6 col-xl-4 mb-3 mb-xl-4">
		<!-- Widget -->
		<div class="card flex-row align-items-center p-3 p-md-4 animate__animated animate__fadeInUp">
			<div class="icon icon-lg bg-warning rounded-circle mr-3">
				<i class="gd-money icon-text d-inline-block text-grey"></i>
			</div>
			<div>
				<h4 class="lh-1 mb-1">{{number_format($total_seamstress_price + $total_tailor_price, 2, ".", ",")}} บาท</h4>
				<h6 class="mb-0">ยอดรวมทั้งหมดในรอบบิลนี้</h6>
			</div>
		</div>
		<!-- End Widget -->
	</div>
</div>

<div class="row">

	<div class="col-md-6 col-xl-4 mb-3 mb-xl-4">
		<!-- Widget -->
		<div class="card flex-row align-items-center p-3 p-md-4 animate__animated animate__fadeInUp animate__slow">
			<div class="icon icon-lg bg-warning rounded-circle mr-3">
				<i class="gd-money icon-text d-inline-block text-grey"></i>
			</div>
			<div>
				<h4 class="lh-1 mb-1">{{number_format($total_seamstress_price, 2, ".", ",")}} บาท</h4>
				<h6 class="mb-0">รายได้ช่างเย็บทั้งหมดในรอบบิลนี้</h6>
			</div>
		</div>
		<!-- End Widget -->
	</div>

	<div class="col-md-6 col-xl-4 mb-3 mb-xl-4">
		<!-- Widget -->
		<div class="card flex-row align-items-center p-3 p-md-4 animate__animated animate__fadeInUp animate__slow">
			<div class="icon icon-lg bg-warning rounded-circle mr-3">
				<i class="gd-money icon-text d-inline-block text-grey"></i>
			</div>
			<div>
				<h4 class="lh-1 mb-1">{{ number_format($total_tailor_price, 2, ".", ",")}} บาท</h4>
				<h6 class="mb-0">รายได้ช่างตัดทั้งหมดในรอบบิลนี้</h6>
			</div>
		</div>
		<!-- End Widget -->
	</div>

	<div class="col-md-6 col-xl-4 mb-3 mb-xl-4">
		<!-- Widget -->
		<div class="card flex-row align-items-center p-3 p-md-4 animate__animated animate__fadeInUp animate__slow">
			<div class="icon icon-lg bg-warning rounded-circle mr-3">
				<i class="gd-user icon-text d-inline-block text-grey"></i>
			</div>
			<div>
				<h4 class="lh-1 mb-1">{{ \App\User::where('role', '!=', 'admin')->count()}} คน</h4>
				<h6 class="mb-0">พนักงาน/ลูกจ้างทั้งหมด</h6>
			</div>
		</div>
		<!-- End Widget -->
	</div>


</div>

<div class="row">

	<div class="col-md-6 col-xl-4 mb-3 mb-xl-4">
		<!-- Widget -->
		<div class="card flex-row align-items-center p-3 p-md-4 animate__animated animate__fadeInUp animate__slow">
			<div class="icon icon-lg bg-warning rounded-circle mr-3">
				<i class="gd-layers-alt icon-text d-inline-block text-grey"></i>
			</div>
			<div>
				<h4 class="lh-1 mb-1">{{$tworkCount}} งาน</h4>
				<h6 class="mb-0">งานช่างตัดในรอบบิลนี้</h6>
			</div>
		</div>
		<!-- End Widget -->
	</div>

	<div class="col-md-6 col-xl-4 mb-3 mb-xl-4">
		<!-- Widget -->
		<div class="card flex-row align-items-center p-3 p-md-4 animate__animated animate__fadeInUp animate__slow">
			<div class="icon icon-lg bg-warning rounded-circle mr-3">
				<i class="gd-layers-alt icon-text d-inline-block text-grey"></i>
			</div>
			<div>
				<h4 class="lh-1 mb-1">{{$sworkCount}} งาน</h4>
				<h6 class="mb-0">งานช่างเย็บในรอบบิลนี้</h6>
			</div>
		</div>
		<!-- End Widget -->
	</div>

	<div class="col-md-6 col-xl-4 mb-3 mb-xl-4">
		<a href="/scan">
			<div class="clickable">
				<div class="card flex-row align-items-center p-3 p-md-4 animate__animated animate__slow">
					<div class="icon icon-lg bg-primary rounded-circle mr-3">
						<i class="fas fa-qrcode text-white"></i>
					</div>
					<div>
						<h4 class="lh-1 mb-1">สแกนงาน</h4>
					</div>
				</div>
			</div>
		</a>
	</div>


</div>

<div class="row">

	<div class="col-md-6 col-xl-4 mb-3 mb-xl-4">
		<!-- Widget -->
		<div class="card flex-row align-items-center p-3 p-md-4 animate__animated animate__fadeInUp animate__slow">
			<div class="icon icon-lg bg-warning rounded-circle mr-3">
				<i class="gd-user icon-text d-inline-block text-grey"></i>
			</div>
			<div>
				<h4 class="lh-1 mb-1">{{count(\App\User::where('role', 'tailor')->get())}} คน</h4>
				<h6 class="mb-0">ช่างตัด</h6>
			</div>
		</div>
		<!-- End Widget -->
	</div>

	<div class="col-md-6 col-xl-4 mb-3 mb-xl-4">
		<!-- Widget -->
		<div class="card flex-row align-items-center p-3 p-md-4 animate__animated animate__fadeInUp animate__slow">
			<div class="icon icon-lg bg-warning rounded-circle mr-3">
				<i class="gd-user icon-text d-inline-block text-grey"></i>
			</div>
			<div>
				<h4 class="lh-1 mb-1">{{count(\App\User::where('role', 'seamstress')->get())}} คน</h4>
				<h6 class="mb-0">ช่างเย็บ</h6>
			</div>
		</div>
		<!-- End Widget -->
	</div>

	<div class="col-md-6 col-xl-4 mb-3 mb-xl-4">
	</div>


</div>
