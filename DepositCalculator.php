
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


include('Functions.php');
include("./common/header.php");
$interest = 0.03;
$submitted = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['calculate'])) {

        $principal = $_POST['principal'];
        $principalError = ValidatePrincipal($principal);
        $_SESSION['principal'] = $principal;

        $years = $_POST['years'];
        $yearsError = ValidateYears($years);
        $_SESSION['years'] = $years;

        if (!$yearsError && !$principalError) {
            $submitted = true;
            $_SESSION['submitted'] = $submitted;
        }
    } else if (isset($_POST['previous'])) {
        if (isset($_SESSION['phoneMethod'])) {
            header("Location: ContactTime.php");
            exit();
        } else if (isset($_SESSION['emailMethod'])) {
            header("Location: CustomerInfo.php");
            exit();
        }
    } else if (isset(($_POST['complete']))) {
        if (isset($_SESSION['submitted'])) {
            header("Location: Complete.php");
            exit();
        } else {
            $enterError = 'Please accomplish the calculation first.';
        }
    }
}
?>


<form class="container mt-1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="row align-content-center justify-content-center mb-3">
        <div class="col-12 text-end ">
            <div class="display-6 fw-bolder text-center">
                Enter principal and select number of years to deposit
            </div> 
        </div> 

    </div>

    <!--principal-->
    <div class="row align-content-center justify-content-center">
        <div class="col-4 text-end ">
            <label for="principal" class="text-xl fw-bold">Principal Amount:</label>
        </div>

        <div class="col-4 text-start">
            <input type="text" name="principal" class="form-control col-4" 
            <?php
            if (isset($_SESSION['principal'])) {
                echo 'value="' . $_SESSION['principal'] . '"';
            }
            ?>>
        </div>

        <div class="col-4 text-danger fw-bolder error">
            <?php
            global $errorArray;
            global $principalError;
            if ($principalError) {
                echo $principalError;
            }
            ?>
        </div>
    </div>

    <!--Years-->
    <div class="row align-content-center justify-content-center mt-4">
        <div class="col-4 text-end">
            <label for="yearsToDeposit" class="text-xl fw-bold">Years to deposits:</label>
        </div>

        <div class="col-4">
            <select class="col-4 text-start form-control" name="years" id="yearsToDeposit">
                <?php
                if (isset($_SESSION['years'])) {
                    $selectedValue = $_SESSION['years'];
                } else {
                    $selectedValue = -1;
                }

                echo '<option value="-1" ' . ($_SESSION['years'] == -1 ? 'selected' : '') . ' >Select one ...</option>';


                for ($i = 1; $i <= 25; $i++) {
                    echo '<option  value="' . $i . '" ' . ($_SESSION['years'] == $i ? 'selected' : '') . '>' . $i . '</option>';
                }
                ?> 
            </select>
        </div>

        <div class="col-4 text-danger fw-bolder error">
            <?php
            global $yearsError;
            if ($yearsError) {
                echo $yearsError;
            }
            ?>
        </div>


        <div class="alert alert-danger col-4 text-danger fw-bolder mt-3" 
             style = "display: <?php
             global $enterError;
             echo $enterError? "block" : "none";
             ?>"
             >
                 <?php
                 global $enterError;
                 if ($enterError) {
                     echo $enterError;
                 }
                 ?>
        </div>
    </div>

    <div class="mt-3"> <!-- Center the content in the parent container -->
        <hr class="centered-hr">
    </div>

    <!--Calculate buttons-->
    <div class="row mt-3">
        <div class="col-12 justify-content-center text-center">
            <input type='submit' name='previous' class="btn btn-primary btn-rounded m-3" value='<Previous' >
            <input type='submit' name='calculate' class="btn btn-primary btn-rounded m-3" value='Calculate' >
            <input type='submit' name='complete' class="btn btn-primary btn-rounded m-3" value="Complete>" >
        </div>
    </div>
</form>


<!--render calculation-->
<div class="container" style="display: <?php
     global $submitted;
     echo $submitted ? "block" : "none";
     ?>">  
    <!--render table-->
    <div class="row">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Year</th>
                    <th scope="col">Principal at Year Start</th>
                    <th scope="col">Interest for the year</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <?php
                    global $interest;
                    $tableBodyList = accumulatedPrincipalAndInterest($_SESSION['principal'], $interest, $_SESSION['years']);
                    foreach ($tableBodyList as $tableRow) {
                        echo '<tr>';
                        echo '<th scope="row">' . $tableRow['year'] . '</th>';
                        echo '<td>' . $tableRow['accumulatedPrincipal'] . '</td>';
                        echo '<td>' . $tableRow['accumulatedInterest'] . '</td>';
                        echo '</tr>';
                    }
                    ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('./common/footer.php'); ?>

