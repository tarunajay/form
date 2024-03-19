<?php
if (isset($_POST["selected_state"]) && $_POST["selected_state"]) {
    if ($_POST["selected_state"] == 'Arizona Consultation') {
        header('Location: https://billing.myfastweightloss.com/b/test_fZeeXmaA09mj6pWcMO');
        exit;
    } else if ($_POST["selected_state"] == 'California Consultation') {
        header('Location: https://billing.myfastweightloss.com/b/test_eVaeXm0Zqcyv7u03cd');
        exit;
    } else {
        $practitioner_id = $_POST["practitioner_id"];
        $practitioner_name = $_POST["practitioner_name"];
        $appointment_date = $_POST["appointment_date"];
        $appointment_time = $_POST["appointment_time"];
        $selected_state = $_POST["selected_state"];
        $selected_id = $_POST["selected_id"];
        $business_id = $_POST["business_id"];
        $business_name = $_POST["business_name"];
        header('Location: https://m.dealsfordell.com/kevin/Form/Location.php');
        exit;
    }
} else {
    header('Location: https://m.dealsfordell.com/kevin/Form/Location.php');
    exit;
}
?>
