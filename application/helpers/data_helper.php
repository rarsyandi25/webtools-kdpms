<?php
    date_default_timezone_set('Asia/Jakarta');

    //membuat format angka menjadi rupiah
    function rupiah($angka){
            
        $hasil = "Rp " . number_format($angka, 2, ',', '.');
        return $hasil;
    }

    // mengubah lending menjadi dalam format juta
    function ubahJuta($angka){

        $nominal = round($angka * 1000000);
        $ubahFormatRupiah = rupiah($nominal);
        return $ubahFormatRupiah;
    }
    
    //menubah nama bulan 
    function ubahBulan($month){

        $bulan_array = array(
            '01'=>"Januari",
            '02'=>"Februari",
            '03'=>"Maret", 
            '04'=>"April", 
            '05'=>"Mei",
            '06'=>"Juni",
            '07'=>"Juli",
            '08'=>"Agustus",
            '09'=>"September",
            '10'=>"Oktober", 
            '11'=>"November",
            '12'=>"Desember");

        $bulan = $bulan_array[$month];
        return $bulan;
    }

    //ubah nama kantor berdasarkan id kantor
    function namaKantor($kode){

        $kantor_array = array(
            '01' => "Pusat", 
            '02' => "Cabang Cilodong");

        $kantor = $kantor_array[$kode];
        return $kantor;
    }

    // ubah format date menjadi tanggal-bulan-tahun indonesia
    function ubahDate($date){
        
        $tgl = substr($date, 8, 2);
        $bln = substr($date, 5, 2);
        $thn = substr($date, 0, 4);
    
        switch ($bln) {
            case 1 : {
                    $bln = 'Januari';
                }break;
            case 2 : {
                    $bln = 'Februari';
                }break;
            case 3 : {
                    $bln = 'Maret';
                }break;
            case 4 : {
                    $bln = 'April';
                }break;
            case 5 : {
                    $bln = 'Mei';
                }break;
            case 6 : {
                    $bln = "Juni";
                }break;
            case 7 : {
                    $bln = 'Juli';
                }break;
            case 8 : {
                    $bln = 'Agustus';
                }break;
            case 9 : {
                    $bln = 'September';
                }break;
            case 10 : {
                    $bln = 'Oktober';
                }break;
            case 11 : {
                    $bln = 'November';
                }break;
            case 12 : {
                    $bln = 'Desember';
                }break;
            default: {
                    $bln = 'UnKnown';
                }break;
        }
    
        $tanggalIndonesia = $tgl . " " . $bln . " " . $thn;
        return $tanggalIndonesia;
    }

    // mengambil 2 angka setelah koma
    function ambil2Angka($angka){
        
        $ubah = number_format($angka, 2);
        return $ubah;
    }

    //get kolektibilitas list
    function getKolektibilitas($angka){

        switch($angka){
            case $angka == 1 :
                $status = "Lancar";
                break;
            case $angka == 2 :
                $status = "Dalam Perhatian Khusus (DPK)";
                break;
            case $angka == 3 :
                $status = "Kredit Kurang Lancar";
                break;
            case $angka == 4 :
                $status = "Diragukan";
                break;
            case $angka == 5 :
                $status = "Macet";
                break;
            default :
                $status = "Not valid";
                break;
        }  
        return $status;
    }

    //fungsi konversi data hari kedalam bulan
    function convertDayMonth($hari){
        //asumsi 30hari perbulan
        $hariPerBulan = 30;

        $cariBulan = floor($hari / $hariPerBulan);
        $sisaHari = $hari % $hariPerBulan;

        if ($cariBulan == 0){
            $get = $hari . " Hari ";
        }else if ($sisaHari == 0){
            $get = $cariBulan . " Bulan " . "($hari Hari)";
        }else {
            $get = $cariBulan . " Bulan " . $sisaHari . " Hari " . "($hari Hari)";
        }

        return $get;
    }
    
