<?php

if (isset($_POST['Generatesalary'])) {

    $uploadDir = "admin/backup/uploads/";
    $uploadFileName = $uploadDir . basename($_FILES["excel_file"]["name"]);
    $tempFile = $_FILES["excel_file"]["tmp_name"];

    // Step 2: Ensure upload directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Step 3: File size check
    if ($_FILES["excel_file"]["size"] > 0) {

        // Step 4: Move uploaded file
        if (move_uploaded_file($tempFile, $uploadFileName)) {
            $file = fopen($uploadFileName, "r");
            $rowCounter = 0;

            // Step 5: Prepare data for insertion
            $name = "Attendance"; // Placeholder name, can be modified as needed
            $datetime = date('Y-m-d H:i:s');
            $file_name = basename($_FILES["excel_file"]["name"]);
            $close = 0;
            $status = "pending";

            // Step 6: Insert log entry into database
            $sql = "INSERT INTO attendance (name, datetime, file_name, close, status)
                    VALUES ('$name', '$datetime', '$file_name', '$close', '$status')";

            if (mysqli_query($con, $sql)) {
                echo "<script>alert('✅ Entry inserted successfully.');</script>";
            } else {
                echo "<script>alert('❌ DB Error: " . mysqli_error($con) . "');</script>";
            }

        } else {
            echo "<script>alert('❌ Failed to upload file.');</script>";
        }

    } else {
        echo "<script>alert('❌ File is empty.');</script>";
    }
}
?>



