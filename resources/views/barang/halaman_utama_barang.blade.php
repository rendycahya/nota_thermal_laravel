<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link rel="icon" href="{{asset('/img/kodehack.png')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/all_css.css') }}">
    <title>KODEHACK | Semua Barang </title>
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
        <h1 class="centerUpCase"> Semua Barang</h1>
        <button class="btn btn-dark mb-3" id="floatRight" data-toggle="modal" data-target="#myModalFilterBarang" data-backdrop="static">
            <i class="bi bi-search"></i> Cari
        </button>
        <button class="btn btn-dark mb-3 mr-3" id="floatRight" data-toggle="modal" data-target="#tambahBarang" data-backdrop="static">
            <i class="bi bi-plus-lg"></i> Barang
        </button>
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                    <th scope="col">Nama Barang</th>
                    <th scope="col" class="center">Stok Barang</th>
                    <th scope="col" style="text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody id="keseluruhanData">
                    @foreach($data as $d)
                    <tr id="{{$d->id}}">
                        <td  >{{$d->nama_barang}}</td>
                        <td  class="center">{{$d->stok_barang}}</td>
                        <td class="center">
                            <button type="button" class="btn btn-outline-dark" onclick="showData({{$d->id}})" data-toggle="modal" data-target="#myModal" data-backdrop="static">
                                Detail
                            </button> | 
                            <button type="button" class="btn btn-outline-danger" onclick="hapusBarang({{$d->id}})">
                                Hapus
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="text-align: center;">
            <button class="btn btn-warning mb-3 mr-3" onclick="loadmoreBarang()" id="loadmore">
                Load More...
            </button>
        </div>

            <!-- Modal Tambah Barang -->
            <!-- Modal -->
            <div id="tambahBarang" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="floatLeft" >Tambah Barang</h4>
                    <button type="button" class="close" aria-label="Close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <form id="simpanDataBarang" action="{{ url('/simpanBarang') }}" method="POST">
                        @csrf
                        <tbody>
                            <tr>
                                <td >Nama Barang : <input class="form-control" id="nama_barang" type="text" style="width: 100%; margin-top: 6px;" required></td> 
                            </tr>
                            <tr>
                                <td >Harga Barang : <input class="form-control" id="harga_barang" type="number" style="width: 100%; margin-top: 6px;" required></td>
                            </tr>
                            <tr>
                                <td >Category Barang : 
                                    <select class="selectpicker form-control" id="category" name="category" data-live-search="true" required >
                                        @foreach($category as $c)
                                        <option value="{{$c->id_category}}" data-tokens="{{$c->category}}">{{$c->category}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td >Stok Barang : <input class="form-control" id="stok_barang" type="number" style="width: 100%; margin-top: 6px;" required></td>
                            </tr>
                            <tr>
                                <td >Deskripsi Barang : <textarea  class="form-control" id="deskripsi_barang" type="text" style="width: 100%; margin-top: 6px;" rows="3" required></textarea>
                                <small id="note_deskripsi_barang" class="form-text text-muted">Tulis deskripsi barang tanpa menggunakan emoticon.</small>
                        </td>
                            </tr>
                            <tr>
                                <td >Foto Barang : <input class='form-control' type='file' id='formFile' accept='image/jpeg' onchange='return fileValidation()' style='width: 100%; margin-top: 6px;'required></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-outline-warning" onclick="plusBarang()" value="Simpan">
                    </form>
                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                </div>
                </div>

            </div>
            </div>


            <!-- Modal Filter -->
            <!-- Modal -->
            <div id="myModalFilterBarang" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="floatLeft" >Pencarian Barang</h4>
                    <button type="button" class="close" aria-label="Close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Category Barang </th>
                                </tr>
                            </thead>
                            <form id="queryCariBarang" action="{{ url('/queryCariBarang') }}" method="POST">
                                @csrf
                            <tbody>
                                <tr>
                                    <td ><input class="form-control" id="filter_nama_barang" type="text" style="width: 100%; margin-top: 6px;"></td> 
                                    <td> <select class="form-control mt-1" id="filter_category" name="category">
                                        <option value="" > - </option>
                                        @foreach($category as $c)
                                        <option value="{{$c->id_category}}">{{$c->category}}</option>
                                        @endforeach
                                    </select></td>
                                </tr>                       
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" id="buttonQueryCari" class="btn btn-outline-warning" onclick="cariBarang()" value="Cari">
                    </form>
                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                </div>
                </div>

            </div>
            </div>


            <!-- Modal Detail Barang -->
            <!-- Modal -->
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="floatLeft" >Detail Barang</h4>
                    <button type="button" class="close" aria-label="Close" data-dismiss="modal" onclick="closeDetailBarang()"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td id="slotNama">Nama Barang :</td> 
                                </tr>
                                <tr>
                                    <td id="slotHarga">Harga Barang :</td> 
                                </tr>       
                                <tr>
                                    <td id="slotCategory">Category Barang : </td> 
                                </tr>
                                <tr>
                                    <td id="slotStock">Category Barang : </td> 
                                </tr> 
                                <tr>
                                    <td id="slotDeskripsi">Category Barang : </td> 
                                </tr>                
                                <tr>
                                    <td ><b>Foto Barang</b> 
                                        <div>
                                            <img id="tempatFoto" src="" alt="" width="150px" style="margin: 10px 10px 10px 0px;">
                                        </div>
                                    </td> 
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-warning" id="editBarang" data-dismiss="modal" data-toggle="modal" data-target="#ModalEditBarang" onclick="editBarang()">Edit Barang</button>
                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal" onclick="closeDetailBarang()">Close</button>
                </div>
                </div>

            </div>

            <!-- Modal Edit Barang -->
            <!-- Modal -->
            <div id="ModalEditBarang" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="floatLeft">Edit Barang</h4>
                    <button type="button" class="close" aria-label="Close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <form id="updateDataBarang" action="https://nota.kodehack.com/updateDataBarang" method="POST"></form>
                        <input type="hidden" name="_token" value="n3iK7t2fgo9j13ixxhi7K1oqURtsVrLeprHAIPrd">                        <tbody>
                            <tr>
                                <td><b>Nama Barang :</b><input class="form-control" id="edit_nama_barang" type="text" style="width: 100%; margin-top: 6px;" required=""></td> 
                            </tr>
                            <tr>
                                <td><b>Harga Barang :</b><input class="form-control" id="edit_harga_barang" type="number" style="width: 100%; margin-top: 6px;" required=""></td>
                            </tr>
                            <tr>
                                <td><b>Category Barang :</b> 
                                    <div class="dropdown bootstrap-select form-control dropup"><select class="selectpicker form-control" id="edit_category" name="edit_category" data-live-search="true" required="" tabindex="-98">
                                                                                <option value="1" data-tokens="SparePart Laptop">SparePart Laptop</option>
                                                                                <option value="2" data-tokens="SparePart Computer">SparePart Computer</option>
                                                                                <option value="3" data-tokens="Laptop Second">Laptop Second</option>
                                                                                <option value="4" data-tokens="Baju Thrift - Preloved">Baju Thrift - Preloved</option>
                                                                                <option value="5" data-tokens="Aksesoris Komputer Laptop">Aksesoris Komputer Laptop</option>
                                                                                <option value="6" data-tokens="Paket Rakit Komputer">Paket Rakit Komputer</option>
                                                                                <option value="7" data-tokens="Pelatihan Training">Pelatihan Training</option>
                                                                                <option value="8" data-tokens="Gaming">Gaming</option>
                                                                                <option value="9" data-tokens="Printer Percetakan">Printer Percetakan</option>
                                                                                <option value="10" data-tokens="Jaringan">Jaringan</option>
                                                                                <option value="11" data-tokens="Jasa">Jasa</option>
                                                                            </select><button type="button" class="btn dropdown-toggle btn-light" data-toggle="dropdown" role="combobox" aria-owns="bs-select-2" aria-haspopup="listbox" aria-expanded="false" data-id="edit_category" title="SparePart Laptop"><div class="filter-option"><div class="filter-option-inner"><div class="filter-option-inner-inner">SparePart Laptop</div></div> </div></button><div class="dropdown-menu " style="max-height: 315px; overflow: hidden; min-height: 162px;"><div class="bs-searchbox"><input type="search" class="form-control" autocomplete="off" role="combobox" aria-label="Search" aria-controls="bs-select-2" aria-autocomplete="list" aria-activedescendant="bs-select-2-0"></div><div class="inner show" role="listbox" id="bs-select-2" tabindex="-1" style="max-height: 251px; overflow-y: auto; min-height: 98px;"><ul class="dropdown-menu inner show" role="presentation" style="margin-top: 0px; margin-bottom: 0px;"><li class="selected active"><a role="option" class="dropdown-item active selected" id="bs-select-2-0" tabindex="0" aria-setsize="11" aria-posinset="1" aria-selected="true"><span class="text">SparePart Laptop</span></a></li><li><a role="option" class="dropdown-item" id="bs-select-2-1" tabindex="0"><span class="text">SparePart Computer</span></a></li><li><a role="option" class="dropdown-item" id="bs-select-2-2" tabindex="0"><span class="text">Laptop Second</span></a></li><li><a role="option" class="dropdown-item" id="bs-select-2-3" tabindex="0"><span class="text">Baju Thrift - Preloved</span></a></li><li><a role="option" class="dropdown-item" id="bs-select-2-4" tabindex="0"><span class="text">Aksesoris Komputer Laptop</span></a></li><li><a role="option" class="dropdown-item" id="bs-select-2-5" tabindex="0"><span class="text">Paket Rakit Komputer</span></a></li><li><a role="option" class="dropdown-item" id="bs-select-2-6" tabindex="0"><span class="text">Pelatihan Training</span></a></li><li><a role="option" class="dropdown-item" id="bs-select-2-7" tabindex="0"><span class="text">Gaming</span></a></li><li><a role="option" class="dropdown-item" id="bs-select-2-8" tabindex="0"><span class="text">Printer Percetakan</span></a></li><li><a role="option" class="dropdown-item" id="bs-select-2-9" tabindex="0"><span class="text">Jaringan</span></a></li><li><a role="option" class="dropdown-item" id="bs-select-2-10" tabindex="0"><span class="text">Jasa</span></a></li></ul></div></div></div>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Stok Barang : </b><input class="form-control" id="edit_stok_barang" type="number" style="width: 100%; margin-top: 6px;" required=""></td>
                            </tr>
                            <tr>
                                <td><b>Deskripsi Barang :</b> <textarea class="form-control" id="edit_deskripsi_barang" type="text" style="width: 100%; margin-top: 6px;" rows="3" required=""></textarea>
                                <small id="note_deskripsi_barang" class="form-text text-muted">Tulis deskripsi barang tanpa menggunakan emoticon.</small>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Foto Barang : </b><input class="form-control" type="file" id="edit_formFile" accept="image/jpeg" onchange="return editFileValidation()" style="width: 100%; margin-top: 6px;">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-outline-warning" id="update_barang" value="Update Barang" onclick="updateBarang(25)">
                    
                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                </div>
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
<script type="text/javascript" src="{{ asset('/js/js_barang_page.js') }}" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
