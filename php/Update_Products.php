<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "product";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ""; // Initialize an empty message
$productFound = false; // Flag to indicate if product was found

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productID = $_POST['productID'];

    // Search for the product based on the provided product ID
    $sql = "SELECT * FROM tbl_product WHERE productID = '$productID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $productDetails = $result->fetch_assoc();
        $productFound = true;
    } else {
        $message = "Product not found.";
    }

    // Handle the product update form submission
    if (isset($_POST['updateProduct'])) {
        $productName = $_POST['productName'];
        $productDesc = $_POST['productDesc'];
        $amount = $_POST['amount'];
        $amount_value = $_POST['amount_value'];
        $expire_date = $_POST['expire_date'];
        $productPrice = $_POST['productPrice'];
        $productType = $_POST['productType'];

        // Check if the product was found before attempting to update it
        if ($productFound) {
            // Check if a file was uploaded
            if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['productImage']['tmp_name'];
                $fileName = $_FILES['productImage']['name'];

                // Set the destination directory
                $destination = 'C:/xampp/htdocs/Manage/assets/' . $fileName;

                // Move the uploaded file to the destination directory
                if (move_uploaded_file($file, $destination)) {
                    // Update the productImage value in the database
                    $sqlupdate = "UPDATE tbl_product SET productName = '$productName', productDesc = '$productDesc', 
                    amount = '$amount', amount_value = '$amount_value', expire_date = '$expire_date', productPrice = '$productPrice',
                    productType = '$productType', productImage = '$fileName' WHERE productID = '$productID'";

                    // Execute the SQL query
                    if ($conn->query($sqlupdate) === TRUE) {
                        $message = "Product updated successfully.";
                        // Update the productDetails variable with the new values
                        $productDetails['productName'] = $productName;
                        $productDetails['productDesc'] = $productDesc;
                        $productDetails['amount'] = $amount;
                        $productDetails['amount_value'] = $amount_value;
                        $productDetails['expire_date'] = $expire_date;
                        $productDetails['productPrice'] = $productPrice;
                        $productDetails['productType'] = $productType;
                        $productDetails['productImage'] = $fileName;
                    } else {
                        $message = "Error updating product: " . $conn->error;
                    }
                } else {
                    $message = "Error moving the uploaded file.";
                }
            } else {
                // Update other fields without changing the productImage value
                $sqlupdate = "UPDATE tbl_product SET productName = '$productName', productDesc = '$productDesc', 
                amount = '$amount', amount_value = '$amount_value', expire_date = '$expire_date', productPrice = '$productPrice',
                productType = '$productType' WHERE productID = '$productID'";

                // Execute the SQL query
                if ($conn->query($sqlupdate) === TRUE) {
                    $message = "Product updated successfully.";
                    // Update the productDetails variable with the new values
                    $productDetails['productName'] = $productName;
                    $productDetails['productDesc'] = $productDesc;
                    $productDetails['amount'] = $amount;
                    $productDetails['amount_value'] = $amount_value;
                    $productDetails['expire_date'] = $expire_date;
                    $productDetails['productPrice'] = $productPrice;
                    $productDetails['productType'] = $productType;
                } else {
                    $message = "Error updating product: " . $conn->error;
                }
            }
        } else {
            $message = "Product not found.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head><head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-light-blue.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="../css/subjects.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Update Product</title>
    <style>
          body {
            background-image: url('../assets/em.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
        }

        .container {
            max-width: 430px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            background-color: rgba(255, 255, 253, 0.8);
            margin-top: 50px ;
            margin-left: 500px;
            margin-bottom: 100px ;
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
            margin-top: 0;
            /* Add this to remove the default top margin */
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="text"],
        textarea,
        input[type="date"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color:  #d1ab56;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 26px;
        }

        input[type="submit"]:hover {
            background-color:  #d1ab56;
        }

        /* Grid styles for form elements */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-gap: 10px;
        }

        .search-button {
            padding: 10px 20px;
            font-size: 14px;
        }
        .fancy-footer {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  color: white;
  padding: 0px;
  text-align: center;
  background-color: black;
}

    </style>

    <script>
        window.onload = function() {
            var message = "<?php echo $message; ?>";
            if (message !== "") {
                alert(message);
            }
        };

        function validateForm() {
            var productID = document.getElementById("productID").value;
            if (productID === "") {
                alert("Please enter a product ID.");
                return false;
            }
        }

    </script>
</head>
<body>
        <!-- Side Navigation -->
<div class="w3-sidebar w3-bar-block w3-black w3-animate-left" style="display:none" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large"
  onclick="w3_close()">Close &times;</button>
  <a href="Add_Products.php" class="w3-bar-item w3-button">Add</a>
  <a href="Update_Products.php" class="w3-bar-item w3-button">Update</a>
  <a href="Search_Products.php" class="w3-bar-item w3-button">View</a>

</div>
<header class="w3-container w3-black" id="myHeader">
<button class="w3-button w3-large" onclick="w3_open()">&#9776;</button>
</header>
    <div class="container">
        <h2>Update Product</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data"
            onsubmit="return validateForm()">
            <div class="form-row">
                <label for="productID">Product ID:</label>
                <input type="text" name="productID" id="productID">
                
            
            </div>

            <!-- Display the product details for updating -->
            <?php if ($productFound): ?>
            <div class="form-row">
                <label for="productName">Product Name:</label>
                <input type="text" name="productName" id="productName"
                    value="<?php echo isset($productDetails['productName']) ? $productDetails['productName'] : ''; ?>">
            </div>

            <div class="form-row">
                <label for="productDesc">Product Description:</label>
                <textarea name="productDesc"
                    id="productDesc"><?php echo isset($productDetails['productDesc']) ? $productDetails['productDesc'] : ''; ?></textarea>
            </div>

            <div class="form-row">
                <label for="amount">Amount:</label>
                <input type="text" name="amount" id="amount"
                    value="<?php echo isset($productDetails['amount']) ? $productDetails['amount'] : ''; ?>">
            </div>

            <div class="form-row">
                <label for="amount_value">Amount Value:</label>
                <input type="text" name="amount_value" id="amount_value"
                    value="<?php echo isset($productDetails['amount_value']) ? $productDetails['amount_value'] : ''; ?>">
            </div>

            <div class="form-row">
                <label for="expire_date">Expiration Date:</label>
                <input type="date" name="expire_date" id="expire_date"
                    value="<?php echo isset($productDetails['expire_date']) ? $productDetails['expire_date'] : ''; ?>">
            </div>

            <div class="form-row">
                <label for="productPrice">Product Price:</label>
                <input type="text" name="productPrice" id="productPrice"
                    value="<?php echo isset($productDetails['productPrice']) ? $productDetails['productPrice'] : ''; ?>">
            </div>

            <div class="form-row">
                <label for="productType">Product Type:</label>
                <input type="text" name="productType" id="productType"
                    value="<?php echo isset($productDetails['productType']) ? $productDetails['productType'] : ''; ?>">
            </div>

            <div class="form-row">
                <label for="productImage">Product Image:</label>
                <input type="file" name="productImage" id="productImage">
            </div>

            <input type="submit" name="updateProduct" value="Update">
            <input type="submit" name="searchProduct" value="Search" class="search-button">

            <?php endif; ?>
        </form>
    </div>
    <script>
      


      function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
}
function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
}
  </script>

  <footer class="fancy-footer">
<p>Copyright Group(M)@</p>
</footer>
</body>
</html>
