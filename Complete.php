<?php
session_start();
if (!isset($_SESSION['agree'])) {
    header("Location: CustomerInfo.php");
    exit();
} else {
    if (!isset($_SESSION['filledForCustomerInfo'])) {
        header("Location: CustomerInfo.php");
        exit();
    } else {
        if ($_SESSION['submitted'] != true) {
            header("Location: DepositCalculator.php");
            exit();
        }
    }
}

include('Functions.php');
include("./common/header.php");

if (isset($_SESSION['name'])) {
    $name = $_SESSION['name'];
}

if (isset($_SESSION['phoneNum'])) {
    $phoneNum = $_SESSION['phoneNum'];
}

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
}

if (isset($_SESSION['selected_timeslots'])) {
    $timeslotsArray = $_SESSION['selected_timeslots'];
}

if (isset($_SESSION['phoneMethod'])) {
    $method = $_SESSION['phoneMethod'];
} else if (isset($_SESSION['emailMethod'])) {
    $method = $_SESSION['emailMethod'];
}
?>

<!-- render opening -->
<div class="row m-2">
    <div class="display-6 fw-bold text-primary">
        Thank you <?php echo!empty($name) ? ", $name, " : ""; ?> for using our deposit calculator!
    </div>
</div>
<div class="row m-3">
    <div class="fs-4">
        <?php
        if (isset($method)) {
            echo $opening = ($method && $method === 'email') ?
            renderOpening($method) :
            renderOpening($method);
        }
        session_unset();
        ?>
    </div>
</div>
<?php
include('./common/footer.php');
