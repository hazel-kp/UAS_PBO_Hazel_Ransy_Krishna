<?php
require_once 'Mahasiswa.php';

class MahasiswaMandiri extends Mahasiswa {
    private $golongan_ukt;
    private $nama_wali;

    public function __construct($id_mahasiswa, $nama_mahasiswa, $nim, $semester, $tarif_ukt_nominal, $golongan_ukt, $nama_wali, $db = null) {
        parent::__construct($id_mahasiswa, $nama_mahasiswa, $nim, $semester, $tarif_ukt_nominal, 'Mandiri', $db);
        $this->golongan_ukt = $golongan_ukt;
        $this->nama_wali = $nama_wali;
    }

    // Getter & Setter untuk golongan_ukt
    public function getGolonganUkt() {
        return $this->golongan_ukt;
    }

    public function setGolonganUkt($golongan_ukt) {
        $this->golongan_ukt = $golongan_ukt;
    }

    // Getter & Setter untuk nama_wali
    public function getNamaWali() {
        return $this->nama_wali;
    }

    public function setNamaWali($nama_wali) {
        $this->nama_wali = $nama_wali;
    }

    // Implementasi abstract method
    public function hitungTagihanSemester() {
        // Logika perhitungan berdasarkan golongan_ukt
        $potongan = 0;
        switch($this->golongan_ukt) {
            case 'A':
                $potongan = 0.5; // 50% potongan
                break;
            case 'B':
                $potongan = 0.3; // 30% potongan
                break;
            case 'C':
                $potongan = 0.1; // 10% potongan
                break;
            default:
                $potongan = 0;
        }
        
        $tagihan = $this->tarif_ukt_nominal * (1 - $potongan);
        return $tagihan;
    }

    public function tampilkanSpesifikasiAkademik() {
        $tagihan = $this->hitungTagihanSemester();
        return "Mahasiswa Mandiri\n" .
               "Nama: {$this->nama_mahasiswa}\n" .
               "NIM: {$this->nim}\n" .
               "Semester: {$this->semester}\n" .
               "Golongan UKT: {$this->golongan_ukt}\n" .
               "Nama Wali: {$this->nama_wali}\n" .
               "Tarif UKT: Rp " . number_format($this->tarif_ukt_nominal, 0, ',', '.') . "\n" .
               "Tagihan Semester: Rp " . number_format($tagihan, 0, ',', '.');
    }

    // Method SELECT-WHERE untuk mengambil data berdasarkan ID
    public function getDataById($id) {
        if ($this->db === null) {
            throw new Exception("Koneksi database tidak tersedia");
        }

        $query = "SELECT * FROM tabel_mahasiswa WHERE id_mahasiswa = ? AND jenis_pembayaran = 'Mandiri'";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            
            // Update properti dengan data dari database
            $this->id_mahasiswa = $data['id_mahasiswa'];
            $this->nama_mahasiswa = $data['nama_mahasiswa'];
            $this->nim = $data['nim'];
            $this->semester = $data['semester'];
            $this->tarif_ukt_nominal = $data['tarif_ukt_nominal'];
            $this->golongan_ukt = $data['golongan_ukt'];
            $this->nama_wali = $data['nama_wali'];
            
            return $data;
        }
        
        return null;
    }
}
?>