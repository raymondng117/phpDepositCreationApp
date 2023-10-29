<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

function ValidatePrincipal($amount) {
    // Check if the input is set and not empty
    if (isset($amount) && !empty($amount)) {
        // Trim and sanitize the input
        $principal = floatval(trim($amount));

        // Check if the amount is a valid numeric value and greater than zero
        if ($principal <= 0 || !is_numeric($principal)) {
            // Add an error message to the global error array
            return "Principal amount must be a numeric value greater than zero.";
        }
    } else {
        // Add an error message to the global error array if input is not set or empty
        return "Principal amount is required.";
    }
}

function ValidateYears($years) {
    if (!isset($years) || $years == -1) {
        return "You must select years to deposit";
    }
}

function ValidateName($name) {
    if (!isset($name) || empty(trim($name))) {
        return "Name cannot be blank";
    }
}

function ValidatePostalCode($postalCode) {
    if (!isset($postalCode) || empty(trim($postalCode))) {
        return "Postal code cannot be blank";
    } else {
        $postalCode = strtoupper(str_replace(' ', '', $postalCode));
        $pattern = '/^[A-Z]\d[A-Z]\d[A-Z]\d$/';
        if (preg_match($pattern, $postalCode)) {
            return "";
        } else {
            return "Incorrect Postal Code";
        }
    }
}

function ValidatePhone($phone) {
    $pattern = '/^[2-9]\d{2}-[2-9]\d{2}-\d{4}$/';

    if (!isset($phone) || empty(trim($phone))) {
        return "Phone number cannot be blank";
    } elseif (!preg_match($pattern, $phone)) {
        return "Incorrect phone number";
    }
}

function ValidateEmail($email) {
    if (!isset($email) || empty(trim($email))) {
        return "Email cannot be blank";
    } else {
        $pattern = '/^[a-zA-Z0-9.]+@[a-zA-Z0-9.]+\.[a-zA-Z]{2,4}$/';

        if (!preg_match($pattern, $email)) {
            return "Incorrect email";
        }
    }
}

// render opening
function renderOpening($method) {
    global $phoneNum;
    global $email;
    global $timeslotsArray;
    $combinedArray = [];

    switch ($method) {
        case "phone":
            foreach ($timeslotsArray as $timeslot) {
                array_push($combinedArray, $timeslot);
            }
            $formattedArray = implode(", ", $combinedArray);
            return "Our customer service department will call you tomorrow {$formattedArray} at $phoneNum.";

        case "email":
            return "An email about the details of our GIC has been sent to $email.";
    }
}

// create array of table content
function accumulatedPrincipalAndInterest($principal, $interest, $years) {
    $tableRows = []; // Initialize an empty array for table rows
    intval($years);

    for ($i = 1; $i <= $years; $i++) { // Changed the loop condition to include the final year
        if ($i == 1) {
            $accumulatedPrincipal = floatval($principal);
            $accumulatedInterest = floatval($principal) * $interest;
        } else {
            $accumulatedPrincipal = $accumulatedPrincipal + $accumulatedInterest;
            $accumulatedInterest = $accumulatedPrincipal * $interest; // Removed an extra dollar sign ($)
        }

        $item = [
            'year' => $i,
            'accumulatedPrincipal' => sprintf("$%.2f", $accumulatedPrincipal),
            'accumulatedInterest' => sprintf("$%.2f", $accumulatedInterest)
        ];
        array_push($tableRows, $item);
    }

    return $tableRows;
}
