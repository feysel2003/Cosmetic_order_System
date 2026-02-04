<?php include('partial/menu.php'); ?>
<div class="main-content">
    <div class="wraper">
        <h1>Add Admin</h1>
        <br><br>

        <?php 
            if(isset($_SESSION['add'])){
                echo $_SESSION['add'];//display session message
                unset($_SESSION['add']);//removing desplay message
            }
            ?>

        <form action="" method="post">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter Your Name">
                    </td>
                    
                    <td>
                    
                        Username: 
                    </td>
                    <td>
                        <input type="text" name="username" placeholder="Your username">
                    </td>
                    <td>Password:</td>
                    <td>
                        <input type="password" name="password" placeholder="Your password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin"class="bnt-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>



<?php include('partial/footer.php'); ?>

<?php
if(isset($_POST['submit'])){
     $full_name=$_POST['full_name'];
     $username=$_POST['username'];
     $password=md5($_POST['password']); //password Encryption with md5
//sql query to save to database
$sql="INSERT INTO tbl_admin SET
full_name='$full_name',
username='$username',
password='$password'
";


// excuting query and saving data into database
$res=mysqli_query($conn,$sql) or die(mysqli_error( ));
// check wether the data is inserted or not and idsplay apropriate message
if($res==TRUE){
   // echo "DATA IS INSERTED SUCCESFULLY";
   //create a session to display message
$_SESSION["add"]="Admin Added Succefully";
//Redirect page
header("location:".SITEURL."admin/manage-admin.php");
}
else{
    //echo "DATA INSERTION IS FAILED";
     //create a session to display message
$_SESSION["add"]="Failed to Add Admin";
//Redirect page to adde admin
header("location:".SITEURL."admin/add-admin.php");
}
}

?>