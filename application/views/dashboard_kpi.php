<?php $tanggal = '15'; ?>
<div class="content-wrapper">
	<input type="hidden" id="tamplate" value="">
	<input type="hidden" id="session_kantor" value="<?php echo $this->session->userdata('kantor'); ?>">
	<input type="hidden" id="session_jabatan" value="<?php echo $this->session->userdata('jabatan'); ?>">
	<input type="hidden" id="session_id_user" value="<?php echo $this->session->userdata('id'); ?>">
	<input type="hidden" id="NowDate" value="<?php echo date('Y-m-d'); ?>">
	<input type="hidden" id="bln" value="<?php echo $bulan; ?>">
	<input type="hidden" id="thn" value="<?php echo $tahun; ?>">
	<input type="hidden" id="load_page" value="false">

	<div class="col-md-12">
		<div class="row mt-5">
			<div class="col-12 text-xs-center text-xl-left text-lg-left text-md-left text-sm-center">
				<a href="<?= base_url('tools'); ?>" class="btn btn-secondary btn-sm mt-n3"><i class="mdi mdi-keyboard-backspace"></i>Menu Tools</a>
			</div>
		</div>

		<div class="row mt-2">
			<div class="col-md-3 text-lg-left text-md-center text-sm-center text-center">
				Bulan : <b><?php echo ubahBulan($bulan); ?></b><br>
				Tahun : <b><?php echo $tahun; ?></b><br>
				Pilihan Kantor :
				<b>
					<?php echo namaKantor($kantor); ?>
				</b>
			</div>
			<div class="col-md-6 text-lg-center text-md-center text-sm-center text-center">
				Filter Data
				<form action="<?php echo base_url('kpi/dashboard_kpi'); ?>" method="post" class="form-inline justify-content-center mt-2">
					<select name="bulan" id="bulan" class="custom-select custom-select-sm my-1 mr-sm-2">
						<!-- looping bulan 1 - 12, dan jika bulan kurang dari 10 maka akan ditambahkan 0 didepannya -->
						<?php
							for ($i = 1; $i <= 12; $i++) {
								if ($i < 10) {
									$i = '0' . $i;
								}
						?>
							<option value="<?php echo $i; ?>" <?php if ($bulan == $i) {
																	echo ('selected');
																} ?>> <?php echo ubahBulan($i); ?></option>
						<?php } ?>
						<!-- akhir looping -->
					</select>
					<select name="tahun" id="tahun" class="custom-select custom-select-sm my-1 mr-sm-2">
						<!-- looping tahun dari 2019 s/d tahun ini -->
						<?php
							for ($thn = 2019; $thn <= date('Y'); $thn++) {
						?>
							<option value="<?= $thn; ?>" <?php if ($tahun == $thn) {
																echo ('selected');
															} ?>><?= $thn; ?></option>
						<?php } ?>
						<!-- akhir looping -->
					</select>
					<!-- kondisi dimana kantor cabang tidak bisa melihat data dari kantor pusat, sedangkan kantor pusat bisa melihat yang cabang -->
					<?php if($this->session->userdata('kantor') !== '02'){ ?>
					<select name="kantor" id="kantor" class="custom-select custom-select-sm my-1 mr-sm-2">
						<option value="01" <?php if ($kantor == '01') {
												echo ('selected');
											} ?>>Pusat</option>
						<option value="02" <?php if ($kantor == '02') {
												echo ('selected');
											} ?>>Cabang Cilodong</option>
					</select>
					<?php } ?>
					<button type="submit" id="btnFilter" class="btn btn-sm btn-primary">Filter</button>
				</form>
			</div>
			<div class="col-md-3 text-lg-right text-md-center text-sm-center text-center">
				<br>
				User :
				<b><?php echo ucfirst($this->session->userdata('username')); ?></b><br>
				Kantor :
				<b><?php echo namaKantor($this->session->userdata('kantor')); ?></b>
			</div>
		</div>
	</div>
	<hr>

	<!-- loading -->
	<center>
		<div id="loader" style="position: absolute; left: 50%;">
			<div class="text-center" style="position: relative; left: -50%; z-index:1000;">
				<div class="spinner-border text-facebook" role="status" style="width: 2rem; height: 2rem;">
					<span class="sr-only">Loading...</span>
				</div><br>
				<b>LOADING...</b>
			</div>
		</div>
	</center>
	<!-- end loading -->

	<!-- handle data jika null -->
	<span class="spedo">
		<div class="col-md-12">
			<div class="row justify-content-center">
				<div id="lendingNull">

				</div>&nbsp;
				<div id="nplNull">

				</div>&nbsp;
				<div id="crNull">

				</div>&nbsp;
				<div id="cr_ao_Null">

				</div>&nbsp;
				<div id="bzNull">

				</div>&nbsp;
				<div id="nsNull">

				</div>&nbsp;
			</div>
		</div>
	</span>
	<!-- end handle data jika null -->

	<div class="row justify-content-center">
		<?php if ($lending_cabang || $npl_cabang || $cr_cabang || $cr_cabang_ao || $bz_cabang || $ns_cabang) { ?>

			<!-- Lending -->
			<?php 
			
			if ($lending_cabang != null) { 
				$tampung = getDataSpedo($lending_cabang[0]->data_spedo);	 
			?>
				<span class="rounded-circle spedo" data-popover="popover" data-content='<b> Lending : <?= ubahJuta($lending_cabang[0]->jml_value); ?> <br> Lending (%) : <?= ambil2Angka($lending_cabang[0]->lending) . ' %'; ?> <br> Status : <?= getStatus($lending_cabang[0]->jml_value, $tampung[0], $tampung[3], $tampung[6], $tampung[9]); ?> </b>' data-html='true' data-placement='top' data-trigger='hover'>
					<a class="rounded-circle" href="" data-toggle="modal" data-target="#modal_lending">
						<canvas class="mt-2 mb-2 mx-2 rounded-circle" id="lending" data-type="radial-gauge" data-width="300" data-height="300" data-units="<?php echo $lending_cabang[0]->unit; ?>" data-title="<?= $lending_cabang[0]->title; ?>" data-value="<?php echo $lending_cabang[0]->jml_value; ?>" data-min-value="0" data-max-value="<?php echo $lending_cabang[0]->jml_max_value; ?>" data-major-ticks="<?php echo $lending_cabang[0]->mayor_ticks; ?>" data-minor-ticks="<?php echo $lending_cabang[0]->minor_ticks; ?>" data-stroke-ticks="true" data-highlights='<?php echo $lending_cabang[0]->data_spedo; ?>' data-color-plate="black" data-color-major-ticks="#000000" data-color-minor-ticks="#000000" data-color-title="#fff" data-color-units="#ccc" data-color-numbers="#eee" data-color-needle="rgba(240, 128, 128, 1)" data-color-needle-end="rgba(255, 160, 122, .9)" data-value-box="true" data-animate-on-init="true" data-animation-rule="bounce" data-animation-duration="1500">
						</canvas>
					</a>
				</span>
			<?php
			} else {
				echo '<span id="nullLending" data=""></span>';
			} ?>
			<!-- /Lending -->

			<!-- NPL -->
			<?php 

			 if ($npl_cabang != null) { 
				$tampung = getDataSpedo($npl_cabang[0]->data_spedo);	 
			?>
				<span class="rounded-circle spedo" data-popover="popover" data-content='<b>NPL : <?= ambil2Angka($npl_cabang[0]->jml_value) . " %"; ?> <br> Status : <?= getStatusNPL($npl_cabang[0]->jml_value, $tampung[0], $tampung[3], $tampung[6], $tampung[9]); ?> <br> Baki debet NPL : <?php echo rupiah($npl_cabang[0]->jml_bd_npl); ?> <br> Total Baki debet : <?php echo rupiah($npl_cabang[0]->jml_bd); ?></br>' data-html='true' data-placement='top' data-trigger='hover'>
					<a class="rounded-circle" href="" data-toggle="modal" data-target="#modal_npl">
						<canvas class="mt-2 mb-2 mx-2 rounded-circle" id="nplkantor" data-type="radial-gauge" data-width="300" data-height="300" data-units="<?php echo $npl_cabang[0]->unit; ?>" data-title="<?= $npl_cabang[0]->title; ?>" data-value="<?php echo $npl_cabang[0]->jml_value; ?>" data-min-value="0" data-max-value="<?php echo $npl_cabang[0]->jml_max_value; ?>" data-major-ticks="<?php echo $npl_cabang[0]->mayor_ticks; ?>" data-minor-ticks="<?php echo $npl_cabang[0]->minor_ticks; ?>" data-stroke-ticks="true" data-highlights='<?php echo $npl_cabang[0]->data_spedo; ?>' data-color-plate="#010101" data-color-major-ticks="#000000" data-color-minor-ticks="#000000" data-color-title="#fff" data-color-units="#ccc" data-color-numbers="#eee" data-color-needle="rgba(240, 128, 128, 1)" data-color-needle-end="rgba(255, 160, 122, .9)" data-value-box="true" data-animate-on-init="true" data-animation-rule="bounce" data-animation-duration="1500">
						</canvas>
					</a>
				</span>
			<?php
			} else {
				echo '<span id="nullNpl" data=""></span>';
			} ?>
			<!-- /NPL -->

			<!-- Collection Ratio -->
			<?php 
			
			if ($cr_cabang != null) {
				$tampung = getDataSpedo($cr_cabang[0]->data_spedo);	 
			?>
				<span class="rounded-circle spedo" data-popover="popover" data-content='<b>CR : <?= ambil2Angka($cr_cabang[0]->jml_value) . " %"; ?> <br> Status : <?= getStatus($cr_cabang[0]->jml_value, $tampung[0], $tampung[3], $tampung[6], $tampung[9]); ?> <br> Jumlah tagihan : <?= rupiah($cr_cabang[0]->jml_tagihan); ?> <br> Jumlah bayar : <?= rupiah($cr_cabang[0]->jml_bayar); ?></b>' data-html='true' data-placement='top' data-trigger='hover'>
					<a href="" data-toggle="modal" data-target="#modal_cr">
						<canvas class="mt-2 mb-2 mx-2 rounded-circle" id="cr" data-type="radial-gauge" data-width="300" data-height="300" data-units="<?php echo $cr_cabang[0]->unit; ?>" data-title="<?= $cr_cabang[0]->title . " Kolektor"; ?>" data-value="<?php echo $cr_cabang[0]->jml_value; ?>" data-min-value="0" data-max-value="<?php echo $cr_cabang[0]->jml_max_value; ?>" data-major-ticks="<?php echo $cr_cabang[0]->mayor_ticks; ?>" data-minor-ticks="<?php echo $cr_cabang[0]->minor_ticks; ?>" data-stroke-ticks="true" data-highlights='<?php echo $cr_cabang[0]->data_spedo; ?>' data-color-plate="#010101" data-color-major-ticks="#000000" data-color-minor-ticks="#000000" data-color-title="#fff" data-color-units="#ccc" data-color-numbers="#eee" data-color-needle="rgba(240, 128, 128, 1)" data-color-needle-end="rgba(255, 160, 122, .9)" data-value-box="true" data-animate-on-init="true" data-animation-rule="bounce" data-animation-duration="1500">
						</canvas>
					</a>
				</span>
			<?php
			} else {
				echo '<span id="nullCr" data=""></span>';
			} ?>

			<!-- /Collection Ratio AO -->
			<?php 
			
			if ($cr_cabang_ao != null) {
				$tampung = getDataSpedo($cr_cabang_ao[0]->data_spedo);	 
			?>
				<span class="rounded-circle spedo" data-popover="popover" data-content='<b>CR : <?= ambil2Angka($cr_cabang_ao[0]->jml_value) . " %"; ?> <br> Status : <?= getStatus($cr_cabang_ao[0]->jml_value, $tampung[0], $tampung[3], $tampung[6], $tampung[9]); ?> <br> Jumlah tagihan : <?= rupiah($cr_cabang_ao[0]->jml_tagihan); ?> <br> Jumlah bayar : <?= rupiah($cr_cabang_ao[0]->jml_bayar); ?></b>' data-html='true' data-placement='top' data-trigger='hover'>
					<a href="" data-toggle="modal" data-target="#modal_cr_ao">
						<canvas class="mt-2 mb-2 mx-2 rounded-circle" id="cr_ao" data-type="radial-gauge" data-width="300" data-height="300" data-units="<?php echo $cr_cabang_ao[0]->unit; ?>" data-title="<?= $cr_cabang_ao[0]->title . " AO"; ?>" data-value="<?php echo $cr_cabang_ao[0]->jml_value; ?>" data-min-value="0" data-max-value="<?php echo $cr_cabang_ao[0]->jml_max_value; ?>" data-major-ticks="<?php echo $cr_cabang_ao[0]->mayor_ticks; ?>" data-minor-ticks="<?php echo $cr_cabang_ao[0]->minor_ticks; ?>" data-stroke-ticks="true" data-highlights='<?php echo $cr_cabang_ao[0]->data_spedo; ?>' data-color-plate="#010101" data-color-major-ticks="#000000" data-color-minor-ticks="#000000" data-color-title="#fff" data-color-units="#ccc" data-color-numbers="#eee" data-color-needle="rgba(240, 128, 128, 1)" data-color-needle-end="rgba(255, 160, 122, .9)" data-value-box="true" data-animate-on-init="true" data-animation-rule="bounce" data-animation-duration="1500">
						</canvas>
					</a>
				</span>
			<?php
			} else {
				echo '<span id="nullCr_ao" data=""></span>';
			} ?>
			<!-- /Collection Ratio AO -->

			<!-- Bucket Zero -->
			<?php 
			
			if ($bz_cabang != null) { 
				$tampung = getDataSpedo($bz_cabang[0]->data_spedo);	 
			?>
				<span class="rounded-circle spedo" data-popover="popover" data-content='<b>BZ : <?= ambil2Angka($bz_cabang[0]->jml_value) . " %"; ?> <br> Status : <?= getStatus($bz_cabang[0]->jml_value, $tampung[0], $tampung[3], $tampung[6], $tampung[9]); ?> <br> Jumlah tagihan : <?= rupiah($bz_cabang[0]->jml_tagihan); ?> <br> Jumlah bayar : <?= rupiah($bz_cabang[0]->jml_bayar); ?></b>' data-html='true' data-placement='top' data-trigger='hover'>
					<a class="rounded-circle" href="" data-toggle="modal" data-target="#modal_bz">
						<canvas class="mt-2 mb-2 mx-2 rounded-circle" id="bz" data-type="radial-gauge" data-width="300" data-height="300" data-units="<?php echo $bz_cabang[0]->unit; ?>" data-title="<?= $bz_cabang[0]->title; ?>" data-value="<?php echo $bz_cabang[0]->jml_value; ?>" data-min-value="0" data-max-value="<?php echo $bz_cabang[0]->jml_max_value; ?>" data-major-ticks="<?php echo $bz_cabang[0]->mayor_ticks; ?>" data-minor-ticks="<?php echo $bz_cabang[0]->minor_ticks; ?>" data-stroke-ticks="true" data-highlights='<?php echo $bz_cabang[0]->data_spedo; ?>' data-color-plate="#010101" data-color-major-ticks="#000000" data-color-minor-ticks="#000000" data-color-title="#fff" data-color-units="#ccc" data-color-numbers="#eee" data-color-needle="rgba(240, 128, 128, 1)" data-color-needle-end="rgba(255, 160, 122, .9)" data-value-box="true" data-animate-on-init="true" data-animation-rule="bounce" data-animation-duration="1500">
						</canvas>
					</a>
				</span>
			<?php
			} else {
				echo '<span id="nullBz" data=""></span>';
			} ?>
			<!-- /Bucket Zero -->

			<!-- Non Starter -->
			<?php 
			
			if ($ns_cabang != null) { 
				$tampung = getDataSpedo($ns_cabang[0]->data_spedo);	 
			?>
				<span class="rounded-circle spedo" data-popover="popover" data-content="<b>Non Starter : <?= ambil2Angka($ns_cabang[0]->jml_value) . " %"; ?> <br> Status : <?= getStatusNPL($ns_cabang[0]->jml_value, $tampung[0], $tampung[3], $tampung[6], $tampung[9]); ?> <br> Jumlah Pinjaman FID NS : <?= rupiah($ns_cabang[0]->jml_pinjaman_fid_ns); ?> <br> Jumlah Pinjaman NS : <?= rupiah($ns_cabang[0]->jml_pinjaman_ns); ?> </b>" data-html="true" data-placement="top" data-trigger="hover">
					<a class="rounded-circle" href="" data-toggle="modal" data-target="#modal_ns">
						<canvas class="mt-2 mb-2 mx-2 rounded-circle" id="bz" data-type="radial-gauge" data-width="300" data-height="300" data-units="<?php echo $ns_cabang[0]->unit; ?>" data-title="<?= $ns_cabang[0]->title; ?>" data-value="<?php echo $ns_cabang[0]->jml_value; ?>" data-min-value="0" data-max-value="<?php echo $ns_cabang[0]->jml_max_value; ?>" data-major-ticks="<?php echo $ns_cabang[0]->mayor_ticks; ?>" data-minor-ticks="<?php echo $ns_cabang[0]->minor_ticks; ?>" data-stroke-ticks="true" data-highlights='<?php echo $ns_cabang[0]->data_spedo; ?>' data-color-plate="#010101" data-color-major-ticks="#000000" data-color-minor-ticks="#000000" data-color-title="#fff" data-color-units="#ccc" data-color-numbers="#eee" data-color-needle="rgba(240, 128, 128, 1)" data-color-needle-end="rgba(255, 160, 122, .9)" data-value-box="true" data-animate-on-init="true" data-animation-rule="bounce" data-animation-duration="1500">
						</canvas>
					</a>
				</span>
			<?php
			} else {
				echo '<span id="nullNS" data=""></span>';
			} ?>
			<!-- /Non Starter -->

		<?php } else { ?>
			<span class="spedo">
				<div class="row align-content-center align-items-center justify-content-center text-center">
					<h2 class="text-danger">
						<b><i class="mdi mdi-alert"></i> 204</b> <br>
						<hr>
						Data Dengan Filter : <br>
						<b><?= ubahBulan($bulan) . ' - ' . $tahun; ?></b> <br>
						Tidak Ditemukan
					</h2>
				</div>
			</span>
		<?php }; ?>
	</div>


	<!-- Modal Lending -->
	<div class="modal fade" id="modal_lending" tabindex="1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl modal-dialog-scrollable" role="dialog">
			<div class="modal-content">
				<div class="modal-header bg-light">
					<h5 class="modal-title" id="exampleModalLongTitle">Data Lending Per AO
						<p>Bulan : <?php echo ubahBulan($bulan) . "&nbsp" . $tahun ?></p>
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row justify-content-center">
						<?php 
						 foreach ($lending_ao as $res) { 
							$tampung = getDataSpedo($res->data_spedo);	 
						?>
							<span class="rounded-circle" data-popover="popover" data-content='<b> Lending : <?= ubahJuta($res->jml_value); ?> <br> Lending (%) : <?= ambil2Angka($res->lending) . ' %'; ?> <br> Status : <?= getStatus($res->jml_value, $tampung[0], $tampung[3], $tampung[6], $tampung[9]); ?> </b>' data-html='true' data-placement='top' data-trigger='hover'>
								<a class="rounded-circle" href="#detail_lending_ao" data-toggle="modal" data-target="#detail_lending_ao<?php echo $res->kode_group2; ?>" data-backdrop="false">
									<canvas class="mt-2 mb-2 mx-2 rounded-circle" id="bz" data-type="radial-gauge" data-width="300" data-height="300" data-units="<?php echo $res->unit; ?>" data-title="<?php echo $res->deskripsi_group2; ?>" data-value="<?php echo $res->jml_value; ?>" data-min-value="0" data-max-value="<?php echo $res->jml_max_value; ?>" data-major-ticks="<?php echo $res->mayor_ticks; ?>" data-minor-ticks="<?php echo $res->minor_ticks; ?>" data-stroke-ticks="true" data-highlights='<?php echo $res->data_spedo; ?>' data-color-plate="#010101" data-color-major-ticks="#000000" data-color-minor-ticks="#000000" data-color-title="#fff" data-color-units="#ccc" data-color-numbers="#eee" data-color-needle="rgba(240, 128, 128, 1)" data-color-needle-end="rgba(255, 160, 122, .9)" data-value-box="true" data-animate-on-init="true" data-animation-rule="bounce" data-animation-duration="1500">
									</canvas>
								</a>
							</span>
						<?php } ?>
					</div>
				</div>
				<div class="modal-footer bg-light">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /Modal Lending -->

	<!-- Modal NPL -->
	<div class="modal fade" id="modal_npl" tabindex="2" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header bg-light">
					<h5 class="modal-title" id="exampleModalLongTitle">Data NPL per Collector
						<p>Bulan : <?php echo ubahBulan($bulan) . "&nbsp" . $tahun ?></p>
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<div class="row justify-content-center">
						<?php 
						 foreach ($npl_kolektor as $res) { 
							$tampung = getDataSpedo($res->data_spedo);	
						?>

							<span class="rounded-circle" data-popover="popover" data-content='<b> NPL : <?= ambil2Angka($res->jml_value) . " %"; ?> <br> Status : <?= getStatusNPL($res->jml_value, $tampung[0], $tampung[3], $tampung[6], $tampung[9]); ?> <br> Baki debet NPL : <?= rupiah($res->jml_bd_npl); ?> <br> Total Baki debet : <?= rupiah($res->jml_bd); ?></b>' data-html='true' data-placement='top' data-trigger='hover'>
								<a class="rounded-circle" href="#detail_npl_kol<?php echo $res->kode_group3; ?>" data-toggle="modal" data-target="#detail_npl_kol<?php echo $res->kode_group3; ?>" data-backdrop="false">
									<canvas class="mt-2 mb-2 mx-2 rounded-circle" id="bz" data-type="radial-gauge" data-width="300" data-height="300" data-units="<?php echo $res->unit; ?>" data-title="<?php echo $res->deskripsi_group3; ?>" data-value="<?php echo $res->jml_value; ?>" data-min-value="0" data-max-value="<?php echo $res->jml_max_value; ?>" data-major-ticks="<?php echo $res->mayor_ticks; ?>" data-minor-ticks="<?php echo $res->minor_ticks; ?>" data-stroke-ticks="true" data-highlights='<?php echo $res->data_spedo; ?>' data-color-plate="#010101" data-color-major-ticks="#000000" data-color-minor-ticks="#000000" data-color-title="#fff" data-color-units="#ccc" data-color-numbers="#eee" data-color-needle="rgba(240, 128, 128, 1)" data-color-needle-end="rgba(255, 160, 122, .9)" data-value-box="true" data-animate-on-init="true" data-animation-rule="bounce" data-aimation-duration="500">
									</canvas>
								</a>
							</span>

						<?php } ?>
					</div>

					<!-- spedo kolektibilitas -->
					<hr>
					<div id="kolToogle">	
						<div class="text-center">
							<b>Rasio Antar Kolektibilitas</b>
						</div>
						<div class="row justify-content-center">
							<?php 
							 foreach ($dataKolektibilitas as $res) { 
								$tampung = getDataSpedo($res->data_spedo);	 
							?>
								<span class="rounded-circle" data-popover="popover" data-content='<b> Kolektibilitas <?=$res->kolektibilitas;?> : <?= ambil2Angka($res->jml_value) . " %"; ?> <br> Status : <?php echo ($res->kolektibilitas == 1) ? getStatus($res->jml_value, $tampung[0], $tampung[3], $tampung[6], $tampung[9]) : getStatusNPL($res->jml_value, $tampung[0], $tampung[3], $tampung[6], $tampung[9]); ?> </b>' data-html='true' data-placement='top' data-trigger='hover'>
									<a class="rounded-circle" href="#detail_kol<?php echo $res->kolektibilitas; ?>" data-toggle="modal" data-target="#detail_kol<?php echo $res->kolektibilitas; ?>" data-backdrop="false">
										<canvas class="mt-2 mb-2 mx-2 rounded-circle" id="kol" data-type="radial-gauge" data-width="200" data-height="200" data-units="<?php echo $res->unit; ?>" data-title="Kol <?= $res->kolektibilitas; ?>" data-value="<?php echo $res->jml_value; ?>" data-min-value="0" data-max-value="<?php echo $res->jml_max_value; ?>" data-major-ticks="<?php echo $res->mayor_ticks; ?>" data-minor-ticks="<?php echo $res->minor_ticks; ?>" data-stroke-ticks="true" data-highlights='<?php echo $res->data_spedo; ?>' data-color-plate="#010101" data-color-major-ticks="#000000" data-color-minor-ticks="#000000" data-color-title="#fff" data-color-units="#ccc" data-color-numbers="#eee" data-color-needle="rgba(240, 128, 128, 1)" data-color-needle-end="rgba(255, 160, 122, .9)" data-value-box="true" data-animate-on-init="true" data-animation-rule="bounce" data-aimation-duration="500">
										</canvas>
									</a>
								</span>
							<?php } ?>
						</div>
					</div>
					<!-- /spedo kolektibilitas -->
					
					<hr>
				</div>
				<div class="modal-footer bg-light">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /Modal NPL -->

	<!-- Modal Collection Ratio -->
	<div class="modal fade" id="modal_cr" tabindex="3" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header bg-light">
					<h5 class="modal-title" id="exampleModalLongTitle">Detail Collection Ratio
						<p>Bulan : <?php echo ubahBulan($bulan) . "&nbsp" . $tahun ?></p>
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row justify-content-center">
						<?php 
						 foreach ($cr_kolektor as $res) { 
							$tampung = getDataSpedo($res->data_spedo);	 
						?>
							<span class="rounded-circle" data-popover="popover" data-content='<b>CR : <?= ambil2Angka($res->jml_value) . " %"; ?> <br> Status : <?= getStatus($res->jml_value, $tampung[0], $tampung[3], $tampung[6], $tampung[9]); ?> <br> Jumlah tagihan : <?= rupiah($res->jml_tagihan); ?> <br> Jumlah bayar : <?= rupiah($res->jml_bayar); ?></b>' data-html='true' data-placement='top' data-trigger='hover'>
								<a class="rounded-circle" href="#detail_cr_kolektor<?php echo $res->kode_group3; ?>" data-toggle="modal" data-target="#detail_cr_kolektor<?php echo $res->kode_group3; ?>" data-backdrop="false">
									<canvas class="mt-2 mb-2 mx-2 rounded-circle" id="bz" data-type="radial-gauge" data-width="300" data-height="300" data-units="<?php echo $res->unit; ?>" data-title="<?php echo $res->deskripsi_group3; ?>" data-value="<?php echo $res->jml_value; ?>" data-min-value="0" data-max-value="<?php echo $res->jml_max_value; ?>" data-major-ticks="<?php echo $res->mayor_ticks; ?>" data-minor-ticks="<?php echo $res->minor_ticks; ?>" data-stroke-ticks="true" data-highlights='<?php echo $res->data_spedo; ?>' data-color-plate="#000000" data-color-major-ticks="#000000" data-color-minor-ticks="#000000" data-color-title="#fff" data-color-units="#ccc" data-color-numbers="#eee" data-color-needle="rgba(240, 128, 128, 1)" data-color-needle-end="rgba(255, 160, 122, .9)" data-value-box="true" data-animate-on-init="true" data-animation-rule="bounce" data-aimation-duration="1500">
									</canvas>
								</a>
							</span>
						<?php } ?>
					</div>
				</div>
				<div class="modal-footer bg-light">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /Modal Collection Ratio -->

	<!-- Modal Collection Ratio AO -->
	<div class="modal fade" id="modal_cr_ao" tabindex="3" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header bg-light">
					<h5 class="modal-title" id="exampleModalLongTitle">Detail Collection Ratio AO
						<p>Bulan : <?= ubahBulan($bulan) . "&nbsp" . $tahun; ?></p>
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row justify-content-center">
						<?php 
						 foreach ($cr_ao as $res) { 
							$tampung = getDataSpedo($res->data_spedo);	 
						?>
							<span class="rounded-circle" data-popover="popover" data-content='<b>CR : <?= ambil2Angka($res->jml_value) . " %"; ?> <br> Status : <?= getStatus($res->jml_value, $tampung[0], $tampung[3], $tampung[6], $tampung[9]); ?> <br> Jumlah tagihan : <?= rupiah($res->jml_tagihan); ?> <br> Jumlah bayar : <?= rupiah($res->jml_bayar); ?></b>' data-html='true' data-placement='top' data-trigger='hover'>
								<a class="rounded-circle" href="#detail_cr_ao<?php echo $res->kode_group2; ?>" data-toggle="modal" data-target="#detail_cr_ao<?php echo $res->kode_group2; ?>" data-backdrop="false">
									<canvas class="mt-2 mb-2 mx-2 rounded-circle" id="cr_ao" data-type="radial-gauge" data-width="300" data-height="300" data-units="<?php echo $res->unit; ?>" data-title="<?php echo $res->deskripsi_group2; ?>" data-value="<?php echo $res->jml_value; ?>" data-min-value="0" data-max-value="<?php echo $res->jml_max_value; ?>" data-major-ticks="<?php echo $res->mayor_ticks; ?>" data-minor-ticks="<?php echo $res->minor_ticks; ?>" data-stroke-ticks="true" data-highlights='<?php echo $res->data_spedo; ?>' data-color-plate="#000000" data-color-major-ticks="#000000" data-color-minor-ticks="#000000" data-color-title="#fff" data-color-units="#ccc" data-color-numbers="#eee" data-color-needle="rgba(240, 128, 128, 1)" data-color-needle-end="rgba(255, 160, 122, .9)" data-value-box="true" data-animate-on-init="true" data-animation-rule="bounce" data-aimation-duration="1500">
									</canvas>
								</a>
							</span>
						<?php } ?>
					</div>
				</div>
				<div class="modal-footer bg-light">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /Modal Collection Ratio AO -->

	<!-- Modal Bucket Zero -->
	<div class="modal fade" id="modal_bz" tabindex="4" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header bg-light">
					<h5 class="modal-title" id="exampleModalLongTitle">Detail Bucket Zero
						<p>Bulan : <?php echo ubahBulan($bulan) . "&nbsp" . $tahun ?></p>
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row justify-content-center">
						<?php 
						 foreach ($bz_kolektor as $res) { 
							$tampung = getDataSpedo($res->data_spedo);	 
						?>
							<span class="rounded-circle" data-popover="popover" data-content='<b>BZ : <?= ambil2Angka($res->jml_value) . " %"; ?> <br> Status : <?= getStatus($res->jml_value, $tampung[0], $tampung[3], $tampung[6], $tampung[9]); ?> <br> Jumlah tagihan : <?= rupiah($res->jml_tagihan); ?> <br> Jumlah bayar : <?= rupiah($res->jml_bayar); ?></b>' data-html='true' data-placement='top' data-trigger='hover'>
								<a class="rounded-circle" href="#detail_bz_kol" data-toggle="modal" data-target="#detail_bz_kol<?php echo $res->kode_group3; ?>" data-backdrop="false">
									<canvas class="mt-2 mb-2 mx-2 rounded-circle" id="bz" data-type="radial-gauge" data-width="300" data-height="300" data-units="<?php echo $res->unit; ?>" data-title="<?php echo $res->deskripsi_group3; ?>" data-value="<?php echo $res->jml_value; ?>" data-min-value="0" data-max-value="<?php echo $res->jml_max_value; ?>" data-major-ticks="<?php echo $res->mayor_ticks; ?>" data-minor-ticks="<?php echo $res->minor_ticks; ?>" data-stroke-ticks="true" data-highlights='<?php echo $res->data_spedo; ?>' data-color-plate="#010101" data-color-major-ticks="#000000" data-color-minor-ticks="#000000" data-color-title="#fff" data-color-units="#ccc" data-color-numbers="#eee" data-color-needle="rgba(240, 128, 128, 1)" data-color-needle-end="rgba(255, 160, 122, .9)" data-value-box="true" data-animate-on-init="true" data-animation-rule="bounce" data-aimation-duration="500">
									</canvas>
								</a>
							</span>
						<?php } ?>
					</div>
				</div>
				<div class="modal-footer bg-light">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /Modal Bucket Zero -->

	<!-- Modal NON STARTER -->
	<div class="modal fade" id="modal_ns" tabindex="4" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header bg-light">
					<h5 class="modal-title" id="exampleModalLongTitle">Detail FID - Non Starter
						<p>Bulan : <?php echo ubahBulan($bulan) . "&nbsp" . $tahun ?></p>
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row justify-content-center">
						<?php 
						 foreach ($ns_ao as $res) { 
							$tampung = getDataSpedo($res->data_spedo);	 
						?>
							<span class="rounded-circle spedo" data-popover="popover" data-content="<b>Non Starter : <?= ambil2Angka($res->jml_value) . " %"; ?> <br> Status : <?= getStatusNPL($res->jml_value, $tampung[0], $tampung[3], $tampung[6], $tampung[9]); ?> <br> Jumlah Pinjaman FID NS : <?= rupiah($res->jml_pinjaman_fid_ns); ?> <br> Jumlah Pinjaman NS : <?= rupiah($res->jml_pinjaman_ns); ?> </b>" data-html="true" data-placement="top" data-trigger="hover">
								<a class="rounded-circle" href="#detail_ns_ao" data-toggle="modal" data-target="#detail_ns_ao<?= $res->kode_group2; ?>" data-backdrop="false">
									<canvas class="mt-2 mb-2 mx-2 rounded-circle" id="bz" data-type="radial-gauge" data-width="300" data-height="300" data-units="<?php echo $res->unit; ?>" data-title="<?php echo $res->deskripsi_group2; ?>" data-value="<?php echo $res->jml_value; ?>" data-min-value="0" data-max-value="<?php echo $res->jml_max_value; ?>" data-major-ticks="<?php echo $res->mayor_ticks; ?>" data-minor-ticks="<?php echo $res->minor_ticks; ?>" data-stroke-ticks="true" data-highlights='<?php echo $res->data_spedo; ?>' data-color-plate="#010101" data-color-major-ticks="#000000" data-color-minor-ticks="#000000" data-color-title="#fff" data-color-units="#ccc" data-color-numbers="#eee" data-color-needle="rgba(240, 128, 128, 1)" data-color-needle-end="rgba(255, 160, 122, .9)" data-value-box="true" data-animate-on-init="true" data-animation-rule="bounce" data-aimation-duration="500">
									</canvas>
								</a>
							</span>
						<?php } ?>
					</div>
				</div>
				<div class="modal-footer bg-light">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /Modal NON STARTER -->

	<!-- Modal Detail Lending -->
	<?php foreach ($lending_ao as $res) { ?>
		<?php

		$this->db->query("SELECT LAST_DAY('$tahun-$bulan-$tanggal') INTO @pv_per_tgl");
		$this->db->query("SELECT '$res->kode_group2' INTO @pv_kode_ao");
		$dataDetail = $this->db->query("SELECT * FROM kms_kpi.v_kpi_ao_lending WHERE kode_kantor = '$res->kode_kantor'")->result();
		$jmlLending = $this->db->query("SELECT SUM(jml_lending) as jumlah_lending FROM kms_kpi.v_kpi_ao_lending WHERE kode_kantor = '$res->kode_kantor'")->row();
		$dataKpiMapLending = $this->db->query("SELECT * FROM kms_kpi.v_kpi_ao_lending WHERE kode_kantor = '$res->kode_kantor'")->num_rows();
		?>
		<div class="modal modal2 modal_detail_lending fade" id="detail_lending_ao<?php echo $res->kode_group2; ?>" tabindex="5" role="dialog" aria-labelledby="" aria-hidden="true">
			<div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
				<div class="modal-content">
					<div class="modal-header bg-light">
						<h5 class="modal-title" id="exampleModalLongTitle">Data Nasabah Lending
							<p><?php echo $res->deskripsi_group2; ?>, <?php echo ubahBulan($bulan) . "&nbsp" . $tahun; ?></p>
						</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table id="dt_tables_lending<?php echo $res->kode_group2; ?>" cellspacing="0" class="table table-bordered table-hover display compact nowrap" style="width:100%">
							<thead class="bg-light">
								<tr>
									<th>No Rekening</th>
									<th>Nama Nasabah</th>
									<th>Mitra Bisnis</th>
									<th>Tanggal Realisasi</th>
									<th>Jangka Waktu</th>
									<th>Tanggal Jatuh Tempo</th>
									<th>Jumlah Lending</th>
									<th>Baki Debet</th>
									<th>Jumlah Pinjaman</th>
									<th>Alamat</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($dataDetail as $resDetail) { ?>
									<tr>
										<td><?php echo $resDetail->no_rekening; ?></td>
										<td><?php echo $resDetail->nama_nasabah; ?></td>
										<?php echo ($resDetail->deskripsi_group5 != NULL ? "<td>" . (($resDetail->deskripsi_group5) == "kantor" ? ucfirst("mediator") : ucfirst($resDetail->deskripsi_group5)) . "</td>" : "<td> - </td>"); ?>
										<td><?php echo ubahDate($resDetail->tgl_realisasi); ?></td>
										<td><?= $resDetail->jkw . " Bulan"; ?></td>
										<td><?php echo ubahDate($resDetail->tgl_jatuh_tempo); ?></td>
										<td><?php echo rupiah($resDetail->jml_lending); ?></td>
										<td><?php echo rupiah($resDetail->baki_debet); ?></td>
										<td><?php echo rupiah($resDetail->jml_pinjaman); ?></td>
										<td><?php echo $resDetail->alamat; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					<div class="modal-footer bg-light">
						<h6 class="mr-auto"><?= $dataKpiMapLending . " MAP"; ?> - TOTAL : <?= rupiah($jmlLending->jumlah_lending); ?></h6>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- /Modal Detail Lending -->

	<!-- Modal Detail NPL -->
	<?php foreach ($npl_kolektor as $res) { ?>
		<?php

		$this->db->query("SELECT LAST_DAY('$tahun-$bulan-$tanggal') INTO @pv_per_tgl");
		$this->db->query("SELECT '$res->kode_group3' INTO @pv_kode_kolektor");
		$dataDetail = $this->db->query("SELECT * FROM kms_kpi.v_kpi_kolektor_npl WHERE kode_kantor = '$res->kode_kantor'")->result();
		?>
		<div class="modal fade" id="detail_npl_kol<?php echo $res->kode_group3; ?>" tabindex="2" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header bg-light">
						<h5 class="modal-title" id="exampleModalLongTitle">Detail NPL
							<p><?php echo $res->deskripsi_group3; ?>, <?php echo ubahBulan($bulan) . "&nbsp" . $tahun; ?></p>
						</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="table-responsive">
							<table id="dt_tables_npl<?php echo $res->kode_group3; ?>" class="table table-bordered table-hover display compact nowrap" style="width:100%">
								<thead class="bg-light">
									<tr>
										<th>No Rekening</th>
										<th>Nama Nasabah</th>
										<th>Alamat</th>
										<th>Tanggal Realisasi</th>
										<th>Jangka Waktu</th>
										<th>Tanggal Jatuh Tempo</th>
										<th>Baki Debet</th>
										<th>Jumlah Pinjaman</th>
										<th>Jumlah Lending</th>
										<th>Angsuran per Bulan</th>
										<th>Jumlah Tunggakan</th>
										<th>Total Tagihan</th>
										<th>Sisa Tunggakan</th>
										<th>Jumlah Denda</th>
										<th>Jumlah Pembayaran</th>
										<th>Jumlah SP Assign</th>
										<th>Jumlah SP Return</th>
										<th>FT Pokok</th>
										<th>FT Bunga</th>
										<th>FT Hari Awal</th>
										<th>FT Hari</th>
										<th>Kolektibilitas</th>
										<th>Last Payment</th>
										<!-- <th>Status</th> -->
									</tr>
								</thead>
								<tbody>
									<?php foreach ($dataDetail as $resDetail) { ?>
										<tr>
											<td><?= $resDetail->no_rekening; ?></td>
											<td><?= $resDetail->nama_nasabah; ?></td>
											<td><?= $resDetail->alamat; ?></td>
											<td><?= ubahDate($resDetail->tgl_realisasi); ?></td>
											<td><?= $resDetail->jkw . " Bulan"; ?></td>
											<td><?= ubahDate($resDetail->tgl_jatuh_tempo); ?></td>
											<td><?= rupiah($resDetail->baki_debet); ?></td>
											<td><?= rupiah($resDetail->jml_pinjaman); ?></td>
											<td><?= rupiah($resDetail->jml_lending); ?></td>
											<td><?= rupiah($resDetail->jml_tagihan_turun); ?></td>
											<td><?= rupiah($resDetail->jml_tunggakan); ?></td>
											<td><?= rupiah($resDetail->total_tagihan); ?></td>
											<td><?= rupiah($resDetail->sisa_tunggakan); ?></td>
											<td><?= rupiah($resDetail->jml_denda); ?></td>
											<td><?= rupiah($resDetail->jml_tagihan_bayar); ?></td>
											<td><?= $resDetail->jml_sp_assign . " Surat"; ?></td>
											<td><?= $resDetail->jml_sp_return . " Surat"; ?></td>
											<td><?= $resDetail->ft_pokok . " Bulan"; ?></td>
											<td><?= $resDetail->ft_bunga . " Bulan"; ?></td>
											<td><?= convertDayMonth($resDetail->ft_hari_awal); ?></td>
											<td><?= convertDayMonth($resDetail->ft_hari); ?></td>
											<td><?= $resDetail->kolektibilitas . " - " . getKolektibilitas($resDetail->kolektibilitas); ?></td>
											<td><?= ($resDetail->last_payment !== null) ? ubahDate($resDetail->last_payment) : " - "; ?></td>
											<!-- <td><#?= cekBayar($resDetail->last_payment); ?></td> -->
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="modal-footer bg-light">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">
							Close
						</button>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- Modal Detail NPL -->

	<!-- Modal Detail Kolektibilitas -->
	<?php foreach ($dataKolektibilitas as $res) { ?>
		<?php

		$this->db->query("SELECT LAST_DAY('$tahun-$bulan-$tanggal') INTO @pv_per_tgl");
		$this->db->query("SELECT '$res->kolektibilitas' INTO @pv_kode_kolektibilitas");
		$dataDetail = $this->db->query("SELECT * FROM kms_kpi.v_kpi_kolektibilitas_npl WHERE kode_kantor = '$res->kode_kantor'")->result();
		?>
		<div class="modal fade" id="detail_kol<?php echo $res->kolektibilitas; ?>" tabindex="2" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header bg-light">
						<h5 class="modal-title" id="exampleModalLongTitle">Detail Kolektibilitas <?= $res->kolektibilitas . ' - ' . getKolektibilitas($res->kolektibilitas); ?>
							<p><?php echo ubahBulan($bulan) . "&nbsp" . $tahun; ?></p>
						</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="table-responsive">
							<table id="dt_tables_kol<?php echo $res->kolektibilitas; ?>" class="table table-bordered table-hover display compact nowrap" style="width:100%">
								<thead class="bg-light">
									<tr>
										<th>No Rekening</th>
										<th>Nama Nasabah</th>
										<th>Alamat</th>
										<th>Tanggal Realisasi</th>
										<th>Jangka Waktu</th>
										<th>Tanggal Jatuh Tempo</th>
										<th>Baki Debet</th>
										<th>Jumlah Pinjaman</th>
										<th>Jumlah Lending</th>
										<th>Angsuran per Bulan</th>
										<th>Jumlah Tunggakan</th>
										<th>Total Tagihan</th>
										<th>Sisa Tunggakan</th>
										<th>Jumlah Denda</th>
										<th>Jumlah Pembayaran</th>
										<th>Jumlah SP Assign</th>
										<th>Jumlah SP Return</th>
										<th>FT Pokok</th>
										<th>FT Bunga</th>
										<th>FT Hari Awal</th>
										<th>FT Hari</th>
										<th>Kolektibilitas</th>
										<th>Last Payment</th>
										<!-- <th>Status</th> -->
									</tr>
								</thead>
								<tbody>
									<?php foreach ($dataDetail as $resDetail) { ?>
										<tr>
											<td><?= $resDetail->no_rekening; ?></td>
											<td><?= $resDetail->nama_nasabah; ?></td>
											<td><?= $resDetail->alamat; ?></td>
											<td><?= ubahDate($resDetail->tgl_realisasi); ?></td>
											<td><?= $resDetail->jkw . " Bulan"; ?></td>
											<td><?= ubahDate($resDetail->tgl_jatuh_tempo); ?></td>
											<td><?= rupiah($resDetail->baki_debet); ?></td>
											<td><?= rupiah($resDetail->jml_pinjaman); ?></td>
											<td><?= rupiah($resDetail->jml_lending); ?></td>
											<td><?= rupiah($resDetail->jml_tagihan_turun); ?></td>
											<td><?= rupiah($resDetail->jml_tunggakan); ?></td>
											<td><?= rupiah($resDetail->total_tagihan); ?></td>
											<td><?= rupiah($resDetail->sisa_tunggakan); ?></td>
											<td><?= rupiah($resDetail->jml_denda); ?></td>
											<td><?= rupiah($resDetail->jml_tagihan_bayar); ?></td>
											<td><?= $resDetail->jml_sp_assign . " Surat"; ?></td>
											<td><?= $resDetail->jml_sp_return . " Surat"; ?></td>
											<td><?= $resDetail->ft_pokok . " Bulan"; ?></td>
											<td><?= $resDetail->ft_bunga . " Bulan"; ?></td>
											<td><?= convertDayMonth($resDetail->ft_hari_awal); ?></td>
											<td><?= convertDayMonth($resDetail->ft_hari); ?></td>
											<td><?= $resDetail->kolektibilitas . " - " . getKolektibilitas($resDetail->kolektibilitas); ?></td>
											<td><?= ($resDetail->last_payment !== null) ? ubahDate($resDetail->last_payment) : " - "; ?></td>
											<!-- <td><#?= cekBayar($resDetail->last_payment); ?></td> -->
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="modal-footer bg-light">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">
							Close
						</button>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- Modal Detail Kolektibilitas -->

	<!-- Modal Detail CR -->
	<?php foreach ($cr_kolektor as $res) { ?>
		<?php

		$this->db->query("SELECT LAST_DAY('$tahun-$bulan-$tanggal') INTO @pv_per_tgl");
		$this->db->query("SELECT '$res->kode_group3' INTO @pv_kode_kolektor");
		$dataDetail = $this->db->query("SELECT * FROM kms_kpi.v_kpi_kolektor_cr WHERE kode_kantor = '$res->kode_kantor'")->result();
		?>
		<div class="modal fade" id="detail_cr_kolektor<?php echo $res->kode_group3; ?>" tabindex="5" role="dialog" aria-labelledby="" aria-hidden="true">
			<div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
				<div class="modal-content">
					<div class="modal-header bg-light">
						<h5 class="modal-title" id="exampleModalLongTitle">Detail CR
							<p><?php echo $res->deskripsi_group3; ?>, <?php echo ubahBulan($bulan) . "&nbsp" . $tahun; ?></p>
						</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="table-responsive">
							<table id="dt_tables_cr<?php echo $res->kode_group3; ?>" class="table table-bordered table-hover display compact nowrap" style="width:100%">
								<thead class="bg-light">
									<tr>
										<th>No Rekening</th>
										<th>Nama Nasabah</th>
										<th>Alamat</th>
										<th>Tanggal Realisasi</th>
										<th>Jangka Waktu</th>
										<th>Tanggal Jatuh Tempo</th>
										<th>Baki Debet</th>
										<th>Jumlah Pinjaman</th>
										<th>Jumlah Lending</th>
										<th>Angsuran per Bulan</th>
										<th>Jumlah Tunggakan</th>
										<th>Total Tagihan</th>
										<th>Sisa Tunggakan</th>
										<th>Jumlah Denda</th>
										<th>Jumlah Pembayaran</th>
										<th>Jumlah SP Assign</th>
										<th>Jumlah SP Return</th>
										<th>FT Pokok</th>
										<th>FT Bunga</th>
										<th>FT Hari Awal</th>
										<th>FT Hari</th>
										<th>Kolektibilitas</th>
										<th>Last Payment</th>
										<!-- <th>Status</th> -->
									</tr>
								</thead>
								<tbody>
									<?php foreach ($dataDetail as $resDetail) { ?>
										<tr>
											<td><?= $resDetail->no_rekening; ?></td>
											<td><?= $resDetail->nama_nasabah; ?></td>
											<td><?= $resDetail->alamat; ?></td>
											<td><?= ubahDate($resDetail->tgl_realisasi); ?></td>
											<td><?= $resDetail->jkw . " Bulan"; ?></td>
											<td><?= ubahDate($resDetail->tgl_jatuh_tempo); ?></td>
											<td><?= rupiah($resDetail->baki_debet); ?></td>
											<td><?= rupiah($resDetail->jml_pinjaman); ?></td>
											<td><?= rupiah($resDetail->jml_lending); ?></td>
											<td><?= rupiah($resDetail->jml_tagihan_turun); ?></td>
											<td><?= rupiah($resDetail->jml_tunggakan); ?></td>
											<td><?= rupiah($resDetail->total_tagihan); ?></td>
											<td><?= rupiah($resDetail->sisa_tunggakan); ?></td>
											<td><?= rupiah($resDetail->jml_denda); ?></td>
											<td><?= rupiah($resDetail->jml_tagihan_bayar); ?></td>
											<td><?= $resDetail->jml_sp_assign . " Surat"; ?></td>
											<td><?= $resDetail->jml_sp_return . " Surat"; ?></td>
											<td><?= $resDetail->ft_pokok . " Bulan"; ?></td>
											<td><?= $resDetail->ft_bunga . " Bulan"; ?></td>
											<td><?= convertDayMonth($resDetail->ft_hari_awal); ?></td>
											<td><?= convertDayMonth($resDetail->ft_hari); ?></td>
											<td><?= $resDetail->kolektibilitas . " - " . getKolektibilitas($resDetail->kolektibilitas); ?></td>
											<td><?= ($resDetail->last_payment !== null) ? ubahDate($resDetail->last_payment) : " - "; ?></td>
											<!-- <td><#?= cekBayar($resDetail->last_payment); ?></td> -->
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="modal-footer bg-light">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- /Modal Detail CR -->

	<!-- Modal Detail CR AO -->
	<?php foreach ($cr_ao as $res) { ?>
		<?php

		$this->db->query("SELECT LAST_DAY('$tahun-$bulan-$tanggal') INTO @pv_per_tgl");
		$this->db->query("SELECT '$res->kode_group2' INTO @pv_kode_ao");
		$dataDetail = $this->db->query("SELECT * FROM kms_kpi.v_kpi_ao_cr WHERE kode_kantor = '$res->kode_kantor'")->result();
		?>
		<div class="modal fade" id="detail_cr_ao<?php echo $res->kode_group2; ?>" tabindex="5" role="dialog" aria-labelledby="" aria-hidden="true">
			<div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
				<div class="modal-content">
					<div class="modal-header bg-light">
						<h5 class="modal-title" id="exampleModalLongTitle">Detail CR AO
							<p><?php echo $res->deskripsi_group2; ?>, <?php echo ubahBulan($bulan) . "&nbsp" . $tahun; ?></p>
						</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="table-responsive">
							<table id="dt_tables_cr_ao<?php echo $res->kode_group2; ?>" class="table table-bordered table-hover display compact nowrap" style="width:100%">
								<thead class="bg-light">
									<tr>
										<th>No Rekening</th>
										<th>Nama Nasabah</th>
										<th>Alamat</th>
										<th>Tanggal Realisasi</th>
										<th>Jangka Waktu</th>
										<th>Tanggal Jatuh Tempo</th>
										<th>Baki Debet</th>
										<th>Jumlah Pinjaman</th>
										<th>Jumlah Lending</th>
										<th>Angsuran per Bulan</th>
										<th>Jumlah Tunggakan</th>
										<th>Total Tagihan</th>
										<th>Sisa Tunggakan</th>
										<th>Jumlah Denda</th>
										<th>Jumlah Pembayaran</th>
										<th>FT Pokok</th>
										<th>FT Bunga</th>
										<th>FT Hari Awal</th>
										<th>FT Hari</th>
										<th>Kolektibilitas</th>
										<th>Last Payment</th>
										<!-- <th>Status</th> -->
									</tr>
								</thead>
								<tbody>
									<?php foreach ($dataDetail as $resDetail) { ?>
										<tr>
											<td><?= $resDetail->no_rekening; ?></td>
											<td><?= $resDetail->nama_nasabah; ?></td>
											<td><?= $resDetail->alamat; ?></td>
											<td><?= ubahDate($resDetail->tgl_realisasi); ?></td>
											<td><?= $resDetail->jkw . " Bulan"; ?></td>
											<td><?= ubahDate($resDetail->tgl_jatuh_tempo); ?></td>
											<td><?= rupiah($resDetail->baki_debet); ?></td>
											<td><?= rupiah($resDetail->jml_pinjaman); ?></td>
											<td><?= rupiah($resDetail->jml_lending); ?></td>
											<td><?= rupiah($resDetail->jml_tagihan_turun); ?></td>
											<td><?= rupiah($resDetail->jml_tunggakan); ?></td>
											<td><?= rupiah($resDetail->total_tagihan); ?></td>
											<td><?= rupiah($resDetail->sisa_tunggakan); ?></td>
											<td><?= rupiah($resDetail->jml_denda); ?></td>
											<td><?= rupiah($resDetail->jml_tagihan_bayar); ?></td>
											<td><?= $resDetail->ft_pokok . " Bulan"; ?></td>
											<td><?= $resDetail->ft_bunga . " Bulan"; ?></td>
											<td><?= convertDayMonth($resDetail->ft_hari_awal); ?></td>
											<td><?= convertDayMonth($resDetail->ft_hari); ?></td>
											<td><?= $resDetail->kolektibilitas . " - " . getKolektibilitas($resDetail->kolektibilitas); ?></td>
											<td><?= ($resDetail->last_payment !== null) ? ubahDate($resDetail->last_payment) : " - "; ?></td>
											<!-- <td><#?= cekBayar($resDetail->last_payment); ?></td> -->
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="modal-footer bg-light">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- /Modal Detail CR AO -->

	<!-- Modal Detail Bucket  Zero -->
	<?php foreach ($bz_kolektor as $res) { ?>
		<?php

		$this->db->query("SELECT LAST_DAY('$tahun-$bulan-$tanggal') INTO @pv_per_tgl");
		$this->db->query("SELECT '$res->kode_group3' INTO @pv_kode_kolektor");
		$dataDetail = $this->db->query("SELECT * FROM kms_kpi.v_kpi_kolektor_bucket_zero WHERE kode_kantor = '$res->kode_kantor'")->result();
		?>
		<div class="modal fade" id="detail_bz_kol<?php echo $res->kode_group3; ?>" tabindex="5" role="dialog" aria-labelledby="" aria-hidden="true">
			<div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
				<div class="modal-content">
					<div class="modal-header bg-light">
						<h5 class="modal-title" id="exampleModalLongTitle">Detail Bucket Zero
							<p><?php echo $res->deskripsi_group3; ?>, <?php echo ubahBulan($bulan) . "&nbsp" . $tahun; ?></p>
						</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="table-responsive">
							<table id="dt_tables_bz<?php echo $res->kode_group3; ?>" class="dt_tables table table-bordered table-hover display compact nowrap" style="width:100%">
								<thead class="bg-light">
									<tr>
										<th>No Rekening</th>
										<th>Nama Nasabah</th>
										<th>Alamat</th>
										<th>Tanggal Realisasi</th>
										<th>Jangka Waktu</th>
										<th>Tanggal Jatuh Tempo</th>
										<th>Baki Debet</th>
										<th>Jumlah Pinjaman</th>
										<th>Jumlah Lending</th>
										<th>Angsuran per Bulan</th>
										<th>Jumlah Tunggakan</th>
										<th>Total Tagihan</th>
										<th>Sisa Tunggakan</th>
										<th>Jumlah Denda</th>
										<th>Jumlah Pembayaran</th>
										<th>Jumlah SP Assign</th>
										<th>Jumlah SP Return</th>
										<th>FT Pokok</th>
										<th>FT Bunga</th>
										<th>FT Hari Awal</th>
										<th>FT Hari</th>
										<th>Kolektibilitas</th>
										<th>Last Payment</th>
										<!-- <th>Status</th> -->
									</tr>
								</thead>
								<tbody>
									<?php foreach ($dataDetail as $resDetail) { ?>
										<tr>
											<td><?= $resDetail->no_rekening; ?></td>
											<td><?= $resDetail->nama_nasabah; ?></td>
											<td><?= $resDetail->alamat; ?></td>
											<td><?= ubahDate($resDetail->tgl_realisasi); ?></td>
											<td><?= $resDetail->jkw . " Bulan"; ?></td>
											<td><?= ubahDate($resDetail->tgl_jatuh_tempo); ?></td>
											<td><?= rupiah($resDetail->baki_debet); ?></td>
											<td><?= rupiah($resDetail->jml_pinjaman); ?></td>
											<td><?= rupiah($resDetail->jml_lending); ?></td>
											<td><?= rupiah($resDetail->jml_tagihan_turun); ?></td>
											<td><?= rupiah($resDetail->jml_tunggakan); ?></td>
											<td><?= rupiah($resDetail->total_tagihan); ?></td>
											<td><?= rupiah($resDetail->sisa_tunggakan); ?></td>
											<td><?= rupiah($resDetail->jml_denda); ?></td>
											<td><?= rupiah($resDetail->jml_tagihan_bayar); ?></td>
											<td><?= $resDetail->jml_sp_assign . " Surat"; ?></td>
											<td><?= $resDetail->jml_sp_return . " Surat"; ?></td>
											<td><?= $resDetail->ft_pokok . " Bulan"; ?></td>
											<td><?= $resDetail->ft_bunga . " Bulan"; ?></td>
											<td><?= convertDayMonth($resDetail->ft_hari_awal); ?></td>
											<td><?= convertDayMonth($resDetail->ft_hari); ?></td>
											<td><?= $resDetail->kolektibilitas . " - " . getKolektibilitas($resDetail->kolektibilitas); ?></td>
											<td><?= ($resDetail->last_payment !== null) ? ubahDate($resDetail->last_payment) : " - "; ?></td>
											<!-- <td><#?= cekBayar($resDetail->last_payment); ?></td> -->
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="modal-footer bg-light">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- /Modal Detail Bucket  Zero -->

	<!-- Modal Detail NON STARTER -->
	<?php foreach ($ns_ao as $res) { ?>
		<?php

		$this->db->query("SELECT LAST_DAY('$tahun-$bulan-$tanggal') INTO @pv_per_tgl");
		$this->db->query("SELECT '$res->kode_group2' INTO @pv_kode_ao");
		$dataDetail = $this->db->query("SELECT * FROM kms_kpi.v_kpi_ao_fid WHERE kode_kantor = '$res->kode_kantor'")->result();
		// $dataKpiMapFID = $this->db->query("SELECT * FROM kms_kpi.v_kpi_ao_fid WHERE kode_kantor = '$res->kode_kantor'")->num_rows();
		?>
		<div class="modal fade" id="detail_ns_ao<?php echo $res->kode_group2; ?>" tabindex="5" role="dialog" aria-labelledby="" aria-hidden="true">
			<div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
				<div class="modal-content">
					<div class="modal-header bg-light">
						<h5 class="modal-title" id="exampleModalLongTitle">Detail FID - Non Starter
							<p><?php echo $res->deskripsi_group2; ?>, <?php echo ubahBulan($bulan) . "&nbsp" . $tahun; ?></p>
						</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="table-responsive">
							<table id="dt_tables_ns<?php echo $res->kode_group2; ?>" class="dt_tables table table-bordered table-hover display compact nowrap" style="width:100%">
								<thead class="bg-light">
									<tr>
										<th>No Rekening</th>
										<th>Nama Nasabah</th>
										<th>Tanggal Realisasi</th>
										<th>Jangka Waktu</th>
										<th>Tanggal Jatuh Tempo</th>
										<th>Baki Debet</th>
										<th>Jumlah Pinjaman</th>
										<th>FT Hari</th>
										<th>Total Tagihan</th>
										<th>Jumlah Pembayaran</th>
										<th>Alamat</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($dataDetail as $resDetail) { ?>
										<tr>
											<td><?= $resDetail->no_rekening; ?></td>
											<td><?= $resDetail->nama_nasabah; ?></td>
											<td><?= ubahDate($resDetail->tgl_realisasi); ?></td>
											<td><?= $resDetail->jkw . " Bulan"; ?></td>
											<td><?= ubahDate($resDetail->tgl_jatuh_tempo); ?></td>
											<td><?= rupiah($resDetail->baki_debet); ?></td>
											<td><?= rupiah($resDetail->jml_pinjaman); ?></td>
											<td><?= convertDayMonth($resDetail->ft_hari); ?></td>
											<td><?= rupiah($resDetail->total_tagihan); ?></td>
											<td><?= rupiah($resDetail->jml_tagihan_bayar); ?></td>
											<td><?= $resDetail->alamat; ?></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="modal-footer bg-light">
						<!-- <h6 class="mr-auto"><#?= $dataKpiMapFID . " MAP - TOTAL : " . ubahJuta($res->jml_value); ?></h6> -->
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- /Modal Detail NON STARTER -->
</div>
<!-- content-wrapper ends -->

<?php require_once('include/footerkpi.php'); ?>

<script>
	$(document).ready(function() {
		//datatable
		function cchart(id_modal, id_table) {
			return $(id_modal).on('shown.bs.modal', function() {
				if (!$.fn.DataTable.isDataTable(id_table)) {
					var tbtb = $(id_table).DataTable({
						// responsive: false,
						language: {
							decimal: "",
							emptyTable: "Tidak Ada Data",
							info: "Menampilkan _START_ sampai _END_ dari total _TOTAL_ baris",
							infoEmpty: "Menampilkan 0 sampai 0 dari total 0 baris",
							infoFiltered: "(Filter dari total _MAX_ baris)",
							infoPostFix: "",
							thousands: ",",
							lengthMenu: "Tampilkan _MENU_ baris",
							loadingRecords: "Memuat...",
							processing: "Proses...",
							search: "Cari:",
							zeroRecords: "Tidak ada data yang sesuai",
							paginate: {
								first: "Pertama",
								last: "Terakhir",
								next: "Selanjutnya",
								previous: "Sebelumnya"
							},
							aria: {
								sortAscending: ": Aktifkan Berdasarkan paling Awal",
								sortDescending: ": Aktifkan Berdasarkan paling Akhir"
							}
						},
						autoWidth: true,
						pagingType: "simple_numbers",
						lengthMenu: [
							[7, 10, 25, 50, 100],
							[7, 10, 25, 50, 100]
						],
						responsive: {
							details: {
								renderer: function(api, rowIdx, columns) {
									var data = $.map(columns, function(col, i) {
										return col.hidden ?
											'<tr data-dt-row="' + col.rowIndex + '" data-dt-column="' + col.columnIndex + '">' +
											'<td>' + col.title + ' : ' + '</td> ' +
											'<td>' + col.data + '</td>' +
											'</tr>' :
											'';
									}).join('');

									return data ?
										$('<table/>').append(data) :
										false;
								}
							}
						},
						columnDefs: [{
							className: 'control',
							orderable: true,
							targets: 0
						}],
						// fixedColumns: {
						// 	leftColumns: 2
						// },
						dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
							"<'row'<'col-sm-12't>>" +
							"<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
						// scrollY: 320,
						// scrollX: true,
						// scrollCollapse: true,
						// scroller: true,
					});
				} else {
					// var tbtb = $.fn.dataTable.fnTables(true);

					// $(tbtb).each(function () {
					// 	$(this).dataTable().fnDestroy();
					// });
				}

				//tbtb.columns.adjust().responsive.recalc();
			});
		}

		function cchart2(id_modal, id_table,colgrp) {
			return $(id_modal).on('shown.bs.modal', function() {
				if (!$.fn.DataTable.isDataTable(id_table)) {
					var tbtb = $(id_table).DataTable({
						// responsive: false,
						language: {
							decimal: "",
							emptyTable: "Tidak Ada Data",
							info: "Menampilkan _START_ sampai _END_ dari total _TOTAL_ baris",
							infoEmpty: "Menampilkan 0 sampai 0 dari total 0 baris",
							infoFiltered: "(Filter dari total _MAX_ baris)",
							infoPostFix: "",
							thousands: ",",
							lengthMenu: "Tampilkan _MENU_ baris",
							loadingRecords: "Memuat...",
							processing: "Proses...",
							search: "Cari:",
							zeroRecords: "Tidak ada data yang sesuai",
							paginate: {
								first: "Pertama",
								last: "Terakhir",
								next: "Selanjutnya",
								previous: "Sebelumnya"
							},
							aria: {
								sortAscending: ": Aktifkan Berdasarkan paling Awal",
								sortDescending: ": Aktifkan Berdasarkan paling Akhir"
							}
						},
						rowGroup: {
							dataSrc: colgrp
						},
						autoWidth: true,
						pagingType: "simple_numbers",
						lengthMenu: [
							[5, 10, 25, 50, 100, -1],
							[5, 10, 25, 50, 100, "Semua"]
						],
						responsive: {
							details: {
								renderer: function(api, rowIdx, columns) {
									var data = $.map(columns, function(col, i) {
										return col.hidden ?
											'<tr data-dt-row="' + col.rowIndex + '" data-dt-column="' + col.columnIndex + '">' +
											'<td>' + col.title + ' : ' + '</td> ' +
											'<td>' + col.data + '</td>' +
											'</tr>' :
											'';
									}).join('');

									return data ?
										$('<table/>').append(data) :
										false;
								}
							}
						},
						columnDefs: [{
							className: 'control',
							orderable: true,
							targets: 0
						}],
						// fixedColumns: {
						// 	leftColumns: 2
						// },
						order: [
							[colgrp, "desc"]
						],
						dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
							"<'row'<'col-sm-12't>>" +
							"<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
						// scrollY: 320,
						// scrollX: true,
						// scrollCollapse: true,
						// scroller: true,
					});
				} else {
					// var tbtb = $.fn.dataTable.fnTables(true);

					// $(tbtb).each(function () {
					// 	$(this).dataTable().fnDestroy();
					// });
				}

				//tbtb.columns.adjust().responsive.recalc();
			});
		}

		<?php foreach ($lending_ao as $res) { ?>
			new cchart('#detail_lending_ao<?php echo $res->kode_group2; ?>', '#dt_tables_lending<?php echo $res->kode_group2; ?>');
		<?php } ?>

		<?php foreach ($npl_kolektor as $res) { ?>
			new cchart2('#detail_npl_kol<?php echo $res->kode_group3; ?>', '#dt_tables_npl<?php echo $res->kode_group3; ?>', 21);
		<?php } ?>

		<?php foreach ($cr_kolektor as $res) { ?>
			new cchart2('#detail_cr_kolektor<?php echo $res->kode_group3; ?>', '#dt_tables_cr<?php echo $res->kode_group3; ?>',21);
		<?php } ?>

		<?php foreach ($cr_ao as $res) { ?>
			new cchart2('#detail_cr_ao<?php echo $res->kode_group2; ?>', '#dt_tables_cr_ao<?php echo $res->kode_group2; ?>',19);
		<?php } ?>

		<?php foreach ($bz_kolektor as $res) { ?>
			new cchart2('#detail_bz_kol<?php echo $res->kode_group3; ?>', '#dt_tables_bz<?php echo $res->kode_group3; ?>',21);
		<?php } ?>

		<?php foreach ($ns_ao as $res) { ?>
			new cchart('#detail_ns_ao<?php echo $res->kode_group2; ?>', '#dt_tables_ns<?php echo $res->kode_group2; ?>');
		<?php } ?>

		<?php foreach ($dataKolektibilitas as $res) { ?>
			new cchart('#detail_kol<?php echo $res->kolektibilitas; ?>', '#dt_tables_kol<?php echo $res->kolektibilitas; ?>');
		<?php } ?>
		//tutup datatable

		//alert data tidak ada
		var isiLending = "<div class='alert alert-danger alert-dismissible fade out show' role='alert'>Data <b>Lending</b> Tidak Ada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden=true'>&times;</span></button></div>";
		$('#nullLending').attr('data', isiLending);
		var nullLending = $('#nullLending').attr('data');
		$('#lendingNull').html(nullLending);

		var isiNpl = "<div class='alert alert-danger alert-dismissible fade out show' role='alert'>Data <b>NPL</b> Tidak Ada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden=true'>&times;</span></button></div>";
		$('#nullNpl').attr('data', isiNpl);
		var nullNpl = $('#nullNpl').attr('data');
		$('#nplNull').html(nullNpl);

		var isiCr = "<div class='alert alert-danger alert-dismissible fade out show' role='alert'>Data <b>CR Kolektor</b> Tidak Ada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden=true'>&times;</span></button></div>";
		$('#nullCr').attr('data', isiCr);
		var nullCr = $('#nullCr').attr('data');
		$('#crNull').html(nullCr);

		var isiCr = "<div class='alert alert-danger alert-dismissible fade out show' role='alert'>Data <b>CR AO</b> Tidak Ada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden=true'>&times;</span></button></div>";
		$('#nullCr_ao').attr('data', isiCr);
		var nullCr = $('#nullCr_ao').attr('data');
		$('#crNull_ao').html(nullCr);

		var isiBz = "<div class='alert alert-danger alert-dismissible fade out show' role='alert'>Data <b>Bucket 0</b> Tidak Ada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden=true'>&times;</span></button></div>";
		$('#nullBz').attr('data', isiBz);
		var nullBz = $('#nullBz').attr('data');
		$('#bzNull').html(nullBz);

		var isiNS = "<div class='alert alert-danger alert-dismissible fade out show' role='alert'>Data <b>Non Starter</b> Tidak Ada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden=true'>&times;</span></button></div>";
		$('#nullNS').attr('data', isiNS);
		var nullNS = $('#nullNS').attr('data');
		$('#nsNull').html(nullNS);
		//tutup alert data tidak ada
		
		// $(function() {
		// 	$('select[name=bulan]').on('change', function() {
		// 		let bulan = $(this).children('option:selected').val();
		// 		console.log(bulan)
		// 	});
		// 	$('select[name=tahun]').on('change', function() {
		// 		let tahun = $(this).children('option:selected').val();
		// 		console.log(tahun)
		// 	});
		// });

		var bulan = $('#bln').val();
		var tahun = $('#thn').val();

		console.log(bulan + " " + tahun);


	});
</script>
