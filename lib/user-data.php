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
    public function GetUsername() {
        include '../connect.php';

        $query = "SELECT `username` FROM `users` WHERE `username` = $this->username";
        $result = $connect->query($query);
        $row = $result->fetch_assoc();

        $name = $row["username"];

        return $name;
    }

    public function CreateUserData() {
        include '../connect.php';

        $username = $this->username;
        $nickname = $this->nickname;
        $email = $this->email;
        $priority = $this->priority;
        $password = $this->password;
        $id_business = $this->id_business;

        echo $this->GetUsername();

        if ($this->GetUsername() != $username) {
            $query = "INSERT `users` (`id`, `username`, `nickname`, `email`, `prioritas`, `password`, `id_business`) VALUES (NULL, '$username', '$nickname', '$email', '$priority', '$password', '$id_business')";
            $connect->query($query);
            echo $this->GetUsername();
        }
        else {
            echo "akun sudah tersedia";
        }
    }

    public function DeleteUserData() {
        include '..connect.php';

        $username = $this->username;
        $query = "DELETE FROM `users` WHERE `username` = $username";
        $connect->query($query);
    }
}

$userd = new User(null, 'endo', 'endo23', 'endo@mail.com', 1, 'endo123', 1);

$userd->CreateUserData();

class Business extends User {
    public $b_id;
    public $b_name;
    public $b_loc_prov;
    public $b_loc_city;

    public function CreateBusinessData() {
        
    }
}
?>