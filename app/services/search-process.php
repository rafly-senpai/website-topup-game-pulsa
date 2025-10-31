<?php

session_start();

if (isset($_SESSION["request"])) {
   
   // includes
   include_once $_SERVER["DOCUMENT_ROOT"] . "/app/configs/koneksi.php";
   include_once $_SERVER["DOCUMENT_ROOT"] . "/app/helpers/functions.php";
   
   $searchInput = $_POST["searchInput"] ?? "";
   
   if ($searchInput !== "") {
      if (!str_contains($searchInput, "'")) {
         $searchResults = getDataFromDatabase($productsDb, "SELECT * FROM products WHERE name LIKE '%$searchInput%'");
         $_SESSION["searchResults"] = $searchResults;
      }
   }
   
}

header("location:/public/beranda.php");