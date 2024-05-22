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
        <title>Inv.Lab MAS - HOME</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <style>
            .addfile {
                border: 1px solid #000; /* Warna dan ketebalan border */
                padding: 3px;
            }
        </style>
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
                        <h1 class="mt-4">Semua Barang yang Ada</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Inv.Lab MAS</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    Tambah Barang
                                </button>
                                <a href="export.php" class="btn btn-info">Export data to Excell</a>
                                <form action="" method="POST" enctype="multipart/form-data" class="row-g-2">
                                    <div style="margin-top:5px;width:430px;" class="input-group">
                                        <div class="addfile custom-file">
                                            <input type="file" style="border:outline">
                                        </div>
                                        <div class="input-group-append">
                                            <input name="submit" value="Upload Excell" class="btn btn-outline-primary" type="submit" id="inputGroupFileAddon04"></input>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Barang</th>
                                                <th>Deskripsi</th>
                                                <th>Stock</th>
                                                <th>Edit/delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $fetchallstock = mysqli_query($conn, "select * from barang");
                                                $i = 1;
                                                while($data=mysqli_fetch_array($fetchallstock)){                                                    
                                                    $namabarang = $data['namabarang'];
                                                    $desk = $data['desk'];
                                                    $stock = $data['stock'];
                                                    $idb = $data['idbarang'];
                                            ?>
                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$namabarang;?></td>
                                                <td><?=$desk;?></td>
                                                <td><?=$stock;?></td>
                                                <td>
                                                    <button type="button" class="btn-primary" data-toggle="modal" data-target="#edit<?=$idb;?>">
                                                        Edit
                                                    </button>
                                                    <input type="hidden" name="iddeleted" value="<?=$idb;?>">
                                                    <button type="button" class="btn-danger" data-toggle="modal" data-target="#delete<?=$idb;?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                                <!-- The Modal Edit -->
                                                <div class="modal fade" id="edit<?=$idb;?>">
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
                                                                <input type="text" name="namabarang" value="<?=$namabarang;?>" class="form-control" required>
                                                                <br>
                                                                <input type="text" name="desk" value="<?=$desk;?>" class="form-control" required>                                                            
                                                                <br>
                                                                <input type="hidden" name="idb" value="<?=$idb;?>">
                                                                </div>                        
                                                            
                                                                <!-- Modal footer -->
                                                                <div class="modal-footer">
                                                                <button type="submit" class="btn btn-warning" name="updatebarang">Edit</button>
                                                                </div>
                                                            </form>
                                                            
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- The Modal Delete -->
                                                <div class="modal fade" id="delete<?=$idb;?>">
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
                                                                </div>                        
                                                            
                                                                <!-- Modal footer -->
                                                                <div class="modal-footer">
                                                                <button type="submit" class="btn btn-danger" name="hapus">Delete</button>
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
            <h4 class="modal-title">Tambah Barang</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <form method="post">
                <div class="modal-body">
                <input type="text" name="namabarang" placeholder="Nama barang" class="form-control" required>
                <br>
                <input type="text" name="desk" placeholder="Deskripsi barang" class="form-control" required>
                <br>
                <input type="number" name="stock" placeholder="Stock barang" class="form-control" required>                                
                </div>                        
            
                <!-- Modal footer -->
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="addnewbarang">Submit</button>
                </div>
            </form>
            
        </div>
        </div>
    </div>

</html>
