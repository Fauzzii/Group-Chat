<!DOCTYPE html>
<html>

<head>
    <title>Gucha</title>
    <link rel="stylesheet" type="text/css" href="../style/verif.css">
    <link rel="icon" href="logo.png">
    <meta charset="UTF-8"> <!-- Tambahkan meta charset -->
</head>

<body>
    <img src="wave-haikei.png" alt="" class="v" height="100%">
    <img class="l" src="image (2).png" alt="">
    <a href="forgot.php">
        <img class="p" src="image (5).png" alt="">
    </a>
    <div id="frm">
        <img src="forgot.png" alt="" width="30%" style="margin-left: 130px; margin-top: 50px;">
        <h2>Lupa password</h2>
        <h3>Verifikasi email dan password anda</h3>
        <h3>untuk mendapatkan akses kembali</h3>
        <form name="f1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
             <label class="e">Update password</label>
            <span class="pass">
                <img src="lock.png" alt="" width="20px">
                <input type="password" class="txt" placeholder="Password" id="pass" name="pass">
                <img class="eye" src="hide.png" alt="" width="20px" id="eye">
            </span>
            <span class="masuk">
                <input type="submit" id="btn" value="Masuk">
            </span>
        </form>
    </div>
    <script>
        document.getElementById("user").addEventListener("input", function() {
            var emailInput = this.value;
            var emailError = document.getElementById("emailError");
            if (!emailInput.includes("@gmail.com")) {
                emailError.style.display = "inline-block";
            } else {
                emailError.style.display = "none";
            }
        });

        // Tambahkan event handler untuk menghilangkan pesan kesalahan saat input kosong
        document.getElementById("user").addEventListener("blur", function() {
            var emailInput = this.value;
            var emailError = document.getElementById("emailError");
            if (emailInput.trim() === "") {
                emailError.style.display = "none";
            }
        });
    </script>

    <script src="../js/register.js"></script>
</body>

</html>
