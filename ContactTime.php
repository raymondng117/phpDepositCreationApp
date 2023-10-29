<?php
session_start();

if (!isset($_SESSION['agree'])) {
    header("Location: CustomerInfo.php");
    exit();
} else {
    if (!isset($_SESSION['filledForCustomerInfo'])) {
        header("Location: CustomerInfo.php");
        exit();
    }
}

$predefinedTimeslots = [
    "9:00 am - 10:00 am",
    "10:00 am - 11:00 am",
    "11:00 am - 12:00 pm",
    "12:00 pm - 1:00 pm",
    "1:00 pm - 2:00 pm",
    "2:00 pm - 3:00 pm",
    "3:00 pm - 4:00 pm",
    "4:00 pm - 5:00 pm",
    "5:00 pm - 6:00 pm"
];

$display = "none";
$errorMsg = "";

if (isset($_POST['next'])) {
    if (!isset($_POST['timeslots'])) {
        $errorMsg = "You must select contact time for us to contact you!";
        $display = "block";
        $_SESSION['selected_timeslots'] = [];
    } else {
        $_SESSION['selected_timeslots'] = $_POST['timeslots'];
        header("Location: DepositCalculator.php");
        exit();
    }
} else if (isset($_POST['back'])) {
    header("Location: CustomerInfo.php");
    exit();
}

include("./common/header.php");
?>

<form form class="container mt-1" method="post" action="./ContactTime.php">

    <div class="row">
        <div class="display-6 fw-bold my-2">Select Contact Times</div>
        <div class="fw-bold my-2">When can we contact you? Check all applicable:</div>
        <div class="alert alert-danger text-danger fw-bold my-2" style="display: <?php echo $display; ?>">
            <?php echo $errorMsg; ?>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-4">
            <?php
            foreach ($predefinedTimeslots as $timeslot) {
                $isChecked = isset($_SESSION['selected_timeslots']) && in_array($timeslot, $_SESSION['selected_timeslots']) ? 'checked' : '';
                echo "<input type='checkbox' name='timeslots[]' value='$timeslot' class='my-2' $isChecked/>";
                echo "<label class='mx-2'>$timeslot</label><br>";
            }
            ?>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-4">
            <input type='submit' name='back' class="btn btn-primary btn-rounded m-2" value='<Back'>
            <input type='submit' name='next' class="btn btn-primary btn-rounded m-2" value='Next>'>
        </div>
    </div>
</form>

<?php
include('./common/footer.php');
?>
