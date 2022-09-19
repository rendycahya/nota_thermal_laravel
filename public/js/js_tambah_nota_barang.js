let tbody = document.querySelector("#show");
let tbodydummy = document.querySelector("#dummy");
let arr = [];
let index = 0;
let penampung = 0;
let url = simpanNota.getAttribute("action");
let tampungSemua = "";
let data = "";
let jumlah = 0;
let tampungPembayaran = "";
let tampungJenisTransaksi = "";
let tampungStokBarang = 0;

function pembayaran() {
    let uang_dibayar = document.getElementById("uang_dibayar").value;
    let uang_kembali = uang_dibayar - penampung;
    document.getElementById("uang_kembali").innerHTML = Intl.NumberFormat(
        "id-ID",
        { style: "currency", currency: "IDR", minimumFractionDigits: 0 }
    ).format(uang_kembali);
    let nama_pembeli = document.getElementById("nama_pembeli").value;

    tampungSemua = {
        barang: arr,
        total_semua: penampung,
        uang_dibayar: Number(uang_dibayar),
        uang_kembali: uang_kembali,
        nama_pembeli: nama_pembeli,
        metode_pembayaran: tampungPembayaran,
        jenis_transaksi: tampungJenisTransaksi,
    };
}

function calculate() {
    var rows = document.querySelectorAll("tr.input");
    rows.forEach(function (currentRow) {
        var banyak_barang = Number(
            currentRow.querySelector("#banyak_barang").value
        );
        var harga_barang = Number(
            currentRow.querySelector("#harga_barang").value
        );
        document.querySelectorAll("banyak_barang");
        jumlah = banyak_barang * harga_barang;
        let tampiljumlah = jumlah;

        currentRow.querySelector("#total_harga_barang").innerHTML =
            Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR",
                minimumFractionDigits: 0,
            }).format(tampiljumlah);
    });
}

//SimpanNota
function SimpanNota() {
    let dataSimpan = new FormData();

    if (tampungPembayaran == "Cash") {
        dataSimpan.append("file", "");
        dataSimpan.append("semua", JSON.stringify(tampungSemua));
    } else if (tampungPembayaran == "Transfer") {
        var input = document.querySelector('input[type="file"]');
        dataSimpan.append("file", input.files[0]);
        dataSimpan.append("semua", JSON.stringify(tampungSemua));
    }

    simpanNota.onsubmit = async (e) => {
        e.preventDefault();

        let response = await fetch(url, {
            method: "POST",
            credentials: "same-origin",
            headers: {
                "X-CSRF-Token":
                    document.querySelector("input[name=_token]").value,
            },
            body: dataSimpan,
        });

        let result = response;
        await result.json().then(function (res) {
            data = res;
        });

        if (result.status == 200) {
            let print = confirm("Nota Berhasil Tersimpan, Print atau tidak ?");
            if (print) {
                window.open("/cetakNota/" + data.id, "_blank");
                location.reload();
            } else {
                location.reload();
                return false;
            }
        }
    };
}

function editData(id) {
    let indexof = arr.findIndex((o) => o.index === id);
    $("#editData").modal("show");
    document.getElementById("edit_tambah_nama_barang").value =
        arr[indexof].nama_barang;
    document.getElementById("edit_note_stock_barang").innerHTML =
        "Stock barang sekarang : <b>" + arr[indexof].stock + "</b>";
    document.getElementById("edit_tambah_harga_barang").value =
        arr[indexof].harga_barang;
    document.getElementById("edit_tambah_banyak_barang").value =
        arr[indexof].banyak_barang;
    document.getElementById("edit_tamba_total_barang").value =
        arr[indexof].total_harga_barang;
    let onklik = document.getElementById("edit_simpan_tambah_barang");
    onklik.setAttribute("onclick", "updateBarang(" + id + ")");
}

function updateBarang(id) {
    let indexof = arr.findIndex((o) => o.index === id);
    let nama_barang = document.getElementById("edit_tambah_nama_barang").value;
    let stock = document.getElementById("id");
    let harga_barang = document.getElementById("tambah_harga_barang").value;
    let banyak_barang = document.getElementById("tambah_banyak_barang").value;
    let total_harga_barang =
        document.getElementById("tamba_total_barang").value;
    let getStock = document.getElementById("note_stock_barang");

    arr[id].nama_barang = nama_barang;
    arr[id].harga_barang = harga_barang;
    arr[id].banyak_barang = banyak_barang;
    arr[id].total_harga_barang = total_harga_barang;

    let gettr = document.getElementById(id);
    gettr.children[0].innerHTML = "#";
    gettr.children[1].innerHTML = nama_barang;
    gettr.children[2].innerHTML = banyak_barang;
    gettr.children[3].innerHTML = Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(harga_barang);
    gettr.children[4].innerHTML = Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(total_harga_barang);

    $("#tambahBarang").modal("hide");
    getStock.style.display = "none";
    // document.getElementById('id_barang_dipilih').value="";
    document.getElementById("cari_nama_barang").value = "";
    document.getElementById("tambah_harga_barang").value = "";
    document.getElementById("tambah_banyak_barang").value = "";
    document.getElementById("tamba_total_barang").value = "";

    penampung = 0;
    for (let i = 0; i < arr.length; i++) {
        penampung += parseInt(arr[i]["total_harga_barang"]);
    }
    document.getElementById("total_semuanya").innerHTML = Intl.NumberFormat(
        "id-ID",
        { style: "currency", currency: "IDR", minimumFractionDigits: 0 }
    ).format(penampung);

    let onklik = document.getElementById("simpan_tambah_barang");
    onklik.setAttribute("onclick", "plusBarang()");
    onklik.value = "Simpan Barang";
}

function deleteData(id) {
    let deleteid = confirm("Yakin ingin menghapus barang?");
    if (deleteid) {
        let indexof = arr.findIndex((o) => o.index === id);
        arr.splice(indexof, 1);
        let gettbody = document.getElementById("show");
        let gettrindex = document.getElementById(id);
        gettbody.removeChild(gettrindex);

        penampung = 0;
        for (let i = 0; i < arr.length; i++) {
            penampung += parseInt(arr[i]["total_harga_barang"]);
        }
        document.getElementById("total_semuanya").innerHTML = Intl.NumberFormat(
            "id-ID",
            { style: "currency", currency: "IDR", minimumFractionDigits: 0 }
        ).format(penampung);
        console.log(arr);
    } else {
        return false;
    }
}

function metodPembayaran(name) {
    if (name == "cash") {
        tampungPembayaran = "Cash";
        console.log(tampungPembayaran);
        document.getElementById("metod_pembayaran1").checked = true;
        document.getElementById("metod_pembayaran2").checked = false;
        document
            .querySelector("#slotFile")
            .removeChild(document.getElementById("slotFile").firstChild);
    } else if (name == "transfer") {
        tampungPembayaran = "Transfer";
        console.log(tampungPembayaran);
        document.getElementById("metod_pembayaran1").checked = false;
        document.getElementById("metod_pembayaran2").checked = true;
        document.getElementById("slotFile").innerHTML =
            "<div class='mb-3'><label for='formFile' class='form-label'>Masukkan Bukti Transfer</label><input class='form-control' type='file' id='formFile' accept='image/jpeg' onchange='return fileValidation()'></div>";
        // document.getElementById("coba").innerHTML = "<button onclick='coba()'>Coba</button>";
    }
}

function fileValidation() {
    var fileInput = document.getElementById("formFile");
    var filePath = fileInput.value;
    var sizeInput = fileInput.files[0].size;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if (!allowedExtensions.exec(filePath)) {
        alert("File harus berupa gambar & Kurang dari 2mb");
        fileInput.value = "";
        return false;
    } else if (sizeInput > 2000000) {
        alert("File harus berupa gambar & Kurang dari 2mb");
        fileInput.value = "";
        return false;
    }
}

function jenisTransaksi(name) {
    if (name == "pemasukan") {
        tampungJenisTransaksi = "Pemasukan";
        // console.log(tampungJenisTransaksi);
        document.getElementById("jenis_transaksi1").checked = true;
        document.getElementById("jenis_transaksi2").checked = false;
    } else if (name == "pengeluaran") {
        tampungJenisTransaksi = "Pengeluaran";
        // console.log(tampungJenisTransaksi);
        document.getElementById("jenis_transaksi1").checked = false;
        document.getElementById("jenis_transaksi2").checked = true;
    }
}

async function cariNamaBarang() {
    let getSelect = document.getElementById("exampleFormControlSelect2");
    let cari_nama_barang = document.getElementById("cari_nama_barang").value;
    let harga_barang = document.getElementById("tambah_harga_barang");
    let getStock = document.getElementById("note_stock_barang");
    let data = { nama_barang: cari_nama_barang };
    fetch("/getBarang", {
        method: "POST",
        credentials: "same-origin",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-Token": document.querySelector("input[name=_token]").value,
        },
        body: JSON.stringify(data),
    })
        .then((response) => response.json())
        .then((response) => {
            if ($.isEmptyObject(response)) {
                console.log("Kosong");
                getSelect.style.display = "none";
                getStock.style.display = "none";
                harga_barang.value = "";
            } else {
                console.log(response);
                getSelect.style.display = "";
                while (getSelect.hasChildNodes()) {
                    getSelect.removeChild(getSelect.lastChild);
                }
                response.forEach(function (m) {
                    let tagOption = document.createElement("option");
                    // tagOption.setAttribute("value",m.id);
                    tagOption.innerHTML = m.nama_barang;
                    tagOption.setAttribute(
                        "onclick",
                        "pilihBarang(" + m.id + ")"
                    );
                    getSelect.appendChild(tagOption);
                });
            }
        });
}

function hitung() {
    let harga_barang = document.getElementById("tambah_harga_barang").value;
    let banyak_barang = document.getElementById("tambah_banyak_barang").value;
    let jumlah = harga_barang * banyak_barang;
    document.getElementById("tamba_total_barang").value = jumlah;
}

function pilihBarang(id) {
    let getSelect = document.getElementById("exampleFormControlSelect2");
    let getStock = document.getElementById("note_stock_barang");
    let get_default = document.getElementById("tambah_banyak_barang");

    fetch("/pilihBarang/" + id)
        .then((response) => response.json())
        .then((response) => {
            console.log(response);
            getSelect.style.display = "none";
            getStock.style.display = "";
            get_default.value = "";
            response.forEach(function (m) {
                // document.getElementById('id_barang_dipilih').value = m.id;
                document.getElementById("cari_nama_barang").value =
                    m.nama_barang;
                getStock.innerHTML =
                    "Stock barang sekarang : <b>" + m.stok_barang + "</b>";
                document.getElementById("tambah_harga_barang").value =
                    m.harga_barang;
                tampungStokBarang = m.stok_barang;
            });
        });
}

function plusBarang() {
    let nama_barang = document.getElementById("cari_nama_barang").value;
    let harga_barang = document.getElementById("tambah_harga_barang").value;
    let banyak_barang = document.getElementById("tambah_banyak_barang").value;
    let total_barang = document.getElementById("tamba_total_barang").value;
    let getStock = document.getElementById("note_stock_barang");
    // let id_dipilih = document.getElementById('id_barang_dipilih').value;

    if (tampungStokBarang - banyak_barang < 0) {
        alert("Banyak barang melebihi stok yang ada");
        return false;
    } else {
        let barang = {
            index: index,
            stock: tampungStokBarang,
            // 'id_barang_dipilih' : id_dipilih,
            nama_barang: nama_barang,
            banyak_barang: banyak_barang,
            harga_barang: harga_barang,
            total_harga_barang: total_barang,
        };
        arr.push(barang);
        $("#tambahBarang").modal("hide");
        console.log(arr);
        getStock.style.display = "none";
        document.getElementById("cari_nama_barang").value = "";
        document.getElementById("tambah_harga_barang").value = "";
        document.getElementById("tambah_banyak_barang").value = "";
        document.getElementById("tamba_total_barang").value = "";

        while (tbodydummy.hasChildNodes()) {
            tbodydummy.removeChild(tbodydummy.firstChild);
        }

        let tr = tbody.insertRow();
        tr.id = index;
        tr.insertCell().innerHTML = "#";
        tr.insertCell().innerHTML = nama_barang;
        tr.insertCell().innerHTML = banyak_barang;
        tr.insertCell().innerHTML = Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits: 0,
        }).format(harga_barang);
        tr.insertCell().innerHTML = Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits: 0,
        }).format(total_barang);
        tr.insertCell().innerHTML =
            "<button onclick='editData(" +
            index +
            ")' class='btn btn-outline-dark'>Edit</button> | <button onclick='deleteData(" +
            index +
            ")' class='btn btn-outline-danger'>Hapus</button>";
        index++;

        penampung = 0;
        for (let i = 0; i < arr.length; i++) {
            penampung += parseInt(arr[i]["total_harga_barang"]);
        }

        document.getElementById("total_semuanya").innerHTML = Intl.NumberFormat(
            "id-ID",
            { style: "currency", currency: "IDR", minimumFractionDigits: 0 }
        ).format(penampung);
        jumlah = 0;
    }
}
