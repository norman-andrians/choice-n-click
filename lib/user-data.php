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
    public $p_number;
    public $image;
    public $priority;

    protected $password;
    protected $id_image;
    protected $id_business;

    // Construktor hanya terdiri dari 'id', 'username', dan 'email' untuk entry data dalam kelas dasar
    // Bisa disebut juga data sementara, ini tidak disimpan dalam cookie
    // * id business tidak boleh di konstruktor karena kelas business dulu yang harus dibuat
    public function __construct($id, $nickname, $email) {
        $this->id = $id;
        $this->nickname = $nickname;
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
    protected function GetNickname() {
        include '../connect.php';

        $nama = "";
        $id = $this->id;
        $username = $this->username;

        $query = "SELECT `nickname` FROM `users` WHERE `id` = '$id'";
        $result = $connect->query($query);
        
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $nama = $row['username'];
        }
        
        return $nama;
    }


    static function idExist($id) {
        include '../connect.php';

        $query = "SELECT * FROM `users` WHERE `id` = '$id'";
        $result = $connect->query($query);
        
        if ($result->num_rows == 1) {
            return true;
        }
        
        return false;
    }

    static function nicknameExist($nickname) {
        include '../connect.php';

        $query = "SELECT * FROM `users` WHERE `nickname` = '$nickname'";
        $result = $connect->query($query);
        
        if ($result->num_rows == 1) {
            return true;
        }
        
        return false;
    }

    static function emailExist($email) {
        include '../connect.php';

        $query = "SELECT * FROM `users` WHERE `email` = '$email'";
        $result = $connect->query($query);
        
        if ($result->num_rows == 1) {
            return true;
        }
        
        return false;
    }

    // Membuat data user
    public function Create($username, $phone_number, $priority, $pw, $image, $id_business) {
        include '../connect.php';
        include './user-data.php';

        $this->username = $username;
        $this->p_number = $phone_number;
        $this->priority = $priority;
        $this->password = $pw;
        $this->image = $image;
        $this->id_business = $id_business;

        $nickname = $this->nickname;
        $email = $this->email;

        $image_name = "user_" . $nickname . "_" . $id;
        $image_maxsize = 5000000; // max 5mb upload

        $img = new Image($image);

        if ($this->GetNickname() != "$nickname") {
            $query = "INSERT `users` (`id`, `username`, `nickname`, `email`, `prioritas`, `password`, `id_business`) VALUES (NULL, '$username', '$nickname', '$email', '$priority', '$pw', '$id_business')";

            $connect->query($query);
            $img->Create($image_name, $image_maxsize);
        }
        else {
            // Error: `nickname` sudah tersedia
        }
    }

    // Membaca seluruh data kolom dalam satu baris dan mengembalikannya menjadi mysqli_result
    public function Read() {
        include '../connect.php';

        $id = $this->id;

        $query = "SELECT * FROM `users` WHERE `id` = 3";
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

    static function GenerateOTP() {
        return rand(100000, 999999);
    }

    static function isOTPCorrect($input) {
        $code = $_COOKIE['otp_code'];

        if ($input == $code) {
            return true;
        }
        else { return false; }
    }

    public function sendOTP($code) {
        $to = $this->email;
        $subject = "Verifikasi kode OTP Choice N Click";
        $message = "
        <html>
        <head>
            <title>Verifikasi 6-digit kode OTP</title>
        </head>
        <body>
            <h1>Selamat Datang di Choice N Click!</h1>
            <p>Kami ingin mengkonfirmasi bahwa alamat email ini adalah milik anda. Silahkan masukan kode OTP dibawah ini</p>
            <h3>$code</h3>
            <p>Jika ini bukan anda yang membuat akun, segera hapus</p>
        </body>
        </html>
        ";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        mail($to, $subject, $message, $headers);
    }

}

class Business extends User {
    public $b_id;
    public $b_name;
    public $b_loc_prov;
    public $b_loc_city;

    public function __construct($id, $name, $loc_prov, $loc_city) {
        $this->b_id = $id;
        $this->b_name = $name;
        $this->b_loc_prov = $loc_prov;
        $this->b_loc_city = $loc_city;
    }
}

class ProductCategory extends Business {

}

class Product extends ProductCategory {
    
}
?>