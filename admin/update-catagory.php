<?php include('partial/menu.php'); ?>

<div class="main-content">
    <div class="wraper">
        <h1>Update Catagory</h1>
        <br><br>
         <?php 
         // check whether is set or not 
         if(isset($_GET['id'])){
            // get the id and all other detail
            $id=$_GET['id'];
            // create sql query to get all other details
            $sql = "SELECT * FROM tbl_catagory WHERE id=$id";
            
            // execute the query
            $res = mysqli_query($conn, $sql);

            //count the rows whether the id is valid or not 
            $count = mysqli_num_rows($res);

            if($count==1){
                // get all the data
                $row=mysqli_fetch_assoc($res);
                $title=$row['title'];
                $current_image=$row['image_name'];
                $featured=$row['featured'];
                $active=$row['active'];

            }
            else{
                //redirect to manage catagory with error message 
                $_SESSION['no-catagory-found']="<div class='error'> Catagory Not Found:</div>";

            header('location:'.SITEURL.'admin/manage-catagory.php');
         }
        }

         else
         {
            // redirect to manage catagory 

            header('location:'.SITEURL.'admin/manage-catagory.php');
         }
         ?>
        <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
                
                        <td>Title:</td>
                        <td>
                            <input type="text" name="title" value="<?php echo $title; ?>">
                        </td>
                    
                    <tr>
                        <td>Current Image</td>
                        <td>
                            <?php 
                            if($current_image!=""){
                                //dispaly the imge
                                ?>
                                <img src="<?php echo SITEURL; ?>image/catagory/<?php echo $current_image; ?> " width="150px">
                                <?php
                            }
                            else{
                                //desplay error message 
                                echo "<div class='error'>Image Not Added. </div>";
                            }
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>New Image:</td>
                        <td>
                     <input type="file" name="image">
                        </td>
                    </tr>

                    <tr>
                        <td>Featured:</td>
                        <td>
                            <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes

                            <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No"> No

                        </td>
                    </tr>

                    <tr>
                        <td>Active:</td>
                        <td>
                            <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                            <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No"> No

                        </td>
                    </tr>

                    <tr >
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">

                        <td colspan="2"><input type="submit" name="submit" value="update catagory" class="tbl-secndary"></td>

                    </tr>
                
        </table>
        </form>
        <?php 
        if(isset($_POST['submit'])){
            //echo "clicked";
            // get all the value from
            $id=$_POST['id'];
            $title=$_POST['title'];
            $current_image=$_POST['current_image'];
            $featured=$_POST['featured'];
            $active=$_POST['active'];

            // update new image if selected 
         // check whether the image is selected or not 
         if(isset($_FILES['image']['name'])){
            //get the image Details
            $image_name=$_FILES['image']['name'];
            // check whether the image available or not 
            if($image_name!=""){
                //image available
               // uploade the current image 

               //Auto rename our image 
            // get the extension of our image (jpg,png,gif,etc) e.g "specia.cosmotic1.ipg"

            $ext= end(explode('.',$image_name));
            
            // rename the image
            $image_name= "Cosmotic_Catagory_".rand(000, 999).'.'.$ext;
            
            //$image_name= $_FILES['image']['name'];
            $source_path= $_FILES['image']['tmp_name'];
             $destination_path= "../image/catagory/".$image_name;

             // finally upload image the image

             $upload = move_uploaded_file($source_path, $destination_path);

             // check whether the image is uploaded or not 
             // and if the image is not uploaded then we will stop the process and redirect message
              if($upload==false){
                // set message 
                $_SESSION['uploade'] = "<div class='error' > Failed to Upload image. </div>";
                //redirect to Add Catagory Page
                header('location'.SITEURL.'admin/manage-catagory.php');
                //stop the proccess
                die();

              }
               // remove current image if avilable
               if($current_image!=""){

                $remove_path="../image/catagory/".$current_image;

               $remove=unlink($remove_path);
               // check wether the image is removed or not 
               // failed to remove then display the error message
               if($remove==false){
                //failed to remove message
                $_SESSION['failed-to-remove']="<div class='error'>Failed To Remove Current Image.</div>";
                  header('location'.SITEURL.'admin/manage-catagory.php');
                  die();
               } 

               } 
               
            }
            else{
                $image_name=$current_image;

            }
         }
         else{
            $image_name=$current_image;
         }
            // update the database
            $sql2= "UPDATE tbl_catagory SET 
            title = '$title',
            image_name='$image_name',
            featured='$featured',
            active = '$active'
            WHERE id=$id
            ";

            // execute the query
            $res2=mysqli_query($conn,$sql2);

            // redirect to manage catagory with message 

            //check whether execurted or not

            If($res2==true){
             // catagory updated
              $_SESSION['update'] ="<div class='success'> Catagory Updated Successfully.</div>";
              header('location:'.SITEURL.'admin/manage-catagory.php');

            }
            else{
                // failed to update catagory
                $_SESSION['update'] ="<div class='error'> Failed To Update Catagory.</div>";
              header('location:'.SITEURL.'admin/manage-catagory.php');

            }
        }
        ?>
    </div>
</div>


<?php include('partial/footer.php'); ?>