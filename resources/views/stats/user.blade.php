<div class="row">
	<div class="col-md-6 col-xl-4 mb-3 mb-xl-4">
		<!-- Widget -->
		<div class="card flex-row align-items-center p-3 p-md-4 animate__animated animate__fadeInUp">
			<div class="icon icon-lg bg-primary rounded-circle mr-3">
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
				<h4 class="lh-1 mb-1">{{count($countworks)}}</h4>
				<h6 class="mb-0">จำนวนงานทั้งหมด</h6>
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
				<h4 class="lh-1 mb-1">{{number_format($salary, 2, ".", ",")}} บาท</h4>
				<h6 class="mb-0">จำนวนเงินที่ได้รับในรอบบิลนี้</h6>
			</div>
		</div>
		<!-- End Widget -->
	</div>

	<div class="col-md-6 col-xl-4 mb-3 mb-xl-4">
		<!-- Widget -->
		<a href="/scan">
			<div class="clickable">
				<div class="card flex-row align-items-center p-3 p-md-4 animate__animated animate__fadeInUp">
					<div class="icon icon-lg bg-primary rounded-circle mr-3">
						<i class="fas fa-qrcode text-white"></i>
					</div>
					<div>
						<h4 class="lh-1 mb-1">สแกนงาน</h4>
					</div>
				</div>
			</div>
		</a>
		<!-- End Widget -->
	</div>
</div>