<?php

// tambah data ke database
function addDataToDatabase($database, $query) {
   $add = $database->exec($query);
   if ($add) {
      return true;
   }
}

// ambil data dari database
function getDataFromDatabase($database, $query) {
   $get = $database->query($query);
   $results = $get->fetchAll(PDO::FETCH_ASSOC);
   return $results;
}

// ubah data di database
function updateDataInDatabase($database, $query) {
   $update = $database->exec($query);
   if ($update) {
      return true;
   }
}

// ambil data waktu saat ini
function getTimeNow($type) {
   date_default_timezone_set("Asia/Jakarta");
   if ($type === "all") {
      return date("d/m/Y - H:i");
   }
}

// membuat kode acak
function generateRandomCode($type, $length) {
   $materials = [
      "letter" => "ABCDEFGHIJKLMNOPQRSTUVWXYZ",
      "number" => "0123456789",
      "all" => "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"
   ];
   
   if ($length >= 1) {
      $code = "";
      if ($type === "letter") {
         for ($i = 1; $i <= $length; $i++) {
            $randomIndex = rand(0, strlen($materials["letter"]) - 1);
            $code .= $materials["letter"][$randomIndex];
         }
         return $code;
      } elseif ($type === "number") {
         for ($i = 1; $i <= $length; $i++) {
            $randomIndex = rand(0, strlen($materials["number"]) - 1);
            $code .= $materials["number"][$randomIndex];
         }
         return $code;
      } elseif ($type === "all") {
         for ($i = 1; $i <= $length; $i++) {
            $randomIndex = rand(0, strlen($materials["all"]) - 1);
            $code .= $materials["all"][$randomIndex];
         }
         return $code;
      } else {
         return "Invalid character type.";
      }
   } else {
      return "The minimum code length is 1";
   }
}