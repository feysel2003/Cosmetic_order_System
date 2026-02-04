<?php ob_start(); ?>
<?php include('partial/menu.php'); ?>
<div class="main-content">
    <div class="wraper">
        <h1>Add Cosmotic</h1>
        <br><br>

        <?php
        if(isset($_SESSION['upload'])){
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="title of the cosmotic">
                    </td>
                </tr>

                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="description of th cosmotic"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" >
                    </td>
                </tr>

                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image" >
                    </td>
                </tr>

                <tr>
                    <td>Catagory:</td>
                    <td>
                        <select name="catagory">

                        <?php
                        //create php code to display catagories from database
                        // create sql to get all active catagories from database
                        $sql="SELECT * FROM tbl_catagory WHERE active='Yes'";

                        //executing query
                        $res = mysqli_query($conn,$sql);
                       
                        // count rows to check whether we have categories or not 
                        $count=mysqli_num_rows($res);

                        // count is greater than zero we have catagory else we don't have catagory
                        if($count>0){
                            //We have Catagory
                          while($row=mysqli_fetch_assoc($res)){
                            //get detail of catagory
                            $id=$row['id'];
                            $title=$row['title'];
                            ?>
                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                             
                            <?php
                          }
                        }
                        else{
                            // we don't have catagory
                            ?>
                          <option value="0">No Catagory Found</option>

                            <?php
                        }
                        // display on dropdown
                        ?>
                            
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No

                    </td>
                </tr>

                <tr>
                <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No

                    </td>
                </tr>
              <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Add Cosmotic" class="btn-secondary">
                </td>
              </tr>

            </table>
        </form>
<?php
        //check whether the botton is clicked or not

        if(isset($_POST['submit'])){
            //Add the Cosmotic in the databse
            //echo "clicked";
            //1. get the data from the form
                
            $title=$_POST['title'];
            $description=$_POST['description'];
            $price=$_POST['price'];
            $catagory=$_POST['catagory'];

            //check whether radio button for feature and active are checked or not 

            if(isset($_POST['featured'])){
                $featured=$_POST["featured"];

            }
            else{
                $featured= "No"; //seting the default value
            }

            if(isset($_POST['active'])){
                $active=$_POST["active"];

            }
            else{
                $active= "No"; //seting the default value
            }
            //2. upload the image if selected

            // CHECK WHETHER THE selected image is clicked or not and uploade the image only if the image is selected
            if(isset($_FILES['image']['name'])){
                //get the detail of the selected image 

                $image_name=$_FILES['image']['name'];
                // check whether  the image is sected or not and upload image only if selected
                if($image_name!=""){
                    // Image is Selected
                    // rename the image
                    // get the extenstion of selected image 
                    $ext_parts = explode('.', $image_name);
                    $ext = end($ext_parts);

                    // create new name for image

                    $image_name= "cosmotic-Name-".rand(0000,9999).".".$ext;

                    // uploade the image
                    // get the src and dest path
                    $src=$_FILES['image']['tmp_name'];

                    $dest = "../image/cosmotic/".$image_name;
                    // finally uploade the cosmotic image

                    $upload=move_uploaded_file($src,$dest);
                    //check whether the image upload or not 
                    if($upload==false){
                        //failed to uploade the image 
                        //redirect to add cosmotic page with the errore message 
                        $_SESSION['upload']="<div class='error'> Failed To Uploade The Image. </div>";
                        header('location:'.SITEURL.'admin/add-cosmotic.php');
                        //stop the process
                        die();
                    }
                }
            }
            else{
                $image_name=""; // setting default value as blank

            }
            //3. insert into database

            //create sql query to save or add cosmotic
            $sql2="INSERT INTO tbl_comotic SET 
            title = '$title',
            description= '$description',
            price= $price,
            image_name = '$image_name',
            catagory_id = $catagory,
            featured = '$featured',
            active = '$active'
               ";

               //execute the query
               $res2=mysqli_query($conn, $sql2);
               //check whether data inserted or not 

               if($res2==true){
                //data inserted successfuly
                $_SESSION['add'] = "<div class='success'>Cosmotic Added Successfully.</div>";
                header('location:'.SITEURL.'admin/manage-cosmotic.php');
               }
               else{
                //Failed to insert Data
                $_SESSION['add'] = "<div class='error'>Failed To Add Cosmotic.</div>";
                header('location:'.SITEURL.'admin/manage-cosmotic.php');
               }
            

        }
        ?>
    </div>
</div>



<?php include('partial/footer.php'); ?>
<?php ob_end_flush(); ?>