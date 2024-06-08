<?php
require 'function.php';
require 'check.php';

//Dapetin ID barang yang dipassing dari halaman stock barang
$idbarang = $_GET['id']; //get id barang
//Get informasi barang berdasarkan database
$get = mysqli_query($conn, "select * from stock where idbarang = '$idbarang'");
$fetch = mysqli_fetch_assoc($get);
//set variable
$codebarang = $fetch['kodebarang'];
$namabarang = $fetch['namabarang'];
$spesifikasi = $fetch['spesifikasi'];
$partnumber = $fetch['partnumber'];
$stock = $fetch['stock'];
$satuan = $fetch['satuan'];
$posisi = $fetch['posisi'];
$tipe = $fetch['tipe'];
$keterangan = $fetch['keterangan'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Details Barang</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <style>
        .zoomable {
            width: 100px;
        }

        .zoomable:hover {
            transform: scale(2.5);
            transition: 0.3s ease;
        }

        a {
            text-decoration: none;
            color: black;
        }


        /* Style untuk modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>


</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <a class="navbar-brand" href="index.php"> <img src="images/Logo KAT.png" width="100px;">Karunia Adiguna Teknik</a>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Detail Barang
                        </a>
                        <a class="nav-link" href="masuk.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Barang Masuk
                        </a>
                        <a class="nav-link" href="keluar.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Barang Keluar
                        </a>

                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php
                    $ambildatalogin = mysqli_query($conn, "select * from login");
                    while ($data = mysqli_fetch_array($ambildatalogin)) {
                        $email = $data['username'];
                    }
                    ?>
                    <?= $email; ?>
                    <a class="nav-link" href="logout.php">
                        Logout
                    </a>
                </div>
            </nav>
        </div>


        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4"><strong><a href="index.php"><</a></strong>Details Barang</h1>

                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-2">Code Barang</div>
                                <div class="col-md-10">: <?= $codebarang; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">Nama Barang</div>
                                <div class="col-md-10">: <?= $namabarang; ?><?= $spesifikasi; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">Stock Barang</div>
                                <div class="col-md-10">: <?= $stock; ?><?= $satuan; ?></div>
                            </div>
                        </div>

                        <div class="card-body">
                            <h4>Barang Masuk</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Quantity</th>
                                            <th>Satuan</th>
                                            <th>Harga</th>
                                            <th>Asal Barang</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $ambildatamasuk = mysqli_query($conn, "select * from masuk where idbarang='$idbarang'");
                                        $i = 1;
                                        while ($fetch = mysqli_fetch_array($ambildatamasuk)) {
                                            $tanggal = $fetch['tanggal'];
                                            $qty = $fetch['QTY'];
                                            $satuan = $fetch['satuan'];
                                            $harga = $fetch['harga'];
                                            $asalbarang = $fetch['asalbarang'];
                                            $keterangan = $fetch['keterangan'];

                                        ?>

                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $tanggal; ?></td>
                                                <td><?= $qty; ?></td>
                                                <td><?= $satuan; ?></td>
                                                <td><?= $harga; ?></td>
                                                <td><?= $asalbarang; ?></td>
                                                <td><?= $keterangan; ?></td>
                                            </tr>

                                        <?php
                                        };

                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <h4>Barang Keluar</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Quantity</th>
                                            <th>Satuan</th>
                                            <th>Harga</th>
                                            <th>Lokasi</th>
                                            <th>Nama Penerima</th>
                                            <th>Divisi</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $ambildatakeluar = mysqli_query($conn, "select * from keluar where idbarang='$idbarang'");
                                        $i = 1;
                                        while ($fetch = mysqli_fetch_array($ambildatakeluar)) {
                                            $tanggal = $fetch['tanggal'];
                                            $qty = $fetch['QTY'];
                                            $satuan = $fetch['satuan'];
                                            $harga = $fetch['harga'];
                                            $lokasi = $fetch['lokasi'];
                                            $namapenerima = $fetch['namapenerima'];
                                            $divisi = $fetch['divisi'];
                                            $keterangan = $fetch['keterangan'];

                                        ?>

                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $tanggal; ?></td>
                                                <td><?= $qty; ?></td>
                                                <td><?= $satuan; ?></td>
                                                <td><?= $harga; ?></td>
                                                <td><?= $lokasi ?></td>
                                                <td><?= $namapenerima ?></td>
                                                <td><?= $divisi ?></td>
                                                <td><?= $keterangan; ?></td>
                                            </tr>

                                        <?php
                                        };

                                        ?>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>
            </main> 

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2020</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/datatables-demo.js"></script>


</body>

<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tambah Barang</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="text" name="kodebarang" placeholder="Kode Barang" class="form-control" required>
                    <br>
                    <input type="text" name="namabarang" placeholder="Nama Barang" class="form-control" required>
                    <br>
                    <input type="text" name="spesifikasi" placeholder="Spesifikasi Barang" class="form-control">
                    <br>
                    <input type="text" name="partnumber" placeholder="Part-Number" class="form-control">
                    <br>
                    <input type="text" name="satuan" placeholder="Satuan" class="form-control" required>
                    <br>
                    <input type="text" name="posisi" placeholder="Posisi" class="form-control" required>
                    <br>
                    <label for="kategori">Pilih Tipe:</label>
                    <select name="tipe" id="kategori">
                        <option value="Konsumable">Konsumable</option>
                        <option value="Aset">Aset</option>
                    </select>
                    <br>
                    <input type="text" name="keterangan" placeholder="Keterangan" class="form-control">
                    <br>
                    <!-- <input type="file" name="file" class="form-control"> -->
                    <button type="submit" class="btn btn-primary" name="addstock">Submit</button>
                </div>
            </form>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>

        </div>
    </div>
</div>

</html>