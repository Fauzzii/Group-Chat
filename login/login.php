<?php
session_start();

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

// Inisialisasi variabel untuk menyimpan pesan kesalahan
$error = "";

// Memeriksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil nilai dari form
    $email = $_POST['user']; // Ubah dari $username menjadi $email
    $password = $_POST['pass'];

    // Memeriksa apakah input kosong
    if (empty($email) || empty($password)) {
        $error = "Silakan isi semua field.";
    } else if (!strpos($email, "@")) {
        echo "<script>alert('Email tidak valid!');</script>";
    } else {
        // SQL untuk memeriksa apakah akun ada dalam database
        $sql = "SELECT * FROM users WHERE Email='$email' AND Password='$password'"; // Mengubah Username menjadi Email
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Jika akun ditemukan, arahkan ke halaman main.php
            // Tambahkan kode untuk memeriksa dan menyimpan email serta username ke session
            $sql_check_email = "SELECT * FROM Users WHERE Email='$email'";
            $result_check_email = $conn->query($sql_check_email);

            if ($result_check_email->num_rows > 0) {
                // Jika email ditemukan, ambil username
                while ($row = $result_check_email->fetch_assoc()) {
                    $username = $row["Username"];

                    $id = $row['UserID'];
                }
                // Simpan email dan username ke session untuk digunakan di halaman main.php
                $_SESSION["email"] = $email;
                $_SESSION["username"] = $username;
                $_SESSION["id"] = $id;
            }

            header("Location: ../dashboard/main.php");
            exit();
        } else {
            // Jika akun tidak ditemukan, set pesan kesalahan
            $error = "Email atau password salah."; // Mengubah Username menjadi Email
            // Tambahkan alert JavaScript untuk memberikan peringatan
            echo "<script>alert('Email atau password salah.');</script>";
        }
    }

    // Menutup koneksi database
    $conn->close();
}
?>

<html>

<head>
    <title>Gucha</title>
    <link rel="stylesheet" type="text/css" href="../style/login.css">
    <link rel="icon" href="../images/logo.png">
    <style>
        .preloader {
            position: fixed;
            width: 100%;
            height: 100%;
            background: white;
            top: 0;
            left: 0;
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            transition: transform 0.5s ease-in-out;
        }

        .preloader video {
            width: 500px;
            /* Adjust size as needed */
            height: auto;
        }

        .preloader.slide-up {
            transform: translateY(-100%);
            /* Slide up animation */
        }
    </style>
</head>

<body>
    <img src="../images/wave-haikei.png" alt="" class="v" height="100%">
    <img class="l" src="../images/image (4).png" alt="">
    <a href="login.html">
        <img class="p" src="../images/image (5).png" alt="">
    </a>
    <div id="frm">
        <h1>Selamat Datang Kembali! 👋</h1>
        <h2>Ayo Mulai Perjalananmu!</h2>
        <form name="f1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label class="e">Email</label>
            <span class="email">
                <img src="../images/mail.png" alt="" width="20px">
                <input type="text" class="txt" placeholder="Email" id="user" name="user">
            </span>
            <span id="emailError" class="error-message">Email harus mengandung karakter '@'</span>
            <br>
            <label class="e">Password</label>
            <span class="pass">
                <img src="../images/lock.png" alt="" width="20px">
                <input type="password" class="txt" placeholder="Password" id="pass" name="pass">
                <img class="eye" src="../images/hide.png" alt="" width="20px" id="eye">
            </span>
            
            <a class="ba" href="register.php">Buat Akun</a>
            <span class="masuk">
                <input type="submit" id="btn" value="Masuk">
            </span>
        </form>
    </div>
    <script src="../js/loginn.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const preloader = document.getElementById('preloader');
            const video = preloader.querySelector('video');

            // Pastikan preloader ditampilkan saat halaman dimuat
            preloader.style.display = 'flex';

            // Event listener untuk memulai video setelah metadata dimuat
            video.addEventListener('loadedmetadata', () => {
                video.play();
            });

            // Event listener untuk menyembunyikan preloader setelah video selesai
            video.addEventListener('ended', () => {
                preloader.classList.add('slide-up');
            });
        });
    </script>
</body>

</html>