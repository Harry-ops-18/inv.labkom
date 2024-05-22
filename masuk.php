<?php
require 'function.php';
require 'cek.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Inv.Lab MAS - Barang masuk</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">Inv.Lab MAS</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang yang Ada
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Masuk
                            </a>
                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Keluar
                            </a>  
                            <a class="nav-link" href="logout.php">
                                Logout
                            </a>                                   
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?php
                        // Periksa apakah pengguna sudah login
                        if(isset($_SESSION['log']) && $_SESSION['log'] === true) {
                            // Jika pengguna sudah login, tampilkan emailnya
                            echo $_SESSION['email']; // Sesuaikan dengan kunci sesi yang digunakan untuk menyimpan email
                        } else {
                            
                        }
                        ?>                      
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Barang Masuk</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Inv.Lab MAS - Barang Masuk</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    Tambah Barang
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Barang</th>
                                                <th>Penerima</th>
                                                <th>Tanggal</th>
                                                <th>Sejumlah</th>
                                                <th>Edit/delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $fetchallstock = mysqli_query($conn, "select * from barang_masuk m, barang b where b.idbarang = m.idbarang");
                                                $i = 1;
                                                while($data=mysqli_fetch_array($fetchallstock)){
                                                    $idb = $data['idbarang'];                                                   
                                                    $idm = $data['idmasuk'];                                                   
                                                    $namabarang = $data['namabarang'];
                                                    $ket = $data['ket'];
                                                    $date = $data['tanggal'];
                                                    $qty = $data['qty'];
                                            ?>
                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$namabarang;?></td>
                                                <td><?=$ket;?></td>
                                                <td><?=$date;?></td>
                                                <td><?=$qty;?></td>
                                                <td>
                                                    <button type="button" class="btn-primary" data-toggle="modal" data-target="#edit<?=$idm;?>">
                                                        Edit
                                                    </button>
                                                    <input type="hidden" name="iddeleted" value="<?=$idb;?>">
                                                    <button type="button" class="btn-danger" data-toggle="modal" data-target="#delete<?=$idm;?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                                <!-- The Modal Edit -->
                                                <div class="modal fade" id="edit<?=$idm;?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                            <h4 class="modal-title">Edit barang</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            
                                                            <!-- Modal body -->
                                                            <form method="post">
                                                                <div class="modal-body">
                                                                <input type="text" name="ket" value="<?=$ket;?>" class="form-control" required>                                                            
                                                                <br>
                                                                <input type="number" name="qty" value="<?=$qty;?>" class="form-control" required>                                                            
                                                                <br>
                                                                <input type="hidden" name="idb" value="<?=$idb;?>">
                                                                <input type="hidden" name="idm" value="<?=$idm;?>">
                                                                </div>                        
                                                            
                                                                <!-- Modal footer -->
                                                                <div class="modal-footer">
                                                                <button type="submit" class="btn btn-warning" name="updatein">Edit</button>
                                                                </div>
                                                            </form>
                                                            
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- The Modal Delete -->
                                                <div class="modal fade" id="delete<?=$idm;?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                            <h4 class="modal-title">Delete barang</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            
                                                            <!-- Modal body -->
                                                            <form method="post">
                                                                <div class="modal-body">
                                                                Apakah anda yakin ingin menghapus <?="$namabarang";?> ?   
                                                                <input type="hidden" name="idb" value="<?=$idb;?>">
                                                                <input type="hidden" name="qty" value="<?=$qty;?>">
                                                                <input type="hidden" name="idm" value="<?=$idm;?>">
                                                                </div>                        
                                                            
                                                                <!-- Modal footer -->
                                                                <div class="modal-footer">
                                                                <button type="submit" class="btn btn-danger" name="deletein">Delete</button>
                                                                </div>
                                                            </form>
                                                            
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

    <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
        <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Tambah Barang Masuk</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <form method="post">
                <div class="modal-body">
                <select name="barangnya" class="form-control">
                    <?php

                        $ambilsemuabarang = mysqli_query($conn, "select * from barang");
                        while($fetcharray = mysqli_fetch_array($ambilsemuabarang)){                            
                            $namabarangnya = $fetcharray['namabarang'];
                            $idbarangnya = $fetcharray['idbarang'];

                    ?>

                    <option value="<?=$idbarangnya;?>"><?=$namabarangnya;?></option>
                    
                    <?php                    
                        }
                    ?>
                </select>                
                <br>
                <input type="number" name="qty" placeholder="Quantity" class="form-control" required>
                <br>
                <input type="text" name="penerima" placeholder="Nama Penerima" class="form-control" required>                                                    
            </div>                        
            
                <!-- Modal footer -->
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="barangmasuk">Submit</button>
                </div>
            </form>
            
        </div>
        </div>
    </div>

</html>