<?php
include'../conifg.php';
session_start();
$id_grup=$_GET['id_grup'];
$id_calon=$_GET['id'];


$query="INSERT INTO groupmembers values('','$id_grup','$id_calon')";
$sql=mysqli_query($conn,$query);
if ($sql) {
    ?>
<script>
    window.location.href='add-user.php?tgl=<?=$_GET['tgl']?>';
</script>
    <?php
    
    # code...
}