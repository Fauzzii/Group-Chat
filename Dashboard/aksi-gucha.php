<?php
$id_grup=$_GET['id_grup'];
session_start();
include'../conifg.php';
$chat=$_POST['chat'];
$id_gw=$_SESSION['id'];
$query="INSERT INTO messages values('','$id_grup','$id_gw','$chat',CURRENT_TIMESTAMP())";
$sql=mysqli_query($conn,$query);
if ($sql) {
    
    ?>
<script>
    window.location.href="gucha.php?id=<?=$_GET['id_grup']?>";
</script>
    <?php
}