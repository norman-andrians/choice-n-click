<?php
// ===
// *
// * Library user data kelas-kelas dan kueri mysqli berorientasi objek dasar
// * dengan sintaks kode sederhana
// * Berisi:
// * 1. Kelas User yang terdiri dari:
// *    - Properti id, uername, nickname, email, prioritas, password dan id bisnis
// *    - Method SetPassword, GetUsername dan CRUD
// * 2. Kelas Bisnis yang terdiri dari:
// *
// *
// ===

include '../connect.php';

class User {
    public $id;
    public $username;
    public $nickname;
    public $email;
    public $priority;

    protected $password;
    protected $id_business;

    // Construktor hanya terdiri dari 'id', 'username', dan 'email' untuk entry data dalam kelas dasar
    // Bisa disebut juga data sementara, ini tidak disimpan dalam cookie
    // * id business tidak boleh di konstruktor karena kelas business dulu yang harus dibuat
    public function __construct($id, $username, $email) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
    }

    // Mengubah Password
    public function SetPassword($password) {
        $this->password = $password;
    }

    public function GetId() {
        include '../connect.php';

        $id = "";
        $username = $this->username;

        $query = "SELECT `username` FROM `users` WHERE `username` = '$username'";
        $result = $connect->query($query);
        
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $id = $row['id'];
        }
        else {
            // Error: id pengguna tidak ditemukan
        }
        
        return $id;
    }

    // Mendapatkan username sesuai objek ini dari database
    protected function GetUsername() {
        include '../connect.php';

        $nama = "";
        $username = $this->username;

        $query = "SELECT `username` FROM `users` WHERE `username` = '$username'";
        $result = $connect->query($query);
        
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $nama = $row['username'];
        }
        
        return $nama;
    }

    // Membuat data user
    public function Create($nickname, $priority, $pw, $id_business) {
        include '../connect.php';

        $this->nickname = $nickname;
        $this->priority = $priority;
        $this->password = $pw;
        $this->id_business = $id_business;

        $username = $this->username;
        $email = $this->email;

        if ($this->GetUsername() != "$username") {
            $query = "INSERT `users` (`id`, `username`, `nickname`, `email`, `prioritas`, `password`, `id_business`) VALUES (NULL, '$username', '$nickname', '$email', '$priority', '$pw', '$id_business')";

            
        }
        else {
            // Error: `username` sudah tersedia
        }
    }

    // Membaca seluruh data kolom dalam satu baris dan mengembalikannya menjadi mysqli_result
    public function Read() {
        include '../connect.php';

        $id = $this->id;

        $query = "SELECT * FROM `users` WHERE `id` = $id";
        $result = $connect->query($query);

        return $result;
    }

    public function Update() {
        include '../connect.php';

        $id = $this->id;
        $username = $this->username;
        $nickname = $this->nickname;
        $email = $this->email;
        $priority = $this->priority;
    }

    // Memuat/update data dari database
    public function Load() {
        include '../connect.php';

        $id = $this->id;

        $query = "SELECT * FROM `users` WHERE `id` = $id";
        $result = $connect->query($query);

        if ($result->num_rows == 1) {
            $rows = $result->fetch_assoc();

            $this->username = $rows['username'];
            $this->nickname = $rows['nickname'];
            $this->email = $rows['email'];
            $this->priority = $rows['prioritas'];
            $this->password = $rows['password'];
            $this->id_business = $rows['id_business'];
        }
        else {
            // Error: data pengguna tidak ditemukan
        }
    }

    // Menghapus data user dari database (Dimustahilkan private karena jejak digital)
    // Jangan hapus data user yh
    private function Delete() {
        include '../connect.php';

        $username = $this->username;
        $query = "DELETE FROM `users` WHERE `username` = $username";
        $connect->query($query);
    }
}

$userd = new User(null, "erand", "ernad@example.com");
$userd->Create("erand333", 0, "ender1234", 8);

$data = $userd->Read();
$r = $data->fetch_assoc();


echo "id: ".$r['id']."<br>";
echo "username: ".$r['username']."<br>";
echo "nickname: ".$r['nickname']."<br>";
echo "email: ".$r['email']."<br>";

class Business extends User {
    public $b_id;
    public $b_name;
    public $b_loc_prov;
    public $b_loc_city;

    public function CreateBusinessData() {
        
    }
}
?>