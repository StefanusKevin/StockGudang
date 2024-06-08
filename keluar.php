<?php
require 'function.php';
require 'check.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Barang Keluar</title>
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

        .icon {
            width: 15px;
            padding: 1px;
        }
    </style>

</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <a class="navbar-brand" href="index.php">Karunia Adiguna Teknik</a>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Stock Barang
                        </a>
                        <a class="nav-link" href="masuk.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Barang Masuk
                        </a>
                        <a class="nav-link" href="keluar.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Barang Keluar
                        </a>
                        <a class="nav-link" href="admin.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Kelola Admin
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
                    <h1 class="mt-4">Barang Keluar</h1>
                    <!-- <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Stock Barang</li>
                        </ol> -->

                    <div class="card mb-4">
                    <div class="card-header">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                Input
                            </button>
                            <a href="export masuk.php" class="btn btn-info">Export Data </a>
                            <div class="row mt-4">
                                <div class="col">
                                    <form method="post" class="form-inline">
                                        <input type="date" name="tgl_alfa" class="form-control">
                                        <input type="date" name="tgl_omega" class="form-control ml-3">
                                        <button type="submit" name="filter_tgl" class="btn-btn-info ml-3">Filter</button>
                                    </form>
                                </div>
                            </div>
                            <!-- <i class="fas fa-table mr-1"></i>
                                DataTable Example -->
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <!-- <th>Gambar</th> -->
                                            <th>Nama Barang</th>
                                            <th>Spesifikasi</th>
                                            <th>Part Number</th>
                                            <th>Jumlah</th>
                                            <th>Satuan</th>
                                            <th>Harga</th>
                                            <th>Lokasi</th>
                                            <th>Nama Penerima</th>
                                            <th>Divisi</th>
                                            <th>Keterangan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php
                                        if (isset($_POST['filter_tgl'])) {
                                            $alfa = $_POST['tgl_alfa'];
                                            $omega = $_POST['tgl_omega'];
                                            print_r($alfa);
                                            print_r($omega);

                                            if ($alfa != null || $omega != null) {
                                                $ambilsemuadatastock = mysqli_query($conn, "select * from keluar k, stock s where s.idbarang = k.idbarang and tanggal BETWEEN
                                                '$alfa' and DATE_ADD('$omega', INTERVAL 1 DAY)");
                                            } else {
                                                $ambilsemuadatastock = mysqli_query($conn, "select * from keluar k, stock s where s.idbarang = k.idbarang");
                                            }
                                        } else {
                                            $ambilsemuadatastock = mysqli_query($conn, "select * from keluar k, stock s where s.idbarang = k.idbarang");
                                        }

                                        // $ambilsemuadatastock = mysqli_query($conn, "select * from keluar k, stock s where s.idbarang = k.idbarang");
                                        while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                                            $idb = $data['idbarang'];
                                            $idk = $data['idkeluar'];
                                            $tanggal = $data['tanggal'];
                                            $namabarang = $data['namabarang'];
                                            $spesifikasi = $data['spesifikasi'];
                                            $partnumber = $data['partnumber'];
                                            $qty = $data['QTY'];
                                            $satuan = $data['satuan'];
                                            $harga = $data['harga'];
                                            $namapenerima = $data['namapenerima'];
                                            $divisi = $data['divisi'];
                                            $lokasi = $data['lokasi'];
                                            $keterangan = $data['keterangan'];

                                            // //cek gambar ada/tidak
                                            // $image = $data['image']; //ambilgambar
                                            // if($image==null){
                                            //     //jika tidak ada gambar
                                            //     $img= 'No Photo';
                                            // }else{
                                            //     //jika ada gambar
                                            //     $img= '<img src="images/'.$image.'" class="zoomable">';
                                            // }

                                        ?>

                                            <tr>
                                                <td><?= $tanggal; ?></td>
                                                <!-- <td><?= $img; ?></td> -->
                                                <td><?= $namabarang; ?></td>
                                                <td><?= $spesifikasi; ?></td>
                                                <td><?= $partnumber; ?></td>
                                                <td><?= $qty; ?></td>
                                                <td><?= $satuan; ?></td>
                                                <td><?= $harga; ?></td>
                                                <td><?= $lokasi; ?></td>
                                                <td><?= $namapenerima; ?></td>
                                                <td><?= $divisi; ?></td>
                                                <td><?= $keterangan; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?= $idk; ?>">
                                                        <img class="icon" src="images/editor.png" class="zoomable">
                                                    </button>
                                                    <input type="hidden" name="idbarangyangdihapus" value="<?= $idb; ?>">
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $idk; ?>">
                                                        <img class="icon" src="images/delete_vector.png" class="zoomable" width="15px">
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?= $idk; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Update Barang</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <!-- Modal body -->
                                                        <form method="post">
                                                            <div class="modal-body">
                                                                <input type="text" name="namabarang" value=<?= $namabarang; ?> class="form-control" required>
                                                                <br>
                                                                <input type="text" name="spesifikasi" value=<?= $spesifikasi; ?> class="form-control">
                                                                <br>
                                                                <input type="number" name="qty" value=<?= $qty; ?> class="form-control" required>
                                                                <br>
                                                                <input type="text" name="satuan" value=<?= $satuan; ?> class="form-control">
                                                                <br>
                                                                <input type="number" name="harga" value=<?= $harga; ?> class="form-control">
                                                                <br>
                                                                <input type="text" name="lokasi" value=<?= $lokasi; ?> class="form-control" required>
                                                                <br>
                                                                <input type="text" name="namapenerima" value=<?= $namapenerima; ?> class="form-control" required>
                                                                <br>
                                                                <input type="text" name="divisi" value=<?= $divisi; ?> class="form-control" required>
                                                                <br>
                                                                <input type="text" name="keterangan" value=<?= $keterangan; ?> class="form-control" required>
                                                                <br>
                                                                <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                                <input type="hidden" name="idk" value="<?= $idk; ?>">

                                                                <button type="submit" class="btn btn-warning" name="updatekeluar">Confirm</button>
                                                            </div>
                                                        </form>

                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="delete<?= $idk; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Barang</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <!-- Modal body -->
                                                        <form method="post">
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin menghapus <?= $namabarang; ?> ?
                                                                <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                                <input type="hidden" name="kty" value="<?= $qty; ?>">
                                                                <input type="hidden" name="idk" value="<?= $idk; ?>">
                                                                <br>
                                                                <br>
                                                                <button type="submit" class="btn btn-danger" name="hapuskeluar">Hapus</button>
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>

                                        <?php
                                        }
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
                <h4 class="modal-title">Tambah Barang Keluar</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <form method="post">
                <div class="modal-body">

                    <select name="barang" class="form-control">
                        <?php
                        $ambilsemuadata = mysqli_query($conn, "select * from stock");
                        while ($fetcharray = mysqli_fetch_array($ambilsemuadata)) {
                            $tampilnamabarang = $fetcharray['namabarang'];
                            $tampilidbarang = $fetcharray['idbarang'];

                        ?>
                            <option value="<?= $tampilidbarang; ?>"><?= $tampilnamabarang; ?></option>

                        <?php
                        }
                        ?>
                    </select>
                    <br>
                    <input type="text" name="spesifikasi" placeholder="Spesifikasi" class="form-control" required>
                    <br>
                    <input type="text" name="partnumber" placeholder="Part Number" class="form-control" required>
                    <br>
                    <input type="number" name="qty" placeholder="Quantity" class="form-control" required>
                    <br>
                    <input type="text" name="satuan" placeholder="Satuan" class="form-control" required>
                    <br>
                    <input type="number" name="harga" placeholder="Harga" class="form-control" required>
                    <br>
                    <input type="text" name="lokasi" placeholder="Lokasi" class="form-control" required>
                    <br>
                    <input type="text" name="namapenerima" placeholder="Nama Penerima" class="form-control" required>
                    <br>
                    <input type="text" name="divisi" placeholder="Divisi" class="form-control" required>
                    <br>
                    <input type="text" name="keterangan" placeholder="Keterangan" class="form-control" required>
                    <br>
                    <button type="submit" class="btn btn-primary" name="subtractstock">Submit</button>
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