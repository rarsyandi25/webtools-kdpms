<div class="content-wrapper">
	<input type="hidden" id="session_kantor" value="<?php echo $this->session->userdata('kantor'); ?>" />
	<!-- <input type="hidden" id="kd_group3" value="<#?php echo $this->session->userdata('kode_group3'); ?>" /> -->
	<input type="hidden" id="kd_group3" value="09" />
	<input type="hidden" id="nowDate" value="<?php echo date('Y-m-d'); ?>" />

	<div class="col-md-12">
		<div class="row mt-5">
			<div class="col-12 text-xs-center text-xl-left text-lg-left text-md-left text-sm-center">
				<a href="<?= base_url('tools'); ?>" class="btn btn-secondary btn-sm mt-n3"><i class="mdi mdi-keyboard-backspace"></i>Menu Tools</a>
			</div>
		</div>

		<div class="row mt-2">
			<div class="col-md-4 text-lg-left text-md-center text-sm-center text-center">
				Bulan : <b><?php echo ubahBulan($bulan); ?></b><br>
				Tahun : <b><?php echo $tahun; ?></b>
			</div>
			<div class="col-md-4 text-lg-center text-md-center text-sm-center text-center">
				<form action="<?php echo base_url('kpi/dashboard_kpi_col'); ?>" method="post" class="form-inline justify-content-center mt-1">
					Filter Data : &nbsp;
					<select name="bulan" id="bulan" class="custom-select custom-select-sm my-1 mr-sm-2">
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
					</select>
					<select name="tahun" id="tahun" class="custom-select custom-select-sm my-1 mr-sm-2">
						<?php
						for ($thn = 2019; $thn <= date('Y'); $thn++) {
						?>
							<option value="<?= $thn; ?>" <?php if ($tahun == $thn) {
																echo ('selected');
															} ?>><?= $thn; ?></option>
						<?php } ?>
					</select>
					<button class="btn btn-sm btn-primary" id="btnFilter" type="submit">Filter</button>
				</form>
			</div>
			<div class="col-md-4 text-lg-right text-md-center text-sm-center text-center">
				User :
				<b><?= $this->session->userdata('username'); ?></b><br>
				Kantor :
				<b><?= namaKantor($this->session->userdata('kantor')); ?></b>
			</div>
		</div>
	</div>
	<hr />

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
				<div id="bzNull">

				</div>&nbsp;
				<div id="crNull">

				</div>&nbsp;
				<div id="nplNull">

				</div>&nbsp;
			</div>
		</div>
	</span>
	<!-- end handle data jika null -->

	<div class="row justify-content-center">
		<?php if ($bz_kolektor > 0 || $cr_kolektor > 0 || $npl_kolektor > 0) { ?>

			<!-- NPL -->
			<?php if ($npl_kolektor > 0) { ?>

				<span class="rounded-circle spedo npl_popover" data-popover="popover" data-html="true" data-placement="top" data-trigger="hover">
					<a class="rounded-circle npl_spedo" href="" data-toggle="modal" data-target="#modal_npl">
					
					</a>
				</span>
			<?php
			} else {
				echo '<span id="nullNPL" data=""></span>';
			} ?>
			<!-- /NPL -->
			
			<!-- Collection Ratio -->
				
			<?php if ($cr_kolektor > 0) {  ?>

				<span class="rounded-circle spedo cr_popover" data-popover="popover" data-html="true" data-placement="top" data-trigger="hover">
					<a class="rounded-circle cr_spedo" href="" data-toggle="modal" data-target="#modal_cr">
					
					</a>
				</span>
			<?php
			} else {
				echo '<span id="nullCR" data=""></span>';
			} ?>
			<!-- /Collection Ratio -->

			<!-- Bucket Zero -->
			
			<?php if ($bz_kolektor > 0) { ?>
				<span class="rounded-circle spedo bz_popover" data-popover="popover" data-html="true" data-placement="top" data-trigger="hover">
					<a class="rounded-circle bz_spedo" href="" data-toggle="modal" data-target="#modal_cr">
					
					</a>
				</span>
			<?php
			} else {
				echo '<span id="nullBZ" data=""></span>';
			} ?>
			<!-- /Bucket Zero -->

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

	<!-- Modal Bucket Zero -->
	<div class="modal fade" id="modal_bz" tabindex="2" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header bg-light">
					<h5 class="modal-title" id="exampleModalLongTitle">Detail Bucket Zero
						<p><?= $this->session->userdata('username'); ?>, <?= ubahBulan($bulan) . "&nbsp" . $tahun; ?></p>
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<table id="dt_tables_bz" class="table table-bordered table-hover display compact nowrap" style="width:100%">
						<thead class="bg-light">
							<tr>
								<th>No Rekening</th>
								<th>Nama Nasabah</th>
								<th>Alamat</th>
								<th>Tanggal Realisasi</th>
								<th>Jangka Waktu</th>
								<th>Jatuh Tempo</th>
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
							<?php foreach ($bz_detail as $resDetail) { ?>
								<tr>
									<td><?= $resDetail->no_rekening; ?></td>
									<td><?= $resDetail->nama_nasabah; ?></td>
									<td><?= $resDetail->alamat; ?></td>
									<td><?= ubahDate($resDetail->tgl_realisasi); ?></td>
									<td><?= $resDetail->jkw . " Bulan"; ?></td>
									<td><?= ubahDate($resDetail->tgl_jatuh_tempo); ?></td>
									<td><?= substr($resDetail->tgl_jatuh_tempo,8,2); ?></td>
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
				<div class="modal-footer bg-light">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">
						Close
					</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /Modal Bucket Zero -->

	<!-- Modal Collection Ratio -->
	<div class="modal fade" id="modal_cr" tabindex="4" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header bg-light">
					<h5 class="modal-title" id="exampleModalLongTitle">Detail Collection Ratio
						<p><?= $this->session->userdata('username'); ?>, <?= ubahBulan($bulan) . "&nbsp" . $tahun; ?><p>
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<table id="dt_tables_cr" class="table table-bordered table-hover display compact nowrap" style="width:100%">
						<thead class="bg-light">
							<tr>
								<th>No Rekening</th>
								<th>Nama Nasabah</th>
								<th>Alamat</th>
								<th>Tanggal Realisasi</th>
								<th>Jangka Waktu</th>
								<th>Jatuh Tempo</th>
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
							<?php foreach ($cr_detail as $resDetail) { ?>
								<tr>
									<td><?= $resDetail->no_rekening; ?></td>
									<td><?= $resDetail->nama_nasabah; ?></td>
									<td><?= $resDetail->alamat; ?></td>
									<td><?= ubahDate($resDetail->tgl_realisasi); ?></td>
									<td><?= $resDetail->jkw . " Bulan"; ?></td>
									<td><?= ubahDate($resDetail->tgl_jatuh_tempo); ?></td>
									<td><?= substr($resDetail->tgl_jatuh_tempo,8,2); ?></td>
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
				<div class="modal-footer bg-light">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">
						Close
					</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /Modal Collection Ratio -->

	<!-- Modal NPL -->
	<div class="modal fade" id="modal_npl" tabindex="3" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header bg-light">
					<h5 class="modal-title" id="exampleModalLongTitle">Detail NPL
						<p><?= $this->session->userdata('username'); ?>, <?= ubahBulan($bulan) . "&nbsp" . $tahun; ?></p>
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<table id="dt_tables_npl" class="table table-bordered table-hover display compact nowrap" style="width:100%">
						<thead class="bg-light">
							<tr>
								<th>No Rekening</th>
								<th>Nama Nasabah</th>
								<th>Alamat</th>
								<th>Tanggal Realisasi</th>
								<th>Jangka Waktu</th>
								<th>Jatuh Tempo</th>
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
							<?php foreach ($npl_detail as $resDetail) { ?>
								<tr>
									<td><?= $resDetail->no_rekening; ?></td>
									<td><?= $resDetail->nama_nasabah; ?></td>
									<td><?= $resDetail->alamat; ?></td>
									<td><?= ubahDate($resDetail->tgl_realisasi); ?></td>
									<td><?= $resDetail->jkw . " Bulan"; ?></td>
									<td><?= ubahDate($resDetail->tgl_jatuh_tempo); ?></td>
									<td><?= substr($resDetail->tgl_jatuh_tempo,8,2); ?></td>
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
				<div class="modal-footer bg-light">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">
						Close
					</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /Modal NPL -->

</div>
<!-- content-wrapper ends -->


<?php require_once('include/footerkpi.php'); ?>


<script type="text/javascript">
	$(document).ready(function() {

		//datatable
		function cchart(id_modal, id_table, colgrp,title) {
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
							[7, 10, 25, 50, 100],
							[7, 10, 25, 50, 100]
						],
						responsive: {
							details: {
								renderer: function(api, rowIdx, columns) {
									var data = $.map(columns, function(col, i) {
										return col.hidden ?
											'<tr data-dt-row="' + col.rowIndex +
											'" data-dt-column="' + col.columnIndex +
											'">' +
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
						order: [
							[colgrp, "asc"]
						],
						columnDefs: [{
							className: 'control',
							orderable: true,
							targets: 0
						}],
						buttons: [
							{
								extend: 'excelHtml5',
								title: title,
								autoFilter: true,
								className: 'btn btn-sm btn-primary bg-primary ',
								messageTop: <?= $bulan ?>+'/'+<?= $tahun ?>,
								exportOptions: {
									columns: [0,1,2,3,4,5,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23]
								}
							},
							// {
							// 	extend: 'pdfHtml5',
							// 	pageSize: 'A4',
							// 	title: title,
							// 	orientation: 'potrait',
							// 	className: 'btn btn-sm btn-primary bg-primary ',
							// 	messageTop: <?= $bulan ?>+'/'+<?= $tahun ?>,
							// 	exportOptions: {
							// 		columns: [ 0, 1, 3, 5 ]
							// 	}
							// },
							// {
							// 	extend: 'pdfHtml5',
							// 	text: 'OPEN AS PDF',
							// 	download: 'open',
							// 	pageSize: 'A4',
							// 	title: title,
							// 	orientation: 'potrait',
							// 	className: 'btn btn-sm btn-primary bg-primary ',
							// 	messageTop: <?= $bulan ?>+'/'+<?= $tahun ?>,
							// 	exportOptions: {
							// 		columns: [ 0, 1, 3, 5 ]
							// 	}
								
							// },
							// {
							// 	extend: 'print',
							// 	title: title,
							// 	className: 'btn btn-sm btn-primary bg-primary ',
							// 	messageTop: <?= $bulan ?>+'/'+<?= $tahun ?>,
							// 	exportOptions: {
							// 		columns: [ 0, 1, 3 ]
							// 	}
							// },
							
						],
						// fixedColumns: {
						// 	leftColumns: 2
						// },
						dom: "B<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
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
		new cchart('#modal_bz', '#dt_tables_bz', 6,'DATA BZ');
		new cchart('#modal_cr', '#dt_tables_cr', 6,'DATA CR');
		new cchart('#modal_npl', '#dt_tables_npl', 6, 'DATA NPL');
		//tutup datatable


		//alert data tidak ada
		var isiBZ = "<div class='alert alert-danger alert-dismissible fade out show' role='alert'>Data <b>BZ</b> Tidak Ada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden=true'>&times;</span></button></div>";
		$('#nullBZ').attr('data', isiBZ);
		var nullBZ = $('#nullBZ').attr('data');
		$('#bzNull').html(nullBZ);

		var isiCR = "<div class='alert alert-danger alert-dismissible fade out show' role='alert'>Data <b>CR</b> Tidak Ada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden=true'>&times;</span></button></div>";
		$('#nullCR').attr('data', isiCR);
		var nullCR = $('#nullCR').attr('data');
		$('#crNull').html(nullCR);

		var isiNPL = "<div class='alert alert-danger alert-dismissible fade out show' role='alert'>Data <b>NPL</b> Tidak Ada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden=true'>&times;</span></button></div>";
		$('#nullNPL').attr('data', isiNPL);
		var nullNPL = $('#nullNPL').attr('data');
		$('#nplNull').html(nullNPL);
		//tutup alert data tidak ada

	});

	// ajax data
	const url = '<?= base_url('kpi/'); ?>';
	const loading = `<div class="spinner-border text-dark" style="font-size: 2px; height: 20px; width: 20px;" role="status">
						<span class="sr-only">Loading...</span>
					</div>`;
	let kantor = $('#session_kantor').val();
	let kode_group3 = $('#kd_group3').val();
	let bulan = '<?= $bulan; ?>';
	let tahun = '<?= $tahun; ?>';
	let status = 'kpi_col';

	console.log(kantor +" "+ kode_group3 +" "+ bulan +" "+ tahun);
	
	nplKolektor();
	function nplKolektor() {

		$.ajax({
			url: url + "spedo_npl_kolektor/" +tahun+"/"+bulan+"/"+kode_group3+"/"+kantor+"/"+status,
			method: "GET",
			dataType: "JSON",
			success: function(data) {
				// console.log(data);
				if (data.length > 0) {
					
					let spedo = getDataSpedo(data[0].data_spedo);

					$('.npl_popover').attr("data-content", "<b>NPL : "+ ambil2Angka(data[0].jml_value) +" % <br> Status : "+ getStatusNPL(data[0].jml_value, spedo[0], spedo[3], spedo[6], spedo[9]) +" <br> Baki Debet NPL : "+ rupiah(data[0].jml_bd_npl) +" <br> Total Baki Debet : "+ rupiah(data[0].jml_bd) +"</b>");
					$('.npl_spedo').html(`
						<canvas class="mt-2 mb-2 mx-2 rounded-circle" id="spedo_npl" data-type="radial-gauge" data-width="300" data-height="300" data-units="`+ data[0].unit +`" data-title="`+ data[0].title +`" data-value="`+ data[0].jml_value +`" data-min-value="0" data-max-value="`+ data[0].jml_max_value +`" data-major-ticks="`+ data[0].mayor_ticks +`" data-minor-ticks="`+ data[0].minor_ticks +`" data-stroke-ticks="true" data-highlights='`+ data[0].data_spedo +`' data-color-plate="#010101" data-color-major-ticks="#000000" data-color-minor-ticks="#000000" data-color-title="#fff" data-color-units="#ccc" data-color-numbers="#eee" data-color-needle="rgba(240, 128, 128, 1)" data-color-needle-end="rgba(255, 160, 122, .9)" data-value-box="true" data-animate-on-init="true" data-animation-rule="bounce" data-animation-duration="1500"></canvas>
					`);
				}
			} 
		});
	}

	crKolektor();
	function crKolektor() {

		$.ajax({
			url: url + "spedo_cr_kolektor/" +tahun+"/"+bulan+"/"+kode_group3+"/"+kantor+"/"+status,
			method: "GET",
			dataType: "JSON",
			success: function(data) {
				// console.log(data);
				if (data.length > 0) {

					let spedo = getDataSpedo(data[0].data_spedo);

					$('.cr_popover').attr("data-content", "<b>Collection Ratio : "+ ambil2Angka(data[0].jml_value) +" % <br> Status : "+ getStatus(data[0].jml_value, spedo[0], spedo[3], spedo[6], spedo[9]) +" <br> Jumlah Tagihan : "+ rupiah(data[0].jml_tagihan) +" <br> Jumlah Bayar : "+ rupiah(data[0].jml_bayar) +"</b>");
					$('.cr_spedo').html(`
						<canvas class="mt-2 mb-2 mx-2 rounded-circle" id="spedo_cr" data-type="radial-gauge" data-width="300" data-height="300" data-units="`+ data[0].unit +`" data-title="`+ data[0].title +`" data-value="`+ data[0].jml_value +`" data-min-value="0" data-max-value="`+ data[0].jml_max_value +`" data-major-ticks="`+ data[0].mayor_ticks +`" data-minor-ticks="`+ data[0].minor_ticks +`" data-stroke-ticks="true" data-highlights='`+ data[0].data_spedo +`' data-color-plate="#010101" data-color-major-ticks="#000000" data-color-minor-ticks="#000000" data-color-title="#fff" data-color-units="#ccc" data-color-numbers="#eee" data-color-needle="rgba(240, 128, 128, 1)" data-color-needle-end="rgba(255, 160, 122, .9)" data-value-box="true" data-animate-on-init="true" data-animation-rule="bounce" data-animation-duration="1500"></canvas>
					`);
				}
			} 
		});
	}

	bzKolektor();
	function bzKolektor() {

		$.ajax({
			url: url + "spedo_bz_kolektor/" +tahun+"/"+bulan+"/"+kode_group3+"/"+kantor+"/"+status,
			method: "GET",
			dataType: "JSON",
			success: function(data) {
				// console.log(data);
				if (data.length > 0) {

					let spedo = getDataSpedo(data[0].data_spedo);

					$('.bz_popover').attr("data-content", "<b> Bucket Zero : "+ ambil2Angka(data[0].jml_value) +" % <br> Status : "+ getStatus(data[0].jml_value, spedo[0], spedo[3], spedo[6], spedo[9]) +" <br> Jumlah Tagihan : "+ rupiah(data[0].jml_tagihan) +" <br> Jumlah Bayar : "+ rupiah(data[0].jml_bayar) +"</b>");
					$('.bz_spedo').html(`
						<canvas class="mt-2 mb-2 mx-2 rounded-circle" id="spedo_cr" data-type="radial-gauge" data-width="300" data-height="300" data-units="`+ data[0].unit +`" data-title="`+ data[0].title +`" data-value="`+ data[0].jml_value +`" data-min-value="0" data-max-value="`+ data[0].jml_max_value +`" data-major-ticks="`+ data[0].mayor_ticks +`" data-minor-ticks="`+ data[0].minor_ticks +`" data-stroke-ticks="true" data-highlights='`+ data[0].data_spedo +`' data-color-plate="#010101" data-color-major-ticks="#000000" data-color-minor-ticks="#000000" data-color-title="#fff" data-color-units="#ccc" data-color-numbers="#eee" data-color-needle="rgba(240, 128, 128, 1)" data-color-needle-end="rgba(255, 160, 122, .9)" data-value-box="true" data-animate-on-init="true" data-animation-rule="bounce" data-animation-duration="1500"></canvas>
					`);
				}
			} 
		});
	}
</script>
