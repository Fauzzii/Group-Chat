<?php
session_start();
include'../conifg.php';
$chat=$_POST['chat'];
$id1=$_GET['id1'];
$id2=$_GET['id2'];

$id_chat=$_SESSION['id'];
$query1="INSERT INTO messages_person values('','$id_chat','$id2','$chat',CURRENT_TIMESTAMP())";
$sql1=mysqli_query($conn,$query1);
if ($sql1) {
    
    ?>
<script>
    window.location.href="chat.php?id1=<?=$id1?>&id2=<?=$id2?>";
</script> 
    <?php
}