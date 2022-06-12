<?php
//Cek belum login terlebih dahulu


if (isset($_SESSION['log'])) {
} else {
    header('location:login.php');
}
