<?php

require 'function.php';
require 'check.php';

?>
<html>

<head>
    <title>Data Stock Barang Keluar</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
</head>

<body>
    <div class="container">
    <a href="keluar.php"><- Back </a>
        <h2>Stock Barang Keluar</h2>
        <h4>(History)</h4>
        <div class="data-tables datatable-dark">
            <table class="table table-bordered" id="mauexport" width="100%" cellspacing="0">
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
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $ambilsemuadatastock = mysqli_query($conn, "select * from stock");
                    $i = 1;
                    while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                        $kodebarang = $data['kodebarang'];
                        $namabarang = $data['namabarang'];
                        $spesifikasi = $data['spesifikasi'];
                        $partnumber = $data['partnumber'];
                        $stock = $data['stock'];
                        $satuan = $data['satuan'];
                        $posisi = $data['posisi'];
                        $tipe = $data['tipe'];
                        $keterangan = $data['keterangan'];
                        $idb = $data['idbarang'];
                    ?>

                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?php echo $kodebarang; ?></td>
                            <td><?php echo $namabarang; ?></td>
                            <td><?php echo $spesifikasi; ?></td>
                            <td><?php echo $partnumber; ?></td>
                            <td><?php echo $stock; ?></td>
                            <td><?php echo $satuan; ?></td>
                            <td><?php echo $posisi; ?></td>
                            <td><?php echo $tipe; ?></td>
                            <td><?php echo $keterangan; ?></td>
                        </tr>


                    <?php
                    };

                    ?>
                </tbody>
            </table>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#mauexport').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    // 'copy','csv',
                    'excel', 'pdf', 'print'
                ]
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>



</body>

</html>