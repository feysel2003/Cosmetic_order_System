<?php include('partial/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Customer Contact Messages</h1>

        <br><br>

        <?php
        // Check for session message
        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        ?>

        <table class="tbl-full">
            <tr>
                <th>SN</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Brand</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Date</th>
                <th>Action</th>
            </tr>

            <?php
            // Fetch contact messages along with brand names (if any)
            $sql = "
                SELECT c.*, b.brand_name 
                FROM tbl_contact c
                LEFT JOIN brand b ON c.brand_id = b.brand_id
                ORDER BY c.date DESC
            ";
            $res = mysqli_query($conn, $sql);

            if ($res == true) {
                $count = mysqli_num_rows($res);
                $sn = 1;

                if ($count > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
                        $full_name = $row['full_name'];
                        $email = $row['email'];
                        $subject = $row['subject'];
                        $message = $row['message'];
                        $date = $row['date'];
                        $brand = $row['brand_name'] ? $row['brand_name'] : "Other Issue";
                        ?>

                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo htmlspecialchars($full_name); ?></td>
                            <td><?php echo htmlspecialchars($email); ?></td>
                            <td><?php echo htmlspecialchars($brand); ?></td>
                            <td><?php echo htmlspecialchars($subject); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($message)); ?></td>
                            <td><?php echo $date; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/delete-contact.php?id=<?php echo $id; ?>" class="btn-danger" onclick="return confirm('Are you sure you want to delete this message?');">Delete</a>
                            </td>
                        </tr>

                        <?php
                    }
                } else {
                    echo "<tr><td colspan='8' class='error text-center'>No contact messages found.</td></tr>";
                }
            }
            ?>
        </table>
    </div>
</div>

<?php include('partial/footer.php'); ?>
