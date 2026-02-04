<?php include('partial/menu.php'); ?>
<div class="main-contenet">
    <div class="wraper">
        <h1>Mange Catagory</h1>
        <br><br>

        <?php 

        if(isset($_SESSION['add'])){
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if(isset($_SESSION['remove'])){
            echo $_SESSION['remove'];
            unset($_SESSION['remove']);
        }

        if(isset($_SESSION['delete'])){
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }

        if(isset($_SESSION['no-catagory-found'])){
            echo $_SESSION['no-catagory-found'];
            unset($_SESSION['no-catagory-found']);
        }
        
        if(isset($_SESSION['update'])){
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }

        if(isset($_SESSION['upload'])){
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        
        if(isset($_SESSION['failed-to-remove'])){
            echo $_SESSION['failed-to-remove'];
            unset($_SESSION['failed-to-remove']);
        }
        
        ?>
        <br><br>

<a href="<?php echo SITEURL; ?>admin/add-catagory.php" class="btn-primary">Add Catagory</a>
<br /><br /><br />

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Title:</th>
                <th>Image:</th>
                <th>Featured:</th>
                <th>Active:</th>
                <th>Actions:</th>
            </tr>
            <?php 
            //query to get all catagory from the database

            $sql= "SELECT * FROM tbl_catagory";

            //execute query

            $res=mysqli_query($conn,$sql);

            //count rows

            $count= mysqli_num_rows($res);

            //create serial number varialble and assign value as 1.

            $sn=1;

         // check whether we ahve data in the database
            if($count>0){
                // we have data in the database
                /// get the data and desplay

                while($row=mysqli_fetch_assoc($res)){
                    $id=$row['id'];
                    $title=$row['title'];
                    $image_name=$row['image_name'];
                    $featured=$row['featured'];
                    $active=$row['active'];

                    ?>

<tr>
            <td><?php echo $sn++; ?></td>
                <td><?php echo $title; ?></td>

                <td>
                <?php
                //check whether image name is available or not 
                if($image_name!=""){
                    // display the image 
                    ?>
                    <img src="<?php echo SITEURL; ?>image/catagory/<?php echo $image_name; ?>" width="200px" height="150px"> 
                    <?php
                }
                else{
                    //display the message

                    echo "<div class='error'>Image Not Added. </div>";
                }

                ?>
                
            </td>


                <td><?php echo $featured; ?></td>
                <td><?php echo $active; ?></td>
                <td>
                <a href="<?php echo SITEURL; ?>admin/update-catagory.php?id=<?php echo $id; ?>" class="btn-secondary">Update Catagory</a>
                <a href="<?php echo SITEURL;?>admin/delete-catagory.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Catagory</a>  
                </td>
            </tr>

                    <?php
                }
            }
            else{
               // We don't have data in the database
                //we will desplay tne message in the table
                ?>
                <tr>
                    <td colspan="6">
                        <div class="error">No Catagory Added.</div>
                    </td>
                </tr>
                <?php
            }
            ?>
            

        </table>
    </div>
</div>
<?php include('partial/footer.php'); ?>