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

    public function SetPassword($password) {
        $this->password = $password;
    }

    public function CreateUserData() {
        include '../connect.php';

        $id = $this->id;
        $username = $this->username;
        $nickname = $this->nickname;
        $email = $this->email;
        $priority = $this->priority;
        $password = $this->password;
        $id_business = $this->id_business;

        $query = "INSERT `users` (`id`, `username`, `nickname`, `email`, `prioritas`, `password`, `id_business`) VALUES (NULL, '$username', '$nickname', '$email', '$priority', '$password', '$id_business')";

        $connect->query($query);
    }

    public function DeleteUserData() {
        include '..connect.php';

        $id = $this->id;

        $query = "DELETE FROM `users` WHERE `id` = $id";
    }
}

$userd = new User(null, 'endo', 'endo23', 'endo@mail.com', 1, 'endo123', 1);

$userd->CreateUserData();

class Business extends User {
    public $b_id = $this->id_business;
    public $b_name;
}
?>