<?php
require_once 'Mahasiswa.php';

class MahasiswaBidikmisi extends Mahasiswa {
    private $nomor_kip_kuliah;
    private $dana_saku_subsidi;

    public function __construct($id_mahasiswa, $nama_mahasiswa, $nim, $semester, $tarif_ukt_nominal, $nomor_kip_kuliah, $dana_saku_subsidi, $db = null) {
        parent::__construct($id_mahasiswa, $nama_mahasiswa, $nim, $semester, $tarif_ukt_nominal, 'Bidik Misi', $db);
        $this->nomor_kip_kuliah = $nomor_kip_kuliah;
        $this->dana_saku_subsidi = $dana_saku_subsidi;
    }

    // Getter & Setter untuk nomor_kip_kuliah
    public function getNomorKipKuliah() {
        return $this->nomor_kip_kuliah;
    }

    public function setNomorKipKuliah($nomor_kip_kuliah) {
        $this->nomor_kip_kuliah = $nomor_kip_kuliah;
    }

    // Getter & Setter untuk dana_saku_subsidi
    public function getDanaSakuSubsidi() {
        return $this->dana_saku_subsidi;
    }

    public function setDanaSakuSubsidi($dana_saku_subsidi) {
        $this->dana_saku_subsidi = $dana_saku_subsidi;
    }

    // Implementasi abstract method
    public function hitungTagihanSemester() {
        // Mahasiswa Bidik Misi mendapat subsidi penuh (UKT 0)
        // Tapi tetap dapat dana saku
        $tagihan = 0;
        return $tagihan;
    }

    public function tampilkanSpesifikasiAkademik() {
        $tagihan = $this->hitungTagihanSemester();
        return "Mahasiswa Bidik Misi\n" .
               "Nama: {$this->nama_mahasiswa}\n" .
               "NIM: {$this->nim}\n" .
               "Semester: {$this->semester}\n" .
               "Nomor KIP Kuliah: {$this->nomor_kip_kuliah}\n" .
               "Dana Saku Subsidi: Rp " . number_format($this->dana_saku_subsidi, 0, ',', '.') . "\n" .
               "Tarif UKT: Rp " . number_format($this->tarif_ukt_nominal, 0, ',', '.') . "\n" .
               "Tagihan Semester: Rp " . number_format($tagihan, 0, ',', '.');
    }

    // Method SELECT-WHERE untuk mengambil data berdasarkan ID
    public function getDataById($id) {
        if ($this->db === null) {
            throw new Exception("Koneksi database tidak tersedia");
        }

        $query = "SELECT * FROM tabel_mahasiswa WHERE id_mahasiswa = ? AND jenis_pembayaran = 'Bidik Misi'";
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
            $this->nomor_kip_kuliah = $data['nomor_kip_kuliah'];
            $this->dana_saku_subsidi = $data['dana_saku_subsidi'];
            
            return $data;
        }
        
        return null;
    }
}
?>

//