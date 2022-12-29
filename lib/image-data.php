<?php

class Image {
    public $id;
    public $file;

    public $file_name = $file['name'];
    public $file_type = $file['type'];
    public $file_error = $file['error'];
    public $file_size = $file['size'];
    public $file_tmp = $file['tmp_name'];

    public function __construct($file) {
        $this->file = $file;
    }

    public function Create($newname, $max) {
        include '../connect.php';

        $img_extension = pathinfo($this->file_name, PATHINFO_EXTENSION);
        $require_extension = ["jpg", "jpeg", "png"];

        $img = getimagesize($this->file_tmp);
        $img_width = $img[0];
        $img_height = $img[1];

        if ($this->file_size >= $max) {
            // Error: file tidak boleh lebih dari $max
            return;
        }
        if ($this->file_error != 0) {
            // Error: terjadi kesalahan pada saat upload gambar
            return;
        }
        if (!in_array($img_extension, $require_extension)) {
            // Error: Extensi gambar harus jpg, jpeg, dan png
            return;
        }
        if ($img_width != $img_height) {
            // Error: gambar harus memiliki rasio 1:1 atau ukuran panjang dan lebar harus sama
            return;
        }
        
        $newname .= "." . $img_extension;
        $path = "uploads/image/" . $newname;

        $id = $this->id;
        $file_name = $this->file_name;
        $file_type = $img_extension;
        $file_size = $this->file_size;

        if (move_uploaded_file($this->file_tmp, $path)) {
            $query = "INSERT INTO `images` (`id`, `name`, `type`, `size`) VALUES ('$id', '$file_name', '$file_type', '$file_size')";
            $connect->query($query);
        }
    }
}

?>