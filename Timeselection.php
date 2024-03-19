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
    </style>
</head>

<body>
    <div class="section">
        <div class="main-section">
            <?php
            date_default_timezone_set('America/Los_Angeles');
            if (isset($_POST["state"]) && isset($_POST["business_id"])) {
                $selected_state = $_POST["state"];
                $selected_id = $_POST["appointment_type_id"];
                $business_id = $_POST["business_id"];
                $business_name = $_POST["business_name"];
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.ca1.cliniko.com/v1/appointment_types/' . $selected_id . '/practitioners',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'User-Agent: tarunajaygul@gmail.com',
                        'Authorization: Basic TVMweE16VXdPRGs0T0RFM09UZzFNVFV6TlRneExVMWpiMlJSZWtGdGIzRktla2c0UW1GdFRFbG9RMEZHVVVaalpURXdaVWh6LWNhMTo='
                    ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                $data = json_decode($response, true);
                $practitioners = [];
                foreach ($data['practitioners'] as $practitioner) {
                    $practitioners[] = [
                        'id' => $practitioner['id'],
                        'name' => $practitioner['display_name'],
                        'title' => $practitioner['title']
                    ];
                }

                foreach ($practitioners as $practitioner) {
                    $id = $practitioner['id'];
                    $name = $practitioner['name'];
                    $title = $practitioner['title'];
                    $curl = curl_init();
                    $url = "https://api.ca1.cliniko.com/v1/businesses/{$business_id}/practitioners/{$id}/appointment_types/{$selected_id}/available_times?from=2024-03-18&page=1&per_page=100&to=2024-03-24";

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => $url,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'GET',
                        CURLOPT_HTTPHEADER => array(
                            'User-Agent: tarunajaygul@gmail.com',
                            'Authorization: Bearer TVMweE16VXdPRGs0T0RFM09UZzFNVFV6TlRneExVMWpiMlJSZWtGdGIzRktla2c0UW1GdFRFbG9RMEZHVVVaalpURXdaVWh6LWNhMTo='
                        ),
                    ));

                    $response = curl_exec($curl);
                    curl_close($curl);
                    $response_data = json_decode($response, true);

                    // Initialize an array to store available times
                    $available_times = [];

                    // Loop through the available times and format them
                    foreach ($response_data['available_times'] as $time) {
                        $formatted_date = date('d-m-Y', strtotime($time['appointment_start']));
                        $formatted_time = date('h:i A', strtotime($time['appointment_start'])); // Convert to 12-hour format with AM/PM
                        $available_times[$formatted_date][] = $formatted_time;
                    }

                    // Display the dates and available times
                    echo '<div class="practitioner-section">';
                    foreach ($available_times as $date => $times) {
                        echo '<div class="date">' . $date . '</div>';
                        echo '<form action="form.php" method="post">';
                        echo '<div class="time-slots">';
                        foreach ($times as $time) {
                            echo '<button type="submit" name="appointment_time" value="' . $time . '" class="time-slot">' . $time . '</button>';
                            echo '<input type="hidden" name="practitioner_id" value="' . $id . '">';
                            echo '<input type="hidden" name="practitioner_name" value="' . $title . ' ' . $name . '">';
                            echo '<input type="hidden" name="appointment_date" value="' . $date . '">';
                            echo '<input type="hidden" name="selected_state" value="' . $selected_state . '">';
                            echo '<input type="hidden" name="business_name" value="' . $business_name . '">';
                            echo '<input type="hidden" name="business_id" value="' . $business_id . '">';
                            echo '<input type="hidden" name="selected_id" value="' . $selected_id . '">';
                        }
                        echo '</div>';
                        echo '</form>';
                    }
                    echo '</div>';
                }
            } else {
                echo '<div>Please Select Location... <a href="Location.php">Click me</a></div>';
            }
            ?>

        </div>
        <div class="summary-section">
            <h4>Booking Summary</h4>
            <p><strong>Name:</strong> <?php echo isset($business_name) ? $business_name : ''; ?></p>
            <p><strong>Location:</strong> <?php echo isset($selected_state) ? $selected_state : ''; ?></p>
            <p><strong>Appointment ID:</strong> <?php echo isset($selected_id) ? $selected_id : ''; ?></p>
        </div>
    </div>
</body>