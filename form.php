<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Appointment Times</title>
    <style>
        .date {
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            text-align: center;
        }

        button {
            background-color: rgb(0, 131, 108);
            color: white;
            width: 456.02px;
            height: 51.99px;
            margin-bottom: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .time-slots {
            display: flex;
            flex-direction: column;
            margin-top: 10px;
            width: 100%;
            align-items: center;
        }

        button:hover {
            color: black;
        }

        .submit-btn {
            background-color: #0072ff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            margin-top: 20px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }

        .section {
            display: flex;
            justify-content: space-evenly;
        }

        .summary-section {
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 20px;
            width: 400px;
            height: fit-content;
        }

        .summary-section h4 {
            margin: 0;
            padding-bottom: 5px;
            border-bottom: 1px solid #ccc;
            color: rgb(0, 131, 108);
            height: fit-content;

        }

        .summary-section p {
            margin: 5px 0;
        }

        form {
            max-width: 400px;
            margin: 0 0;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #0072ff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 15px 20px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="section">
       
        <?php
        if (isset($_POST["practitioner_id"]) && isset($_POST["practitioner_name"])) {
            $practitioner_id = $_POST["practitioner_id"];
            $practitioner_name = $_POST["practitioner_name"];
            $appointment_date = $_POST["appointment_date"];
            $appointment_time = $_POST["appointment_time"];
            $selected_state = $_POST["selected_state"];
            $selected_id = $_POST["selected_id"];
            $business_id = $_POST["business_id"];
            $business_name = $_POST["business_name"];
            echo '<div><h4>User Information</h4>';
            echo '<form action="submit_booking.php" method="post">';
            echo '<label for="name">Name:</label>';
            echo '<input type="text" id="name" name="name" required>';

            echo '<label for="email">Email:</label>';
            echo '<input type="email" id="email" name="email" required>';

            echo '<label for="phone">Phone:</label>';
            echo '<input type="tel" id="phone" name="phone" required>';

            echo '<label for="dob">Date of Birth:</label>';
            echo '<input type="date" id="dob" name="dob" required>';
            echo '<input type="hidden" name="practitioner_name" value="'.$practitioner_name.'"required>';
            echo '<input type="hidden" name="business_name" value="'.$business_name.'"required>';
            echo '<input type="hidden" name="practitioner_id" value="'.$practitioner_id.'"required>';
            echo '<input type="hidden" name="appointment_date" value="'.$appointment_date.'"required>';
            echo '<input type="hidden" name="appointment_time" value="'.$appointment_time.'"required>';
            echo '<input type="hidden" name="selected_state" value="'.$selected_state.'"required>';
            echo '<input type="hidden" name="business_id" value="'.$business_id.'"required>';

            echo '<input type="submit" value="Submit">';
            echo '</form></div>';
        ?>

            <div class="summary-section">
                <h4>Booking Summary</h4>
                <p><strong>Name:</strong> <?php echo isset($business_name) ? $business_name : ''; ?></p>
                <p><strong>Location:</strong> <?php echo isset($selected_state) ? $selected_state : ''; ?></p>
                <p><strong>Doctor :</strong> <?php echo isset($practitioner_name) ? $practitioner_name : ''; ?></p>
                <p><strong>Date :</strong> <?php echo isset($appointment_time) ? $appointment_time : ''; ?> <?php echo isset($appointment_date) ? $appointment_date : ''; ?></p>

            </div>
        <?php
        } else {
        } ?>
    </div>