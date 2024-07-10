<?php
    include("errors.php");
    include("connect.php");
    
    if(isset($_POST['signup_submit'])){
        
        $user = mysqli_real_escape_string($conn, htmlspecialchars($_POST['username']));
        $password = mysqli_real_escape_string($conn, htmlspecialchars($_POST['password']));
        $hash = hash("sha256", $password);
        $email = mysqli_real_escape_string($conn, htmlspecialchars($_POST['email']));
        
        if(!isset($user) && empty($user)){
            array_push($errors, "username field required");
        }
        
        if(!isset($hash) && empty($hash)){
            array_push($errors, "password field required");
        }
        
        if(!isset($email) && empty($email)){
            array_push($errors, "email field required");
        }
        
        if(!isset($user) && empty($user) && !isset($hash) && empty($hash)){
            array_push($errors, "username and password field required");
        }
        
        if(!isset($user) && empty($user) && !isset($email) && empty($email)){
            array_push($errors, "username and email field required");
        }
        
        if(!isset($hash) && empty($hash) && !isset($email) && empty($email)){
            array_push($errors, "password and email field required");
        }
        
        $email_pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        
        if(isset($user) && !empty($user) && isset($hash) && !empty($hash) && isset($email) && !empty($email) && preg_match($email_pattern, $email) && filter_var($email, FILTER_VALIDATE_EMAIL)){
            //$sql = "INSERT INTO users (user, password, email) VALUES( " . "'" . $user . "'" . " , " . "'" . $encrypted_data . "'" . " , " . "'" . $email . "'" . " ) ";
            $stmt = $conn->prepare("INSERT INTO users (user, password, email) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $u, $p, $e);
            $u = $user;
            $p = $hash;
            $e = $email;
            $stmt->execute();
            $stmt->close();
            header("Location: ../index.php?user=" . $user);
            mysqli_close($conn);
        } else {
            echo "email invalid";
        }
    } ?>
