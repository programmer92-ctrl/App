<?php
    include("connect.php");
    include("errors.php");
    if(isset($_POST["login_submit"])){
        $user = mysqli_real_escape_string($conn, htmlspecialchars($_POST['username']));
        $password = mysqli_real_escape_string($conn, htmlspecialchars($_POST['password']));
        
        if(!isset($user) && empty($user)){
            array_push($errors, "user field empty");
        }
        
        if(!isset($password) && empty($password)){
            array_push($errors, "empty password");
        }
        
        if(!isset($user) && empty($user) && !isset($password) && empty($password)){
            array_push($errors, "empty user or password fields");
        }
        
        if(isset($user) && !empty($user) && isset($password) && !empty($password)){
               $stmt = $conn->prepare("SELECT password FROM users WHERE user = " . "'" . $user . "'");
               $stmt->execute();
               $result = $stmt->get_result();
               $row = $result->fetch_assoc();
               if (hash_equals(hash("sha256", $password), $row['password'])) {
                   header("Location: ../index.php?user=" . $user);
                
                } else {
                   header("Location: ../login.php");
    }
    }
        
    } ?>
