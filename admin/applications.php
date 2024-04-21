<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin(SkillSprint) - Applications</title>
  <link rel="icon" href="../images/logo/house-cleaning.png" type="image/icon type">
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

  <!-- Table for Applications -->
  <div class="main">
  <h3>Applications</h3>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Skill</th>
        <th>Service Area</th>
        <th>Photo</th>
        <th>Certificate</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      include "../connect.php";
      $currentDateTime = date("Y-m-d H:i:s");
      // ----------------------- expired booking deletion ---------------------
      $sql = "DELETE FROM bookings WHERE dateTime < '$currentDateTime'";
      mysqli_query($con, $sql);
      // ----------------------- expired booking deletion ---------------------

      $query = "SELECT * FROM applications";
      $result = mysqli_query($con, $query);

      if (mysqli_num_rows($result) > 0) {
        // Loop through each row of data
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td>" . $row['id'] . "</td>";
          echo "<td>" . $row['name'] . "</td>";
          echo "<td>" . $row['phone'] . "</td>";
          echo "<td>" . $row['email'] . "</td>";
          echo "<td>" . $row['skill'] . "</td>";
          echo "<td>" . $row['service_area'] . "</td>";
          $photoPath = "../images/wphoto/{$row['photo']}";
          echo "<td class='p'><a href='$photoPath' target='_blank'><img src='{$photoPath}' alt='{$row['name']}' style='height: 80px;'></a></td>";
          // Display the certificate
          $certificatePath = "../images/wcerti/{$row['certificate']}";
          $certificateExtension = pathinfo($certificatePath, PATHINFO_EXTENSION);
          if (in_array($certificateExtension, ['jpg', 'jpeg', 'png'])) {
            echo "<td><a href='$certificatePath' target='_blank'><img src='{$certificatePath}' alt='{$row['name']}' style='height: 80px; '></a></td>";
          } elseif ($certificateExtension === 'pdf') {
            echo "<td class='c'><embed src='{$certificatePath}'  height='80' ><a href='{$certificatePath}' target='_blank'>view</a></td>";
          } else {
            echo "<td>Unsupported file format</td>";
          }

          // Display action buttons
          echo "<td>
            <form action='approve.php' method='post'>
              <input type='hidden' name='id' value='{$row['id']}'>
              <button type='submit' name='approve'>Approve</button>
            </form>
            <br>
            <form action='decline.php' method='post'>
              <input type='hidden' name='id' value='{$row['id']}'>
              <button type='submit' name='decline'>Decline</button>
            </form>
          </td>";

          echo "</tr>";
        }
      } else {
        // No data found in the database
        echo "<tr><td colspan='9'>No applications found</td></tr>";
      }

      // Close the database connection
      mysqli_close($con);
      ?>
    </tbody>
  </table>
  <!-- End Table for Applications -->
  </div>

</body>

</html>