<?php include('partial/menu.php'); ?>
<div class="main-content">
    <div class="wraper">
        <h1>Add Catagory </h1>
        <br><br>
        <?php 
        if(isset($_SESSION['add'])){
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if(isset($_SESSION['upload'])){
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        
        ?>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="catagory-title">
                    </td>
                </tr>

                <tr>
                    <td>Secte Image :</td>
                    <td><input type="file" name="image"></td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No

                    </td>
                </tr>
                
                <tr>
                    <td>Active: </td>
                    <td>
                    <input type="radio" name="active" value="Yes"> Yes
                    <input type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Catagory" class="btn-secondary">

                    </td>
                </tr>
            </table>
        </form>

        <?php 
        if(isset($_POST['submit'])){
            // get the value from the form
            $title=$_POST['title'];
           // for radio input , we nead to check weather the button is selected or not 
           if(isset($_POST['featured'])){
            // get the value from form
            $featured=$_POST['featured'];

           }
           else{
            //set the default value
            $featured="No";
           }

           if(isset($_POST['active'])){
            // get the value from form
            $active=$_POST['active'];

           }
           else{
            //set the default value
            $active="No";
           }

           // check whether the image is selected or not  and set the value for image name accordingly

           //print_r($_FILES['image']);

           //die(); //breack the code here

           if(isset($_FILES['image']['name'])){
            // upload the image
            // To upload image we need image name , source path and destination path
            $image_name=$_FILES['image']['name'];

            //uploade the image only if image is selected
            if($image_name!=""){

            
            //Auto rename our image 
            // get the extension of our image (jpg,png,gif,etc) e.g "specia.cosmotic1.ipg"

            $ext= end(explode('.',$image_name));
            
            // rename the image
            $image_name = "Cosmotic-Catagory-".rand(000, 999).'.'.$ext;
            
            //$image_name= $_FILES['image']['name'];
            $source_path = $_FILES['image']['tmp_name'];
             $destination_path = "../image/catagory/".$image_name;

             // finally upload image the image

             $upload = move_uploaded_file($source_path, $destination_path);

             // check whether the image is uploaded or not 
             // and if the image is not uploaded then we will stop the process and redirect message
              if($upload==false){
                // set message 
                $_SESSION['uploade'] = "<div class='error' > Failed to Upload image. </div>";
                //redirect to Add Catagory Page
                header('location:'.SITEURL.'admin/add-catagory.php');
                //stop the proccess
                die();

              }
            }
           }
           else{
            // don't upload image and set the image_name black
            $image_name= "";
           }

// create sql query to insert catagory into database
         $sql = "INSERT INTO tbl_catagory SET 
         title= '$title',
         image_name = '$image_name',
         featured= '$featured',
         active = '$active'   ";
         // excute the query and save into database
         $res=mysqli_query($conn, $sql);
         // check whether the query executed or not and data added or not 

         if($res==true){
            // query executed and catagory added
          $_SESSION['add']="<div class='success text-center'>Catagory Added Successfully. </div> ";
          // redirect to manage catagory page 

          header('location:'.SITEURL.'admin/manage-catagory.php');
         }
         else{
            // afiled to Add Catagory
            $_SESSION['add']="<div class='error text-center'>Failed To add Catagory. </div> ";
          // redirect to manage catagory page 

          header('location:'.SITEURL.'admin/add-catagory.php');

         }
        }
        ?>

    </div>
</div>


<?php include('partial/footer.php'); ?>