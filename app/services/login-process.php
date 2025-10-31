<?php

session_start();

if (isset($_SESSION["request"])) {
   
   // includes
   include_once $_SERVER["DOCUMENT_ROOT"] . "/app/configs/koneksi.php";
   include_once $_SERVER["DOCUMENT_ROOT"] . "/app/helpers/functions.php";
   
   $phoneInput = $_POST["phoneInput"] ?? "";
   $passwordInput = $_POST["passwordInput"] ?? "";
   
   if ($phoneInput !== "" && $passwordInput !== "") {
      if (!str_contains($phoneInput, "'") && !str_contains($passwordInput, "'")) {
         $user = getDataFromDatabase($usersDb, "SELECT * FROM users WHERE phone = '$phoneInput'");
         if (!empty($user)) {
            if ($phoneInput === $user[0]["phone"] && $passwordInput === $user[0]["password"]) {
               $_SESSION["loginSuccess"] = $user[0]["id"];
               unset($_SESSION["request"]);
               unset($_SESSION["loginError"]);
               header("location:/public/beranda.php");
               exit;
            } else {
               $_SESSION["loginError"] = "Nomor hp atau kata sandi salah.";
            }
         } else {
            $_SESSION["loginError"] = "Nomor hp tidak terdaftar.";
         }
      }
   }
   
}

header("location:/public/auth/masuk.php");