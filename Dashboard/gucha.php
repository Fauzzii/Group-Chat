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

$id_grup = $_GET['id'];
    
// Mengambil nama grup
$query = "SELECT GroupName FROM Groups2 WHERE GroupID = '$id_grup'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $group = $result->fetch_assoc();
    $group_name = $group['GroupName'];
} else {
    $group_name = "Grup tidak ditemukan";
}

// Mengambil data profil

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../style/add-group.css">
    <link rel="icon" href="../images/logo.png">
    <title>Gucha</title>
    <style>
        .profile-picture {
            width: 33px;
            height: 33px;
            border-radius: 100%;
            background: #391A94;
            margin-left: 30px;
            margin-top: 0px;
            color: white;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .profile-picture img {
            width: 100%;
            aspect-ratio: 1/1;
            object-fit: cover;
            border-radius: 50%;
        }

        .profileinfo {
            width: 200px;
            height: auto;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 20px;
            padding: 20px;
        }

        .profileinfo img {
            height: 200px;
            width: 200px;
            aspect-ratio: 1/1;
            object-fit: cover;
            border-radius: 50%;
        }

        .section1 {
            display: flex;
            justify-content: center;
        }

        .section {
            overflow-y: scroll;
            max-height: 90vh;
        }

        .name {
            font-size: 22px;
            font-weight: bold;
        }

        span {
            font-size: 16px;
        }

        .bio {
            resize: none;
            height: 80px;
            width: 250px;
            border-radius: 10px;
            border: none;
            background: #ccc;
            font-size: 16px;
            margin-top: 10px;
        }

        .bio p {
            margin-left: 8px;
            font-size: 14px;
        }

        .chat-input {
            width: 800px;
            padding: 10px;
            border-radius: 20px;
            border: 1px solid #ccc;
            margin-right: 10px;
            font-size: 16px;
        }

        .chat-button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            background-color: #391A94;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .chattext {
            display: flex;
            position: fixed;
            bottom: 0;
            margin-left: 35px;
            margin-bottom: 20px;
            align-items: center;
            justify-content: center;
        }

        .cl {
            display: flex;
            align-items: start;
            flex-direction: column;
            justify-content: start;
            min-height: 80vh;
            overflow-y: auto;
        }

        .cl::-webkit-scrollbar {
            width: 12px;
        }

        .cl::-webkit-scrollbar-thumb {
            background-color: #391A94;
            border-radius: 10px;
            border: 3px solid #ffffff;
        }

        .cl::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .dia,
        .aku {
            display: flex;
            align-items: center;
            width: 100%;
            margin: 5px 0;
        }

        .dia {
            justify-content: start;
        }

        .aku {
            justify-content: end;
            flex-direction: row-reverse;
        }

        .kotak-chat {
            background-color: transparent;
            padding: 10px;
            border-radius: 10px;
            margin: 2px 0;
            width: 95%;
            display: flex;
            align-items: center;
            transition: background-color 0.2s;
            margin-left: 15px;
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

        .kotak-chat:hover {
            background-color: #ccc;
        }


        .kotak-chat img {
            width: 33px;
            height: 33px;
            object-fit: cover;
            border-radius: 50%;
            margin: 0 10px;
            aspect-ratio: 1/1;
        }

        .kotak-chat .nama_chat,
        .kotak-chat .chat {
            margin: 0;
        }

        .judul {
            margin-left: 10px;
            margin-top: 15px;
        }

        .k {
            display: flex;
            top: 20px;
            left: 76%;
            position: absolute;

        }

        .section1 {
            display: flex;
            flex-direction: column;
        }

        span {
            display: flex;
            flex-direction: column;
            margin: 0;
        }

        .anggota-grup {
            position: absolute;
            margin-left: 965px;
            margin-top: 80px;
            left: 0;
            top: 0;
        }
        .anggota{
            width: 290px;
            height: 50px;
            text-align: center;
            display: flex;
            align-items: center;
            margin-top: 8px;
            background: #E6E1E1;
            border-radius: 5px;
            transition: ease-in 0.4s;
        }

        span{
        margin-left: 8px;
        }

        .anggota:hover{
            background: #ccc;
        }

        .cl{
            overflow-y: auto;
        }

        header {
            position: sticky;
            top: 0;
            background-color: white;
            z-index: 1000;
            display: flex;
            align-items: center;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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
$tgl="";
            foreach ($sqlgrup as $grup) {
                $tgl = $grup['tanggal_dibuat'];
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
        <div id="" class="section">
            <header>
                <a href="main.php">
                    <img src="../images/image (5).png" style="width: 20px; height: 20px; margin-top: 2px; margin-left: 12px;">
                </a>
                <div class="profile-picture">
                    <?= getInitials($group_name) ?>
                </div>

                <p class="judul">
                    <a><?= $group_name ?></a>
                </p>
                <a href="add-user.php?tgl=<?= $tgl ?>" class="kotak1">Tambah Anggota</a>
            </header>
            <div id="semua" class="cl">
                <?php

                $query = "SELECT * FROM messages WHERE GroupID='$id_grup'";
                $sql = mysqli_query($conn, $query);

                // Simpan jumlah baris saat ini ke dalam session untuk digunakan nanti
                foreach ($sql as $chat) {
                    $id_gw = $chat['SenderUserID'];
                    $querynama = "SELECT Username, profilepict FROM users WHERE UserID='$id_gw'";
                    $sqlnama = mysqli_query($conn, $querynama);
                    $nama = $sqlnama->fetch_assoc();
                    if ($chat['SenderUserID'] == $_SESSION['id']) {
                        $css = 'aku';
                    } else {
                        $css = 'dia';
                    }
                ?>
                    <div class="kotak-chat <?= $css ?>">
                        <img src="pp/<?= $nama['profilepict'] ?>" alt="Profile Picture">
                        <span class="nama_chat"><?= $nama['Username'] ?>
                            <p class="chat"><?= $chat['Content'] ?></p>
                        </span>
                    </div>
                <?php
                }
                ?>
            </div>
            <div id="latest"></div>
        </div>
        <form action="aksi-gucha.php?id_grup=<?=$_GET['id']?>" method="POST" class="chattext">
            <input type="hidden" name="GroupID" value="<?= $id_grup ?>">
            <input type="text" name="chat" placeholder="Ketik pesan..." class="chat-input" />
            <button type="submit" class="chat-button">></button>
        </form>
        <div class="section1">
            <div class="k">Jumlah Anggota -
                <?php
                // Query untuk menghitung jumlah anggota grup
                $query_count = "SELECT COUNT(UserID) AS total_members FROM groupmembers WHERE GroupID = '$id_grup'";
                $result_count = $conn->query($query_count);

                if ($result_count->num_rows > 0) {
                    $row_count = $result_count->fetch_assoc();
                    echo $row_count['total_members'];
                } else {
                    echo "0";
                }
                ?>
            </div>

            <div class="anggota-grup">
                <?php
                $grupid = $_GET['id'];
                $sql = mysqli_query($conn, "SELECT * FROM GroupMembers INNER JOIN users ON GroupMembers.UserID = users.UserID WHERE GroupID = $grupid ");

                foreach ($sql as $key) {
                ?>
                    <div class="anggota">
                        <span><?= $key['Username'] ?></span>
                    </div>
                <?php
                }
                ?>
            </div>
            <script>
                // Mengambil elemen dengan class 'cl'
                var chatContainer = document.querySelector('.section');
                // Mengatur scroll ke posisi paling bawah
                chatContainer.scrollTop = chatContainer.scrollHeight;
            </script>

</body>

</html>