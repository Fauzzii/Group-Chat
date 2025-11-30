<?php
// Konfigurasi koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gucha";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Memeriksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil nilai dari form
    $username = $_POST['username'];
    $password = $_POST['pass'];
    $email = $_POST['user'];

    // Memeriksa apakah ada input yang kosong
    if (empty($username) || empty($password) || empty($email)) {
        echo "<script>alert('Harap isi semua field!');</script>";
    } else {
        // Memeriksa apakah input email mengandung karakter "@"
        if (!strpos($email, "@")) {
            echo "<script>alert('Email tidak valid!');</script>";
        } else {
            // Memeriksa apakah email sudah terdaftar di database
            $checkEmailQuery = "SELECT * FROM Users WHERE Email = '$email'";
            $checkEmailResult = $conn->query($checkEmailQuery);

            if ($checkEmailResult->num_rows > 0) {
                echo "<script>alert('Email sudah terdaftar!');</script>";
            } else {
                // Memeriksa apakah username sudah terdaftar di database
                $checkUsernameQuery = "SELECT * FROM Users WHERE Username = '$username'";
                $checkUsernameResult = $conn->query($checkUsernameQuery);

                if ($checkUsernameResult->num_rows > 0) {
                    echo "<script>alert('Username sudah terdaftar!');</script>";
                } else {
                    // SQL untuk menyimpan data user ke dalam tabel Users
                    $sql = "INSERT INTO Users (Username, Password, Email) VALUES ('$username', '$password', '$email')";

                    if ($conn->query($sql) === TRUE) {
                        // Jika pendaftaran berhasil, arahkan ke halaman login.php
                        header("Location: login.php");
                        exit();
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }
        }
    }

    // Menutup koneksi database
    $conn->close();
}
?>

<html>

<head>
    <title>Gucha</title>
    <link rel="stylesheet" type="text/css" href="../style/register.css">
    <link rel="icon" href="logo.png">
    <script>
        function checkEmail() {
            var emailInput = document.getElementById("user");
            var emailValue = emailInput.value;
            var emailWarning = document.getElementById("emailWarning");

            if (emailValue.includes("@gmail.com")) {
                emailWarning.style.display = "none";
            } else {
                emailWarning.style.display = "block";
            }
        }
    </script>
</head>

<body>
    <img src="../images/wave-haikei.png" alt="" class="v" height="100%">
    <img class="l" src="../images/image (3).png" alt="">
    <a href="login.php">
        <img class="p" src="../images/image (5).png" alt="">
    </a>
    <div id="frm">
        <h1>Buat Akunmu Terlebih Dahulu😉</h1>
        <h2>Sebelum Memulai Perjalananmu</h2>
        <form name="f1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label class="e">Username</label>
            <span class="email">
                <img src="../images/user.png" alt="" width="20px">
                <input type="text" class="txt" placeholder="Username" id="username" name="username">
            </span>
            <label class="e">Email</label>
            <span class="email">
                <img src="../images/mail.png" alt="" width="20px">
                <input type="text" class="txt" placeholder="Email" id="user" name="user" onkeyup="checkEmail()">

            </span>
            <div id="emailWarning" style="display: none; color: red;">Email harus mengandung karakter '@gmail.com'</div>

            <label class="e">Password</label>
            <span class="pass">
                <img src="../images/lock.png" alt="" width="20px">
                <input type="password" class="txt" placeholder="Password" id="pass" name="pass">
                <img class="eye" src="../images/hide.png" alt="" width="20px" id="eye">
            </span>
            <span class="masuk">
                <input type="submit" id="btn" value="Masuk">
            </span>
        </form>
    </div>
    <script src="../js/register.js"></script>
</body>

</html>