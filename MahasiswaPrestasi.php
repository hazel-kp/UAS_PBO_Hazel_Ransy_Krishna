<?php
require_once 'Mahasiswa.php';

class MahasiswaPrestasi extends Mahasiswa {
    private $nama_instansi_beasiswa;
    private $minimal_ukt_bersyarat;

    public function __construct($id_mahasiswa, $nama_mahasiswa, $nim, $semester, $tarif_ukt_nominal, $nama_instansi_beasiswa, $minimal_ukt_bersyarat, $db = null) {
        parent::__construct($id_mahasiswa, $nama_mahasiswa, $nim, $semester, $tarif_ukt_nominal, 'Prestasi', $db);
        $this->nama_instansi_beasiswa = $nama_instansi_beasiswa;
        $this->minimal_ukt_bersyarat = $minimal_ukt_bersyarat;
    }

    // Getter & Setter untuk nama_instansi_beasiswa
    public function getNamaInstansiBeasiswa() {
        return $this->nama_instansi_beasiswa;
    }

    public function setNamaInstansiBeasiswa($nama_instansi_beasiswa) {
        $this->nama_instansi_beasiswa = $nama_instansi_beasiswa;
    }

    // Getter & Setter untuk minimal_ukt_bersyarat
    public function getMinimalUktBersyarat() {
        return $this->minimal_ukt_bersyarat;
    }

    public function setMinimalUktBersyarat($minimal_ukt_bersyarat) {
        $this->minimal_ukt_bersyarat = $minimal_ukt_bersyarat;
    }

    // Implementasi abstract method dengan logika baru
    public function hitungTagihanSemester() {
        // Total tagihan = tarifUktNominal * 0.25 (Potongan 75%)
        $tagihan = $this->tarif_ukt_nominal * 0.25;
        return $tagihan;
    }

    public function tampilkanSpesifikasiAkademik() {
        $tagihan = $this->hitungTagihanSemester();
        $potongan = $this->tarif_ukt_nominal * 0.75;
        return "Mahasiswa Prestasi\n" .
               "Nama: {$this->nama_mahasiswa}\n" .
               "NIM: {$this->nim}\n" .
               "Semester: {$this->semester}\n" .
               "Instansi Beasiswa: {$this->nama_instansi_beasiswa}\n" .
               "Minimal UKT Bersyarat: Rp " . number_format($this->minimal_ukt_bersyarat, 0, ',', '.') . "\n" .
               "Tarif UKT: Rp " . number_format($this->tarif_ukt_nominal, 0, ',', '.') . "\n" .
               "Potongan Beasiswa (75%): Rp " . number_format($potongan, 0, ',', '.') . "\n" .
               "Tagihan Semester (25%): Rp " . number_format($tagihan, 0, ',', '.');
    }

    // Method SELECT-WHERE untuk mengambil data berdasarkan ID
    public function getDataById($id) {
        if ($this->db === null) {
            throw new Exception("Koneksi database tidak tersedia");
        }

        $query = "SELECT * FROM tabel_mahasiswa WHERE id_mahasiswa = ? AND jenis_pembayaran = 'Prestasi'";
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
            $this->nama_instansi_beasiswa = $data['nama_instansi_beasiswa'];
            $this->minimal_ukt_bersyarat = $data['minimal_ukt_bersyarat'];
            
            return $data;
        }
        
        return null;
    }
}
?>