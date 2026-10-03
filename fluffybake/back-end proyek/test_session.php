<?php
session_start();
$_SESSION['test'] = "Session aktif!";
echo $_SESSION['test'];
