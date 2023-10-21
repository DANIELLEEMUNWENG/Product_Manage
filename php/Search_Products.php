<?php

  include_once("dbconnect.php");
  if (isset($_GET['submit'])) {
    $operation = $_GET['submit'];
    if ($operation == 'search') {
    $search = $_GET['search'];
    $option = $_GET['option'];
    if ($option == "Select") {
      $sqlpro = "SELECT * FROM tbl_product WHERE productName LIKE '%$search%'";
    } else {
      $sqlpro  = "SELECT * FROM tbl_product WHERE productType = '$option'";

    }
  } 
} else{
  $sqlpro  = "SELECT * FROM tbl_product";
}

  $results_per_page = 12; 
if (isset($_GET['pageno'])) { 
 $pageno = (int)$_GET['pageno']; 
 $page_first_result = ($pageno - 1) * $results_per_page; 
} else { 
 $pageno = 1; 
 $page_first_result = 0; 
} 




if (!empty($sqlpro)) { // Check if $sqlpro is not empty
  $stmt = $conn->prepare($sqlpro);
  $stmt->execute();
  $number_of_result = $stmt->rowCount();
  $number_of_page = ceil($number_of_result / $results_per_page);

  $sqlpro = $sqlpro . " LIMIT $page_first_result , $results_per_page";
  $stmt = $conn->prepare($sqlpro);
  $stmt->execute();
  $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
  $rows = $stmt->fetchAll();
  
  // Rest of your code to display the results
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

<style>
.overlay {
            display: none;
            position: fixed;
            z-index: 999;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        /* Styles for modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
        }



.circle-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #d1ab56;
            color: #fff;
            font-size: 24px;
            text-decoration: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 999;
            cursor: pointer;

        }

        .circle-button i {
            font-size: 24px;
            margin: 0;

        }
  body {
            background-image: url('../assets/em.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
        }
        .pagination {
  display: flex;
  justify-content: center;
  align-items: center;
}

.pagination ul {
  list-style: none;
  display: flex;
  justify-content: center;
  align-items: center;
}

.pagination li {
  margin: 0 5px;
}

.pagination a {
  text-decoration: none;
  color: #333;
  background-color: #f5f5f5;
  padding: 8px 12px;
  border-radius: 5px;
}

.pagination a.active {
  background-color: #333;
  color: #fff;
}

        .button-container {
  display: flex;
  margin-bottom: 80px;
}

.button-container a {
  margin-right: 10px;
  
}

  .flip-card-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
  }

  .flip-card {
    width: 300px;
    height: 300px;
    margin: 10px;
    perspective: 1000px;
  }

  .flip-card-inner {
    width: 100%;
    height: 100%;
    transition: transform 0.6s;
    transform-style: preserve-3d;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  }

  .flip-card:hover .flip-card-inner {
    transform: rotateY(180deg);
  }

  .flip-card-front{
    width: 100%;
    height: 100%;
    position: absolute;
    backface-visibility: hidden;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 0px;
    margin: 0;

  }
  .flip-card-back {
    width: 100%;
    height: 100%;
    position: absolute;
    backface-visibility: hidden;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding-top: 50px;
    padding-bottom: 50px;
     }

  .flip-card-front {
    background-color: #d3d3d3;
    color: black;
  }

  .flip-card-back {
    background-color: #e0bd70;
    color: white;
    transform: rotateY(180deg);
    
    
  }

  .flip-card-front h4{
    margin: 0;
  }
  .flip-card-front p {
  margin: 0;
}


  .flip-card-front .product-info {
    display: flex;
    align-items: center;
  }

  .flip-card-front .product-info h4 {
    margin-right: 10px;
  }

  .colored-card {
    background-color: rgba(255, 255, 253, 0.8);
            padding: 20px;
        }







        .button2 {
        background-color: black; 
        color: white;
    }


    p { 
          margin: 0; 
          padding: 0; 
          font-size: 14px;
        } 
        .fancy-footer {
  background-color: black;
  text-align: center;
  color: white;
  padding: 10px;
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
  <a href="Add_Products.php" class="w3-bar-item w3-button">Add</a>
</div>
<header class="w3-container w3-black" id="myHeader">
<button class="w3-button w3-large" onclick="w3_open()">&#9776;</button>
</header>






<div class="w3-center w3-padding">
<h1><b>Available Products</b></h1>
</div>



<div class="w3-card colored-card w3-container w3-padding w3-margin w3-round">
  <div class="search-form" style="display: flex; justify-content: space-between; align-items: center;">
    <h3 class="search-heading"><b>Search Your Product</b></h3>
    <form style="display: flex; align-items: center;">
      <input class="w3-input w3-block w3-round w3-border w3-small search-input" type="search" name="search" placeholder="Type here to search" style="width: 450px; margin-right: 8px;" />
      <select class="w3-input w3-round w3-border w3-small search-select" name="option" style="width: 130px; margin-right: 8px;">
        <option value="Select" selected>Product Type</option>       
        <option value="cake">cake</option>
        <option value="cheese">cheese</option>
        <option value="ice cream">ice cream</option>
        <option value="milk">milk</option>
        <option value="snack">snack</option>
        <option value="yogurt">yogurt</option>
      </select>
      <button class="w3-button button button2 w3-round" type="submit" name="submit" value="search" style="width: 100px; height: 35px; display: flex; align-items: center; justify-content: center;">Search</button>
    </form>
  </div>
</div>




   
<div class="w3-card colored-card w3-container w3-padding w3-margin w3-round">

<div class="flip-card-container">
<?php
$i = 0;

if (!empty($rows) && is_array($rows)) {
    foreach ($rows as $product) {
        $i++;
        $productID = $product['productID'];
        $productName = $product['productName'];
        $productDesc = $product['productDesc'];
        $amount = $product['amount'];
        $amount_value = $product['amount_value'];
        $expire_date = $product['expire_date'];
        $productPrice = $product['productPrice'];
        $productType = $product['productType'];
        $ads = $product['ads'];

        echo "<div class='flip-card'>";
        echo "<div class='flip-card-inner'>";
        echo "<div class='flip-card-front'>";
        echo "<h4>$productName</h4>";
        echo "<img src='../assets/$productID.png' style='width: 100%; height: 100%; object-fit: cover;'>";
        echo "</div>";
        echo "<div class='flip-card-back'>";
        echo "<h4>$productName</h4>";
        echo "<p>Description: $productDesc</p>";
        echo "<p>Price: RM $productPrice</p>";
        echo "<p>Product Type: $productType</p>";
        echo "<p>Amount: $amount</p>";
        echo "<p>Expire date: $expire_date</p>";
        echo '<div class="button-container">';
        
        echo '</div>';
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "No products found.";
}
?>


</div>
</div>



<a href="Add_Products.php" class="circle-button" onclick="scrollToTop()">
    <i class="fas fa-plus"></i>
</a>


<?php
   $num = 1;

   if ($pageno == 1) {
     $num = 1;
   } else if ($pageno == 2) {
     $num = ($num) + 10;
   } else {
     $num = $pageno * 10 - 9;
   }
   
   echo '<div class="pagination">';
   echo '<ul>';
   
   for ($page = 1; $page <= $number_of_page; $page++) {
     echo '<li style="margin-right: 5px;">'; // Add margin-right CSS property
     if ($page == $pageno) {
       echo '<a href="Search_Products.php?pageno=' . $page . '" class="active">' . $page . '</a>';
     } else {
       echo '<a href="Search_Products.php?pageno=' . $page . '">' . $page . '</a>';
     }
     echo '</li>';
   }
   
   echo '</ul>';
   echo '</div>';
?>
  <script>
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }


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