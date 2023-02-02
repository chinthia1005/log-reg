<!DOCTYPE HTML>
<html>
    <head>
        <title>Halaman Registrasi</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
      </head>
    <body>
    
       <div class="container">
       <h3>Register</h3>
       <?php
      if (isset($_POST["submit"])){
          $fullname = $_POST["fullname"];
          $username = $_POST["username"];
          $email = $_POST["email"];
          $no_handphone = $_POST["no_handphone"];
          $password = $_POST["password"];
          $confirm_password = $_POST["confirm_password"];

          $passwordHash = password_hash($password, PASSWORD_DEFAULT);

          $errors= array();

          if(empty($fullname) OR empty ($username) OR empty ($email) OR empty ($no_handphone) OR empty ($password) OR empty ($confirm_password)){
          array_push($errors,"Semua kolom harus diisi");
          }
          if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
              array_push($errors,"Email tidak valid");
          }
          if (strlen($no_handphone)<11){
              array_push($errors,"No Handphone harus lebih dari 11 angka");
          }
          if (strlen($password)<8){
              array_push($errors,"Password harus lebih dari 8 karakter");
          }
          if ($password!==$confirm_password){
              array_push($errors,"Password tidak cocok");
          }

          require_once "database.php";
          $sql = "SELECT * FROM users WHERE email = '$email'";
          $result = mysqli_query($conn, $sql);
          $rowCount = mysqli_num_rows($result);
          if ($rowCount>0) {
              array_push($errors, "Email sudah digunakan");
          }

          if (count($errors)>0){
            foreach ($errors as $error){
                echo "<div class='alert alert-danger'>$error</div>";
            }
          }else{
             
              $sql = "INSERT INTO users (fullname, username, email, no_handphone, password) VALUES ( ?, ?, ?, ?, ? )";
              $stmt = mysqli_stmt_init($conn);
              $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
              if ($prepareStmt){
                mysqli_stmt_bind_param($stmt, "sssss", $fullname, $username, $email, $no_handphone, $passwordHash);
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>Anda Berhasil Register</div>";
        }else{
              die("Ada yang tidak beres");
           }
          }
      }
       ?>
        <form action="register.php" method="post">
       
        <div class="form-group">
         <label>Fullname</label>
        <input type="text" class="form-control" name="fullname"  placeholder="Enter your Fullname">
        </div>
        <div class="form-group">
        <label>Username</label>
        <input type="text" class="form-control" name="username"  placeholder="Enter your Username">
           </div>
           <div class="form-group">
           <label>Email</label>
        <input type="email" class="form-control" name="email"  placeholder="Enter Your Email">
           </div>
           <div class="form-group">
           <label>No Handphone</label>
        <input type="number" class="form-control" name="no_handphone" placeholder="Enter Your Handphone Number">
           </div>
           <div class="form-group">
           <label>Password</label>
        <input type="password" class="form-control" name="password"  placeholder="Enter Your Password">
           </div>
           <div class="form-group">
           <label>Confirm Password</label>
        <input type="password" class="form-control" name="confirm_password"  placeholder="Confirm Password">
           </div>
           <button type="submit" name="submit" class="btn btn-outline-primary">Register</button>
        </form>
      </div>
    </body>
</html>