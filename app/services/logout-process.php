<?php

session_start();

session_destroy();
session_unset();

header("location:/public/auth/masuk.php");