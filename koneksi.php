<?php
class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'db_uas_pbo_trpl1a_hazelransykrishna';
    private $connection;

    // Constructor - koneksi otomatis saat object dibuat
    public function __construct() {
        $this->connect();
    }

    // Method untuk koneksi ke database
    private function connect() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->connection->connect_error) {
            die("Koneksi gagal: " . $this->connection->connect_error);
        }

        $this->connection->set_charset("utf8");
    }

    // Method untuk mendapatkan koneksi
    public function getConnection() {
        return $this->connection;
    }

    // Method untuk menjalankan query SELECT
    public function query($sql) {
        return $this->connection->query($sql);
    }

    // Method untuk prepare statement
    public function prepare($sql) {
        return $this->connection->prepare($sql);
    }

    // Method untuk mendapatkan ID terakhir
    public function getInsertId() {
        return $this->connection->insert_id;
    }

    // Method untuk menghitung affected rows
    public function getAffectedRows() {
        return $this->connection->affected_rows;
    }

    // Method untuk menutup koneksi
    public function close() {
        if ($this->connection) {
            $this->connection->close();
        }
    }

    // Destructor - otomatis menutup koneksi
    public function __destruct() {
        $this->close();
    }
}

// Membuat object database global
$db = new Database();
?>