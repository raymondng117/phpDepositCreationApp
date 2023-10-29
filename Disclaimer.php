<?php
session_start();
$errorMsg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['start'])) {
        if (!isset($_POST['agree'])) {
            $errorMsg = "You must agree to the terms and conditions!";
        } else {
            $_SESSION['agree'] = $_POST['agree'];
            header("Location: CustomerInfo.php");
            exit();
        }
    }
}
?>

<?php include("./common/header.php"); ?>
<div class="container">
    <div class="row justify-content-center mt-2 mb-3">
        <div class="col">
            <div class="display-6 fw-bolder text-center">
                Terms and Conditions
            </div>
        </div>
    </div>

    <div class="row justify-content-center p-1 border border-secondary border-4 mb-1 rounded">
        <div class="col">
            <div class="fs-5">
                I agree that the bank before opening any deposit account, will carry out a due diligence as required under Know Your Customer guidelines of the bank. I would be required to submit necessary documents or proofs, such as identity, address, photograph and any such information, I agree to submit the above documents again at periodic intervals, as may be required by the Bank.
            </div>
        </div>
    </div>

    <div class="row justify-content-center p-1 border border-secondary border-4 mb-1 rounded">
        <div class="col">
            <div class="fs-5">
                I agree to abide by the Bank's Terms and Conditions and rules in force and the changes thereto in Terms and Conditions from time to time relating to my account as communicated and made available on the Bank's website
            </div>
        </div>
    </div>

    <div class="row justify-content-center p-1 border border-secondary border-4 mb-1 rounded">
        <div class="col">
            <div class="fs-5">
                I agree that the Bank can at its sole discretion, amend any of the services/facilities given in my account either wholly or partially at any time by giving me at least 30 days notice and/or provide an option to me to switch to other services/facilities.
            </div>
        </div>
    </div>

    <form action="Disclaimer.php" method="POST" class="mt-3 mb-5">
        <div class="row">
            <div class="col">
                <div class="text-start text-danger fw-bold fs-5">
                <?php echo $errorMsg ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col form-check">
                <input type="checkbox" name="agree[]" value="agree" class="form-check-input">
                <label class="form-check-label" for="agree">I have read and agree with the terms and conditions</label>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <button class="btn btn-primary rounded" type="submit" name="start" value="start">Start</button>
            </div>
        </div>
    </form>
</div>

<div class="mb-3"></div>
<?php include('./common/footer.php'); ?>