<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin(SkillSprint)</title>
  <link rel="stylesheet" href="nav.css" />
  <link rel="stylesheet" href="applications.css" />
</head>

<body>
  <!-- Navigation Bar -->
  <nav>
    <div class="logo-container">
      <img src="../images/logo/house-cleaning.png" alt="SkillSprint Logo" class="logo" style="z-index: 1" />
    </div>
    <a href="applications.php">Applications</a>
    <a href="users.php">Users</a>
    <a href="workers.php">Workers</a>
    <a href="signout.php">Sign Out</a>
  </nav>
  <!-- End Navigation Bar -->

  <!-- Table for Applications -->
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Skill</th>
        <th>Photo</th>
        <th>Certificate</th>
      </tr>
    </thead>
    <tbody>
      <?php
      include "../connect.php";
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
          echo "<td>" . $row['photo'] . "</td>";
          echo "<td>" . $row['certificate'] . "</td>";

          echo "<td>
          <form action='approve.php' method='post'>
          <input type='hidden' name='id' value='" .$row['id'] . "'>
          <input type='hidden' name='name' value='" .$row['name'] . "'>
          <input type='hidden' name='phone' value='" .$row['phone'] . "'>
          <input type='hidden' name='email' value='" .$row['email'] . "'>
          <input type='hidden' name='skill' value='" .$row['skill'] . "'>
          <input type='hidden' name='photo' value='" .$row['photo'] . "'>
          <input type='hidden' name='certificate' value='" .$row['certificate'] . "'>
          <button type='submit' name='approve'>Approve</button>
          </form></td>";

          echo "<td>
            <form action='decline.php' method='post'>
            <input type='hidden' name='id' value='" .$row['id'] . "'>
            <button type='submit' name='decline'>Decline</button>
            </form></td>";
        }
  
      } else {
        // No data found in the database
        echo "<tr><td colspan='7'>No applications found</td></tr>";
      }

      // Close the database connection
      mysqli_close($con);
      ?>
    </tbody>
  </table>
  <!-- End Table for Applications -->
</body>

</html>