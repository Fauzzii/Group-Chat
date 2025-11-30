<?php
$nama_grup = $_POST['nama'];
$id = $_POST['id'];
var_dump($id);
include '../conifg.php';
session_start();
$gw = $_SESSION['id'];
if (empty($nama_grup)) {
?>
    <script>
        window.location.href = "add-group.php";
    </script>
<?php



} else {
    $date = date('Y-m-d H:i:s');
    

    $query1 = "INSERT INTO groups2 values('','$nama_grup','$gw','$date')";
    $sql1 = mysqli_query($conn, $query1);

    if ($sql1) {
       ?>
<script>
    window.location.href="add-user.php?tgl=<?=$date?>";
</script>
       <?php

        
    }
}
