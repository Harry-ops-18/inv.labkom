<?php
session_start();

// pengoneksian ke db
$conn = mysqli_connect("localhost","root","","sarpras_mas");

//add new barang
if(isset($_POST['addnewbarang'])){
    $namabarang = $_POST['namabarang'];
    $desk = $_POST['desk'];
    $stock = $_POST['stock'];

    $addtotbl = mysqli_query($conn, "insert into barang (namabarang, desk, stock) values('$namabarang', '$desk', '$stock')");
    if($addtotbl){
        header("location:index.php");
    } else {
        echo 'Gagal!';
        header('location:index.php');
    }        
};

// add barang masuk
if(isset($_POST['barangmasuk'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocknow = mysqli_query($conn, "select * from barang where idbarang='$barangnya'");
    $fetchdatanya = mysqli_fetch_array($cekstocknow);

    $stocknow = $fetchdatanya['stock'];
    $addstocknowqty= $stocknow+$qty;

    $addtoin = mysqli_query($conn, "insert into barang_masuk (idbarang, ket, qty) values('$barangnya', '$penerima', '$qty')");
    $updatestockin = mysqli_query($conn, "update barang set stock='$addstocknowqty' where idbarang='$barangnya'");
    if($addtoin&&$updatestockin){
        header("location:masuk.php");
    } else {
        echo 'Gagal!';
        header('location:masuk.php');
    }      
};

// add barang keluar
if(isset($_POST['addbarangout'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocknow = mysqli_query($conn, "select * from barang where idbarang='$barangnya'");
    $fetchdatanya = mysqli_fetch_array($cekstocknow);

    $stocknow = $fetchdatanya['stock'];
    $addstocknowqty= $stocknow-$qty;

    $addtoin = mysqli_query($conn, "insert into keluar (idbarang, ket, qty) values('$barangnya', '$penerima', '$qty')");
    $updatestockin = mysqli_query($conn, "update barang set stock='$addstocknowqty' where idbarang='$barangnya'");
    if($addtoin&&$updatestockin){
        header("location:keluar.php");
    } else {
        echo 'Gagal!';
        header('location:keluar.php');
    }      
};

// Update and delete info barang
if(isset($_POST['updatebarang'])){
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $desk = $_POST['desk'];

    $update = mysqli_query($conn, "update barang set namabarang='$namabarang', desk='$desk' where idbarang='$idb'");
    if($update){
        header("location:index.php");
    } else {
        echo 'Gagal!';
        header('location:index.php');      
    }
};

if(isset($_POST['hapus'])){
    $idb = $_POST['idb'];

    $delete = mysqli_query($conn, "delete from barang where idbarang='$idb'");
    if($delete){
        header("location:index.php");
    } else {
        echo 'Gagal!';
        header('location:index.php');      
    }
};

// Update and delete info barang masuk
if(isset($_POST['updatein'])){
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $ket = $_POST['ket'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "select * from barang where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stocknow = $stocknya['stock'];

    $lihatqty = mysqli_query($conn, "select * from barang_masuk where idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($lihatqty);
    $qtynow = $qtynya['qty'];

    if($qty>$qtynow){
        $selisih = $qty-$qtynow;
        $min = $stocknow+$selisih;
        $minstocknya = mysqli_query($conn, "update barang set stock='$min' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update barang_masuk set qty='$qty', ket='$ket' where idmasuk='$idm'");
            if($minstocknya&&$updatenya){
                header("location:masuk.php");
            } else {
                echo 'Gagal!';
                header('location:masuk.php');
            }
    } else {
        $selisih = $qtynow-$qty;
        $plus = $stocknow-$selisih;
        $plusstocknya = mysqli_query($conn, "update barang set stock='$plus' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update barang_masuk set qty='$qty', ket='$ket' where idmasuk='$idm'");
            if($plusstocknya&&$updatenya){
                header("location:masuk.php");
            } else {
                echo 'Gagal!';
                header('location:masuk.php');
            };
    };
};

if(isset($_POST['deletein'])){
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $qty = $_POST['qty'];

    $getdatastock = mysqli_query($conn, "select * from barang where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $datanow = $data['stock'];

    $selisih = $datanow-$qty;

    $update = mysqli_query($conn, "update barang set stock='$selisih' where idbarang='$idb'");
    $delete = mysqli_query($conn, "delete from barang_masuk where idmasuk='$idm'");
        if($update&&$delete){
            header("location:masuk.php");
        } else {
            echo 'Gagal!';
            header('location:masuk.php');
        };
};

// Update and delete info barang keluar
if(isset($_POST['updateout'])){
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $ket = $_POST['ket'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "select * from barang where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stocknow = $stocknya['stock'];

    $lihatqty = mysqli_query($conn, "select * from keluar where idkeluar='$idk'");
    $qtynya = mysqli_fetch_array($lihatqty);
    $qtynow = $qtynya['qty'];

    if($qty>$qtynow){
        $selisih = $qty-$qtynow;
        $min = $stocknow-$selisih;
        $minstocknya = mysqli_query($conn, "update barang set stock='$min' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update keluar set qty='$qty', ket='$ket' where idkeluar='$idk'");
            if($minstocknya&&$updatenya){
                header("location:keluar.php");
            } else {
                echo 'Gagal!';
                header('location:keluar.php');
            }
    } else {
        $selisih = $qtynow-$qty;
        $plus = $stocknow+$selisih;
        $plusstocknya = mysqli_query($conn, "update barang set stock='$plus' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update keluar set qty='$qty', ket='$ket' where idkeluar='$idk'");
            if($plusstocknya&&$updatenya){
                header("location:keluar.php");
            } else {
                echo 'Gagal!';
                header('location:keluar.php');
            };
    };
};

if(isset($_POST['deleteout'])){
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $qty = $_POST['qty'];

    $getdatastock = mysqli_query($conn, "select * from barang where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $datanow = $data['stock'];

    $selisih = $datanow+$qty;

    $update = mysqli_query($conn, "update barang set stock='$selisih' where idbarang='$idb'");
    $delete = mysqli_query($conn, "delete from keluar where idkeluar='$idk'");
        if($update&&$delete){
            header("location:keluar.php");
        } else {
            echo 'Gagal!';
            header('location:keluar.php');
        };
};

?>