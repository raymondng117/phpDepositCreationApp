<?php
// set up session
session_start();
// check if there is an existing start. If no, start a new session. If yes, retrieve the existing session
if (!isset($_SESSION['agree'])) {
    header("Location: Disclaimer.php");
    exit();
}
include('Functions.php');

if (isset($_POST['next'])) {
    $name = $_POST['name'];
    $nameError = ValidateName($name);
    $_SESSION['name'] = $name;

    $postalCode = $_POST['postalCode'];
    $postalError = ValidatePostalCode($postalCode);
    $_SESSION['postalCode'] = $postalCode;

    $phoneNum = $_POST['phoneNum'];
    $phoneNumError = ValidatePhone($phoneNum);
    $_SESSION['phoneNum'] = $phoneNum;

    $email = $_POST['email'];
    $emailError = ValidateEmail($email);
    $_SESSION['email'] = $email;

    if (isset($_POST['contactMethod'])) {
        $method = $_POST['contactMethod'];
        
        if ($method == 'phone') {
            $_SESSION['phoneMethod'] = 'phone';
            if (isset($_SESSION['emailMethod'])) {
                unset($_SESSION['emailMethod']);
            }
        } else if ($method == 'email') {
            $_SESSION['emailMethod'] = 'email';
            if (isset($_SESSION['phoneMethod'])) {
                unset($_SESSION['phoneMethod']);
            }
        }
    } else {
        $contactError = "You must select a contact method";
    }

    if (!$nameError && !$postalError && !$phoneNumError && !$contactError && !$emailError && $method == 'phone') {
        header("Location: ContactTime.php");
        $_SESSION['filledForCustomerInfo'] = 'filledForCustomerInfo';
        echo $_SESSION['filledForCustomerInfo'];
        exit();
    } else if (!$nameError && !$postalError && !$phoneNumError && !$contactError && !$emailError && $method == 'email') {
        header("Location: DepositCalculator.php");
        $_SESSION['filledForCustomerInfo'] = 'filledForCustomerInfo';
        exit();
    }
}
?>

<?php include("./common/header.php");
?>

<form class="container mt-1" id="customerInfo" method="post" action="./CustomerInfo.php">
    <!--name-->
    <div class="row align-content-center justify-content-center mt-4">
        <div class="col-4 text-end ">
            <label for="name" class="text-xl fw-bold">Name:</label>
        </div>

        <div class="col-4 text-start">
            <input type="text" name="name" class="form-control col-4"                     
            <?php
            if (isset($_SESSION['name'])) {
                echo 'value="' . $_SESSION['name'] . '"';
            }
            ?>>
        </div>

        <div class="col-4 text-danger fw-bolder error">
            <?php
            global $nameError;
            if ($nameError) {
                echo $nameError;
            }
            ?>

        </div>
    </div>

    <!--postal-->
    <div class="row align-content-center justify-content-center mt-4">
        <div class="col-4 text-end ">
            <label for="postalCode" class="text-xl fw-bold">Postal Code:</label>
        </div>

        <div class="col-4 text-start">
            <input type="text" name="postalCode" class="form-control col-4" 
            <?php
            if (isset($_SESSION['postalCode'])) {
                echo 'value="' . $_SESSION['postalCode'] . '"';
            }
            ?>
                   >
        </div>

        <div class="col-4 text-danger fw-bolder error">
            <?php
            global $postalError;
            if ($postalError) {
                echo $postalError;
            }
            ?>
        </div>
    </div>

    <!--Phone number-->
    <div class="row align-content-center justify-content-center mt-4">
        <div class="col-4 text-end ">
            <label for="phoneNum" class="text-xl fw-bold">Phone Number:</label>
        </div>

        <div class="col-4 text-start">
            <input type="text" name="phoneNum" class="form-control col-4" 
            <?php
            if (isset($_SESSION['phoneNum'])) {
                echo 'value="' . $_SESSION['phoneNum'] . '"';
            }
            ?>       
                   >
        </div>

        <div class="col-4 text-danger fw-bolder error">
            <?php
            global $phoneNumError;
            if ($phoneNumError) {
                echo $phoneNumError;
            }
            ?>
        </div>
    </div>

    <!--email-->
    <div class="row align-content-center justify-content-center mt-4">
        <div class="col-4 text-end ">
            <label for="email" class="text-xl fw-bold">Email:</label>
        </div>

        <div class="col-4 text-start">
            <input type="text" name="email" class="form-control col-4" 
            <?php
            if (isset($_SESSION['email'])) {
                echo 'value="' . $_SESSION['email'] . '"';
            }
            ?>         
                   >
        </div>

        <div class="col-4 text-danger fw-bolder error">
            <?php
            global $emailError;
            if ($emailError) {
                echo $emailError;
            }
            ?>
        </div>
    </div>

    <div class="mt-3"> 
        <hr class="centered-hr">
    </div>

    <!--Preferred contact method:-->
    <div class="row align-content-center justify-content-around mt-4">
        <div class="col-4 text-end ms-5">
            <p class="text-xl fw-bold">Preferred contact method:</p>
        </div>

        <div class="form-check col-1">
            <input class="form-check-input" type="radio" id="phoneMethod" name="contactMethod" value="phone" onchange="checkSelectedMethod()" 
                   <?php if (isset($_SESSION['phoneMethod'])) echo 'checked'; ?>>
            <label class="form-check-label" for="contactMethod">
                Phone
            </label>
        </div>

        <div class="form-check col-1">
            <input class="form-check-input" type="radio" name="contactMethod" value="email" onchange="checkSelectedMethod()" 
                   <?php if (isset($_SESSION['emailMethod'])) echo 'checked'; ?>>
            <label class="form-check-label" for="contactMethod">
                Email
            </label>
        </div>

        <div class="col-4 text-danger fw-bolder error">
            <?php
            global $contactError;
            if ($contactError) {
                echo $contactError;
            }
            ?>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-4"></div>
        <div class="col-4">
            <input type='submit' name='next' class="btn btn-primary btn-rounded m-2" value='Next>' >
        </div>
    </div>
</form>
<?php include('./common/footer.php'); ?>
