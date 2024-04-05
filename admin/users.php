<?php
include "../connect.php"; // Include your database connection file

$query = "SELECT * FROM users"; // Query to fetch users from the database
$result = mysqli_query($con, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin(SkillSprint) - Users</title>
    <link rel="stylesheet" href="nav.css" />
    <link rel="stylesheet" href="applications.css" />

<body>
  <!-- Navigation Bar -->
  <nav>
    <div class="logo-container">
      <a href="dash.php"><img src="../images/logo/house-cleaning.png" alt="SkillSprint Logo" class="logo" style="z-index: 1" /></a>
    </div>
    <a href="applications.php" class="hover" >Applications</a>
    <a href="users.php" class="hover">Users</a>
    <a href="workers.php" class="hover">Workers</a>
    <a href="signout.php" class="hover">Sign Out</a>
  </nav>
  <!-- End Navigation Bar -->    <div class="main">
    <h3>Users</h3>  
    <!-- Table for Users -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Loation</th>
                <th>Phone</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                // Loop through each row of data
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>" . $row['id'] . "</td>
                        <td>" . $row['username'] . "</td>
                        <td>" . $row['email'] . "</td>
                        <td>" . $row['location'] . "</td>
                        <td>" . $row['phone'] . "</td>
                    <td>
                        <form action='editUser.php' method='post'>
                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                        <input type='hidden' name='name' value='" . $row['username'] . "'>
                        <input type='hidden' name='email' value='" . $row['email'] . "'>
                        <input type='hidden' name='location' value='" . $row['location'] . "'>
                        <input type='hidden' name='phone' value='" . $row['phone'] . "'>
                        <button type='submit' name='edit'>Edit</button>
                        </form>

                        <form action='delete.php' method='post'>
                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                        <button type='submit' name='delete'>Delete</button>
                        </form>
                    </td>
                    </tr>";
                }
            } else {
                // No data found in the database
                echo "<tr><td colspan='6'>No users found</td></tr>";
            }

            // Close the database connection
            mysqli_close($con);
            ?>
        </tbody>
    </table>
    <!-- End Table for Users -->
    </div>
</body>

</html>