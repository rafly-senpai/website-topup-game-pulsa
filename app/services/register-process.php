<?php

session_start();

if (isset($_SESSION["request"])) {
   
   // includes
   include_once $_SERVER["DOCUMENT_ROOT"] . "/app/configs/koneksi.php";
   include_once $_SERVER["DOCUMENT_ROOT"] . "/app/helpers/functions.php";
   
   $nameInput = $_POST["nameInput"] ?? "";
   $phoneInput = $_POST["phoneInput"] ?? "";
   $passwordInput = $_POST["passwordInput"] ?? "";
   
   if ($nameInput !== "" && $phoneInput !== "" && $passwordInput !== "") {
      if (!str_contains($nameInput, "'") && !str_contains($phoneInput, "'") && !str_contains($passwordInput, "'")) {
         if (preg_match("/^08[0-9]{10,11}$/", $phoneInput)) {
            $user = getDataFromDatabase($usersDb, "SELECT * FROM users WHERE phone = '$phoneInput'");
            if (empty($user)) {
               $name = $nameInput;
               $phone = $phoneInput;
               $password = $passwordInput;
               $balance = 0;
               $createdAt = getTimeNow("all");
               if (addDataToDatabase($usersDb, "INSERT INTO users (name, phone, password, balance, created_at) VALUES ('$name', '$phone', '$password', $balance, '$createdAt')")) {
                  unset($_SESSION["request"]);
                  unset($_SESSION["registerError"]);
                  header("location:/public/auth/masuk.php");
                  exit;
               } else {
                  $_SESSION["registerError"] = "Terjadi kesalahan.";
               }
            } else {
               $_SESSION["registerError"] = "Nomor hp sudah terdaftar.";
            }
         } else {
            $_SESSION["registerError"] = "Nomor hp yang kamu masukkan tidak valid.";
         }
      }
   }
   
}

header("location:/public/auth/daftar.php");