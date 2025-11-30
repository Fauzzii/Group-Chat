<?php
include'../conifg.php';
$id=$_GET['id_me'];
$id_lawan=$_GET['id_lawan'];

$cek=mysqli_query($conn,"SELECT *FROM friends where UserID1 in('$id','$id_lawan') and UserID2 in('$id','$id_lawan')");
$cekk=$cek->num_rows;
if ($cekk===1) {
    # code...
    $query="UPDATE friends set request = 0 where UserID1 in('$id','$id_lawan') and UserID2 in('$id','$id_lawan')";

}else{
    
    $query="INSERT INTO friends values('','$id','$id_lawan',0)";
}
$sql=mysqli_query($conn,$query);


if ($sql) {
    
    ?>
<script>
    window.location.href="add-friend.php";
</script>
    <?php
}