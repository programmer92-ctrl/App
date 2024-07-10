<?php
    function show_cart($cat){
    include("connect.php");
    
    $sql = "SELECT * FROM products_table WHERE cat = '" . $cat . "'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()){
    echo "<script type='text/javascript'> if ( window.history.replaceState ) {window.history.replaceState( null, null, window.location.href ); } </script>";
    echo "<div id='cart-container'>";
    echo "<p id='cart-title'>" . $row['title'] . "</p>";
    echo "<p id='cart-price'>$" . $row['price'] . "</p>";
    echo "<p id='cart-desc'>" . $row['description'] . "</p>";
    echo "<img id='cart-photo' src = '" . $row['photo'] . "' height='675px' width='500px' />";
    echo "<p id='cart-name'>" . $row['name'] . "</p>";
    if(isset($_GET['user'])){
        echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . "?user=" . $_GET['user'] . "'>";
    }
    
    if(!isset($_GET['user'])){
        echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . "'>";
    }
    echo "<input type='hidden' name='title' value='" . $row['title'] . "' />";
    echo "<input type='hidden' name='price' value='" . $row['price'] . "' />";
    echo "<input type='hidden' name='desc' value='" . $row['description'] . "' />";
    echo "<input type='hidden' name='photo' value='" . $row['photo'] . "' />";
    echo "<input type='hidden' name='name' value='" . $row['name'] . "' />";
    echo "<input type='submit' id='cart-button' name='add' value='Add' />";
    echo "</form></div>";
    }
    
    if(isset($_POST['add'])){
            $sql = "INSERT INTO cart (user, name, price, title, description, photo) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdsss", $u, $n, $p, $t, $d, $ph);
            $u = $_GET['user'];
            $n = $_POST['name'];
            $p = $_POST['price'];
            $t = $_POST['title'];
            $d = $_POST['desc'];
            $ph = $_POST['photo'];
            $stmt->execute();
            $stmt->close();
            mysqli_close($conn);
    }
    }
    ?>
