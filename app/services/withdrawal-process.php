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
                  $withdrawalId = generateRandomCode("all", 10);
                  $amount = $amountInput;
                  $time = getTimeNow("all");
                  
                  if (addDataToDatabase($withdrawalDb, "INSERT INTO withdrawal (user_id, name, phone, withdrawal_id, amount, time) VALUES ('$userId', '$name', '$phone', '$withdrawalId', $amount, '$time')")) {
                     unset($_SESSION["request"]);
                     unset($_SESSION["withdrawalError"]);
                     header("location:/public/transaksi/detail-penarikan.php?id=$withdrawalId");
                     exit;
                  } else {
                     $_SESSION["withdrawalError"] = "Terjadi kesalahan.";
                  }
                  
               } else {
                  $_SESSION["withdrawalError"] = "Maksimal penarikan adalah 1.000.000";
               }
            } else {
               $_SESSION["withdrawalError"] = "Minimal penarikan adalah 10.000";
            }
         }
      }
   }
   
}

header("location:/public/tarik-saldo.php");