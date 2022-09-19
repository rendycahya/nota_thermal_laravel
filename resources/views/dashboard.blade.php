<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KODEHACK | Dashboard </title>
    <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/dashboard.css') }}">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">
    <link rel="icon" href="{{asset('/img/kodehack.png')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/all_css.css') }}">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="{{ url('/dashboard') }}"><img src="{{asset('/img/kodehack.png')}}" alt="kodehack" width="30px" style="margin-right: 5px;" class="img-responsive">
            Kodehack</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse"  style="margin-right: 100px;" id="navbarNavDropdown">
          <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bi bi-person-badge"></i> {{ Session::get('admin')->nama }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="{{ url('/dashboard') }}"><i class="bi bi-house"></i> Dashboard</a>
                        <a class="dropdown-item" href="{{ url('/barang') }}"><i class="bi bi-bag"></i> Barang</a>
                        <a class="dropdown-item" href="{{ url('/showAllNota') }}"><i class="bi bi-clipboard-check"></i> Nota Transaksi</a>
                        <a class="dropdown-item" href="{{ url('/logout') }}"><i class="bi bi-arrow-right-square"></i> Logout</a>
                    </div>
                </li>
          </ul>
        </div>
    </nav>

    

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container">
    <div>
        <button class="btn btn-dark mt-4" id="floatRight" data-toggle="modal" data-target="#myModalFilterTransaksi" data-backdrop="static">
            <i class="bi bi-search"></i> Filter
        </button>
        <button class="btn btn-dark mt-4 mr-3" id="tagFilterTAkhir" disabled style="float: right;">
            Tanggal Akhir : -
        </button>
        <button class="btn btn-dark mt-4 mr-3" id="tagFilterTAwal" disabled style="float: right;">
            Tanggal Awal : -
        </button>
    </div>
    <br><br><br>
    <div class="row">
        <div class="col-lg col-sm-6">
            <div class="card-box bg-blue">
                <div class="inner">
                    <h3 id="total_pemasukan"> Rp {{number_format($total_pemasukan,0,',','.')}} </h3>
                    <p id="banyak_total_pemasukan"> Dari {{$banyak_total_pemasukan}} Transaksi Pemasukkan </p>
                </div>
                <div class="icon mr-3">
                    <i class="bi bi-clipboard-check" aria-hidden="true"></i>
                    <!-- <i class="fa fa-graduation-cap" aria-hidden="true"></i> -->
                </div>
                <!-- <a href="#" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a> -->
            </div>
        </div>

        <div class="col-lg col-sm-6">
            <div class="card-box bg-green">
                <div class="inner">
                    <h3 id="total_pengeluaran"> Rp {{number_format($total_pengeluaran,0,',','.')}} </h3>
                    <p id="banyak_total_pengeluaran"> Dari {{$banyak_total_pengeluaran}} Transaksi Pengeluaran </p>
                </div>
                <div class="icon mr-3">
                    <i class="bi bi-cart-check" aria-hidden="true"></i>
                </div>
                <!-- <a href="#" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a> -->
            </div>
        </div>
        
    </div>
</div>

            <!-- Modal Filter -->
            <!-- Modal -->
            <div id="myModalFilterTransaksi" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="floatLeft" >Pencarian Data Nota</h4>
                    <button type="button" class="close" aria-label="Close" onclick="tutupModalFilter()" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                <th scope="col">Tanggal Awal</th>
                                <th scope="col">Tanggal Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form id="QueryFilter" action="{{ url('/queryFilterDashboard') }}" method="POST">
                                    @csrf
                                    <tr>
                                        <td>
                                            <input type="date" id="tanggal_awal" >
                                        </td>
                                        <td>
                                            <input type="date" id="tanggal_akhir">
                                        </td>
                                    </tr>                            
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" id="buttonQueryFilter" class="btn btn-outline-warning" onclick="queryFilterTransaksi()" value="Cari">
                    </form>
                    <button type="button" onclick="tutupModalFilter()" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                </div>
                </div>

            </div>
            </div>


</body>
</html>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('/js/js_dashboard_page.js') }}"></script>