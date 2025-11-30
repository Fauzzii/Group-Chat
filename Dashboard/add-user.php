<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gucha</title>
    <link rel="icon" href="../images/logo.png">
    <link rel="stylesheet" type="text/css" href="../style/main.css">
    <style>
        * {
            overflow: hidden;
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
            background-color: #391A94;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 15px;
            margin-right: 8px;
        }

        .profile-picture {
            width: 33px;
            height: 33px;
            margin-left: 30px;
            border-radius: 100%;
            background: #391A94;
            margin-top: 24px;
        }

        header p {
            margin-top: 28px;
            margin-left: 10px;
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

        div.group-circle:nth-child(2) {
            background: red;
        }

        div.group-circle:nth-child(even) {
            background: #391A94;
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
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            margin-left: auto;
            margin-top: 40px;
            background-color: #391A94;
            color: white;
            border-radius: 4px;
            padding: 8px 16px;
            text-decoration: none;
        }

        .lanjutkan {
            height: 40px;
            width: 150px;
            background: #391A94;
            color: white;
            text-decoration: none;
            margin-left: 75%;
            margin-top: 20px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <?php
    include '../conifg.php';
    session_start();
    $tgl = $_GET['tgl'];
    $id_gw = $_SESSION['id'];
    $query1 = "SELECT *FROM groups2 where tanggal_dibuat='$tgl' and CreatedByUserID='$id_gw'";
    $sql = mysqli_query($conn, $query1);
    $array_grup = $sql->fetch_assoc();
    $id_grup = $array_grup['GroupID'];
    $cek_id = "SELECT UserID from groupmembers where GroupID='$id_grup'";
    $sql_cek = mysqli_query($conn, $cek_id);
    $inarray = [];
    foreach ($sql_cek as $cek) {
        $inarray[] = $cek['UserID'];
    }
    // var_dump($inarray);

    ?>
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
                <a href="add-member  .php?id=<?= $grup['GroupID'] ?>">
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
                    <a href="add-member.php?id=<?= $nama['GroupID'] ?>">
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
                    <img src="../images/image (5).png" style="width: 20px; height: 20px; margin-left: 12px; margin-top: 28px;">
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
                <p>
                    <?php
                    if (!isset($_SESSION["email"]) || empty($_SESSION["email"])) {
                        header("Location: login.php");
                        exit();
                    }

                    echo 'Hello, ' . $_SESSION["username"];
                    ?>
                </p>
            </header>
            <div class="kontak">
                <?php
                $id_me = $_SESSION['id'];
                $query_count = "SELECT COUNT(*) as total FROM friends WHERE UserID1='$id_me'";
                $sql_count = mysqli_query($conn, $query_count);
                $count = mysqli_fetch_assoc($sql_count);

                $total_friends = $count['total'];
                ?>
                <p>All Friends - <?= $total_friends ?></p>
                <div class="column">
                    <?php
                    $query = "SELECT * FROM friends WHERE UserID1='$id_me'";
                    $sql = mysqli_query($conn, $query);

                    foreach ($sql as $data) {
                        $id2 = $data['UserID2'];
                        $query2 = "SELECT * FROM users WHERE UserID= '$id2'";
                        $sql2 = mysqli_query($conn, $query2);
                        foreach ($sql2 as $row) {
                            $initial = strtoupper(substr($row['Username'], 0, 1));
                    ?>
                            <div class="kotak-teman">
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
                                <?php
                                if (in_array($row['UserID'], $inarray)) {
                                    # code...

                                ?>
                                    <a class="tambahkan" style="right: 20px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            margin-left: auto;
            margin-top: 40px;
            background-color: #b4b4b4;
            color: black;
            border-radius: 4px;
            padding: 8px 16px;
            text-decoration: none;" id="btn">Sudah Ditambahkan</a>
                                <?php } else {
                                ?>
                                    <a href="member-grup-add.php?id=<?= $row['UserID'] ?>&id_grup=<?= $array_grup['GroupID'] ?>&tgl=<?= $_GET['tgl'] ?>" class="tambahkan">Tambahkan</a>

                                <?php
                                } ?>
                            </div>
                    <?php
                        }
                    }
                    ?>

                    <a href="main.php" class="lanjutkan">lanjutkan</a>
                </div>
            </div>
        </div>
        <div class="section1">
            <img src="../images/empty.png" alt="">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sapiente explicabo dolores neque deleniti, autem voluptatibus veniam impedit doloremque cumque magni? Voluptatibus beatae delectus quae ad quia, veritatis repellat maiores quaerat.</p>
        </div>
    </div>
</body>

</html>