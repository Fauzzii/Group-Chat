<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gucha";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Check koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["user"];

    // Lakukan pengecekan apakah email ada di dalam database dengan prepared statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE Email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email ditemukan di dalam database, maka redirect ke verif.php
        header("Location: verif.php");
        exit(); // Perlu tambahkan exit() setelah header() untuk memastikan skrip berhenti dieksekusi
    } else {
        // Email tidak ditemukan, tampilkan pesan kesalahan
        echo '<script>alert("Email belum terdaftar");</script>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gucha</title>
    <link rel="stylesheet" type="text/css" href="../style/forgot.css">
    <link rel="icon" href="logo.png">
    <meta charset="UTF-8"> <!-- Tambahkan meta charset -->
</head>

<body>
    <img src="../images/wave-haikei.png" alt="" class="v" height="100%">
    <img class="l" src="../images/image (2).png" alt="">
    <a href="login.php">
        <img class="p" src="../images/image (5).png" alt="">
    </a>
    <div id="frm">
        <img src="forgot.png" alt="" width="30%" style="margin-left: 130px; margin-top: 50px;">
        <h2>Lupa password</h2>
        <h3>Verifikasi email dan password anda</h3>
        <h3>untuk mendapatkan akses kembali</h3>
        <form name="f1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label class="e">Email</label>
            <span class="email">
                <img src="../images/mail.png" alt="" width="20px">
                <input type="text" class="txt" placeholder="Email" id="user" name="user">
            </span>
            <span id="emailError" class="error-message">Email harus mengandung karakter '@gmail.com'</span>
            <br>
            <span class="masuk">
                <input type="submit" id="btn" value="Lanjut">
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
</body>

</html>
