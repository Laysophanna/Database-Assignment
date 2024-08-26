<?php
    session_start();

    // Connected to Database
    $conn = new mysqli(
        'localhost',
        'root',
        '',
        'form_login'
    );

    // Check if it connected
    if ($conn->connect_error){
        die("Connection failed : " . $conn->connect_error);
    }

    // Get User Data
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Insert to Database
    //prepare SQL statement
    $stmt = $conn->prepare("SELECT password FROM login WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();

    //get result
    $result = $stmt->get_result();

    //check user exist
    if($result->num_rows ===1){
        $user = $result->fetch_assoc();
        if($user['password'] === $password) {
            $_SESSION['username'] = $username;
            header('Location: welcome.php');
            exit();
        }else{
            echo "Invailid password or username";
        }
    }

$conn->close();
?>