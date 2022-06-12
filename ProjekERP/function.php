<?php
session_start();

// Koneksi ke Database
$conn = mysqli_connect('localhost', 'root', '', 'projekerp');

//HALAMAN PRODUK
//Tambah Stok Produk Baru
if (isset($_POST['submit'])) {
    $namaproduk = $_POST['namaproduk'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    $tambah = mysqli_query($conn, "INSERT INTO produk (namaproduk, stok, harga) VALUES ('$namaproduk', '$stok','$harga')");

    if ($tambah) {
        header('location:index.php');
    } else {
        header('location:index.php');
    }
}

//Edit Buku Baru
if (isset($_POST['edit'])) {
    $idp = $_POST['idp'];
    $namaproduk = $_POST['namaproduk'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    $edit = mysqli_query($conn, "UPDATE produk SET namaproduk='$namaproduk', stok='$stok', harga='$harga' WHERE idproduk='$idp'");
    if ($edit) {
        header('location:index.php');
    } else {
        header('location:index.php');
    }
}

//Delete Buku Baru
if (isset($_POST['delete'])) {
    $idp = $_POST['idp'];

    $delete = mysqli_query($conn, "DELETE FROM produk WHERE idproduk='$idp'");
    if ($edit) {
        header('location:index.php');
    } else {
        header('location:index.php');
    }
}

//HALAMAN STOK MASUK
//Tambah Stok Masuk
if (isset($_POST['stokmasuk'])) {
    $pilihproduk = $_POST['pilihproduk'];
    $jumlah = $_POST['jumlah'];

    $cekstokawal = mysqli_query($conn, "SELECT * FROM produk WHERE idproduk='$pilihproduk'");
    $ambildata = mysqli_fetch_array($cekstokawal);

    $stokawal = $ambildata['stok'];
    $tambahstokmasuk = $stokawal + $jumlah;

    $tambahmasuk = mysqli_query($conn, "INSERT INTO stokmasuk (idproduk, jumlah) VALUES ('$pilihproduk', '$jumlah')");
    $updatestokmasuk = mysqli_query($conn, "UPDATE produk set stok ='$tambahstokmasuk' WHERE idproduk='$pilihproduk'");

    if ($tambahmasuk && $updatestokmasuk) {
        header('location:stokmasuk.php');
    } else {
        header('location:stokmasuk.php');
    }
}

//Edit Buku Masuk
if (isset($_POST['editmasuk'])) {
    $idp = $_POST['idp'];
    $idm = $_POST['idm'];
    $jumlah = $_POST['jumlah'];

    $cekstokawal = mysqli_query($conn, "SELECT * FROM produk WHERE idproduk='$idp'");
    $ambilstok = mysqli_fetch_array($cekstokawal);
    $stokbuku = $ambilstok['stok'];

    $jmlawal = mysqli_query($conn, "SELECT * FROM stokmasuk WHERE idmasuk='$idm'");
    $ambiljml = mysqli_fetch_array($jmlawal);
    $jmlawal = $ambiljml['jumlah'];

    if ($jumlah > $jmlawal) {
        $selisih = $jumlah - $jmlawal;
        $kurang = $stokbuku + $selisih;
        $kurangstok = mysqli_query($conn, "UPDATE produk SET stok='$kurang' WHERE idproduk='$idp'");
        $edit = mysqli_query($conn, "UPDATE stokmasuk SET jumlah='$jumlah' WHERE idmasuk='$idm'");

        if ($kurangstok && $edit) {
            header('location:stokmasuk.php');
        } else {
            header('location:stokmasuk.php');
        }
    } else {
        $selisih = $jmlawal - $jumlah;
        $kurang = $stokbuku - $selisih;
        $kurangstok = mysqli_query($conn, "UPDATE produk SET stok='$kurang' WHERE idproduk='$idp'");
        $edit = mysqli_query($conn, "UPDATE stokmasuk SET jumlah='$jumlah' WHERE idmasuk='$idm'");

        if ($kurangstok && $edit) {
            header('location:stokmasuk.php');
        } else {
            header('location:stokmasuk.php');
        }
    }
}

//Delete Buku Masuk
if (isset($_POST['deletemasuk'])) {
    $idp = $_POST['idp'];
    $jml = $_POST['jml'];
    $idm = $_POST['idm'];

    $cekstokawal = mysqli_query($conn, "SELECT * FROM produk WHERE idproduk='$idp'");
    $ambilstok = mysqli_fetch_array($cekstokawal);
    $stokbuku = $ambilstok['stok'];

    $selisih = $stokbuku - $jml;

    $edit = mysqli_query($conn, "UPDATE produk SET stok='$selisih' WHERE idproduk='$idp'");
    $delete = mysqli_query($conn, "DELETE FROM stokmasuk WHERE idmasuk='$idm'");

    if ($edit && $delete) {
        header('location:stokmasuk.php');
    } else {
        header('location:stokmasuk.php');
    }
}

//HALAMAN STOK KELUAR
//Tambah Stok Buku Keluar
if (isset($_POST['stokkeluar'])) {
    $pilihproduk = $_POST['pilihproduk'];
    $penerima = $_POST['penerima'];
    $jumlah = $_POST['jumlah'];

    $cekstokawal = mysqli_query($conn, "SELECT * FROM produk WHERE idproduk='$pilihproduk'");
    $ambildata = mysqli_fetch_array($cekstokawal);

    $stokawal = $ambildata['stok'];
    $tambahstokkeluar = $stokawal - $jumlah;

    $tambahkeluar = mysqli_query($conn, "INSERT INTO stokkeluar (idproduk, penerima, jumlah) VALUES ('$pilihproduk', '$penerima', '$jumlah')");
    $updatestokkeluar = mysqli_query($conn, "UPDATE produk SET stok = '$tambahstokkeluar' WHERE idproduk='$pilihproduk'");

    if ($tambahkeluar && $updatestokkeluar) {
        header('location:stokkeluar.php');
    } else {
        header('location:stokkeluar.php');
    }
}


//Edit Stok Keluar
if (isset($_POST['editkeluar'])) {
    $idp = $_POST['idp'];
    $idk = $_POST['idk'];
    $penerima = $_POST['penerima'];
    $jumlah = $_POST['jumlah'];

    $cekstokawal = mysqli_query($conn, "SELECT * FROM produk WHERE idproduk='$idp'");
    $ambilstok = mysqli_fetch_array($cekstokawal);
    $stokbuku = $ambilstok['stok'];

    $jmlawal = mysqli_query($conn, "SELECT * FROM stokkeluar WHERE idkeluar='$idk'");
    $ambiljml = mysqli_fetch_array($jmlawal);
    $jmlawal = $ambiljml['jumlah'];

    if ($jumlah > $jmlawal) {
        $selisih = $jumlah - $jmlawal;
        $kurang = $stokbuku - $selisih;
        $kurangstok = mysqli_query($conn, "UPDATE produk SET stok='$kurang' WHERE idproduk='$idp'");
        $edit = mysqli_query($conn, "UPDATE stokkeluar SET jumlah='$jumlah', penerima='$penerima' WHERE idkeluar='$idk'");

        if ($kurangstok && $edit) {
            header('location:stokkeluar.php');
        } else {
            header('location:stokkeluar.php');
        }
    } else {
        $selisih = $jmlawal - $jumlah;
        $kurang = $stokbuku + $selisih;
        $kurangstok = mysqli_query($conn, "UPDATE produk SET stok='$kurang' WHERE idproduk='$idp'");
        $edit = mysqli_query($conn, "UPDATE stokkeluar SET jumlah='$jumlah', penerima='$penerima' WHERE idkeluar='$idk'");

        if ($kurangstok && $edit) {
            header('location:stokkeluar.php');
        } else {
            header('location:stokkeluar.php');
        }
    }
}

//Delete Buku Keluar
if (isset($_POST['deletekeluar'])) {
    $idp = $_POST['idp'];
    $jml = $_POST['jml'];
    $idk = $_POST['idk'];

    $cekstokawal = mysqli_query($conn, "SELECT * FROM produk WHERE idproduk='$idp'");
    $ambilstok = mysqli_fetch_array($cekstokawal);
    $stokbuku = $ambilstok['stok'];

    $selisih = $stokbuku + $jml;

    $edit = mysqli_query($conn, "UPDATE produk SET stok='$selisih' WHERE idproduk='$idp'");
    $delete = mysqli_query($conn, "DELETE FROM stokkeluar WHERE idkeluar='$idk'");

    if ($edit && $delete) {
        header('location:stokkeluar.php');
    } else {
        header('location:stokkeluar.php');
    }
}

//HALAMAN PENJUALAN
//Tambah Data Penjualan
if (isset($_POST['addpenjualan'])) {
    // $idp = $_POST['idp'];
    $customer = $_POST["customer"];
    $pilihproduk = $_POST['pilihproduk'];
    $jumlah = $_POST['jumlah'];
    // $tharga = $_POST['tharga'];
    $pilihsales = $_POST['pilihsales'];

    $cekharga = mysqli_query($conn, "SELECT * FROM produk WHERE idproduk='$pilihproduk'");
    $ambilharga = mysqli_fetch_array($cekharga);
    $hargaproduk = $ambilharga['harga'];

    $totalharga = $hargaproduk * $jumlah;

    $tambah = mysqli_query($conn, "INSERT INTO penjualan (idsales, idproduk, namacustomer, jumlah, totalharga) VALUES ('$pilihsales', '$pilihproduk','$customer', '$jumlah', '$totalharga')");

    if ($totalharga) {
        header('location:penjualan.php');
    } else {
        header('location:penjualan.php');
    }
}

//Edit Data Penjualan
if (isset($_POST['pedit'])) {
    $idpj = $_POST['idpj'];
    $pilihsales = $_POST['pilihsales'];
    $pilihproduk = $_POST['pilihproduk'];
    $customer = $_POST['customer'];

    $jumlah = $_POST['jumlah'];


    $cekharga = mysqli_query($conn, "SELECT * FROM produk WHERE idproduk='$pilihproduk'");
    $ambilharga = mysqli_fetch_array($cekharga);
    $hargaproduk = $ambilharga['harga'];

    $totalharga = $hargaproduk * $jumlah;

    $edit = mysqli_query($conn, "UPDATE penjualan SET idsales='$pilihsales', idproduk='$pilihproduk', namacustomer='$customer', jumlah='$jumlah', totalharga='$totalharga' WHERE idpenjualan='$idpj'");
    if ($edit) {
        header('location:penjualan.php');
    } else {
        header('location:penjualan.php');
    }
}

//Delete Data Penjualan
if (isset($_POST['pdelete'])) {
    $idpj = $_POST['idpj'];

    $delete = mysqli_query($conn, "DELETE FROM penjualan WHERE idpenjualan='$idpj'");
    if ($delete) {
        header('location:penjualan.php');
    } else {
        header('location:penjualan.php');
    }
}

//HALAMAN SALES
//Tambah Sales Baru
if (isset($_POST['addsales'])) {
    $namasales = $_POST['namasales'];
    $alamat = $_POST['alamat'];
    $nohp = $_POST['nohp'];

    $tambah = mysqli_query($conn, "INSERT INTO sales (namasales, alamat, nohp) VALUES ('$namasales', '$alamat','$nohp')");

    if ($tambah) {
        header('location:sales.php');
    } else {
        header('location:sales.php');
    }
}

//Edit Sales Baru
if (isset($_POST['sedit'])) {
    $ids = $_POST['ids'];
    $namasales = $_POST['namasales'];
    $alamat = $_POST['alamat'];
    $nohp = $_POST['nohp'];


    $edit = mysqli_query($conn, "UPDATE sales SET namasales='$namasales', alamat='$alamat', nohp='$nohp' WHERE idsales='$ids'");
    if ($edit) {
        header('location:sales.php');
    } else {
        header('location:sales.php');
    }
}

//Delete Sales Baru
if (isset($_POST['sdelete'])) {
    $ids = $_POST['ids'];

    $delete = mysqli_query($conn, "DELETE FROM sales WHERE idsales='$ids'");
    if ($delete) {
        header('location:sales.php');
    } else {
        header('location:sales.php');
    }
}
