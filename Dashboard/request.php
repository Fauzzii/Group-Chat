<!DOCTYPE html>
<html lang="en">
<?php
include '../conifg.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="logo.png">
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

        .kotak4 {
            background: #391A94;
            color: white;
            width: auto;
            height: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            padding: 5px 10px;
            font-size: 15px;
            border-radius: 5px;
            margin-left: 600px;
        }

        .kotak4 a {
            color: white;
            text-decoration: none;
        }

        .kotak-tolak {
            background: #b4b3b3;
            color: black;
            padding: 5px 10px;
            text-decoration: none;
            font-size: 15px;
            border-radius: 5px;
            margin-left: 10px;
        }

        .kotak-tolak a {
            color: black;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <?php session_start(); ?>
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
                <a href="main.php">
                    <img src="../images/image (5).png" style="width: 20px; height: 20px; position: fixed; margin-top: 28px; margin-left: 12px;">
                </a>
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
            </header>
            <div class="kontak">
                <?php
                $id_me = $_SESSION['id'];
                $query_count = "SELECT COUNT(*) as total FROM friends WHERE UserID1='$id_me'";
                $sql_count = mysqli_query($conn, $query_count);
                $count = mysqli_fetch_assoc($sql_count);
                $query = "SELECT * FROM friends WHERE UserID2='$id_me' and request =0";
                $sql = mysqli_query($conn, $query);

                ?>
                <p>All Requests - <?= mysqli_num_rows($sql) ?></p>
                <div class="column">
                    <?php


                    foreach ($sql as $data) {
                        $id2 = $data['UserID1'];
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
                                <div class="kotak4">
                                    <a href="add-pren.php?id=<?= $row['UserID'] ?>">Terima</a>
                                </div>
                                <?php
                                if ($data['request'] == 0) {
                                ?>
                                    <div class="kotak-tolak">
                                        <a href="tolak.php?id=<?= $row['UserID'] ?>">Tolak</a>
                                    </div>
                                <?php
                                }
                                ?>
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
</body>

</html>
