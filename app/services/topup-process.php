<?php

session_start();

if (isset($_SESSION["request"])) {
   
   // includes
   include_once $_SERVER["DOCUMENT_ROOT"] . "/app/configs/koneksi.php";
   include_once $_SERVER["DOCUMENT_ROOT"] . "/app/helpers/functions.php";
   
   $idInput = $_POST["idInput"] ?? "";
   $productIdInput = $_POST["productIdInput"] ?? "";
   $itemInput = $_POST["itemInput"] ?? "";
   $priceInput = $_POST["priceInput"] ?? "";
   
   // ambil data dari session
   $userId = $_SESSION["loginSuccess"];
   
   // ambil data dari database
   $user = getDataFromDatabase($usersDb, "SELECT * FROM users WHERE id = $userId");
   $product = getDataFromDatabase($productsDb, "SELECT * FROM products WHERE product_id = '$productIdInput'");
   
   if ($idInput !== "" && !str_contains($idInput, "'")) {
      if ($user[0]["balance"] >= $priceInput) {
         
         $newUserBalance = $user[0]["balance"] - $priceInput;
         if (updateDataInDatabase($usersDb, "UPDATE users SET balance = $newUserBalance WHERE id = $userId")) {
            
            $userId = $userId;
            $name = $user[0]["name"];
            $phone = $user[0]["phone"];
            $transactionId = generateRandomCode("all", 10);
            $product = $product[0]["name"];
            $item = $itemInput;
            $price = $priceInput;
            $to = $idInput;
            $time = getTimeNow("all");
            
            if (addDataToDatabase($transactionsDb, "INSERT INTO transactions (user_id, name, phone, transaction_id, product, item, price, 'to', time) VALUES ('$userId', '$name', '$phone', '$transactionId', '$product', '$item', $price, '$to', '$time')")) {
               unset($_SESSION["request"]);
               unset($_SESSION["topupError"]);
               header("location:/public/transaksi/detail-transaksi.php?id=$transactionId");
               exit;
            } else {
               $_SESSION["topupError"] = "Terjadi kesalahan.";
            }
            
         }
         
      } else {
         $_SESSION["topupError"] = "Saldo kamu tidak cukup.";
      }
   }
   
}

header("location:/public/topup.php?id=$productIdInput");