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

$id_gw = $_GET['id2'];

// Mengambil data profil
$querypp = "SELECT profilepict FROM users WHERE UserID=$id_gw";
$sqlll = mysqli_query($conn, $querypp);
$gambar = $sqlll->fetch_assoc();

// Mengambil username dan bio
$query2 = "SELECT username, bio FROM users WHERE UserID='$id_gw'";
$sql2 = mysqli_query($conn, $query2);
$data_user = $sql2->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../style/main.css">
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
        }

        header {
            position: sticky;
            top: 0;
            background-color: white;
            z-index: 1000;
            display: flex;
            align-items: center;
        }

        .section {
            overflow-y: scroll;
            max-height: 90vh;
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

        header p {
            margin: 0 10px;
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

        .kotak-chat:hover {
            background-color: #ccc;
        }


        .kotak-chat img {
            width: 33px;
            height: 33px;
            border-radius: 50%;
            margin: 0 10px;
            aspect-ratio: 1/1;
        }

        .kotak-chat .nama_chat,
        .kotak-chat .chat {
            margin: 0;
        }

        .kotak {
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

        .sidebar-scroll {
            overflow-y: auto;
        }

        .sidebar-scroll::-webkit-scrollbar {
            display: none;
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
        <div id="" class="section">
            <header>
                <a href="main.php">
                    <img src="../images/image (5).png" style="width: 20px; height: 20px; margin-top: 3px; margin-left: 12px;">
                </a>
                <div class="profile-picture">
                    <a href="pp.php?id=<?= $_SESSION['id'] ?>">
                        <img src="pp/<?= $gambar['profilepict'] ?>" alt="">
                    </a>
                </div>
                <p>
                    <?= $data_user['username'] ?>
                </p>
            </header>
            <div id="semua" class="cl" id="cl">
                <?php
                $userid1 = $_SESSION['id'];
                $userid2 = $_GET['id2'];

                $query1 = "SELECT * FROM messages_person where id1 in('$userid1','$userid2') and id2 in('$userid1','$userid2')";
                $sql1 = mysqli_query($conn, $query1);
                $sql1->num_rows;

                // Cek jumlah baris saat ini
                $cek_saat_ini = $sql1->num_rows;

                // Ambil nilai sebelumnya dari session, jika ada
                $cek_sebelumnya = isset($_SESSION['cek_sebelumnya']) ? $_SESSION['cek_sebelumnya'] : 0;

                // Kondisi jika jumlah baris saat ini lebih besar dari nilai sebelumnya
                if ($cek_saat_ini > $cek_sebelumnya) {
                ?>
                    <script>
                        window.location.reload();
                    </script>
                <?php
                }

                // Simpan jumlah baris saat ini ke dalam session untuk digunakan nanti
                $_SESSION['cek_sebelumnya'] = $cek_saat_ini;
                foreach ($sql1 as $chat) {

                    $id_gw = $chat['id1'];
                    $querynama = "SELECT Username, profilepict FROM users WHERE UserID='$id_gw'";
                    $sqlnama = mysqli_query($conn, $querynama);
                    $nama = $sqlnama->fetch_assoc();

                    if ($chat['id1'] == $_SESSION['id']) {
                        $css = 'aku';
                    } else {
                        $css = 'dia';
                    }




                ?>

                    <div class="kotak-chat <?= $css ?>">
                        <img src="pp/<?= $nama['profilepict'] ?>" alt="Profile Picture" style="object-fit: cover;">
                        <div>
                            <span class="nama_chat"><?= $nama['Username'] ?></span>
                            <p class="chat"><?= $chat['konten'] ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <script>
                // Mengambil elemen dengan class 'cl'
                var chatContainer = document.querySelector('.section');
                // Mengatur scroll ke posisi paling bawah
                chatContainer.scrollTop = chatContainer.scrollHeight;
            </script>

            <div class="chattext">
                <form method="post" action="aksi-chat.php?id1=<?= $_GET['id1'] ?>&id2=<?= $_GET['id2'] ?>">
                    <input type="text" name="chat" placeholder="Kirim pesan" class="chat-input">
                    <button type="submit" class="chat-button">></button>
                </form>
            </div>
        </div>
        <div class="section1">
            <div class="profileinfo">
                <a>
                    <img src="pp/<?= $gambar['profilepict'] ?>" alt="">
                </a>
                <div class="name">
                    <p>
                        <?= $data_user['username'] ?>
                    </p>
                </div>
                <label style="text-align: start; display: flex;">Bio</label>
                <div class="bio">
                    <div id="bio" name="bio" rows="4" cols="50" readonly class="bio">
                        <p>
                            <?= $data_user['bio'] ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>