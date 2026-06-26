<?php
abstract class Mahasiswa {
    protected $id_mahasiswa;
    protected $nama_mahasiswa;
    protected $nim;
    protected $semester;
    protected $tarif_ukt_nominal;
    protected $jenis_pembayaran;
    protected $db; // ✅ TAMBAHAN: Properti untuk koneksi database

    // 🔄 PERUBAHAN: Constructor dengan tambahan parameter $db
    public function __construct($id_mahasiswa, $nama_mahasiswa, $nim, $semester, $tarif_ukt_nominal, $jenis_pembayaran, $db = null) {
        $this->id_mahasiswa = $id_mahasiswa;
        $this->nama_mahasiswa = $nama_mahasiswa;
        $this->nim = $nim;
        $this->semester = $semester;
        $this->tarif_ukt_nominal = $tarif_ukt_nominal;
        $this->jenis_pembayaran = $jenis_pembayaran;
        $this->db = $db; // ✅ TAMBAHAN: Inisialisasi db
    }

    // Getter methods
    public function getIdMahasiswa() {
        return $this->id_mahasiswa;
    }

    public function getNamaMahasiswa() {
        return $this->nama_mahasiswa;
    }

    public function getNim() {
        return $this->nim;
    }

    public function getSemester() {
        return $this->semester;
    }

    public function getTarifUktNominal() {
        return $this->tarif_ukt_nominal;
    }

    public function getJenisPembayaran() {
        return $this->jenis_pembayaran;
    }

    // ✅ TAMBAHAN: Getter untuk db
    public function getDb() {
        return $this->db;
    }

    // Setter methods
    public function setIdMahasiswa($id_mahasiswa) {
        $this->id_mahasiswa = $id_mahasiswa;
    }

    public function setNamaMahasiswa($nama_mahasiswa) {
        $this->nama_mahasiswa = $nama_mahasiswa;
    }

    public function setNim($nim) {
        $this->nim = $nim;
    }

    public function setSemester($semester) {
        $this->semester = $semester;
    }

    public function setTarifUktNominal($tarif_ukt_nominal) {
        $this->tarif_ukt_nominal = $tarif_ukt_nominal;
    }

    public function setJenisPembayaran($jenis_pembayaran) {
        $this->jenis_pembayaran = $jenis_pembayaran;
    }

    // ✅ TAMBAHAN: Setter untuk db
    public function setDb($db) {
        $this->db = $db;
    }

    // Abstract methods (tidak berubah)
    abstract public function hitungTagihanSemester();
    abstract public function tampilkanSpesifikasiAkademik();
    abstract public function getDataById($id);
}
?>