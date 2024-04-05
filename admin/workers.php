<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin(SkillSprint) - Workers</title>
    <link rel="stylesheet" href="nav.css" />
    <link rel="stylesheet" href="applications.css" />
</head>

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
  <!-- End Navigation Bar -->
  <div class="main">
    <h3>Workers</h3>
    <!-- Table for Workers -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Skill</th>
                <th>Service Area</th>
                <th>Photo</th>
                <th>Certificate</th>
                <th>Password</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "../connect.php"; // Include your database connection file

            $query = "SELECT * FROM workers"; // Query to fetch workers from the database
            $result = mysqli_query($con, $query);
            
            if (mysqli_num_rows($result) > 0) {
                // Loop through each row of data
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['phone']}</td>
                        <td>{$row['skill']}</td>
                        <td>{$row['service_area']}</td>";
                    
                    // Display the photo
                    $photoPath = "../images/workers/photo/{$row['photo']}";
                    echo "<td class='p'><a href='$photoPath' target='_blank'><img src='{$photoPath}' alt='{$row['name']}' style='height: 80px;'></a></td>";
                    
                    // Display the certificate
                    $certificatePath = "../images/workers/certificates/{$row['certificate']}";
                    $certificateExtension = pathinfo($certificatePath, PATHINFO_EXTENSION);
                    if (in_array($certificateExtension, ['jpg', 'jpeg', 'png'])) {
                        echo "<td><a href='$certificatePath' target='_blank'><img src='{$certificatePath}' alt='{$row['name']}' style='height: 80px; '></a></td>";
                      } elseif ($certificateExtension === 'pdf') {
                        echo "<td class='c'><embed src='{$certificatePath}'  height='80' ><a href='{$certificatePath}' target='_blank'>view</a></td>";
                      } else {
                        echo "<td>Unsupported file format</td>";
                      }
                                
                    echo "<td id='pw'>{$row['password']}</td>
                        <td>
                            <form action='editWorkers.php' method='post'>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <input type='hidden' name='name' value='{$row['name']}'>
                                <input type='hidden' name='email' value='{$row['email']}'>
                                <input type='hidden' name='phone' value='{$row['phone']}'>
                                <input type='hidden' name='skill' value='{$row['skill']}'>
                                <input type='hidden' name='service_area' value='{$row['service_area']}'>
                                <input type='hidden' name='photo' value='{$row['photo']}'>
                                <input type='hidden' name='certificate' value='{$row['certificate']}'>
                                <input type='hidden' name='password' value='{$row['password']}'>
                                <button type='submit' name='edit'>Edit</button>
                            </form>
                        <br>
                            <form action='deleteWorker.php' method='post'>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <button type='submit' name='delete'>Delete</button>
                            </form>
                        </td>
                    </tr>";
                }
            } else {
                // No data found in the database
                echo "<tr><td colspan='8'>No Workers found</td></tr>";
            }

            // Close the database connection
            mysqli_close($con);
            ?>
        </tbody>
    </table>
    <!-- End Table for Workers -->
    </div>
</body>

</html>
