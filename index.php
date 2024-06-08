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
    <title>Stock Gudang</title>
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

        .icon {
            width: 15px;
            padding: 1px;
        }
      


        /* Style untuk modal */
        /* .modal {
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
        } */
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
            <br>
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Stock Gudang</h1>

                    <div class="card mb-4">
                        <div class="card-header">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                Input
                            </button>
                            <a href="export.php" class="btn btn-info">Export Data </a>

                        
                            <!-- <button type="button" onclick="showModal()" class="btn btn-danger">Notifikasi</button> -->
                            <button type="button" data-toggle="modal" class="btn btn-danger" data-target="#notifModal">Notifikasi</button>

                            <script>
                                // Function untuk menampilkan modal
                                function showModal() {
                                    var modal = document.getElementById('myModal');
                                    modal.style.display = 'block';
                                }

                                // Function untuk menyembunyikan modal
                                function hideModal() {
                                    var modal = document.getElementById('myModal');
                                    modal.style.display = 'none';
                                }
                            </script>

                        </div>


                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Spesifikasi</th>
                                            <th>Part_Number</th>
                                            <th>Stock</th>
                                            <th>Satuan</th>
                                            <th>Posisi</th>
                                            <th>Tipe</th>
                                            <th>Keterangan</th>
                                            <!-- <th>Gambar</th> -->
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $ambilsemuadatastock = mysqli_query($conn, "select * from stock");
                                        $i = 1;
                                        while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                                            $codebarang = $data['kodebarang'];
                                            $namabarang = $data['namabarang'];
                                            $spesifikasi = $data['spesifikasi'];
                                            $partnumber = $data['partnumber'];
                                            $stock = $data['stock'];
                                            $satuan = $data['satuan'];
                                            $posisi = $data['posisi'];
                                            $tipe = $data['tipe'];
                                            $keterangan = $data['keterangan'];
                                            $idb = $data['idbarang'];

                                            
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
                                                <td><?= $i++; ?></td>
                                                <td><?= $codebarang; ?></td>
                                                <td><strong><a href="details.php?id=<?= $idb; ?>"><?= $namabarang; ?></a></strong></td>
                                                <td><?= $spesifikasi; ?></td>
                                                <td><?= $partnumber; ?></td>
                                                <td><?= $stock; ?></td>
                                                <td><?= $satuan; ?></td>
                                                <td><?= $posisi; ?></td>
                                                <td><?= $tipe; ?></td>
                                                <td><?= $keterangan; ?></td>
                                                <!-- <td><?= $img; ?></td> -->
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?= $idb; ?>">
                                                    <img class="icon" src="images/editor.png" class="zoomable" >
                                                    </button>
                                                    <input type="hidden" name="idbarangyangdihapus" value="<?= $idb; ?>">
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $idb; ?>">
                                                    <img class="icon" src="images/delete_vector.png" class="zoomable" width="15px">
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?= $idb; ?>">
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
                                                                <a>Code Barang : </a><input type="text" name="kodebarang" value=<?= $codebarang; ?> class="form-control" required>
                                                                <br>
                                                                <a>Nama Barang : </a><input type="text" name="namabarang" value=<?= $namabarang; ?> class="form-control" required>
                                                                <br>
                                                                <a>Spesifikasi : </a><input type="text" name="spesifikasi" value=<?= $spesifikasi; ?> class="form-control">
                                                                <br>
                                                                <a>Part Number : </a><input type="text" name="partnumber" value=<?= $partnumber; ?> class="form-control">
                                                                <br>
                                                                <a>Posisi : </a><input type="text" name="posisi" value=<?= $posisi; ?> class="form-control">
                                                                <br>
                                                                <a>Keterangan : </a><input type="text" name="keterangan" value=<?= $keterangan; ?> class="form-control">
                                                                <br>
                                                                <!-- <input type="file" name="file" class="form-control" >
                                                        <br> -->
                                                                <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                                <button type="submit" class="btn btn-warning" name="updatestock">Confirm</button>
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
                                            <div class="modal fade" id="delete<?= $idb; ?>">
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
                                                                <br>
                                                                <br>
                                                                <button type="submit" class="btn btn-danger" name="hapusstock">Hapus</button>
                                                            </div>
                                                        </form>

                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

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

<!-- The Modal Input-->
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
                    <br><br>
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


<!-- The Modal Notification -->
<div class="modal fade" id="notifModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Stock Barang Habis / Kurang</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">
                <?php
                                    $ambildatastock = mysqli_query($conn, "select * from stock where stock < 1");
                                    while ($fetch = mysqli_fetch_array($ambildatastock)) {
                                        $barang = $fetch['namabarang'];


                                    ?>

                                        <div class="alert alert-danger alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                            <strong>Perhatian!</strong> Stock <?= $barang; ?> Telah Habis
                                        </div>

                                    <?php
                                    }
                                    ?>
                                    <!-- =============== -->
                                    <?php
                                    $ambildatastock = mysqli_query($conn, "select * from stock where stock < minstock");
                                    while ($fetch = mysqli_fetch_array($ambildatastock)) {
                                        $barang = $fetch['namabarang'];
                                        $minstock = $fetch['minstock'];

                                    ?>

                                        <div class="alert alert-warning">
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                            <strong>Warning!</strong> Stock <?= $barang; ?> Kurang Dari <?= $minstock; ?>
                                        </div>

                                    <?php
                                    }
                                    ?>
                </div>
            </form>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>

        </div>
    </div>
</div>

