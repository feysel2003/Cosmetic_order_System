<?php include('partial/menu.php'); ?>

<div class="main-content">
    <div class="wraper">
        <h1>Update Admin</h1>
    
    <br><br>
    <?php
    // get the id of selected Admin
$id=$_GET['id'];
    // create sql query to get the details 
    $sql="SELECT * FROM tbl_admin WHERE id=$id ";
    //excute the query
    $res=mysqli_query($conn,$sql);
    //check wether the query is excuted or not 
    if($res==true){
        //check whether the data is available or not 
        $count =mysqli_num_rows($res);
        // check wether we have admi data or not 
        if($count==1){
            // get the detail
//echo "Admin Available

$rows=mysqli_fetch_assoc($res);
$full_name=$rows['full_name'];
$username=$rows['username'];

        }
        else{
            //redirect to manage admin
            header('location'.SITEURL.'admin/manage-admin.php');
        }

        }
    ?>

    <form action="" method="POST">
        <table class="tbl-30">
            <tr>
                <td>Full Name:</td>
                <td><input type="text" name="full_name" value="<?php echo $full_name; ?>" ></td>
                <td>Username:</td>
                <td><input type="text" name="username" value="<?php echo $username; ?>" ></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                    <input type="submit" name="submit" value="update Admin" class="btn-secondary">
                </td>
            </tr>
        </table>
    </form>
    </div>
</div>
<?php 
//check wether the click submite button is clicked or not
if(isset($_POST['submit'])){
    //echo "button is clicked";
    //get all the value from form to update
    $id=$_POST['id'];
   $full_name=$_POST['full_name'];
  $username=$_POST['username'];
  //ceate sql query to update Admin
  $sql = "UPDATE tbl_admin SET 
  full_name= '$full_name',
  username= '$username'
  WHERE id='$id'
  ";
  //Execute the query
  $res=mysqli_query($conn,$sql);
  //check wether the query excuted successefully or not 
  if($res==true){
    //query excuted and admin Updated
    $_SESSION['update'] = "<div class='success'>Admin Update Successfully</div>";
    header('location:'.SITEURL.'admin/manage-admin.php');

  }
  else{
    $_SESSION['update'] = "<div class='error'>Admin Update is Failed try Agin later</div>";
    header('location:'.SITEURL.'admin/manage-admin.php');
  }
} 
?>

<?php include('partial/footer.php'); ?>