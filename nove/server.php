<?php
          // set sql login and database
          $sql_servername = "127.0.0.1";
          $sql_username = "show";
          $sql_password = "heslonetreba";
          $sql_dbname = "test"; 
  $CATEGORY_NAME = '';
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["productName"])) {
    } else if (isset($_GET["product"])) {
          // AJAX form submission
          $person = json_decode($_GET["product"]);
          // set variables
          $product_CATEGORYTEXT = $person->CATEGORY_FULLNAME;
          $product_PRODUCTNAME = $person->PRODUCTNAME; 
          $product_PRICE_VAT = $person->PRICE_VAT;
          $product_HEUREKA_CPC = $person->HEUREKA_CPC;
          $product_DELIVERY_DATE_date = $person->DELIVERY_DATE_date;
          $product_DELIVERY_DATE_number = $person->DELIVERY_DATE_number;                                     
          $product_IMGURL = $person->IMGURL;    
          $product_IMGURL_ALTERNATIVE = $person->IMGURL_ALTERNATIVE;
          $product_VIDEO_URL = $person->VIDEO_URL; 
          $product_DESCRIPTION = $person->DESCRIPTION;
          // transfer array delivery to variable
          $arrlength = count($person->DELIVERY_ID);
          $product_delivery = '';
          for($x = 0; $x < $arrlength; $x++) {
              $product_DELIVERY_ID = $person->DELIVERY_ID[$x] . ',' . $product_DELIVERY_ID;
          }
          // set up delivery_date number or date
          if (isset($product_DELIVERY_DATE_number)) {
            $product_DELIVERY_DATE = $product_DELIVERY_DATE_number; 
          } 
          if (isset($product_DELIVERY_DATE_date)) {
            $product_DELIVERY_DATE = date("Y-m-d", strtotime($product_DELIVERY_DATE_date));  
          }
          // create connection
          $conn = new mysqli($sql_servername, $sql_username, $sql_password, $sql_dbname);
          // check connection
          if ($conn->connect_error) {
              die("<br>Connection failed: " . $conn->connect_error);
          }
          // set utf8
          if (!$conn->set_charset("utf8")) {
              printf("<br>Error loading character set utf8: %s\n", $conn->error);
          }
          $sql_write = "INSERT INTO obchod_ITEMS (
             product_PRODUCTNAME,
             product_DESCRIPTION,
             product_IMGURL,
             product_IMGURL_ALTERNATIVE,
             product_VIDEO_URL,
             product_PRICE_VAT,
             product_HEUREKA_CPC,
             product_DELIVERY_ID,
             product_CATEGORYTEXT,
             product_DELIVERY_DATE
             )
          VALUES (
             '$product_PRODUCTNAME',
             '$product_DESCRIPTION',
              '$product_IMGURL',
              '$product_IMGURL_ALTERNATIVE',
              '$product_VIDEO_URL',
              '$product_PRICE_VAT',
              '$product_HEUREKA_CPC',
              '$product_DELIVERY_ID',
              '$product_CATEGORYTEXT',
              '$product_DELIVERY_DATE'
            )";
          // write sql to database
          if ($conn->query($sql_write) === TRUE) {
              // echo ok
              
              $id_sql = $conn->insert_id;
              $product_URL = "http://94.112.88.19/produkty/?search=" . $id_sql;
              // DOŘEŠIT ID to ID !!! 
              // $sql_write2 = "INSERT INTO obchod_ITEMS (product_URL) VALUES ('$product_URL')";
              echo "Produkt (" . $product_PRODUCTNAME . ") přidán";
               //if ($conn->query($sql_write2) === TRUE) {
                 // ok druhý zápis
               //} else {
              // write info about error
             // echo "Error: " . $sql_write . ":" . $conn->error;
              // }
            
  
          } else {
              // write info about error
              echo "Error: " . $sql_write . ":" . $conn->error;
          }
          // close connection
          $conn->close();
    } else if (isset($_GET["customer"])) {
      // AJAX form submission
      $customer = json_decode($_GET["customer"]);
          // set sql login and database
         $customerDegree = $customer->customerDegree; 
         $customerFirstName = $customer->customerFirstName;
         $customerLastName = $customer->customerLastName; 
         $customerAddressStreet = $customer->customerAddressStreet;
         $customerAddressCity = $customer->customerAddressCity;
         $customerAddressZIP = $customer->customerAddressZIP;
         $customerEmail = $customer->customerEmail;
         $customerPhone = $customer->customerPhone;
         $customerBirthday = date("Y-m-d", strtotime($customer->customerBirthday));
         
          // create connection
          $conn = new mysqli($sql_servername, $sql_username, $sql_password, $sql_dbname);
          // check connection
          if ($conn->connect_error) {
              die("<br>Connection failed: " . $conn->connect_error);
          }
          // set utf8
          if (!$conn->set_charset("utf8")) {
              printf("<br>Error loading character set utf8: %s\n", $conn->error);
          }
          $sql_write = "INSERT INTO obchod_customers (
             customerDegree,
             customerFirstName,
             customerLastName,
             customerAddressStreet,
             customerAddressCity,
             customerAddressZIP,
             customerEmail,
             customerPhone,
             customerBirthday
             )
          VALUES (
             '$customerDegree',
             '$customerFirstName',
              '$customerLastName',
              '$customerAddressStreet',
              '$customerAddressCity',
              '$customerAddressZIP',
              '$customerEmail',
              '$customerPhone',
              '$customerBirthday'
            )";
          // write sql to database
          if ($conn->query($sql_write) === TRUE) {
              // echo ok
             echo "Zákazník (" . $customerFirstName . " " . $customerLastName . ") přidán";
            
  
          } else {
              // write info about error
              echo "Error: " . $sql_write . ":" . $conn->error;
          }
          // close connection
          $conn->close();
         
         
         
    } else {
      // error in thid file
      $result = "INVALID REQUEST DATA";
    }
    echo $result;
  } else {
    // echo empty variables
    echo "Prázndý záznam";
  }
?>
