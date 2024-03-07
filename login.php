<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "USER_DB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["submit"])) {
    $email = $_POST["EMAIL"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM USER_TBL WHERE EMAIL = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user["PASSWORD"])) {
            $_SESSION['loggedin'] = true;
			$_SESSION['EMAIL'] = $email;
			header("Location: contact.php");
			exit();
        } else {
            echo "<div class='alert alert-danger'>Password does not match</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Email does not match</div>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="CSS/forms.css">
    <link href="CSS/button.css" rel="stylesheet" />
</head>

<body id="bgimg">
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4" style="margin-top: 100px;">
                    <div class="login-wrap p-0">
                        <h3 class="mb-4 text-center">Have an account?</h3>
                        <form action="login.php" method="post" class="signin-form">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Email" name="EMAIL" required>
                            </div>
                            <div class="form-group">
                                <input id="password-field" type="password" class="form-control" placeholder="Password" name="password" required>
                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary submit px-3" value="Submit" name="submit">Sign In</button>
                            </div>
                        </form>
                        <label>Don't have an account?</label>
                        <button type="submit" class="button-38 btn-sm" onclick="location.href = 'register.php'">Sign Up</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>