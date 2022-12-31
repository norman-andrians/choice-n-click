<?php
include '../connect.php';
include '../lib/user-data.php';

if (isset($_POST['signin'])) {
    $nickname = $_POST['nickname'];
    $email = $_POST['email'];

    if (!User::nicknameExist($nickname) && !User::emailExist($email)) {
        $user = new User(null, $nickname, $email);

        $expdate = time() + (86400 * 7);
        $path = "/user/";

        setcookie("nickname", $nickname, $expdate, $path);
        setcookie("email", $email, $expdate, $path);
        setcookie("registered", false, $expdate, $path);
        setcookie("step_passed", 0, $expdate, $path);
    }
    else {
        if (User::nicknameExist($nickname) && User::emailExist($email)) {
            header("location:index.php?nicknameHas=exist&emailHas=exist");
        }
        else if (User::nicknameExist($nickname)) { header("location:index.php?nicknameHas=exist"); }
        else if (User::emailExist($email)) { header("location:index.php?emailHas=exist"); }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mukta:wght@400;500;700&family=Noto+Sans&family=PT+Sans:wght@400;700&family=Poppins:wght@400;700&family=Roboto:wght@400;500&family=Rubik:wght@400;700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finishing just 4 steps</title>
    <link rel="stylesheet" href="../assets/styles/animation/regular-transition.css">
    <link rel="stylesheet" href="../assets/styles/navigation-bar.css">
    <link rel="stylesheet" href="../assets/styles/main.css">
    <link rel="stylesheet" href="../assets/styles/user-signlogin-page.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/9833b8478b.js" crossorigin="anonymous"></script>
</head>
<?php

session_start();
$cookie_exist = isset($_COOKIE['nickname']) && isset($_COOKIE['email']) && isset($_COOKIE['registered']) && isset($_COOKIE['step_passed']);

$nickname = isset($_COOKIE['nickname']) ? $_COOKIE['nickname'] : false;
$email = isset($_COOKIE['email']) ? $_COOKIE['email'] : false;
$registered = isset($_COOKIE['registered']) ? $_COOKIE['registered'] : false;
$step_passed = isset($_COOKIE['step_passed']) ? $_COOKIE['step_passed'] : false;

$user;

/*
else {
    header("location:index.php");
}
*/
?>
<body>
    <div class="main-bg">
        <div class="inp-dp-clt"></div>
        <div class="main-form-container">
            <div class="main-form-base">
                <header class="header-section">
                    <h1>4 Langkah</h1>
                    <p>Isi beberapa formulir dalam 4 langkah setelah itu kamu baru bisa memulai. Perlu diingat semua formulir ini harus secepatnya diisi sebelum tanggal</p>
                </header>
                <div class="progress-bar"></div>
                <form action="finishing.php" method="post" class="mainform" enctype="multipart/form-data">
                    <?php
                    $userRegistered = filter_var($registered, FILTER_VALIDATE_BOOLEAN) == true;

                    if ($cookie_exist && !$userRegistered) {
                        $user = new User(null, $nickname, $email);
                    
                        switch ($step_passed) {
                            case 0:
                                if (!isset($_COOKIE['otp_code'])) {
                                    setcookie("otp_code", $user, time() + 300, $path);

                                    $code = User::GenerateOTP();
                                    $user->sendOTP($code);

                                    header("location:finishing.php");
                                }
                                else {
                                    if (isset($_POST['sendOTP']) && isset($_COOKIE['otp_code'])) {
                                        $input = $_POST['sendOTP'];
                                        $code = $_COOKIE['otp_code'];
                                        $step_passed = $_COOKIE['step_passed'];

                                        if ($input == $code) {
                                            $step_passed++;
                                            header("location:finishing.php");
                                        }
                                    }

                                    if (isset($_COOKIE['otp_code'])) {
                                        echo "your OTP Code is " + $_COOKIE['otp_code'];
                                    }
                                }
                    ?>
                    <div class="tb-form" id="otp-form">
                        <header class="inp-ftg">
                            <h3>Konfirmasi alamat email</h3>
                            <p>Masukan 6-digit nomor yang telah dikirim ke <?php echo $email; ?></p>
                        </header>
                        <div class="inp-row">
                            <div class="inp-six-dig">
                                <input type="number" name="confcode" maxlength=1>
                                <input type="number" name="confcode" maxlength=1>
                                <input type="number" name="confcode" maxlength=1>
                                <input type="number" name="confcode" maxlength=1>
                                <input type="number" name="confcode" maxlength=1>
                                <input type="number" name="confcode" maxlength=1>
                            </div>
                        </div>
                        <div class="inp-row">
                            <div class="gth-btn"><button type="button">Kirim ulang (30s)</button></div>
                        </div>
                        <div class="inp-sub-nito"><button id="sub-nito-btn" type="submit" name="sendOTP">Konfirmasi</button></div>
                    </div>
                    <?php
                                break;
                            case 1:
                    ?>
                    <div class="tb-form" id="pw-form" style="display: none;">
                        <header class="inp-ftg">
                            <h3>Buat Password</h3>
                        </header>
                        <div class="inp-row">
                            <div class="inp-text"><div class="inp-bg"></div><input type="text" name="npw" id="npw" placeholder="Password Baru*"></div>
                        </div>
                        <div class="inp-row">
                            <div class="inp-text"><div class="inp-bg"></div><input type="text" name="cpw" id="cpw" placeholder="Konfirmasi Password*"></div>
                        </div>
                        <div class="inp-sub-nito"><button id="sub-nito-btn" type="submit">Konfirmasi</button></div>
                    </div>
                    <?php
                                break;       
                        }
                    }
                    ?>
                    <div class="tb-form" id="bs-form" style="display: none;">
                        <header class="inp-ftg">
                            <h3>Buat bisnis</h3>
                        </header>
                        <div class="inp-row">
                            <div class="inp-text"><div class="inp-bg"></div><input type="text" name="bname" id="bname" placeholder="Nama bisnis*"></div>
                        </div>
                        <div class="inp-row">
                            <button class="inp-dropdown" id="bdrop" type="button">
                                <input type="hidden" name="btype" value="">
                                <div class="inp-dp-text">Jenis bisnis*</div>
                                <div class="inp-dp-da-icon"><i class="fa-solid fa-caret-down"></i></div>
                                <div class="inp-dp-ct"></div>
                            </button>
                        </div>
                        <div class="inp-row">
                            <button class="inp-dropdown" id="pdrop" type="button">
                                <input type="hidden" name="btype" value="">
                                <div class="inp-dp-text">Provinsi*</div>
                                <div class="inp-dp-da-icon"><i class="fa-solid fa-caret-down"></i></div>
                                <div class="inp-dp-ct"></div>
                            </button>
                        </div>
                        <div class="inp-row">
                            <button class="inp-dropdown" id="cdrop" type="button" disabled>
                                <input type="hidden" name="btype" value="">
                                <div class="inp-dp-text">Kota* (Pilih Provinsi Dulu)</div>
                                <div class="inp-dp-da-icon"><i class="fa-solid fa-caret-down"></i></div>
                                <div class="inp-dp-ct">
                                    <div class="inp-dp-row-empty">Silahkan Pilih Provinsi Terlebih Dahulu</div>
                                </div>
                            </button>
                        </div>
                        <div class="inp-sub-nito"><button id="sub-nito-btn" type="submit">Selanjutnya</button></div>
                    </div>
                    <div class="tb-form" id="cp-form" style="display: none;">
                        <header class="inp-ftg">
                            <h3>Buat Produk</h3>
                            <p>Buat produk pertama anda</p>
                        </header>
                        <div class="inp-row">
                            <div class="inp-file-img">
                                <input type="file" name="productName" id="pname" accept="image/*">
                                <label for="pname" class="inp-fl">
                                    <div class="inp-flog"><i class="fa-solid fa-box-archive fa-3x"></i></div>
                                    <div class="inp-fl-t">Upload Foto Produk</div>
                                </label>
                            </div>
                        </div>
                        <div class="inp-row">
                            <div class="inp-text"><div class="inp-bg"></div><input type="text" name="productName" id="pname" placeholder="Nama Produk*"></div>
                        </div>
                        <div class="inp-row">
                            <div class="inp-text"><div class="inp-bg"></div><input type="text" name="productName" id="pname" placeholder="Kategori Produk*"></div>
                        </div>
                        <div class="inp-row">
                            <div class="inp-text"><div class="inp-bg"></div><input type="number" name="productName" id="pname" placeholder="Harga Produk*"></div>
                        </div>
                        <div class="inp-sub-nito"><button id="sub-nito-btn" type="submit">Mulai</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="module" src="../assets/scripts/form/form-manajement.js"></script>
</body>
</html>