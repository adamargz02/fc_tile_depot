<?php
$errors = array();

/* Escape special characters */
function real_escape($str) {
    global $con;
    return mysqli_real_escape_string($con, $str);
}

/* Remove HTML characters */
function remove_junk($str) {
    $str = nl2br($str);
    return htmlspecialchars(strip_tags($str), ENT_QUOTES);
}

/* Uppercase the first character */
function first_character($str) {
    if (!is_string($str)) {
        return ''; // Return an empty string if not a string
    }
    $val = str_replace('-', " ", $str);
    return ucfirst($val);
}

/* Check input fields are not empty */
function validate_fields($var) {
    global $errors;

    // Ensure $var is iterable, otherwise return an error
    if (!is_iterable($var)) {
        $errors[] = "Input must be an array or iterable object.";
        return $errors;
    }

    // Check each field
    foreach ($var as $field) {
        $val = isset($_POST[$field]) ? remove_junk($_POST[$field]) : '';
        if (empty($val)) {
            $errors[] = "$field can't be blank.";
        }
    }

    return empty($errors) ? true : $errors;
}

/* Display session messages */
function display_msg($msg = '') {
    $output = '';
    if (!empty($msg)) {
        foreach ($msg as $key => $value) {
            // Ensure $value is a string before processing
            if (is_string($value)) {
                $output .= "<div class=\"alert alert-{$key}\">";
                $output .= "<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>";
                $output .= remove_junk(first_character($value));
                $output .= "</div>";
            } else {
                $output .= "<div class=\"alert alert-warning\">";
                $output .= "<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>";
                $output .= "Invalid message content.";
                $output .= "</div>";
            }
        }
    }
    return $output;
}

/* Redirect to a URL */
function redirect($url, $permanent = false) {
    if (!headers_sent()) {
        header('Location: ' . $url, true, $permanent ? 301 : 302);
    }
    exit();
}

/* Calculate total price, cost price, and profit */
function total_price($totals) {
    $sum = 0;
    $sub = 0;

    if (is_iterable($totals)) {
        foreach ($totals as $total) {
            $sum += $total['total_saleing_price'];
            $sub += $total['total_buying_price'];
        }
    }

    $profit = $sum - $sub;
    return array($sum, $profit);
}

/* Format a readable date and time */
function read_date($str) {
    return $str ? date('M j, Y, g:i:s a', strtotime($str)) : null;
}

/* Generate the current timestamp */
function make_date() {
    return date("Y-m-d H:i:s");
}

/* Auto-increment ID */
function count_id() {
    static $count = 1;
    return $count++;
}

/* Generate a random string */
function randString($length = 5) {
    $str = '';
    $cha = "0123456789abcdefghijklmnopqrstuvwxyz";

    for ($x = 0; $x < $length; $x++) {
        $str .= $cha[mt_rand(0, strlen($cha) - 1)];
    }

    return $str;
}
?>
