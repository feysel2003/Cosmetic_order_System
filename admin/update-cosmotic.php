<?php
ob_start(); // Start output buffering
?>
<?php 
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
include('partial/menu.php'); ?>

<?php
//check whether id is set or not
if(isset($_GET['id'])){
    //get all the details
    $id=$_GET['id'];

    //sql query to Get the Selected Cosmotic

    $sql2="SELECT * FROM tbl_comotic WHERE id=$id ";
    //execute the query
    $res2= mysqli_query($conn, $sql2);
    
    //Get the value based on query executed
    $row2 = mysqli_fetch_assoc($res2);

    //get the individual value of selected item
                $title=$row2['title'];
                $description=$row2['description'];
                $price=$row2['price'];
                $current_image=$row2['image_name'];
                $current_catagory=$row2['catagory_id'];
                $featured=$row2['featured'];
                $active=$row2['active'];


}
else{
    //redirect to Manage Cosmotic
    header('location:'.SITEURL.'admin/manage-cosmotic.php');

}
?>
<div class="main-content">
    <div class="wraper">
        <h1>Update Cosmotic</h1>
        <br><br>
        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title ?>">
                    </td>
                </tr>

                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price"  value="<?php echo $price; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php 
                        if($current_image =="")
                        {
                            //image not available
                            echo "<div class='error'>Image Not Available.</div>";
                        }
                        else{
                            //image available
                            ?>
                            <img src="<?php echo SITEURL;?>image/cosmotic/<?php echo $current_image; ?>"alt="<?php echo $title; ?>" width="150px">
                            <?php
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Select New Image:</td>
                    <td>
                        <input type="file" name="image" >
                    </td>
                </tr>

                <tr>
                    <td>Catagory:</td>
                    <td>
                        <select name="catagory">

                        <?php
                        //query to get active catagory
                        $sql = "SELECT * FROM tbl_catagory WHERE active='Yes'";
                        //execute th query
                        $res=mysqli_query($conn,$sql);
                        $count = mysqli_num_rows($res);

                        //check whether catagory available or not 
                        if($count>0)
                        {
                            //Catagory aVailable

                            while($row=mysqli_fetch_assoc($res))
                            {
                                $catagory_title=$row['title'];
                                $catagory_id=$row['id'];

                                ?>
                               <option <?php if($current_catagory==$catagory_id){echo "selected";} ?>value="<?php echo $catagory_id; ?>"><?php echo $catagory_title; ?></option>
                                <?php
                            }
                        }
                        else{
                            //catagory not available
                            echo "<option value='0'>Catagory Not available.</option>";
                        }
                         ?>
                            
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if($featured=="No") {echo "checked";} ?> type="radio" name="featured" value="No"> No

                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes") {echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if($active=="No") {echo "checked";} ?> type="radio" name="active" value="No"> No

                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?> ">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?> ">

                        <input type="submit" name="submit" value="Update Cosmotic" class="btn-secondary">
                    </td>
                </tr>

                </table>
        </form>
        <?php 
        if(isset($_POST['submit'])){
            // get all the detail from the form

            $id = $_POST['id'];
            $title = $_POST['title'];
            $description=$_POST['description'];
            $price=$_POST['price'];
            $current_image=$_POST['current_image'];
            $catagory=$_POST['catagory'];
            $featured=$_POST['featured'];
            $active=$_POST['active'];


            // uploade if selected

            //check whether uploade button is clicked or not
            if(isset($_FILES['image']['name'])){
                //upload button clicked
                $image_name = $_FILES['image']['name']; //new image name

                //check whether the file is avilable or not 
                if($image_name!="")
                {
                    //image is available
                    //uploading new image
                    //Rename th image 
                    $ext = end(explode('.',$image_name));//get the extension of the image

                    $image_name="Cosmotic-Name-".rand(0000,9999).'.'.$ext; //this will be rename the image

                    $source_path=$_FILES['image']['tmp_name']; //
                    $destination_path = "../image/cosmotic/".$image_name;            //Destination path

                    //upload the image
                    $upload=move_uploaded_file($source_path, $destination_path);
                    // check whether the the image is uploade or not
                    if($upload==false)
                    {
                        //failed to upload
                        $_SESSION['upload']="<div class='error'> failed To Uploade new Image. </div>";
                        //redirect to manage cosmotic
                        header('location:'.SITEURL.'admin/manage-cosmotic.php');
                        // stop the proccess
                        die();
                    }

                    // remove  the image if new image is uploaded and current image exist
                    // remove current image if available
                    if($current_image!="")
                    {
                        //current image is available 
                        // redirect the image
                        $remove_path = "../image/cosmotic/".$current_image;

                        $remove=unlink($remove_path);

                        //check whether the image is removed or not 
                        if($remove==false){
                            //failed to remove current image
                            $_SESSION['removed-failed'] = "<div class='error'> Failed to remove current image.</div>";
                            //redirect to manage cosmotic 
                            header('location:'.SITEURL.'admin/manage-cosmotic.php');
                            //stop the session
                            die();
                        }
                    }
                }
                else{
                    $image_name=$current_image; //default image when image is selected.
                }
            }
            else{
                $image_name=$current_image;  //default image when button is not clicked.

            }

            // update the cosmotic in database

            $sql3="UPDATE tbl_comotic SET
            title= '$title',
            description='$description',
            price=$price,
            image_name='$image_name',
            catagory_id='$catagory',
            featured='$featured',
            active='$active'
            WHERE id=$id
            ";

            //execute the sql query
            $res3=mysqli_query($conn,$sql3);

            //check wether the query is executed or not
            if($res3==true){
                //query executed and cosmotic update
                $_SESSION['update']="<div class='success'>Cosmotic update Successfully.</div>";
                header('location:'.SITEURL.'admin/manage-cosmotic.php');

            }
                else{

                    //failed to update cosmotic
                    $_SESSION['update']="<div class='error'>Failed To Update Cosmotic.</div>";
                header('location:'.SITEURL.'admin/manage-cosmotic.php');
                }
            

        }
        ?>
    </div>
</div>


<?php include('partial/footer.php');
?>
<?php ob_end_flush(); ?> // Send output buffer
