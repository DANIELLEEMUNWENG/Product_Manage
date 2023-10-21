<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Establish database connection
        $servername = "localhost"; // Replace with your server name
        $username = "root"; // Replace with your database username
        $password = ""; // Replace with your database password
        $dbname = "product"; // Replace with your database name

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind SQL statement
        $stmt = $conn->prepare("INSERT INTO tbl_product (ProductID, productName, productDesc, amount, amount_value, expire_date, productPrice, productType, ads, productImage) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssssss", $productID, $productName, $productDesc, $amount, $amount_value, $expire_date, $productPrice, $productType, $ads, $productImage);

         // Retrieve form data
         $productID = $_POST['productID'];
         $productName = $_POST['productName'];
         $productDesc = $_POST['productDesc'];
         $amount = $_POST['amount'];
         $amount_value = $_POST['amount_value'];
         $expire_date = $_POST['expire_date'];
         $productPrice = $_POST['productPrice'];
         $productType = $_POST['productType'];
         $ads = $_POST['ads'];
         $productImage = $_FILES['productImage']['name'];
 
         // Move uploaded file to desired location
         $targetDir = "C:/Users/rayan/Documents/xamp/htdocs/Manage/assets/"; // Directory to store the uploaded images
         $targetFile = $targetDir .  $productID . ".png";
         move_uploaded_file($_FILES['productImage']['tmp_name'], $targetFile);
 
         // Execute the statement
         if ($stmt->execute()) {
             echo "Product added successfully.";
         } else {
             echo "Error adding product: " . $stmt->error;
         }
 
         // Close the statement and database connection
         $stmt->close();
         $conn->close();
     }
?>

<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-light-blue.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="../css/subjects.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Add Product</title>
    <style>
        
   
        body {
            background-image: url('../assets/em.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
        }
/* CSS */
.my-component {
  max-width: 600px;
  height: 610px;
  background-color: rgba(255, 255, 253, 0.8);
  padding-right: 80px;
  padding-left: 50px;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  margin: 0 auto;
}

.my-component h2 {
  margin-bottom: 20px;
  text-align: center;
}

.my-component form {
  margin-bottom: 20px;
  display: grid;
  grid-template-columns: 1fr 1fr;
}

.my-component label {
  display: block;
  margin-top: 10px;
}

.my-component input[type="text"],
.my-component textarea,
.my-component input[type="date"],
.my-component input[type="file"] {
  width: 110%;
  padding-top: 10px;
  padding-right: 200px;
  margin-top: 5px;
  border-radius: 4px;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

.my-component input[type="submit"] {
  background-color: #d1ab56;
  color: #fff;
  padding: 4px 0px;
  font-size: 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  margin-top: 23px;
  margin-bottom: 30px;
}

.my-component input[type="submit"]:hover {
  background-color: #45a049;
}

.my-component .success-message {
  background-color: #d4edda;
  color: #155724;
  padding: 10px;
  border-radius: 4px;
}

.my-component .error-message {
  background-color: #f8d7da;
  color: #721c24;
  padding: 10px;
  border-radius: 4px;
}


    </style>
</head>


<body>

<!-- Side Navigation -->
<div class="w3-sidebar w3-bar-block w3-black w3-animate-left" style="display:none" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large"
  onclick="w3_close()">Close &times;</button>
  <a href="Update_Products.php" class="w3-bar-item w3-button">Update</a>
  <a href="Delete_Products.php" class="w3-bar-item w3-button">Delete</a>
  <a href="Search_Products.php" class="w3-bar-item w3-button">View</a>

</div>
<header class="w3-container w3-black" id="myHeader">
<button class="w3-button w3-large" onclick="w3_open()">&#9776;</button>
</header>

    <div class="my-component">
        <h2>Add Product</h2>
        <form id="addProductForm" enctype="multipart/form-data">
            <label for="productID">Product ID:</label>
            <input type="text" name="productID">
            <label for="productName">Product Name:</label>
            <input type="text" name="productName">
            <label for="productDesc">Product Description:</label>
            <textarea name="productDesc"></textarea>
            <label for="amount">Amount:</label>
            <input type="text" name="amount">
            <label for="amount_value">Amount Value:</label>
            <input type="text" name="amount_value">
            <label for="expire_date">Expiration Date:</label>
            <input type="date" name="expire_date">
            <label for="productPrice">Product Price:</label>
            <input type="text" name="productPrice">
            <label for="productType">Product Type:</label>
            <input type="text" name="productType">
            <label for="ads">Ads:</label>
            <textarea name="ads"></textarea>
            <label for="productImage">Product Image:</label>
            <input type="file" name="productImage">

            <input type="submit" value="Add Product">
        </form>
        <div id="statusMessage"></div>
    </div>

    <script>
        document.getElementById("addProductForm").addEventListener("submit", function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        showStatusMessage("Product added successfully.", "success");
                        document.getElementById("addProductForm").reset();
                    } else {
                        showStatusMessage("Error adding product: " + xhr.responseText, "error");
                    }
                }
            };

            xhr.open("POST", "<?php echo $_SERVER['PHP_SELF']; ?>");
            xhr.send(formData);
        });

        function showStatusMessage(message, type) {
            var statusMessage = document.getElementById("statusMessage");
            statusMessage.innerHTML = message;

            if (type === "success") {
                statusMessage.className = "success-message";
            } else if (type === "error") {
                statusMessage.className = "error-message";
            }
        }
        function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
}
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
}
    </script>

</body>
</html>