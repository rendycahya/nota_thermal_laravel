<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">
    <link rel="icon" href="{{asset('/img/kodehack.png')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/all_css.css') }}">
    <title>KODEHACK | ALL Transactions </title>
</head>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="{{ url('/dashboard') }}"><img src="{{asset('/img/kodehack.png')}}" alt="kodehack" width="30px" style="margin-right: 5px;" class="img-responsive">
            Kodehack</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse mr-5" id="navbarNavDropdown">
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
    <div class="container">
        <br>
        <h1 class="centerUpCase"> Nota Transactions</h1>
        <button class="btn btn-dark mb-3" id="floatRight" data-toggle="modal" data-target="#myModalFilter" data-backdrop="static">
            <i class="bi bi-search"></i> Cari
        </button>
        <a class="btn btn-dark mb-3 mr-3" href="{{ url('/buatNota') }}" id="floatRight">
            <i class="bi bi-plus-lg"></i> Transaction
        </a>
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                    <th scope="col">Pembeli</th>
                    <th scope="col">Total</th>
                    <th scope="col">Waktu Pembelian</th>
                    <th scope="col" style="text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody id="keseluruhanData">
                    @foreach($data as $d)
                    <tr id="{{$d->id}}">
                        <!-- <td>{{$d->id}}</td> -->
                        <td class="alignMiddle" >{{$d->nama_pembeli}}</td>
                        <td class="alignMiddle" >Rp {{number_format($d->total_semua,0,',','.')}}</td>
                        <td class="alignMiddle" >{{\Carbon\Carbon::parse($d->created_at)->isoFormat('dddd, DD/MM/Y k:mm');}}</td>
                        <td class="center">
                            <button type="button" class="btn btn-outline-dark" onclick="showData({{$d->id}})" data-toggle="modal" data-target="#myModal" data-backdrop="static">
                                Detail
                            </button> | 
                            <button type="button" class="btn btn-outline-danger" onclick="hapusNota({{$d->id}})">
                                Hapus
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="text-align: center;">
            <button class="btn btn-warning mb-3 mr-3" onclick="loadmore_()" id="loadmore">
                Load More...
            </button>
        </div>

            <!-- Modal Detail Barang -->
            <!-- Modal -->
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="floatLeft" >Rincian Nota</h4>
                    <button type="button" class="close" aria-label="Close" onclick="tutupModal()" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                            <th scope="col">Barang/Jasa</th>
                            <th class="col">Deskripsi</th>
                            <th scope="col">Banyak</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Sub Total</th>
                            </tr>
                        </thead>
                        <tbody class="tampil_data">
                        </tbody>
                        <tbody>
                            <tr>
                                <td colspan="4" class="rightBold">Total :</td>
                                <td id="jumlah_semua" class="bold"></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="rightBold">Metode Pembayaran :</td>
                                <td id="metode_pembayaran" class="bold"></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="rightBold">Jenis Transaksi :</td>
                                <td id="jenis_transaksi" class="bold"></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="rightBold">Pembeli :</td>
                                <td id="nama_pembeli" class="bold"></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="rightBold">Dibayar :</td>
                                <td id="uang_dibayar" class="bold"></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="rightBold">Uang Kembali :</td>
                                <td id="uang_kembali" class="bold"></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="rightBold">Pembuat Nota:</td>
                                <td id="pembuat_nota" class="bold"></td>
                            </tr>
                            <tr id="bukti_tf" style="display: none">
                                <td colspan="4" class="rightBold">Bukti Transfer:</td>
                                <td id="link_bukti_tf" class="bold"></td>
                            </tr>
                        </tbody>
                        
                    </table>
                </div>
                <div class="modal-footer">
                    <button id="printNota" type="button" onclick="printNota()" class="btn btn-outline-success">Print</button>
                    <button type="button" onclick="tutupModal()" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                </div>
                </div>

            </div>
            </div>


            <!-- Modal Filter -->
            <!-- Modal -->
            <div id="myModalFilter" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="floatLeft" >Pencarian Barang</h4>
                    <button type="button" class="close" aria-label="Close" onclick="tutupModal()" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                <th scope="col">Tanggal Awal</th>
                                <th scope="col">Tanggal Akhir</th>
                                <th scope="col">Nama Pembeli</th>
                                <th scope="col">Category Barang</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form id="queryCari" action="{{ url('/queryCari') }}">
                                    @csrf
                                    <tr>
                                        <td>
                                            <input class="form-control" type="date" id="tanggal_awal">
                                        </td>
                                        <td>
                                            <input class="form-control" type="date" id="tanggal_akhir">
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" id="cari_nama_pembeli">
                                        </td>
                                        <td > 
                                            <select class="form-control" id="jenis_transaksi" name="jenis_transaksi">
                                                <option value="" > - </option>
                                                <option value="Pemasukan">Pemasukan</option>
                                                <option value="Pengeluaran">Pengeluaran</option>
                                            </select>
                                        </td>
                                    </tr>                            
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" id="buttonQueryCari" class="btn btn-outline-warning" onclick="cariNota()" value="Cari">
                    </form>
                    <button type="button" onclick="tutupModal()" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                </div>
                </div>

            </div>
            </div>











    </div>
    
</body>
</html>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('/js/js_all_transactions_page.js') }}"></script>
