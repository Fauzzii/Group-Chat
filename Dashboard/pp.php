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

// Mengambil data dari database
$userID = $_SESSION['id'];
$queryUser = $conn->prepare("SELECT username, bio FROM users WHERE UserID=?");
$queryUser->bind_param('i', $userID);
$queryUser->execute();
$resultUser = $queryUser->get_result();
$userUsername = '';
$userBio = '';
if ($resultUser->num_rows > 0) {
    $rowUser = $resultUser->fetch_assoc();
    $userUsername = $rowUser['username'];
    $userBio = $rowUser['bio'];
}

// Menangani pembaruan username dan bio
if (isset($_POST['update_user'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $bio = $conn->real_escape_string($_POST['bio']);
    $query = $conn->prepare("UPDATE users SET username=?, bio=? WHERE UserID=?");
    $query->bind_param('ssi', $username, $bio, $userID);
    if ($query->execute()) {
        $_SESSION['username'] = $username;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Error updating username or bio: " . $conn->error;
    }
}

// Menangani pembaruan profile picture
if (isset($_POST['masuk'])) {
    if ($_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $direktori = "pp/";
        $pp = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
        $pp_unik = uniqid() . '.' . $pp;
        move_uploaded_file($_FILES['img']['tmp_name'], $direktori . $pp_unik);

        $query = $conn->prepare("UPDATE users SET profilepict=? WHERE UserID=?");
        $query->bind_param('si', $pp_unik, $userID);
        if ($query->execute()) {
            echo "<script>window.location.href = 'pp.php?id={$userID}';</script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../style/settings.css">
    <title>Gucha</title>
    <link rel="icon" href="../images/logo.png">
    <style>
        .profile-container {
            text-align: center;
            margin-top: 20px;
        }

        .profile-picture {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: blue;
            margin: 20px auto;
        }

        .profile-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            cursor: pointer;
        }

        label {
            font-weight: bold;
        }

        .username {
            display: flex;
            align-items: center;
            flex-direction: column;
            justify-content: flex-start;
        }

        .username-display {
            font-size: 24px;
            font-weight: bold;
        }

        .sidebar a {
            display: flex;
            padding: 10px 15px;
            color: #333;
            justify-content: center;
            color: black;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #b6b6bb;
        }

        .sidebar .exit a {
            color: red;
        }

        textarea {
            resize: none;
            height: 150px;
            width: 1000px;
            border-radius: 10px;
            border: 2px solid black;
            font-size: 16px;
        }

        .username button {
            background-color: blue;
            color: white;
            padding: 10px 20px;
            margin-top: 10px;
            border: none;
            cursor: pointer;
        }

        .username button:hover {
            background-color: darkblue;
        }

        .tombol {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
            margin-right: 100px;
        }

        .tombol input[type="submit"] {
            margin-left: 10px;
        }

        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            padding: 20px;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            border-radius: 12px;
        }

        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }

        .popup textarea {
            width: 390px;
            height: 30px;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <a href="pp.php">Akun</a>
        <div class="exit">
            <a href="logout.php">Keluar</a>
        </div>
    </div>

    <div class="main-content">
        <div class="section">
            <a href="main.php">
                <img src="../images/image (5).png" style="width: 20px; height: 20px; margin-top: 20px; margin-left: 20px;">
            </a>
            <?php
            $querypp = $conn->prepare("SELECT profilepict FROM users WHERE UserID=?");
            $querypp->bind_param('i', $userID);
            $querypp->execute();
            $resultpp = $querypp->get_result();
            $gambar = $resultpp->fetch_assoc();
            ?>
            <div class="profile-container">
                <div id="pp" class="profile-picture">
                    <img src="pp/<?= $gambar['profilepict'] ?>" alt="">
                </div>
                <p class="username-display">
                    <?php
                    echo 'Hello, ' . $_SESSION["username"];
                    ?>
                    <img src="../images/edit.png" style="width: 16px; height: 16px; cursor: pointer;" id="edit">
                </p>
            </div>
            <form action="" enctype="multipart/form-data" method="post">
                <div style="display: none;">
                    <input type="file" name="img" id="file">
                    <button name="masuk" id="buton" type="submit">masuk</button>
                </div>
            </form>
            <form action="" method="post">
                <div class="username">
                    <label style="text-align: start; display: flex;">Bio</label>
                    <textarea id="bio" name="bio" rows="4" cols="50" readonly><?= htmlspecialchars($userBio); ?></textarea>
                </div>
            </form>

            <div class="popup-overlay" id="popup-overlay"></div>
            <div class="popup" id="popup">
                <span class="close-btn" id="close-popup">&times;</span>
                <form action="" method="post">
                    <label for="edit-username">Edit Username</label>
                    <textarea id="edit-username" name="username" rows="1" cols="50"><?= htmlspecialchars($userUsername); ?></textarea>
                    <label for="edit-bio">Edit Bio</label>
                    <textarea id="edit-bio" name="bio" rows="4" cols="50"><?= htmlspecialchars($userBio); ?></textarea>
                    <input type="submit" name="update_user" value="Submit">
                </form>
            </div>

            <div class="popup" id="delete-popup">
                <span class="close-btn" id="close-delete-popup">&times;</span>
                <p>Apakah Anda yakin akan menghapus akun ini?</p>
                <div class="tombol">
                    <form action="" method="post">
                        <input type="submit" name="delete_user" value="Yakin">
                    </form>
                    <button id="batal-delete">Batal</button>
                </div>
            </div>


            <script>
                const pp = document.getElementById("pp");
                const file = document.getElementById("file");
                const buton = document.getElementById("buton");

                pp.addEventListener('click', function() {
                    file.click();
                });

                file.addEventListener('change', function() {
                    buton.click();
                });

                document.getElementById("edit").addEventListener("click", function() {
                    document.getElementById("popup").style.display = "block";
                    document.getElementById("popup-overlay").style.display = "block";
                });

                document.getElementById("close-popup").addEventListener("click", function() {
                    document.getElementById("popup").style.display = "none";
                    document.getElementById("popup-overlay").style.display = "none";
                });

                document.getElementById("popup-overlay").addEventListener("click", function() {
                    document.getElementById("popup").style.display = "none";
                    document.getElementById("popup-overlay").style.display = "none";
                });

                document.getElementById("hapus").addEventListener("click", function() {
                    document.getElementById("delete-popup").style.display = "block";
                    document.getElementById("popup-overlay").style.display = "block";
                });

                document.getElementById("close-delete-popup").addEventListener("click", function() {
                    document.getElementById("delete-popup").style.display = "none";
                    document.getElementById("popup-overlay").style.display = "none";
                });

                document.getElementById("batal-delete").addEventListener("click", function() {
                    document.getElementById("delete-popup").style.display = "none";
                    document.getElementById("popup-overlay").style.display = "none";
                });
            </script>
</body>

</html>