<?php

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.ca1.cliniko.com/v1/businesses/',
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

$business_id = $data['businesses'][0]['id'];
$business_name = $data['businesses'][0]['business_name'];
// Initialize an empty array to store appointment_type_ids
$all_appointment_type_ids = array();

// Iterate over each business
foreach ($data['businesses'] as $business) {
    // Extract appointment_type_ids for the current business
    $appointment_type_ids = $business['appointment_type_ids'];

    // Merge the appointment_type_ids into the array
    $all_appointment_type_ids = array_merge($all_appointment_type_ids, $appointment_type_ids);
}

// Initialize an empty array to store state names
$states = array();

// Make API requests for each appointment_type_id
foreach ($all_appointment_type_ids as $appointment_type_id) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.ca1.cliniko.com/v1/appointment_types/' . $appointment_type_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'User-Agent: tarunajaygul@gmail.com',
            'token: basic TVMweE16VXdPRGs0T0RFM09UZzFNVFV6TlRneExVMWpiMlJSZWtGdGIzRktla2c0UW1GdFRFbG9RMEZHVVVaalpURXdaVWh6LWNhMTo=',
            'Authorization: Bearer TVMweE16VXdPRGs0T0RFM09UZzFNVFV6TlRneExVMWpiMlJSZWtGdGIzRktla2c0UW1GdFRFbG9RMEZHVVVaalpURXdaVWh6LWNhMTo='
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $decoded_response = json_decode($response, true);
    // Extract the name from the response and add it to the $states array
    $states[] = $decoded_response['name'];
}

// Remove duplicate state names
$states = array_unique($states);
sort($states);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select a State</title>
    <style>
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

        .main-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: fit-content;
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
            <h3>Select a state:</h3>
            <?php foreach ($states as $index => $state) :
                if (!empty($state)) { ?>
                    <form action="Timeselection.php" method="post">
                        <button type="submit" id='name' name="state" value="<?php echo $state; ?>">
                            <?php echo $state; ?>
                        </button>
                        <!-- Add hidden input for the appointment type ID corresponding to this state -->
                        <input type="hidden" name="appointment_type_id" value="<?php echo $all_appointment_type_ids[$index]; ?>">
                        <input type="hidden"  name="business_name" value="<?php echo $business_name; ?>">
                        <input type="hidden" name="business_id" value="<?php echo $business_id; ?>">
                    </form>
            <?php }
            endforeach; ?>
        </div>
        <div class="summary-section">
            <h4>Booking Summary</h4>
            <p><strong>Name:</strong> <?php echo isset($business_name) ? $business_name : ''; ?></p>
        </div>
    </div>
    
</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Loop through each button and check the business name
            $('button').each(function() {
                var businessName = $(this).val();
                console.log(businessName);
                // Check if the business name matches any of the specified names
                if (businessName === "Consultation (Promo)" || businessName === "Consultation Pre-paid (FL)" || businessName === "District of Colombia Consultation") {
                    // Hide the button if the condition is true
                    $(this).hide();
                }
            });
        });
    </script>