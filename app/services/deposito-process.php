<?php

session_start();

if (isset($_SESSION["request"])) {
   
   // includes
   include_once $_SERVER["DOCUMENT_ROOT"] . "/app/configs/koneksi.php";
   include_once $_SERVER["DOCUMENT_ROOT"] . "/app/helpers/functions.php";
   
   // ambil data dari session
   $userId = $_SESSION["loginSuccess"];
   
   // ambil data dari database
   $user = getDataFromDatabase($usersDb, "SELECT * FROM users WHERE id = $userId");
   
   $amountInput = $_POST["amountInput"] ?? "";
   
   if ($amountInput !== "") {
      if (!str_contains($amountInput, "'")) {
         if (ctype_digit($amountInput)) {
            if ($amountInput >= 10000) {
               if ($amountInput <= 1000000) {
                  
                  $userId = $userId;
                  $name = $user[0]["name"];
                  $phone = $user[0]["phone"];
                  $depositoId = generateRandomCode("all", 10);
                  $amount = $amountInput;
                  $time = getTimeNow("all");
                  
                  if (addDataToDatabase($depositoDb, "INSERT INTO deposito (user_id, name, phone, deposito_id, amount, time) VALUES ('$userId', '$name', '$phone', '$depositoId', $amount, '$time')")) {
                     unset($_SESSION["request"]);
                     unset($_SESSION["depositoError"]);
                     header("location:/public/transaksi/detail-deposit.php?id=$depositoId");
                     exit;
                  } else {
                     $_SESSION["depositoError"] = "Terjadi kesalahan.";
                  }
                  
               } else {
                  $_SESSION["depositoError"] = "Maksimal deposit adalah 1.000.000";
               }
            } else {
               $_SESSION["depositoError"] = "Minimal deposit adalah 10.000";
            }
         }
      }
   }
   
}

header("location:/public/deposit.php");