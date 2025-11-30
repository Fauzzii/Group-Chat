<?php
include '../conifg.php';
session_start();
$id_gw=$_SESSION['id'];
$id=$_GET['id'];
$query="UPDATE  friends set request=1 where UserID1='$id' and UserID2='$id_gw'";
$sql=mysqli_query($conn,$query);
if ($sql) {
    ?>
<script>
    window.location.href="request.php";
</script>
    <?php
}