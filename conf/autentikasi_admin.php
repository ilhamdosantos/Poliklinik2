<?php
session_start();

include ('config.php');
$username =$_POST['username'];
$password =$_POST['password'];

$query = mysqli_query($koneksi,"SELECT * FROM tb_admin WHERE username='$username' AND password='$password'");
if(mysqli_num_rows($query)==1){
    header('Location:../admin/dashboard.php');
    $user = mysqli_fetch_array($query);
    $_SESSION['nama'] = $user['nama'];

}
else if($username == '' && $password ==''){
    header('Location:../login_admin.php?error=2');
}
else{
    header('Location:../login_admin.php?error=1');
}
?>
