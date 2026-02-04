<?php include('partial/menu.php'); ?>

<div class="main-content">
    <div class="wraper">
        <h1>Manage Order</h1>
        <div class="table-responsive">
        <table class="tbl-full">
            
            <br><br><br>

            <?php 
            if(isset($_SESSION['update'])){
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
            ?>
            <br><br>
            <tr>
                <th>S.N.</th>
                <th>Cosmotic</th>
                <th>Price</th>
                <th>quantity</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Customer Contact</th>
                <th>Email</th>
                <th>Address</th>
                <th>Actions</th>

            </tr>

            <?php
            //Get all the Order from Database
            $sql = "SELECT * FROM tbl_order ORDER BY id DESC"; //display the latest order at first
            //execute query
            $res = mysqli_query($conn,$sql);
            //count the rows 
            $count = mysqli_num_rows($res);

            $sn=1; // create a serial number it's initial value is one

            if($count>0){
                // oredr Available

                while($row=mysqli_fetch_assoc($res)){
                    // get all the order details
                    $id =$row['id'];
                    $cosmotic =$row['cosmotic'];
                    $price =$row['price'];
                    $quantity =$row['quantity'];
                    $total =$row['total'];
                    $order_date =$row['order_date'];
                    $status =$row['status'];
                    $customer_name =$row['customer_name'];
                    $customer_contact =$row['customer_contact'];
                    $customer_email =$row['customer_email'];
                    $customer_address =$row['customer_address'];

                    ?>

             <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $cosmotic; ?></td>
                <td><?php echo $price; ?></td>
                <td><?php echo $quantity; ?></td>
                <td><?php echo $total; ?></td>
                <td><?php echo $order_date; ?></td>

                <td><?php
                //Ordered, On Delivery, Delivered, Cancelled

                if($status=="Ordered")
                    {
                        echo "<label>$status</label>";
                    }
                    elseif($status=="On Delivery")
                    {
                        echo "<label style='color: orange;'>$status</label>";
                    }
                    elseif($status=="Delivered")
                    {
                        echo "<label style='color: green;'>$status</label>";
                    }
                    elseif($status=="Canceled")
                    {
                        echo "<label style='color: red;'>$status</label>";
                    }
                ?>
                
                </td>

                <td><?php echo $customer_name; ?></td>
                <td><?php echo $customer_contact; ?></td>
                <td><?php echo $customer_email; ?></td>
                <td><?php echo $customer_address; ?></td>
                <td>
                <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary">Update Order</a>
                </td>
            </tr>
                    <?php


                }
            }
            else{
                // order Not Avialable
                echo "<div colspan='12' class='error'> Order Not Available.</div>";
            }
            ?>
            

           
        </table>
        </div>
    </div>
</div>
<?php include('partial/footer.php'); ?>