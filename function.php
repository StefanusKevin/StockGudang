<?php

session_start();

//membuat koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "stockbarang");

if ($conn) {
    // echo 'berhasil';
}

//===========================================tambah/input funtion================================================================

//menambah barang baru
if (isset($_POST['addstock'])) {
    $codebarang = $_POST['kodebarang'];
    $namabarang = $_POST['namabarang'];
    $spesifikasi = $_POST['spesifikasi'];
    $partnumber = $_POST['partnumber'];
    // $stock = $_POST['stock'];
    $satuan = $_POST['satuan'];
    $minstock = $_POST['minstock'];
    $posisi = $_POST['posisi'];
    $tipe = $_POST['tipe'];
    $keterangan = $_POST['keterangan'];

    // //soal gambar
    // $allowed_extension = array('png','jpg');
    // $nama = $_FILES['file']['name']; //ngambil nama gambar
    // $dot = explode('.',$nama);
    // $ekstensi = strtolower(end($dot)); //ngambil ekstensi
    // $ukuran = $_FILES['file']['size']; //ngambil size filenya
    // $file_tmp = $_FILES['file']['tmp_name']; //ngambil lokasi filenya

    // //penamaan file -> enkripsi
    // $image = md5(uniqid($nama,true) . time()).'.'.$ekstensi; //menggabungkan nama file yang dienkripsi dengan ekstensinya

    //validasi udah ada atau belum
    $cekbarang = mysqli_query($conn, "select * from stock where kodebarang='$codebarang'");
    $hitung = mysqli_num_rows($cekbarang);

    $addtotable = mysqli_query($conn, "insert into stock(kodebarang, namabarang, spesifikasi, partnumber, satuan, minstock, posisi, tipe, keterangan) 
    values('$codebarang', '$namabarang', '$spesifikasi', '$partnumber', '$satuan','$minstock','$posisi','$tipe','$keterangan')");
    if ($addtotable) {
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }

    // if ($hitung < 1) {
    //     //jika belum ada
    //     //proses upload gambar
    //     // if(in_array($ekstensi, $allowed_extension) === true){
    //     //validasi ukuran file
    //     if ($ukuran < 20000000) {
    //         move_uploaded_file($file_tmp, 'images/' . $image);
    //         $addtotable = mysqli_query($conn, "insert into stock(kodebarang, namabarang, spesifikasi, stock, satuan, lokasi) values('$codebarang', '$namabarang', '$spesifikasi', '$stock','$satuan','$lokasi')");
    //         if ($addtotable) {
    //             header('location:index.php');
    //         } else {
    //             echo 'Gagal';
    //             header('location:index.php');
    //         }
    //     } else {
    //         //jika file lebih dari 20mb
    //         echo '
    //             <script>
    //                 alert("Ukuran file tidak boleh lebih dari 20mb");
    //                 window.location.href="index.php";
    //             </script>
    //             ';
    //     }
    //     }else{
    //         //jika gambar bukan jpg/png
    //         echo '
    //         <script>
    //             alert("file yang diupload bukan png/jpg");
    //             window.location.href="index.php";
    //         </script>
    //         ';
    //     }

    // } else {
    //     //jika sudah ada
    //     echo '
    //     <script>
    //         alert("Barang sudah terdaftar");
    //         window.location.href="index.php";
    //     </script>
    //     ';
    // }
}

//menambah barang masuk
if (isset($_POST['addnewstock'])) {
    $barang = $_POST['barang'];
    $spesifikasi = $_POST['spesifikasi'];
    $partnumber = $_POST['partnumber'];
    $qty = $_POST['qty'];
    $satuan = $_POST['satuan'];
    $asalbarang = $_POST['asalbarang'];
    $harga = $_POST['harga'];
    $keterangan = $_POST['keterangan'];

    $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang='$barang'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganqty = $stocksekarang + $qty;

    $addtomasuk = mysqli_query($conn, "insert into masuk(idbarang, spesifikasi, partnumber, qty, satuan, asalbarang, harga, keterangan) 
    values('$barang', '$spesifikasi', '$partnumber', '$qty', '$satuan', '$asalbarang', '$harga', '$keterangan')");
    $updatestockmasuk = mysqli_query($conn, "update stock set stock= '$tambahkanstocksekarangdenganqty' where idbarang='$barang'");
    if ($addtomasuk && $updatestockmasuk) {
        header('location:masuk.php');
    } else {
        echo 'Gagal';
        header('location:masuk.php');
    }
}


//mengurangi barang keluar
if (isset($_POST['subtractstock'])) {
    $barang = $_POST['barang'];
    $spesifikasi = $_POST['spesifikasi'];
    $partnumber = $_POST['partnumber'];
    $qty = $_POST['qty']; 
    $satuan = $_POST['satuan'];
    $harga = $_POST['harga'];
    $lokasi = $_POST['lokasi'];
    $namapenerima = $_POST['namapenerima'];
    $divisi = $_POST['divisi'];
    $keterangan = $_POST['keterangan'];

    $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang='$barang'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    if ($stocksekarang >= $qty) {
        //jika stock memadai
        $tambahkanstocksekarangdenganqty = $stocksekarang - $qty;

        $addtokeluar = mysqli_query($conn, "insert into keluar(idbarang, spesifikasi, partnumber, qty, satuan, harga, lokasi, namapenerima, divisi, keterangan) 
        values('$barang', '$spesifikasi', '$partnumber' , '$qty', '$satuan', '$harga', '$lokasi', '$namapenerima', '$divisi', '$keterangan')");
        $updatestockmasuk = mysqli_query($conn, "update stock set stock= '$tambahkanstocksekarangdenganqty' where idbarang='$barang'");
        if ($addtokeluar && $updatestockmasuk) {
            header('location:keluar.php');
        } else {
            echo 'Gagal';
            header('location:keluar.php');
        }
    } else {
        //jika barang tidak cukup
        echo '
        <script>
            alert("stock saat ini tidak mencukupi");
            window.location.href="keluar.php";
        </script>
        ';
    }
}

//===========================================update && hapus funtion================================================================

//update info barang stock
if (isset($_POST['updatestock'])) {
    $idb = $_POST['idb'];
    $codebarang = $_POST['kodebarang'];
    $namabarang = $_POST['namabarang'];
    $spesifikasi = $_POST['spesifikasi'];
    $partnumber = $_POST['partnumber'];
    $posisi = $_POST['posisi'];
    $keterangan = $_POST['keterangan'];

    $update = mysqli_query($conn, "update stock set kodebarang='$codebarang', namabarang='$namabarang', spesifikasi='$spesifikasi', partnumber='$partnumber', posisi='$posisi', keterangan='$keterangan' where idbarang = '$idb'");
    if ($update) {
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }

    // //soal gambar
    // $allowed_extension = array('png','jpg');
    // $nama = $_FILES['file']['name']; //ngambil nama gambar
    // $dot = explode('.',$nama);
    // $ekstensi = strtolower(end($dot)); //ngambil ekstensi
    // $ukuran = $_FILES['file']['size']; //ngambil size filenya
    // $file_tmp = $_FILES['file']['tmp_name']; //ngambil lokasi filenya

    // //penamaan file -> enkripsi
    // $image = md5(uniqid($nama,true) . time()).'.'.$ekstensi; //menggabungkan nama file yang dienkripsi dengan ekstensinya

    // if($ukuran==0){
    //     jika tidak ingin upload

    // }else{
    //     //jika ingin upload
    //     // move_uploaded_file($file_tmp, 'images/'.$image); 
    //     $update = mysqli_query($conn,"update stock set kodebarang='$codebarang', namabarang='$namabarang', spesifikasi='$spesifikasi', lokasi='$lokasi', where idbarang = '$idb'");
    //     if($update){
    //         header('location:index.php');
    //     }else{
    //         echo 'Gagal';
    //         header('location:index.php');
    //     }
    // }
}


//menghapus barang stock
if (isset($_POST['hapusstock'])) {
    $idb = $_POST['idb']; //idbarang

    $gambar = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $get = mysqli_fetch_array($gambar);
    $img = 'images/' . $get['images'];
    unlink($img);

    $hapus = mysqli_query($conn, "delete from stock where idbarang = '$idb'");
    if ($hapus) {
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
}


//update info barang masuk
if (isset($_POST['updatemasuk'])) {
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrng = $stocknya['stock'];

    $qtyskrng = mysqli_query($conn, "select * from masuk where idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrng);
    $qtyskrng = $qtynya['QTY'];

    if ($qty > $qtyskrng) {
        $selisih = $qty - $qtyskrng;
        $kurangin = $stockskrng + $selisih;
        $kuranginstocknya = mysqli_query($conn, "update stock set stock = '$kurangin' where idbarang ='$idb'");
        $update = mysqli_query($conn, "update masuk set QTY ='$qty', penerima='$penerima' where idmasuk ='$idm'");
        if ($kuranginstocknya && $updatenya) {
            header('location:masuk.php');
        } else {
            echo 'Gagal';
            header('location:masuk.php');
        }
    } else {
        $selisih = $qtyskrng - $qty;
        $kurangin = $stockskrng - $selisih;
        $kuranginstocknya = mysqli_query($conn, "update stock set stock = '$kurangin' where idbarang='$idb'");
        $update = mysqli_query($conn, "update masuk set QTY='$qty', penerima='$penerima' where idmasuk = '$idm'");
        if ($kuranginstocknya && $updatenya) {
            header('location:masuk.php');
        } else {
            echo 'Gagal';
            header('location:masuk.php');
        }
    }
}

//menghapus barang masuk
if (isset($_POST['hapusmasuk'])) {
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $qty = $_POST['kty'];

    $getdatastock = mysqli_query($conn, "select * from stock where idbarang= '$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih = $stock - $qty;

    $update = mysqli_query($conn, "update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "delete from masuk where idmasuk= '$idm'");
    if ($update && $hapusdata) {
        header('location:masuk.php');
    } else {
        echo 'Gagal';
        header('location:masuk.php');
    }
}


//update info barang keluar
if (isset($_POST['updatekeluar'])) {
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $pengirim = $_POST['pengirim'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrng = $stocknya['stock'];

    $qtyskrng = mysqli_query($conn, "select * from keluar where idkeluar='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrng);
    $qtyskrng = $qtynya['QTY'];

    if ($qty > $qtyskrng) {
        $selisih = $qty - $qtyskrng;
        $kurangin = $stockskrng - $selisih;
        $kuranginstocknya = mysqli_query($conn, "update stock set stock = '$kurangin' where idbarang ='$idb'");
        $update = mysqli_query($conn, "update keluar set QTY ='$qty', pengirim='$pengirim' where idkeluar ='$idk'");
        if ($kuranginstocknya && $updatenya) {
            header('location:keluar.php');
        } else {
            echo 'Gagal';
            header('location:keluar.php');
        }
    } else {
        $selisih = $qtyskrng - $qty;
        $kurangin = $stockskrng + $selisih;
        $kuranginstocknya = mysqli_query($conn, "update stock set stock = '$kurangin' where idbarang='$idb'");
        $update = mysqli_query($conn, "update keluar set QTY='$qty', pengirim='$pengirim' where idkeluar = '$idk'");
        if ($kuranginstocknya && $updatenya) {
            header('location:keluar.php');
        } else {
            echo 'Gagal';
            header('location:keluar.php');
        }
    }
}


//menghapus barang keluar
if (isset($_POST['hapuskeluar'])) {
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $qty = $_POST['kty'];

    $getdatastock = mysqli_query($conn, "select * from stock where idbarang= '$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih = $stock + $qty;

    $update = mysqli_query($conn, "update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "delete from keluar where idkeluar= '$idk'");
    if ($update && $hapusdata) {
        header('location:keluar.php');
    } else {
        echo 'Gagal';
        header('location:keluar.php');
    }
}


//menambah admin baru
if (isset($_POST['addadmin'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $queryinsert = mysqli_query($conn, "insert into login (username, email, password)  values ('$username','$email','$password')");

    if ($queryinsert) {
        //if berhasil
        header('location:admin.php');
    } else {
        //gagal insert ke db
        header('location:admin.php');
    }
}

//update admin
if (isset($_POST['updateadmin'])) {
    $usernamebaru = $_POST['usernamebaru'];
    $emailbaru = $_POST['emailbaru'];
    $passwordbaru = $_POST['passwordbaru'];
    $idnya = $_POST['id'];


    $queryupdate = mysqli_query($conn, "update login set username='$usernamebaru', email='$emailbaru', password='$passwordbaru' where iduser='$idnya'");

    if ($queryupdate) {
        //if berhasil
        header('location:admin.php');
    } else {
        //gagal insert ke db
        header('location:admin.php');
    }
}

//hapus admin
if (isset($_POST['hapusadmin'])) {
    $idu = $_POST['id'];


    $querydelete = mysqli_query($conn, "delete from login where iduser='$idu'");

    if ($querydelete) {
        //if berhasil
        header('location:admin.php');
    } else {
        //gagal insert ke db
        header('location:admin.php');
    }
}
