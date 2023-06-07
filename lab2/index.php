<?php



function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  $firstname = 
  $lastname = 
  $email = 
  $gender = "";
  $errors = [];
  
  
  if (empty($_POST["firstname"])) {
    $errors[] = "First name is required";
  } else {
    $firstname = test_input($_POST["firstname"]);
    if (!preg_match("/^[a-zA-Z ]*$/",$firstname)) {
      $errors[] = "Only letters and white space allowed in first name";
    }
  }

  if (empty($_POST["lastname"])) {
    $errors[] = "Last name is required";
  } else {
    $lastname = test_input($_POST["lastname"]);
    if (!preg_match("/^[a-zA-Z ]*$/",$lastname)) {
      $errors[] = "Only letters and white space allowed in last name";
    }
  }

  if (empty($_POST["email"])) {
    $errors[] = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors[] = "Invalid email format";
    }
  }

  if (empty($_POST["gender"])) {
    $errors[] = "Gender is required";
  } else {
    $gender = test_input($_POST["gender"]);
  }

  if (empty($errors)) {
    $data = "\n\nFirst Name: $firstname\nLast Name: $lastname\nEmail: $email\nGender: $gender";
    file_put_contents("customer.txt", $data, FILE_APPEND);
    echo "<div class='container'>";
    echo "<p class='text-success'>Data saved successfully!</p>";
    echo "</div>";
    header('Location: list.php');
  }
}
?>


<div class="container">
  <h2>Registration Form</h2>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <div class="form-group">
      <label for="firstname">First name:</label>
      <input type="text" class="form-control" id="firstname" name="firstname">
    </div>
    <div class="form-group">
      <label for="lastname">Last name:</label>
      <input type="text" class="form-control" id="lastname" name="lastname">
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" name="email">
    </div>
    <div class="form-group">
      <label for="gender">Gender:</label><br>
      <div class="form-check-inline">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="gender" value="female">Female
        </label>
      </div>
      <div class="form-check-inline">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="gender" value="male">Male
        </label>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
  <?php 
     if(!empty($errors)) {
      foreach ($errors as $error) {
          echo '<span class="alert alert-danger mt-5">' . $error . '</span><br><br><br>';
      }
    }
  ?>
</div>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>