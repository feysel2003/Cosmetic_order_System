<?php include('partial/menu.php'); ?>
<div class="main-content">
    <div class="wraper">
        <h1>Change Password</h1>
        <br><br>
        <?php 
        if(isset($_GET['id'])){
            $id=$_GET['id'];
        }
        ?>

        <form action="" method="post">
            <table class="tbl-30">
                <tr>
                    <td>Current Password</td>
                    <td><input type="password" name="current_password" placeholder="Current_password"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>New Password</td>
                    <td><input type="password" name="new_password" placeholder="new_password"></td>
                </tr>

                <tr>
                    <td>Confirm Password:</td>
                    <td><input type="password" name="confirm_password" placeholder="Confirm_password"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="change_password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php 
// check whether the buttonclicked or not 
if(isset($_POST['submit'])){
    // get the data from form 
$id=$_POST['id'];
$current_password=md5($_POST['current_password']);
$new_password=md5($_POST['new_password']);
$confirm_password=md5($_POST['confirm_password']);

    // check whether the user with the curren and the current password exist or not 

    $sql= "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password' ";

    //excute the query
    $res=mysqli_query($conn,$sql);
    if($res==true){
        // check wether the data available or not
        $count=mysqli_num_rows($res);
        if($count==1){
            // user exist and password can change
//echo "User Found:";
if($new_password==$confirm_password){
    //update the password
$sql2= "UPDATE tbl_admin SET 
password='$new_password'
WHERE id=$id ";
//execute the query
$res2=mysqli_query($conn,$sql2);
//check wether the query execute or not
 if($res2==true){
    // display succes message
    $_SESSION['change-pwd']='<div class="success" > Password Change Successfully</div> ';
    header('location:'.SITEURL.'admin/manage-admin.php');
 }
 else{
    //display error message
    $_SESSION['change-pwd']='<div class="error" > Failed To Changing Password: </div> ';
    header('location:'.SITEURL.'admin/manage-admin.php');
 }
}
else{
    // redirect to manage admin page with error message
    $_SESSION['password-not-match']='<div class="error" > Password Did Not Match</div> ';
    header('location:'.SITEURL.'admin/manage-admin.php');

}

        }
        else{
            //user does not existed set message and redirect
            $_SESSION['user-not-found']='<div class="error" > User Not Found</div> ';
            header('location:'.SITEURL.'admin/manage-admin.php');

    }
    
    //check wether the New password and the confirm password match or not 

    //
}
}

?>



</php include('partial/footer.php'); ?>