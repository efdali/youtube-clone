<?php

session_start();

// sessionları siliyoruz
session_destroy();

// anasayfaya yönlendiriyoruz
header("Location:index.php");