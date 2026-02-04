<?php include('partial/menu.php'); ?>
<div class="main-contenet">
    <div class="wraper">
        <h1>Mange Admin</h1>
        <table class="tbl-full">
            <br>
            <?php 
            if(isset($_SESSION['add'])){
                echo $_SESSION['add'];//display session message
                unset($_SESSION['add']);//removing desplay message
            }

            if(isset($_SESSION['delete'])){
                echo $_SESSION['delete'];//display session message
                unset($_SESSION['delete']);//removing desplay message
            }

            if(isset($_SESSION['update'])){
                echo $_SESSION['update'];//display session message
                unset($_SESSION['update']);//removing desplay message
            }

            if(isset($_SESSION['user-not-found'])){
                echo $_SESSION['user-not-found'];//display session message
                unset($_SESSION['user-not-found']);//removing desplay message
            }

            if(isset($_SESSION['password-not-match'])){
                echo $_SESSION['password-not-match'];//display session message
                unset($_SESSION['password-not-match']);//removing desplay message
            }

            if(isset($_SESSION['change-pwd'])){
                echo $_SESSION['change-pwd'];//display session message
                unset($_SESSION['change-pwd']);//removing desplay message
            }
            ?>
            <br><br>
            <a href="add-admin.php" class="btn-primary">Add Admin</a>
            <br><br><br>
            <tr>
                <th>S.N.</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>

            </tr>
            <?php 
            //query to get all admin 
            $sql="SELECT * FROM tbl_admin";
            //Excute the query 
            $res=mysqli_query($conn,$sql);
            //check weather the query Excute or Not 
            if($res==TRUE){
                //count rows to check wether , we have data in datbase or not
                $count = mysqli_num_rows($res); //function to get all the row in the database 
                //check num of rows
                $sn=1;//create a variable and assign the value 
                if($count>0){
                    // we have data in the database 
                    while($rows=mysqli_fetch_assoc($res)){
                        //using while to create all the data from the database
                        //and while loop will run as long as have data in the database
                        // Get individual data  
                        $id=$rows['id'];
                        $full_name=$rows['full_name'];
                        $username=$rows['username'];
                        //display the value in our table 
?>

<tr>
            <td><?php echo $sn++; ?></td>
                <td><?php echo $full_name; ?></td>
                <td><?php echo $username; ?></td>
                
                <td>
                    <a href="<?php echo SITEURL;?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Upssword</a>
                <a href="<?php echo SITEURL;?>admin/admin-update.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Delete admine</a>  
                </td>
            </tr>
<?php

                    }
                }
            else{
                //we don't have data in the datbase

            }
            }
            ?>

        </table>
    </div>
</div>
<?php include('partial/footer.php'); ?>