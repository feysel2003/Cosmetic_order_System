<?php
// include constants file 
//Start session
session_start();
//cerate constant to store repeated value
define('SITEURL','http://localhost/Ourproject/');
 define("LOCALHOST","localhost");
 define('DB_USERNAME','root');
 define('DB_PASSWORD','');
 define('DB_NAME','cosmotic-oreder');
$conn = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());
$db_select = mysqli_select_db($conn,DB_NAME) or die(mysqli_error()); 


//echo "delete page";
// check wether the id and image name value is set or not 
if(isset($_GET['id']) AND isset($_GET['image_name']))
{
    //Get the value and Delete
    //echo "Get  value and delete";
    $id = $_GET['id'];
    $image_name=$_GET['image_name'];

    // remove th physical image file is available 
    if($image_name!= ""){
        //image available and remove it 
        $path="../image/catagory/".$image_name;
        // remove the image 
        $remove = unlink($path);

        // if fail to remove the image then add the error message and stop the procces
        if($remove==false) {
            // set the session message 
            $_SESSION['remove'] = "<div class ='success'>Failed To Remove Catagory Image.</div>" ;

            // redirect to manage catagory page 
            header('location:'.SITEURL.'admin/manage-catagory.php');
            // stop 
            die();

            
    }
    // delete data from the database 
   $sql = "DELETE FROM tbl_catagory WHERE id=$id";
   // execute the query 
   $res=mysqli_query($conn,$sql);

   // check wether the data is delete from database or not 

   if($res==true){
    // set success message and redirect
    $_SESSION['delete'] = "<div class ='success'>Catagory Dalete Successfully.</div>" ;
    // redirect to manage catagory
    header('location:'.SITEURL.'admin/manage-catagory.php');
   } 
   else{
    // Set Failed Message and Redirect
    $_SESSION['delete'] = "<div class ='error'>Failed To Dalet Catagory.</div>" ;
    // redirect to manage catagory
    header('location:'.SITEURL.'admin/manage-catagory.php');
   } 
    // redirect to manage catagory page with message 
   

}
else{
    // redirect to manage catagory page

    header('location:'.SITEURL.'admin/manage-catagory.php');

}
}
?>