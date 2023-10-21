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
    <title>Delete Product</title>
    <style>
        body {
            background-image: url('../assets/em.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
        }

        .container {
            max-width: 400px;
            
            margin-top: 60px ;
            margin-left: 500px;
            margin-bottom: 205px;

            background-color: rgba(255, 255, 253, 0.8);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #666;
            font-weight: bold;
        }

        .form-group input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group input[type="submit"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background-color: #d1ab56;
            border: none;
            color: #fff;
            cursor: pointer;
            border-radius: 4px;
        }

        .form-group input[type="submit"]:hover {
            background-color: #e0bd70;
        }

        .message {
            text-align: center;
            font-weight: bold;
            margin-top: 10px;
            padding: 10px;
            border-radius: 4px;
        }

        .message.success {
            background-color: #dff0d8;
            color: #3c763d;
        }

        .message.error {
            background-color: #f2dede;
            color: #a94442;
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
        <h2>Delete Product</h2>
        <form action="Delete_Products.php" method="POST">
            <div class="form-group">
                <label for="delete_id">Product ID:</label>
                <input type="text" name="delete_id" id="delete_id" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Delete">
            </div>
            <?php
            // Process delete request
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
                // Establish database connection
                $servername = "localhost"; // Replace with your server name
                $username = "root"; // Replace with your database username
                $password = ""; // Replace with your database password
                $dbname = "cbd"; // Replace with your database name

                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $productID = $_POST['delete_id'];

                // Construct SQL query
                $sql = "DELETE FROM tbl_product WHERE productID = '$productID'";

                // Execute query
                if ($conn->query($sql) === TRUE) {
                    if ($conn->affected_rows > 0) {
                        echo "<p class='message success'>The product is deleted successfully.</p>";
                    } else {
                        echo "<p class='message error'>The product is not found.</p>";
                    }
                } else {
                    echo "<p class='message error'>Error deleting record: " . $conn->error . "</p>";
                }

                // Close the database connection
                $conn->close();
            }
            ?>
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