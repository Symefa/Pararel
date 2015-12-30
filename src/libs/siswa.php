<?php
/*
* Bismillah
* Dibuat Oleh Alifa Izzan 2015
* izzan@smalane.com
*/
class siswa
{
    public $id
    public $nik
    public $nama
    public $kelas
    public $nilai
    public $sertifikat
    public $pilihan

    public function __construct($Id,$Nik,$Nama,$Kelas,$Sertifikat,$Nilai,$Pilihan)
            $this->id = $Id;
            $this->nik = $Nik;
            $this->kelas = $Kelas;
            $this->sertifikat = $Sertifikat;
            $this->nilai = $Nilai;
            $this->pilihan = $Pilihan;
        }

    public function toarray()
    {
       $finalArray = array('id' => $this->id, 'nik' => $this->nik,'nama' => $this->nama,'kelas' => $this->kelas, 'sertifikat' => $this->$sertifikat);
       $scorer = explode(",", $this->nilai);
       $choser = explode(",", $this->pilihan);
       
       for ($i = 0, $c = count($scorer)/17; $i < $c; $i++)
        {
            $increment = $i*17;
            $arrayNilai = array(
                'agama' => $scorer[0+$increment], 
                'pKN' => $scorer[1+$increment], 
                'bIndo' => $scorer[2+$increment],
                'bInggris' => $scorer[3+$increment],
                'matJib' => $scorer[4+$increment],
                'matPem' => $scorer[5+$increment], 
                'fisika' => $scorer[6+$increment],
                'kimia' => $scorer[7+$increment],
                'biologi' => $scorer[8+$increment],
                'sejWa' => $scorer[9+$increment],
                'sejPem' => $scorer[10+$increment],
                'geografi' => $scorer[11+$increment],
                'sosio' => $scorer[12+$increment],
                'ekonomi' => $scorer[13+$increment],
                'senBud' => $scorer[14+$increment],
                'prakarya' => $scorer[15+$increment],
                'penjaskes' => $scorer[16+$increment]
                );
            array_push($finalArray, ['nilai'.$i+1 => $arrayNilai]);
        }

        for ($i = 0, $c = count($choser); $i < $c; $i++)
        {
            $arrayPilihan = array(
                'pilihan'.$i+1 => $choser[$i] 
                );
            array_push($finalArray, $arrayPilihan);
        }

        return $finalArray;

    }
}
?>