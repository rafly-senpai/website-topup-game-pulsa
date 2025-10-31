<?php

// cek user sudah login atau belum
if (isset($_SESSION["loginSuccess"])) {
   header("location:/public/beranda.php");
   exit;
}

header("location:/public/auth/masuk.php");