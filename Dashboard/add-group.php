<!DOCTYPE html>
<html lang="en">
<?php
session_start();

// Menghubungkan ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gucha";

$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gucha</title>
    <link rel="icon" href="../images/logo.png">
    <link rel="stylesheet" href="../style/add-group.css">
    <style>
        * {
            overflow: hidden;
        }

        .section {
            max-height: 100vh;
            overflow: hidden;
            padding: 10px;
        }

        .section-content {
            max-height: calc(100vh - 150px);
            overflow-y: auto;
        }

        input.pass {
            border: none;
            border-radius: 20px;
            height: 40px;
            background: #E6E1E1;
        }

        span.pass {
            padding: 6px 20px;
            border-radius: 8px;
            background: #E6E1E1;
            gap: 9px;
            display: flex;
            width: max-content;
            align-items: center;
            width: 800px;
        }

        .pass input {
            background: none;
            border: none;
            width: 800px;
        }

        .pass input:focus {
            border: none;
            outline: none;
        }

        .person {
            text-decoration: none;
            color: black;
        }

        .kotak-teman {
            border: 1px solid none;
            padding: 10px;
            margin-bottom: 5px;
            width: 89%;
            background: #E6E1E1;
            height: 50px;
            align-items: center;
            display: flex;
            border-radius: 12px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .kotak-teman:hover {
            background-color: #ccc;
        }

        .profil {
            display: flex;
            align-items: center;
            max-width: 50px;
        }

        h4 {
            font-size: 18px;
            margin-left: 40px;
        }

        .profil img {
            width: 100%;
            display: none;
        }

        #pp {
            display: flex;
            border-radius: 50%;
            object-fit: cover;
            width: 40px;
            height: 40px;
            margin-right: 8px;
        }

        .profil .initial {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: blue;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 15px;
            margin-right: 8px;
        }

        .group-circle {
            text-decoration: none;
            width: 20px;
            height: 20px;
            color: white;
            background: #391A94;
            border-radius: 100px;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 20px;
            margin-top: 20px;
            cursor: pointer;
        }

        input[type=submit] {
            padding: 10px;
            background-color: blue;
            color: white;
            border: none;
            border-radius: 5px;
            margin-left: 5px;
            width: 100px;
            cursor: pointer;
        }

        .nama-grup {
            display: flex;
        }

        .nama-grup h4 {
            margin-bottom: 10px;
            font-weight: bold;
        }

        h5 {
            font-size: 12px;
            margin-left: 40px;
        }

        /* Custom scrollbar styles */
        .section-content::-webkit-scrollbar {
            width: 12px;
        }

        .section-content::-webkit-scrollbar-track {
            background: #E6E1E1;
            border-radius: 10px;
        }

        .section-content::-webkit-scrollbar-thumb {
            background: blue;
            border-radius: 10px;
        }

        .section-content::-webkit-scrollbar-thumb:hover {
            background: darkblue;
        }

        .section-content {
            scrollbar-width: thin;
            scrollbar-color: blue #E6E1E1;
        }

        .section1 {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .section1 img {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <a href="add-group.php" class="kotak">+</a>
        <?php
        $id_saya = $_SESSION['id'];
        $querygrup = "SELECT * FROM Groups2 WHERE CreatedByUserID = '$id_saya'";
        $sqlgrup = mysqli_query($conn, $querygrup);

        function getInitials($name)
        {
            $words = explode(" ", $name);
            $initials = "";
            foreach ($words as $word) {
                $initials .= strtoupper($word[0]);
            }
            return $initials;
        }

        foreach ($sqlgrup as $grup) {
        ?>
            <a href="gucha.php?id=<?= $grup['GroupID'] ?>">
                <div class="group-circle">
                    <?= getInitials($grup['GroupName']) ?>
                </div>
            </a>
            <?php
        }

        $querygrup2 = "SELECT * FROM groupmembers WHERE UserID = '$id_saya'";
        $sqlgrup2 = mysqli_query($conn, $querygrup2);

        foreach ($sqlgrup2 as $grup2) {
            $id_grup = $grup2['GroupID'];
            $nama_grup = "SELECT * FROM Groups2 WHERE GroupID='$id_grup'";
            $sql_nama = mysqli_query($conn, $nama_grup);
            foreach ($sql_nama as $nama) {
            ?>
                <a href="gucha.php?id=<?= $nama['GroupID'] ?>">
                    <div class="group-circle">
                        <?= getInitials($nama['GroupName']) ?>
                    </div>
                </a>
        <?php
            }
        }
        ?>
    </div>

    <div class="main-content">
        <div class="section">
            <header>
                <a href="main.php">
                    <img src="../images/image (5).png" style="height: 20px; width: 20px;margin-left: 2px; margin-top: 18px;">
                </a>
                <?php
                $id_gw = $_SESSION['id'];
                $querypp = "SELECT profilepict FROM users WHERE UserID=$id_gw";
                $sqlll = mysqli_query($conn, $querypp);
                $gambar = $sqlll->fetch_assoc();
                ?>

                <div class="profile-picture">
                    <a href="pp.php?id=<?= $_SESSION['id'] ?>">
                        <img src="pp/<?= $gambar['profilepict'] ?>" alt="" srcset="">
                    </a>
                </div>
                <p class="wl">
                    <?php
                    if (!isset($_SESSION["email"]) || empty($_SESSION["email"])) {
                        header("Location: login.php");
                        exit();
                    }

                    echo 'Hello, ' . $_SESSION["username"];
                    ?>
                </p>
            </header>
            <div class="section-content">
                <div class="teks">
                    <h4>Buat Grupmu Sekarang!</h4>
                    <h5>Gabung bersama teman, diskusi seru, dan nikmati beragam aktivitas. Ayo mulai petualangan seru dengan grupmu!</h5>
                </div>
                <div class="search">
                    <form method="post" action="aksi-grup.php">
                        <span class="pass">
                            <input type="text" class="txt" placeholder="Buat Grup" id="pass" name="nama">
                            <input type="submit" id="btn" name="tes" value="Buat Grup">
                        </span>
                    </form>
                </div>
            </div>
        </div>
        <div class="section1">
            <img src="../images/empty.png" alt="">
            <p>Selamat datang! Ayo mulai percakapan seru dengan anggota lainnya. Klik pada profil teman yang ingin kamu ajak bicara dan mulai obrolan.</p>
        </div>
    </div>
</body>

</html>