<?php
require_once 'Mahasiswa.php';

class MahasiswaMandiri extends Mahasiswa {
    private $golongan_ukt;
    private $nama_wali;

    // 🔄 PERUBAHAN: Constructor dengan tambahan parameter $db
    public function __construct($id_mahasiswa, $nama_mahasiswa, $nim, $semester, $tarif_ukt_nominal, $golongan_ukt, $nama_wali, $db = null) {
        parent::__construct($id_mahasiswa, $nama_mahasiswa, $nim, $semester, $tarif_ukt_nominal, 'Mandiri', $db); // 🔄 Passing $db ke parent
        $this->golongan_ukt = $golongan_ukt;
        $this->nama_wali = $nama_wali;
    }

    // Getter & Setter (tidak berubah)
    public function getGolonganUkt() {
        return $this->golongan_ukt;
    }

    public function setGolonganUkt($golongan_ukt) {
        $this->golongan_ukt = $golongan_ukt;
    }

    public function getNamaWali() {
        return $this->nama_wali;
    }

    public function setNamaWali($nama_wali) {
        $this->nama_wali = $nama_wali;
    }

    // ✅ TIDAK BERUBAH: Implementasi hitungTagihanSemester
    public function hitungTagihanSemester() {
        // Total Tagihan = tarifUktNominal + 100000 (Biaya operasional)
        $tagihan = $this->tarif_ukt_nominal + 100000;
        return $tagihan;
    }

    // ✅ TIDAK BERUBAH: Implementasi tampilkanSpesifikasiAkademik
    public function tampilkanSpesifikasiAkademik() {
        $tagihan = $this->hitungTagihanSemester();
        return "Mahasiswa Mandiri\n" .
               "Nama: {$this->nama_mahasiswa}\n" .
               "NIM: {$this->nim}\n" .
               "Semester: {$this->semester}\n" .
               "Golongan UKT: {$this->golongan_ukt}\n" .
               "Nama Wali: {$this->nama_wali}\n" .
               "Tarif UKT: Rp " . number_format($this->tarif_ukt_nominal, 0, ',', '.') . "\n" .
               "Biaya Operasional: Rp 100.000\n" .
               "Tagihan Semester: Rp " . number_format($tagihan, 0, ',', '.');
    }

    // ✅ TIDAK BERUBAH: Method SELECT-WHERE
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