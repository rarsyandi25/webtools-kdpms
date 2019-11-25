<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Model_kpi extends CI_Model {

	//KPI NPL
	public function datakpi_npl($tahun = '', $bulan = '', $tanggal = '', $kode_kantor = ''){
		$this->db->query("SELECT '$tahun-$bulan-$tanggal' INTO @pv_per_tgl"); // GET VIEW NPL PER CABANG
		return $this->db->query("SELECT * FROM kms_kpi.v_kpi_npl_cabang WHERE kode_kantor = '$kode_kantor'");
	}

	public function datakpi_npl_Kol($tahun = '', $bulan = '', $tanggal = '', $kode_kantor = ''){ // GET VIEW NPL PER KOLEKTOR
		$this->db->query("SELECT '$tahun-$bulan-$tanggal' INTO @pv_per_tgl");
		return $this->db->query("SELECT * FROM kms_kpi.v_kpi_npl_kolektor WHERE kode_kantor = '$kode_kantor'");
	}

	public function datakpi_npl_Kol_detail(){	// GET VIEW NPL PER KOLEKTOR-DETAIL
		$this->db->query("SELECT '2019-11-01' INTO @pv_per_tgl");
		$this->db->query("SELECT '01' INTO @pv_kode_kolektor");
		return $this->db->query("SELECT * FROM kms_kpi.v_kpi_kolektor_npl");
	}
	//END KPI NPL
	

	// KPI LENDING
	public function datakpi_lending($tahun = '', $bulan = '', $tanggal = '', $kode_kantor = ''){ // GET VIEW LENDING PER CABANG
		$this->db->query("SELECT '$tahun-$bulan-$tanggal' INTO @pv_per_tgl");
		return $this->db->query("SELECT * FROM kms_kpi.v_kpi_lending_cabang WHERE kode_kantor = '$kode_kantor'");
	}

	public function datakpi_lending_AO($tahun = '', $bulan = '', $tanggal = '', $kode_kantor = ''){ // GET VIEW LENDING PER AO
		$this->db->query("SELECT '$tahun-$bulan-$tanggal' INTO @pv_per_tgl");
		return $this->db->query("SELECT * FROM kms_kpi.v_kpi_lending_ao WHERE kode_kantor = '$kode_kantor'");
	}

	public function datakpi_lending_AOdetail($tahun = '', $bulan = '', $tanggal = '', $kode_group2){ // GET VIEW LENDING PER AO-DETAIL
		$this->db->query("SELECT '$tahun-$bulan-$tanggal' INTO @pv_per_tgl");
		$this->db->query("SELECT '$kode_group2' INTO @pv_kode_ao");
		return $this->db->query("SELECT * FROM kms_kpi.v_kpi_ao_lending");
	}
	// END KPI LENDING
	

	//KPI COLLECTION RATIO
	public function datakpi_CR($tahun = '', $bulan = '', $tanggal = '', $kode_kantor = ''){ // GET VIEW COLLECTION RATIO PER CABANG
		$this->db->query("SELECT '$tahun-$bulan-$tanggal' INTO @pv_per_tgl");
		return $this->db->query("SELECT * FROM kms_kpi.v_kpi_cr_cabang WHERE kode_kantor = '$kode_kantor'");
	}

	public function datakpi_CR_Kol($tahun = '', $bulan = '', $tanggal = '', $kode_kantor = ''){ //GET VIEW COLLECTION RATIO PER KOLEKTOR
		$this->db->query("SELECT '$tahun-$bulan-$tanggal' INTO @pv_per_tgl");
		return $this->db->query("SELECT * FROM kms_kpi.v_kpi_cr_kolektor WHERE kode_kantor = '$kode_kantor'");
	}

	public function datakpi_CR_Kol_detail(){ //GET VIEW COLLECTION RATIO PER KOLEKTOR-DETAIL
		$this->db->query("SELECT '2019-10-31' INTO @pv_per_tgl");
		$this->db->query("SELECT '01' INTO @pv_kode_kolektor");
		return $this->db->query("SELECT * FROM `kms_kpi`.`v_kpi_kolektor_cr`");
	}
	//END KPI COLLECTION RATIO

	
	//KPI BUCKET ZERO
	public function datakpi_BZ($tahun = '', $bulan = '', $tanggal = '', $kode_kantor = ''){ // GET VIEW BUCKET ZERO PER CABANG
		$this->db->query("SELECT '$tahun-$bulan-$tanggal' INTO @pv_per_tgl");
		return $this->db->query("SELECT * FROM kms_kpi.v_kpi_bz_cabang WHERE kode_kantor = '$kode_kantor'");
  	}

  	public function datakpi_BZ_Kol($tahun = '', $bulan = '', $tanggal = '', $kode_kantor = ''){ //GET VIEW BUCKET ZERO PER KOLEKTOR
		$this->db->query("SELECT '$tahun-$bulan-$tanggal' INTO @pv_per_tgl");
		return $this->db->query("SELECT * FROM kms_kpi.v_kpi_bz_kolektor WHERE kode_kantor = '$kode_kantor'");
	}
	
	public function datakpi_BZ_Kol_detail(){ //GET VIEW BUCKET ZERO PER KOLEKTOR-DETAIL
		$this->db->query("SELECT '2019-11-01' INTO @pv_per_tgl");
		$this->db->query("SELECT '01' INTO @pv_kode_kolektor");
		return $this->db->query("SELECT * FROM kms_kpi.v_kpi_kolektor_bucket_zero");
	}
	//END KPI BUCKET ZERO


	// //KPI MITRA
	// public function datakpi_mitra_AO(){
	// 	$this->db->query("SELECT '2019-11-01' INTO @pv_per_tgl");
	// 	return $this->db->query("SELECT * FROM kms_kpi.v_kpi_ao_mitra WHERE kode_group2 = '05'");
	// }
	// //END KPI MITRA


	// //KPI SP RETURN
	// public function datakpi_spreturn_Kol(){
	// 	$this->db->query("SELECT '2019-11-01' INTO @pv_per_tgl");
	// 	return $this->db->query("SELECT * FROM kms_kpi.v_kpi_kolektor_sp_return WHERE kode_group3 = '09'");
	// }
	// //END KPI SP RETURN

}