<?php
include '../connect.php';

$nicknameExist = isset($_GET['nicknameHas']) && $_GET['nicknameHas'] == "exist";
$emailExist = isset($_GET['emailHas']) && $_GET['emailHas'] == "exist";
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
    <title>Daftar</title>
    <link rel="stylesheet" href="../assets/styles/animation/regular-transition.css">
    <link rel="stylesheet" href="../assets/styles/navigation-bar.css">
    <link rel="stylesheet" href="../assets/styles/main.css">
    <link rel="stylesheet" href="../assets/styles/user-signlogin-page.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>
<body>
    <nav class="nav-container">
        <div class="nav-menu">
            <div class="nav-row"><a href="../"><button class="nav-reg-btn">Home</button></a></div>
            <div class="nav-row"><a href="../about"><button class="nav-reg-btn">About</button></a></div>
            <div class="nav-row"><a href="#"><button class="nav-reg-btn">Service</button></a></div>
            <div class="nav-row"><a href="#"><button class="nav-reg-btn">Features</button></a></div>
        </div>
    </nav>
    <div class="main-bg">
        <div class="main-form-container">
            <div class="main-form-base">
                <header class="header-section">
                    <h1>Daftar</h1>
                    <p>Buat kamu yang belum punya akun, yuk segera buat</p>
                </header>
                <form action="finishing.php" method="post" class="main-form">
                    <div class="inp-row">
                        <!--<div class="inp-label"><label for="nickname">Nickname<span class="require-symbol">*</span> (Tidak boleh spasi)</label></div> -->
                        <div class="inp-text"><div class="inp-bg"></div><input type="text" name="nickname" id="nickname" placeholder="Nickname*"></div>
                    </div>
                    <div class="inp-row">
                        <!--<div class="inp-label"><label for="email">Email<span class="require-symbol">*</span></label></div> -->
                        <div class="inp-text"><div class="inp-bg"></div><input type="email" name="email" id="email" placeholder="Email*"></div>
                    </div>
                    <div class="error-text">
                        <?php
                        if ($nicknameExist && $emailExist) {
                            echo "Nickname dan email sudah tersedia, disarankan nickname disertai nomor atau simbol";
                        }
                        else if ($nicknameExist) {
                            echo "Nickname sudah tersedia, disarankan disertai nomor atau simbol";
                        }
                        else if ($emailExist) {
                            echo "Email sudah tersedia";
                        }
                        ?>
                    </div>
                    <!--
                    <div class="inp-row">
                        <div class="inp-label"><label for="telp">No Telp.<span class="require-symbol">*</span></label></div>
                        <div class="inp-text"><input type="tel" name="telpnum" id="telp" placeholder="No. Telp*"></div>
                    </div>
                    -->
                    <div class="inp-sub"><button id="sub-btn" type="submit" name="signin" value="yes">Lanjutkan</button></div>
                    <div class="hcp-text">Sudah punya akun? <a href="../login">Login</a></div>
                </form>
            </div>
        </div>
    </div>
    <script type="module" src="../assets/scripts/form/signupin.js"></script>
</body>
</html>