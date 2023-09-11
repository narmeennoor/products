    <?php


// include('database.php');

// // Manually specify the keycode
// $keycode = 1; // You can change this to your desired keycode

// // Initialize an empty array to store uploaded image filenames
// $uploadedImageFilenames = [];

// // Check if any files were uploaded
// if (!empty($_FILES['myFiles']['name'][0])) {
//     $totalFiles = count($_FILES['myFiles']['name']);

//     for ($i = 0; $i < $totalFiles; $i++) {
//         $name = $_FILES['myFiles']['name'][$i];
//         $tempName = $_FILES['myFiles']['tmp_name'][$i];
//         $targetPath = 'C:/xampp/htdocs/test/uploads/' . $name;

//         if (move_uploaded_file($tempName, $targetPath)) {
//             $uploadedImageFilenames[] = $name;
//         }
//     }
// }

// // Insert uploaded image filenames into the tbluploads table with the specified keycode
// foreach ($uploadedImageFilenames as $filename) {
//     $query = "INSERT INTO tbluploads (`keycode`, `images`) VALUES ('$keycode', '$filename')";

//     if ($conn->query($query) !== TRUE) {
//         echo "Error: " . $query . "<br>" . $conn->error;
//     }
// }

// // Close the database connection
// $conn->close();





include('database.php');

$pc = isset($_POST['pdcode']) ? $_POST['pdcode'] : '';
$pn = isset($_POST['pdname']) ? $_POST['pdname'] : '';
$units = isset($_POST['units']) ? $_POST['units'] : '';
$sp = isset($_POST['sp']) ? $_POST['sp'] : '';
$op = isset($_POST['op']) ? $_POST['op'] : '';
$pd = isset($_POST['pd']) ? $_POST['pd'] : '';
// Get the next available keycode
$maxKeycodeQuery = "SELECT MAX(keycode) AS max_keycode FROM tblimage";
$maxKeycodeResult = mysqli_query($conn, $maxKeycodeQuery);

if ($maxKeycodeResult) {
    $row = mysqli_fetch_assoc($maxKeycodeResult);
    $nextKeycode = ($row['max_keycode'] === null) ? 1 : $row['max_keycode'] + 1;
} else {
    $nextKeycode = 1;
}


// Define the path to the folder where you want to save additional images
$additionalImageFolder = 'C:/xampp/htdocs/test/additionalimg/';

// Initialize an empty array to store uploaded image filenames
$uploadedImageFilenames = [];

// Check if additional files were uploaded
if (isset($_FILES['myFiles']['name'][0])) {
    $totalFiles = count($_FILES['myFiles']['name']);

    for ($i = 0; $i < $totalFiles; $i++) {
        $name = $_FILES['myFiles']['name'][$i];
        $tempName = $_FILES['myFiles']['tmp_name'][$i];
        $targetPath = $additionalImageFolder . $name;

        if (move_uploaded_file($tempName, $targetPath)) {
            $uploadedImageFilenames[] = $name;
        } else {
            // Handle upload failure for additional image
            echo "Upload failed for file: $name";
        }
    }
}

// Process the main display image (myfile) here
if (isset($_FILES['myfile']) && !empty($_FILES['myfile']['name'])) {
    $mainImageName = $_FILES['myfile']['name'];
    $mainImageTempName = $_FILES['myfile']['tmp_name'];
    $mainImagePath = 'C:/xampp/htdocs/test/uploads/' . $mainImageName;

    // Debugging: Check the values
    echo "Name: $mainImageName<br>";
    echo "Temp Name: $mainImageTempName<br>";

    if (move_uploaded_file($mainImageTempName, $mainImagePath)) {
        // Successfully uploaded main display image
    } else {
        // Handle upload failure for main display image
        echo "Main image upload failed.";
    }
} else {
    // Handle the case where 'myfile' is not set in the form
    echo "Main image file not selected.";
}

if (isset($_FILES['myfile']['error'])) {
    // Debugging: Check the error code
    echo "File upload error: " . $_FILES['myfile']['error'];
}

// Get other form data


// Insert data into the tbluploads table with the same keycode for each additional image
foreach ($uploadedImageFilenames as $filename) {
    $query = "INSERT INTO tbluploads (`keycode`, `images`) VALUES ('$nextKeycode', '$filename')";

    if ($conn->query($query) !== TRUE) {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}

// Insert data into the tblimage table with the same keycode
if (!empty($mainImageName)) {
    $query = "INSERT INTO tblimage (`keycode`, `productcode`, `productname`, `unit`, `sellingprice`, `offerprice`, `pdesc`, `image`) VALUES ('$nextKeycode', '$pc', '$pn', '$units', '$sp', '$op', '$pd', '$mainImageName')";

    if ($conn->query($query) === TRUE) {
        echo "Data inserted successfully";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
} else {
    echo "Main image upload failed 1";
}

$conn->close();






// $imageFilename = "";
// if (!empty($_FILES['dp']['name'])) {
//     $name = $_FILES['dp']['name'];
//     $tempName = $_FILES['dp']['tmp_name'];
//     $targetPath = 'C:/xampp/htdocs/test/uploads/' . $name;

//     move_uploaded_file($tempName, $targetPath);
//     $imageFilename = $name; 
   
// }

// // Get other form data
// $pc = $_POST['pdcode'];
// $pn = $_POST['pdname'];
// $units = $_POST['units'];
// $sp = $_POST['sp'];
// $op = $_POST['op'];
// $pd = $_POST['pd'];

// // Insert data into the database
// if (!empty($imageFilename)) {
//     $query = "INSERT INTO tblimage (`keycode`, `productcode`, `productname`, `unit`,`sellingprice`,`offerprice`,`pdesc`, `image`) VALUES (' ','$pc','$pn','$units','$sp','$op','$pd','$imageFilename')";

//     if ($conn->query($query) === TRUE) {
//         echo "Data inserted successfully";
//     } else {
//         echo "Error: " . $query . "<br>" . $conn->error;
//     }
// } else {
//     //echo "Error: " . $query . "<br>" . $conn->error;
//     echo "Image upload failed";
// }

// $conn->close();


 ?>











