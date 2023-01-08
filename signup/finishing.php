<?php
include '../connect.php';
include '../lib/user-data.php';

if (isset($_POST['signin'])) {
    $nickname = $_POST['nickname'];
    $email = $_POST['email'];

    if (!User::nicknameExist($nickname) && !User::emailExist($email)) {
        $user = new User(null, $nickname, $email);

        $expdate = time() + (86400 * 7);
        $path = "/";

        setcookie("nickname", $nickname, $expdate, $path);
        setcookie("email", $email, $expdate, $path);
        setcookie("registered", 0, $expdate, $path);
        setcookie("step_passed", 0, $expdate, $path);

        header("location:finishing.php");
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

$cookie_exist = isset($_COOKIE['nickname']) && isset($_COOKIE['email']) && isset($_COOKIE['registered']) && isset($_COOKIE['step_passed']);

$nickname = isset($_COOKIE['nickname']) ? $_COOKIE['nickname'] : false;
$email = isset($_COOKIE['email']) ? $_COOKIE['email'] : false;
$registered = isset($_COOKIE['registered']) ? $_COOKIE['registered'] : false;
$step_passed = isset($_COOKIE['step_passed']) ? $_COOKIE['step_passed'] : false;

$user;

/*
if (isset($_COOKIE['step_passed'])) {
    echo $_COOKIE['step_passed'];
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
                    <p>Isi beberapa formulir dalam 4 langkah setelah itu kamu baru bisa memulai.</p>
                </header>
                <div class="progress-bar"></div>
                <form action="finishing.php" method="post" class="mainform" enctype="multipart/form-data">
                    <?php
                    $userRegistered = (bool)$registered;

                    if ($cookie_exist && !$userRegistered) {
                        $user = new User(null, $nickname, $email);
                    
                        switch ($step_passed) {
                            case 0:
                                if (!isset($_COOKIE['otp_code'])) {
                                    $code = User::GenerateOTP();
                                    $user->sendOTP($code);

                                    setcookie("otp_code", $code, time() + 300, "/");
                                    header("location:finishing.php");
                                }
                                else {
                                    if (isset($_POST['sendOTP']) && isset($_COOKIE['otp_code'])) {
                                        $input = $_POST['fullcode'];
                                        $code = $_COOKIE['otp_code'];
                                        $step_passed = $_COOKIE['step_passed'];

                                        if ($input == $code) {
                                            $step_passed++;

                                            $expdate = time() + (86400 * 7);
                                            $path = "/";
                                            
                                            setcookie("otp_code", 0, time() - 3600, $path);
                                            setcookie("step_passed", $step_passed, $expdate, $path);
                                            header("location:finishing.php");
                                        }
                                    }
                                    if (isset($_COOKIE['otp_code'])) {
                                        echo "your OTP Code is " . $_COOKIE['otp_code'];
                                    }
                                }
                    ?>
                    <div class="tb-form" id="otp-form">
                        <header class="inp-ftg">
                            <h3>Konfirmasi alamat email</h3>
                            <p>Masukan 6-digit kode yang telah dikirim ke <?php echo $email; ?></p>
                        </header>
                        <div class="inp-row">
                            <div class="inp-six-dig">
                                <input type="number" name="confcode" maxlength=1 min=0 max=9>
                                <input type="number" name="confcode" maxlength=1 min=0 max=9>
                                <input type="number" name="confcode" maxlength=1 min=0 max=9>
                                <input type="number" name="confcode" maxlength=1 min=0 max=9>
                                <input type="number" name="confcode" maxlength=1 min=0 max=9>
                                <input type="number" name="confcode" maxlength=1 min=0 max=9>
                            </div>
                            <input type="hidden" name="fullcode" value="" id="fullcode">
                        </div>
                        <div class="inp-row">
                            <div class="gth-btn"><button type="button">Kirim ulang (30s)</button></div>
                        </div>
                        <div class="error-text">
                            <?php
                            $isSendedOTP = isset($_POST['sendOTP']) && isset($_COOKIE['otp_code']);

                            if ($isSendedOTP) {
                                $input = $_POST['fullcode'];
                                $code = $_COOKIE['otp_code'];

                                if ($input != $code) {
                                    echo "Kode OTP yang anda masukan salah";
                                }
                            }
                            ?>
                        </div>
                        <div class="inp-sub-nito"><button id="sub-nito-btn" type="button" name="sendOTP" value="send">Konfirmasi</button></div>
                    </div>
                    <?php
                                break;
                            case 1:
                                $isFilled = isset($_POST['username']) && isset($_POST['telphone']) && isset($_POST['cpw']);

                                if (isset($_POST['create']) && $isFilled) {
                                    $username = $_POST['username'];
                                    $telphone = $_POST['telphone'];
                                    $password = $_POST['cpw'];

                                    $step_passed++;

                                    $expdate = time() + (86400 * 7);
                                    $path = "/";

                                    setcookie("username", $username, $expdate, $path);
                                    setcookie("phonenum", $telphone, $expdate, $path);
                                    setcookie("password", $password, $expdate, $path);
                                    setcookie("step_passed", $step_passed, $expdate, $path);

                                    header("location:finishing.php");
                                }
                    ?>
                    <div class="tb-form" id="ca-form">
                        <header class="inp-ftg">
                            <h3>Buat Akun</h3>
                        </header>
                        <!--
                        <div class="inp-row">
                            <div class="inp-file-img">
                                <input type="file" name="profileName" id="pname" accept="image/*">
                                <label for="pname" class="inp-fl">
                                    <div class="inp-flog"><i class="fa-solid fa-user fa-3x"></i></div>
                                    <div class="inp-fl-t">Upload Foto Profil</div>
                                </label>
                            </div>
                        </div>
                        -->
                        <div class="inp-row">
                            <div class="inp-text"><div class="inp-bg"></div><input type="text" name="username" id="username" placeholder="Nama lengkap*" required></div>
                            <div class="error-input"></div>
                        </div>
                        <div class="inp-row">
                            <div class="inp-text"><div class="inp-bg"></div><input type="number" name="telphone" id="telphone" placeholder="Nomor Telepon*" min="1000000000" max="99999999999999" required></div>
                            <div class="error-input"></div>
                        </div>
                        <header class="inp-ftg">
                            <h3>Buat Password Baru</h3>
                        </header>
                        <div class="inp-row">
                            <div class="inp-text"><div class="inp-bg"></div><input type="password" name="npw" id="npw" placeholder="Password Baru*" required></div>
                            <div class="error-input"></div>
                        </div>
                        <div class="inp-row">
                            <div class="inp-text"><div class="inp-bg"></div><input type="password" name="cpw" id="cpw" placeholder="Isi Ulang Password*" required></div>
                            <div class="error-input"></div>
                        </div>
                        <div class="error-text"></div>
                        <div class="inp-sub-nito"><button id="sub-nito-btn" type="button" name="create" value="user">Selanjutnya</button></div>
                    </div>
                    <?php
                                break;    
                            case 2:
                                $isFilled = isset($_POST['bname']) && isset($_POST['btype']) && isset($_POST['locprov']) && isset($_POST['loccity']);

                                if (isset($_POST['create']) && $isFilled) {
                                    $b_name = $_POST['bname'];
                                    $b_type = $_POST['btype'];
                                    $b_loc_prov = $_POST['locprov'];
                                    $b_loc_city = $_POST['loccity'];

                                    $step_passed++;

                                    $expdate = time() + (86400 * 7);
                                    $path = "/";

                                    setcookie("b_name", $b_name, $expdate, $path);
                                    setcookie("b_type", $b_type, $expdate, $path);
                                    setcookie("b_loc_prov", $b_loc_prov, $expdate, $path);
                                    setcookie("b_loc_city", $b_loc_city, $expdate, $path);
                                    setcookie("step_passed", $step_passed, $expdate, $path);

                                    header("location:finishing.php");
                                }
                    ?>
                    <div class="tb-form" id="bs-form">
                        <header class="inp-ftg">
                            <h3>Buat bisnis</h3>
                        </header>
                        <div class="inp-row">
                            <div class="inp-text"><div class="inp-bg"></div><input type="text" name="bname" id="bname" placeholder="Nama bisnis*" required></div>
                            <div class="error-input"></div>
                        </div>
                        <div class="inp-row">
                            <button class="inp-dropdown" id="bdrop" type="button">
                                <input type="hidden" name="btype" value="" required>
                                <div class="inp-dp-text">Jenis bisnis*</div>
                                <div class="inp-dp-da-icon"><i class="fa-solid fa-caret-down"></i></div>
                                <div class="inp-dp-ct"></div>
                            </button>
                            <div class="error-dp-input"></div>
                        </div>
                        <div class="inp-row">
                            <button class="inp-dropdown" id="pdrop" type="button">
                                <input type="hidden" name="locprov" value="" required>
                                <div class="inp-dp-text">Provinsi*</div>
                                <div class="inp-dp-da-icon"><i class="fa-solid fa-caret-down"></i></div>
                                <div class="inp-dp-ct"></div>
                            </button>
                            <div class="error-dp-input"></div>
                        </div>
                        <div class="inp-row">
                            <button class="inp-dropdown" id="cdrop" type="button" disabled>
                                <input type="hidden" name="loccity" value="" required>
                                <div class="inp-dp-text">Kota* (Pilih Provinsi Dulu)</div>
                                <div class="inp-dp-da-icon"><i class="fa-solid fa-caret-down"></i></div>
                                <div class="inp-dp-ct">
                                    <div class="inp-dp-row-empty">Silahkan Pilih Provinsi Terlebih Dahulu</div>
                                </div>
                            </button>
                            <div class="error-dp-input"></div>
                        </div>
                        <div class="inp-sub-nito"><button id="sub-nito-btn" type="button" name="create" value="business">Selanjutnya</button></div>
                    </div>
                    <?php
                                    break;
                                case 3:
                    ?>
                    <div class="tb-form" id="cp-form">
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
                    <?php
                                    break;
                        }
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
    <script type="module" src="../assets/scripts/form/form-manajement.js"></script>
</body>
</html>