<!DOCTYPE html>
<html lang="en">
<?php
include '../conifg.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gucha</title>
    <link rel="icon" href="../images/logo.png">
    <link rel="stylesheet" type="text/css" href="../style/main.css">
    <style>
        .sidebar-scroll {
            overflow-y: auto;
        }

        /* Hide the default scrollbar */
        .sidebar-scroll::-webkit-scrollbar {
            display: none;
        }

        .profile-picture {
            width: 33px;
            height: 33px;
            margin-left: 62px;
            border-radius: 100%;
            background: #391A94;
            margin-top: 24px;
        }


        .preloader {
            position: fixed;
            width: 100%;
            height: 100%;
            background: white;
            top: 0;
            left: 0;
            z-index: 1000;
            display: flex;
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

        .notif {
            width: 20px;
            height: 20px;
            border-radius: 100%;
            background: red;
            margin-left: 893px;
            color: white;
            margin-top: 23px;
            position: absolute;
            display: none;
        }
    </style>
</head>

<body>
    <?php session_start(); ?>
    <div class="preloader" id="preloader">
        <video src="../videos/logo.mp4" autoplay></video>
    </div>
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
                <a href="add-friend.php" class="kotak1">Tambah Teman</a>
                <div class="terima"></div>
                <a href="request.php">
                    <img src="../images/bell.png" style="width: 25px;height:25px; cursor:pointer; margin-top: 28px; margin-left: 20px;">
                </a>
                <div class="notif"></div>
            </header>
            <div class="kontak">
                <?php
                $id_me = $_SESSION['id'];
                $query_count = "SELECT COUNT(*) as total FROM friends WHERE UserID1='$id_me'";
                $sql_count = mysqli_query($conn, $query_count);
                $count = mysqli_fetch_assoc($sql_count);
                $query = "SELECT * FROM friends WHERE UserID1='$id_me' || UserID2='$id_me'";
                $sql = mysqli_query($conn, $query);
                 $sql->num_rows;
                ?>
                <p>All Friends - <?= mysqli_num_rows($sql) ?></p>
                <div class="column">
                    <?php


                    foreach ($sql as $data) {
                        $id2='';
                        if ($data['UserID1']!==$id_me) {
                            $id2=$data['UserID1'];
                        }else{
                            $id2=$data['UserID2'];
                        }


                        $query2 = "SELECT * FROM users WHERE UserID= '$id2'";
                        $sql2 = mysqli_query($conn, $query2);
                        foreach ($sql2 as $row) {
                            $initial = strtoupper(substr($row['Username'], 0, 1));
                    ?>
                            <div class="kotak-teman" onclick="window.location.href='chat.php?id1=<?= $id_me ?>&id2=<?= $id2 ?>'">
                                <div class="profil">
                                    <?php
                                    $cek = $row['profilepict'];

                                    if (empty($cek)) {
                                    ?>
                                        <div class="initial"><?= $initial ?></div>
                                    <?php } else { ?>
                                        <img id="pp" src="pp/<?= $row['profilepict'] ?>" alt="" srcset="">
                                    <?php } ?>
                                </div>
                                <?= $row['Username'] ?>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="section1">
            <img src="../images/empty.png" alt="">
            <p>Selamat datang! Ayo mulai percakapan seru dengan anggota lainnya. Klik pada profil teman yang ingin kamu ajak bicara dan mulai obrolan.</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const preloader = document.getElementById('preloader');
            const video = preloader.querySelector('video');

            video.addEventListener('ended', () => {
                preloader.classList.add('slide-up'); // Add class to slide the video up after it ends
            });
        });
    </script>
</body>

</html>