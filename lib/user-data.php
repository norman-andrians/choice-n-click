<?php
include '../connect.php';

class User {
    public $id;
    public $username;
    public $nickname;
    public $email;
    public $priority;
    protected $password;
    protected $id_business;

    public function __construct($id, $username, $nickname, $email, $password, $priority) {
        $this->id = $id;
        $this->username = $username;
        $this->nickname = $nickname;
        $this->email = $email;
        $this->priority = $priority;
        $this->password = $password;
    }

    // Mengubah Password
    public function SetPassword($password) {
        $this->password = $password;
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
    public function Create() {
        include '../connect.php';

        $username = $this->username;
        $nickname = $this->nickname;
        $email = $this->email;
        $priority = $this->priority;
        $password = $this->password;
        $id_business = $this->id_business;

        if ($this->GetUsername() != "$username") {
            $query = "INSERT `users` (`id`, `username`, `nickname`, `email`, `prioritas`, `password`, `id_business`) VALUES (NULL, '$username', '$nickname', '$email', '$priority', '$password', '$id_business')";
            $connect->query($query);
        }
        else {
            // Error: `username` sudah tersedia
        }
    }

    // Membaca seluruh data kolom dalam satu baris dan mengembalikannya menjadi mysqli_result
    public function Read() {
        include '../connect.php';

        $query = "SELECT * FROM `users` WHERE `id` = 1";
        $result = $connect->query($query);

        return $result;
    }

    public function Delete() {
        include '..connect.php';

        $username = $this->username;
        $query = "DELETE FROM `users` WHERE `username` = $username";
        $connect->query($query);
    }
}

class Business extends User {
    public $b_id;
    public $b_name;
    public $b_loc_prov;
    public $b_loc_city;

    public function CreateBusinessData() {
        
    }
}
?>