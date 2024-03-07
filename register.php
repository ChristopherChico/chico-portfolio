<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = mysqli_real_escape_string($conn, $_POST["FirstName"]);
    $lastName = mysqli_real_escape_string($conn, $_POST["MiddleName"]);
    $country = mysqli_real_escape_string($conn, $_POST["Country"]);
    $city = mysqli_real_escape_string($conn, $_POST["City"]);
    $province = mysqli_real_escape_string($conn, $_POST["Province"]);
    $barangay = mysqli_real_escape_string($conn, $_POST["Barangay"]);
    $phone = mysqli_real_escape_string($conn, $_POST["Phone"]);
    $email = mysqli_real_escape_string($conn, $_POST["Email"]);
    $password = mysqli_real_escape_string($conn, $_POST["Password"]);
    $repeatPassword = mysqli_real_escape_string($conn, $_POST["Rpassword"]);
    
    $stmt = $conn->prepare("SELECT * FROM user_tbl WHERE EMAIL = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $hashedPassword = $password;

    // Validate password match
    if ($password != $repeatPassword) {
		echo "<div class='alert alert-danger'>Password and Repeat Password do not match.</div>";
    } else if ($result->num_rows > 0) {
        echo "<div class='alert alert-danger'>Email is already registered.</div>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='alert alert-danger'>Invalid email address.</div>";
    } else {
        $stmt = $conn->prepare("INSERT INTO user_tbl (FIRST_NAME, LAST_NAME, COUNTRY, CITY, PROVINCE, BARANGAY, EMAIL, PASSWORD) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
         $stmt->bind_param("ssssssss", $firstName, $lastName, $country, $city, $province, $barangay, $email, $hashedPassword);

         if ($stmt->execute()) {
            $_SESSION['registration_success'] = true;
            header("Location: login.php");
            exit();
        } else {
            $_SESSION['registration_error'] = "Error: " . $stmt->error;
        }

    $stmt->close();
    
    }

	function validatePhoneNumber($phoneNumber)
	{
		require_once('libphonenumber/autoload.php');
		$phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
	
		try {
			$numberProto = $phoneUtil->parse($phoneNumber, null);
			return $phoneUtil->isValidNumber($numberProto);
		} catch (\libphonenumber\NumberParseException $e) {
			return false;
		}
	}
    
}

?>

<!doctype html>
<html lang="en">
  <head>
  	<title>Register</title>
	<link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css" />

	
	<link rel="stylesheet" href="CSS/forms.css">
	<link href="CSS/button.css" rel="stylesheet" />

<style>
	

	#countrySelect option {
    color: black !important;
	}

	.iti-container {
        background-color: rgba(255, 255, 255, 0); /* Set your desired background color */
		color: black;
    }
    
    .alert {
	color: black;
    border: 0ch;
    justify-content: center;
    align-items: center;
    position: fixed;
    bottom: 100px;
    left: 50%;
    transform: translateX(-50%);
	z-index: 20;
}



</style>

</head>

	<body class="img js-fullheight" style="background-image: linear-gradient(to right top, #265073, #317088, #4f9098, #79afa6, #a9cdb6, #b1d2b8, #b9d7bb, #c2dcbd, #a1cbaf, #7eb9a4, #59a79c, #2d9596);">
		
	<section >
		<div class="container">
			<div class="justify-content-center">
			</div>
			<div class="row justify-content-center">
				<div class="col-md-7 col-lg-7" style="margin-top: 150px;">
					<div class="login-wrap p-0">
		      	<h3 class="mb-4 text-center">Make an account</h3>
		      	<form class="signin-form" method="post">
                    
					<div class="row">
						<div class="col-md-6">
							<input type="text" class="form-control" name="FirstName" placeholder="First Name" required>
						</div>

						<div class="col-md-6" style="margin-bottom: 15px;">
							<input type="text" class="form-control" name="MiddleName" placeholder="Last Name" required>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6" style="margin-bottom: 15px;">
							<select class="form-control" id="countrySelect" name="Country" required>
                                <option value="" id="Country" disabled selected>Select Country</option>
                            </select>
						</div>

						<div class="col-md-6">
							<input type="text" class="form-control" name="City" placeholder="City" required>
						</div>

					</div>

					<div class="row">
						<div class="col-md-6" style="margin-bottom: 15px;">
							<input type="text" class="form-control" name="Province" placeholder="Province" required>
						</div>

						<div class="col-md-6" style="margin-bottom: 15px;">
							<input type="text" class="form-control" name="Barangay" placeholder="Barangay" required>
						</div>
	
					</div>

					<div class="row">
						<div class="col-md-5" style="margin-bottom: 15px;">
							<input type="tel" id="phone" name="Phone" class="form-control" placeholder="Phone Number">
						</div>

						<div class="col-md-7">
							<input type="text" class="form-control" name="Email" id="Email" placeholder="Email" required>
						</div>
					</div>		

	            <div class="form-group">
	              <input id="password-field" type="password" name="Password" class="form-control" placeholder="Password" required>
	              <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
	            </div>
				<div class="form-group">
					<input id="" type="password" class="form-control" name="Rpassword" placeholder="Repeat Password" required>
					<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
				  </div>
	            <div class="form-group">
	            	<button type="submit" class="form-control btn btn-primary submit px-3" value="Submit" name="submit">Sign Up</button>
	            </div>
	          </form>
	          <label>Already have an account?</label>
				<button type="submit" class="button-38 btn-sm"  onclick="location.href = 'login.php'">Sign In</button>
	          </div>
		      </div>
			</div>
		</div>
	</div>
</section>

 <script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('https://restcountries.com/v3.1/all')
            .then(response => response.json())
            .then(data => {
                const countrySelect = document.getElementById('countrySelect');

                const sortedCountries = data.sort((a, b) => {
                    const nameA = a.name.common.toUpperCase();
                    const nameB = b.name.common.toUpperCase();
                    return nameA.localeCompare(nameB);
                });

                sortedCountries.forEach(country => {
                    const option = document.createElement('option');
                    option.value = country.name.common;
                    option.text = country.name.common;
                    countrySelect.add(option);
                });
            })
            .catch(error => console.error('Error fetching countries:', error));
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
            const phoneInput = document.getElementById('phone');
            const iti = window.intlTelInput(phoneInput, {
                initialCountry: 'PH',
                utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js',
            });

            const itiContainer = phoneInput.closest('.iti');
            itiContainer.classList.add('iti-container');
        });
</script>

</body>
</html>

