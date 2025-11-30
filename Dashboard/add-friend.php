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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../style/add-friend.css">
    <title>Gucha</title>
    <link rel="icon" href="../images/logo.png">
    <style>
        .profile-picture {
            width: 33px;
            height: 33px;
            border-radius: 100%;
            background: #391A94;
            margin-right: 10px;
        }

        .profile-picture img {
            width: 100%;
            aspect-ratio: 1/1;
            object-fit: cover;
            border-radius: 50%;
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

        header {
            display: flex;
            align-items: center;
        }

        .header-content {
            display: flex;
            align-items: center;
        }

        header img {
            margin-right: 10px;
        }

        header p {
            margin: 0;
            text-align: right;
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

        .sidebar-scroll {
            overflow-y: auto;
        }

        /* Hide the default scrollbar */
        .sidebar-scroll::-webkit-scrollbar {
            display: none;
        }

        .tambahkan {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="sidebar-scroll">
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
    </div>

    <div class="main-content">
        <div class="section">
            <header>
                <a href="main.php">
                    <img src="../images/image (5).png" style="width: 20px; height: 20px; margin-left: 12px;">
                </a>
                <div class="header-content">
                    <?php
                    $id_gw = $_SESSION['id'];
                    $querypp = "SELECT profilepict from users where UserID=$id_gw";
                    $sqlll = mysqli_query($conn, $querypp);
                    $gambar = $sqlll->fetch_assoc();
                    ?>
                    <div class="profile-picture">
                        <a href="pp.php?id=<?= $_SESSION['id'] ?>">
                            <img src="pp/<?= $gambar['profilepict'] ?>" alt="" srcset="">
                        </a>
                    </div>
                    <p><?php echo 'Hello, ' . $_SESSION["username"]; ?></p>
                </div>
            </header>
            <div class="teks">
                <h4>Tambah Teman Sekarang!</h4>
                <h5>Bersama lebih seru! Tambahkan teman, ngobrol, dan nikmati aktivitas seru di aplikasi kami. Gabung sekarang!</h5>
            </div>
            <div class="search">
                <form method="post" action="">
                    <span class="pass">
                        <input type="text" class="txt" placeholder="Search" id="pass" name="pass">
                        <input type="submit" id="btn" name="submit" value="Tambah Teman">
                    </span>
                    <?php
                    if (isset($_POST['submit'])) {
                        if (empty($_POST['pass'])) {
                            echo '<div class="error">Masukkan Username terlebih dahulu</div>';
                        } else {
                            $username_search = $_POST['pass'];
                            $query = "SELECT * FROM `users` WHERE Username LIKE '%$username_search%';";
                            $search = mysqli_query($conn, $query);
                            foreach ($search as $key) {
                                // Tambahkan kondisi untuk memeriksa apakah username bukan milik pengguna yang sedang login
                                if ($key['UserID'] != $_SESSION['id']) {
                            ?>
                                <div class="e">
                                    <div class="t">
                                        <?= $key['Username'] ?>
                                    </div>
                                    <?php
                                    $id_saya = $_SESSION['id'];
                                    $query2 = "SELECT *FROM friends where UserID1='$id_saya' and request in('0')";
                                    $sql2 = mysqli_query($conn, $query2);
                                    $inarray = [];
                                    foreach ($sql2 as $array) {
                                        $inarray[] = $array['UserID2'];
                                    }
                                    if (in_array($key['UserID'], $inarray)) {
                                    ?>
                                        <a class="tambahkan" style="background: #b4b4b4; color:black; width: 100px; font-size: 11px; text-align: center; height: 15px; font-weight: bold;" id="btn">Sudah Berteman</a>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="add.php?id_me=<?= $_SESSION['id'] ?>&id_lawan=<?= $key['UserID'] ?>" class="tambahkan" id="btn">Tambahkan</a>
                                    <?php
                                    }
                                    ?>
                                </div>
                            <?php
                                }
                            }
                        }   
                    }
                    ?>
                </form>
            </div>
        </div>
        <div class="section1">
            <img src="../images/empty.png" alt="">
            <p>Selamat datang! Ayo mulai percakapan seru dengan anggota lainnya. Klik pada profil teman yang ingin kamu ajak bicara dan mulai obrolan.</p>
        </div>
    </div>

</body>

</html>