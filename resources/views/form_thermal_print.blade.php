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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <title>KODEHACK | Tambah Nota Barang</title>
</head>


<body>
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
    <h1>Pembuatan Nota Barang KODEHACK</h1>
    
    <h4 id="floatLeft">Form Barang</h4>
    <h4 id="floatRight"><a href="{{ url('/showAllNota') }}" class="btn btn-outline-dark">Lihat Semua Nota Barang</a></h4>
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th>No.</th>
                <th>Barang/ Jasa</th>
                <th>Harga</th>
                <th>Banyak</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr class='input'>
                <td>#</td>
                <td><input class="form-control" type="text" id="nama_barang" name="nama_barang" disabled></td>
                <td><input class="form-control" type="number" id="banyak_barang" name="banyak_barang" onkeyup="calculate()" disabled/></td>
                <td><input class="form-control" type="number" id="harga_barang" name="harga_barang" onkeyup="calculate()" disabled/></td>
                <td><p id="total_harga_barang" name="total_harga_barang"></p></td>
            </tr>
            <tr>
                <td colspan="5" class="center"><button data-toggle="modal" data-target="#tambahBarang" data-backdrop="static" class="btn btn-warning" id="save" >Tambahkan Barang</button></td>
            </tr>
        </tbody>
    </table>
    <br><br>
    <h1>Rincian Barang</h1>
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th>No.</th>
                <th>Barang/ Jasa</th>
                <th>Banyak</th>
                <th>Harga</th>
                <th>Sub Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="dummy">
            <tr>
                <td>...................</td>
                <td>...................</td>
                <td>...................</td>
                <td>...................</td>
                <td>...................</td>
                <td>...................</td>
            </tr>
        </tbody>
        <tbody id="show">
        </tbody>
        <tbody>
            <tr id="last">
                <td colspan="3" class="rightBold">Total :</td>
                <td id="total_semuanya" colspan="2">....</td>
            </tr>
            <tr>
                <td colspan="3" class="rightBold">Metode Pembayaran :</td>
                <td colspan="3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cash" id="metod_pembayaran1" onclick="metodPembayaran(name)">
                        <label class="form-check-label" for="metod_pembayaran1">
                            Cash
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="transfer" id="metod_pembayaran2" onclick="metodPembayaran(name)">
                        <label class="form-check-label" for="metod_pembayaran2">
                            Transfer
                        </label>
                        <div id="slotFile">
                        </div>
                        <!-- <div id="coba">
                            <button onclick="coba()">Coba</button>
                        </div> -->
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="rightBold">Jenis Transaksi :</td>
                <td colspan="3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="pemasukan" id="jenis_transaksi1" onclick="jenisTransaksi(name)">
                        <label class="form-check-label" for="jenis_transaksi1">
                            Pemasukkan
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="pengeluaran" id="jenis_transaksi2" onclick="jenisTransaksi(name)">
                        <label class="form-check-label" for="jenis_transaksi2">
                            Pengeluaran
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="rightBold">Pembeli : </td>
                <td colspan="3"><input class="form-control" type="text" id="nama_pembeli" name="nama_pembeli"/></td>
            </tr>
            <tr>
                <td colspan="3" class="rightBold">Dibayar : </td>
                <td colspan="3"><input class="form-control" type="number" id="uang_dibayar" name="uang_dibayar" onblur="pembayaran()"/></td>
                <!-- <td><button  class="btn btn-warning">Oke ?</button></td> -->
            </tr>
            <tr>
                <td colspan="3" class="rightBold">Kembali : </td>
                <td id="uang_kembali" colspan="3">....</td>
            </tr>
            <form id="simpanNota" action="{{ url('/simpanNota') }}">
                @csrf
            <tr>
                <td colspan="6">
                    <div class="center">
                        <input type="submit" name="simpan_nota" id="simpan_nota" class="btn btn-warning" onclick="SimpanNota()" value="Simpan & Print">
                    </div>
                </td>
            </tr>
            </form>
        </tbody>
    </table>

        <!-- Modal Tambah Nota -->
        <!-- Modal -->
        <div id="tambahBarang" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="floatLeft" >Tambah Barang </h4>
                <button type="button" class="close" aria-label="Close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tbody>
                        <div class="form-group">
                            <label for="tambah_nama_barang" class="col-form-label">Nama Barang / Jasa :</label>
                            <input type="text" class="form-control" id="cari_nama_barang" onkeyup="cariNamaBarang()" placeholder="Masukkan Nama Barang">
                            <div class="form-group">
                                <select multiple class="form-control" id="exampleFormControlSelect2" style="display: none;">
                                    <!-- <option id="" value=""></option> -->
                                </select>
                                <small id="note_stock_barang" class="form-text text-muted" style="display: none;"></small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tambah_harga_barang" class="col-form-label">Harga :</label>
                            <input type="number" class="form-control" id="tambah_harga_barang" disabled>
                        </div>
                        <div class="form-group">
                            <label for="tambah_banyak_barang" class="col-form-label">Banyak :</label>
                            <input type="number" class="form-control" id="tambah_banyak_barang" onkeyup="hitung()">
                            <small id="note_stock_barang" class="form-text text-muted">Masukkan banyak barang < stok barang yang dipilih </small>
                        </div>
                        <div class="form-group">
                            <label for="tamba_total_barang" class="col-form-label">Total :</label>
                            <input type="number" class="form-control" id="tamba_total_barang" disabled>
                        </div>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-outline-warning" onclick="plusBarang()" value="Simpan Barang" id="simpan_tambah_barang">
                </form>
                <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
            </div>
            </div>

        </div>
        </div>

        <!-- Modal Tambah Nota -->
        <!-- Modal -->
        <div id="editData" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="floatLeft" >Edit Barang </h4>
                <button type="button" class="close" aria-label="Close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tbody>
                        <input type="hidden" id="id_barang_dipilih">
                        <div class="form-group">
                            <label for="edit_tambah_nama_barang" class="col-form-label">Nama Barang / Jasa :</label>
                            <input type="text" class="form-control" id="edit_tambah_nama_barang" onkeyup="cariNamaBarang()" placeholder="Masukkan Nama Barang" disabled>
                            <div class="form-group">
                                <select multiple class="form-control" id="exampleFormControlSelect2" style="display: none;">
                                    <!-- <option id="" value=""></option> -->
                                </select>
                                <small id="edit_note_stock_barang" class="form-text text-muted"></small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_tambah_harga_barang" class="col-form-label">Harga :</label>
                            <input type="number" class="form-control" id="edit_tambah_harga_barang" disabled>
                        </div>
                        <div class="form-group">
                            <label for="edit_tambah_banyak_barang" class="col-form-label">Banyak :</label>
                            <input type="number" class="form-control" id="edit_tambah_banyak_barang" onkeyup="hitung()">
                            <small id="note_stock_barang" class="form-text text-muted">Masukkan banyak barang < stok barang yang dipilih </small>
                        </div>
                        <div class="form-group">
                            <label for="edit_tamba_total_barang" class="col-form-label">Total :</label>
                            <input type="number" class="form-control" id="edit_tamba_total_barang" disabled>
                        </div>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-outline-warning" value="Update Barang" id="edit_simpan_tambah_barang">
                </form>
                <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
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
<script type="text/javascript" src="{{ asset('/js/js_tambah_nota_barang.js') }}" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>