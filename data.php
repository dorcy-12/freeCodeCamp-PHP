<?php
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input values
    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $age = $_POST['Age'];
    $occupation =  $_POST['role'];
    $recommendation = $_POST['rcm'];
    $features = $_POST['features'];
    $improvements = filter_input(INPUT_POST, 'improvements', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
    $allimprovs = implode("; ",$improvements);
    $comments = $_POST['comment'];

    // Validate input values
    $errors = array();
    
    if (empty($name)) {
        $errors[] = "Please enter a valid name.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }
    if ($age< 0 || $age > 100) {
        $errors[] = "Please enter a valid IQ score between 0 and 200.";
    }
    if (empty($features)) {
        $errors[] = "Please select a feature.";
    }
    if (empty($occupation)) {
        $errors[] = "Please select an occupation.";
    }
    if (empty($recommendation)) {
        $errors[] = "Please select a recommendation.";
    }
    if (empty($comments)) {
        $errors[] = "Please enter an essay.";
    }

    if (!empty($errors)) {
        echo "<h3>Errors in database:</h3><ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    } else {
        //Database connection
        $conn =  mysqli_connect("localhost","root","root","PHP_FORMS");

        if($conn -> connect_error){
            die('Connection Failed : '.$conn->connect_error);
            echo "<h2>Error in connecting</h2>";
        } else {
            //Database connection
            $conn =  mysqli_connect("localhost","root","root","PHP_FORMS");
            if($conn -> connect_error){
                die('Connection Failed : '.$conn->connect_error);
                echo "<h2>Error in second connection</h2>";
            } else {
                move_uploaded_file($file_loc, $file_dir.$file); // Upload the file to the server
                $sql = "INSERT INTO freecodecamp (name,email, age, occupation, recommend, fav_feature, improvement, comments) VALUES ('$name', '$email', '$age', '$occupation', '$recommendation', '$features', '$allimprovs', '$comments')";
                if (mysqli_query($conn, $sql)) {
                    echo "<h2>Thank you for submitting your form!</h2>";
                } else {
                    echo $sql;
                    echo "<h2>Last step Error:</h2><p>" . mysqli_error($conn) . "</p>";
                }
                mysqli_close($conn);
            }
        }
    }
}
?>
