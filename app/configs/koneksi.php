<?php

$usersDb = new PDO("sqlite:" . $_SERVER["DOCUMENT_ROOT"] . "/databases/users.db");
$productsDb = new PDO("sqlite:" . $_SERVER["DOCUMENT_ROOT"] . "/databases/products.db");
$itemsDb = new PDO("sqlite:" . $_SERVER["DOCUMENT_ROOT"] . "/databases/items.db");
$transactionsDb = new PDO("sqlite:" . $_SERVER["DOCUMENT_ROOT"] . "/databases/transactions.db");
$informationsDb = new PDO("sqlite:" . $_SERVER["DOCUMENT_ROOT"] . "/databases/informations.db");
$depositoDb = new PDO("sqlite:" . $_SERVER["DOCUMENT_ROOT"] . "/databases/deposito.db");
$withdrawalDb = new PDO("sqlite:" . $_SERVER["DOCUMENT_ROOT"] . "/databases/withdrawal.db");