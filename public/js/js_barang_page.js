let tbodyall = document.querySelector("#keseluruhanData");

function fileValidation() {
    var fileInput = document.getElementById("formFile");
    var sizeInput = fileInput.files[0].size;
    var filePath = fileInput.value;
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

function editFileValidation() {
    var fileInput = document.getElementById("edit_formFile");
    var sizeInput = fileInput.files[0].size;
    var filePath = fileInput.value;
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

function loadmoreBarang() {
    let ambiljumlah = document
        .getElementById("keseluruhanData")
        .getElementsByTagName("tr").length;
    fetch("/loadmoreBarang/" + ambiljumlah)
        .then((response) => response.json())
        .then((response) => {
            response.forEach(function (m) {
                let tambah = tbodyall.insertRow();
                tambah.id = m.id;
                let cell1 = tambah.insertCell(0);
                let cell2 = tambah.insertCell(1);
                let cell3 = tambah.insertCell(2);
                cell1.innerHTML = m.nama_barang;
                cell2.innerHTML = m.stok_barang;
                cell3.innerHTML =
                    "<button type='button' class='btn btn-outline-dark' onclick='showData(" +
                    m.id +
                    ")' data-toggle='modal' data-target='#myModal' data-backdrop='static'>Detail</button> | <button type='button' class='btn btn-outline-danger' onclick='hapusBarang(" +
                    m.id +
                    ")'>Hapus</button>";
                cell2.className = "center";
                cell3.className = "center";
            });
            if (response.length === 0) {
                let ubah = document.getElementById("loadmore");
                ubah.innerHTML = "Semua Barang Sudah Tampil";
                ubah.setAttribute("disabled", "true");
            }
        });
}

function plusBarang() {
    let url = simpanDataBarang.getAttribute("action");
    let nama_barang = document.getElementById("nama_barang").value;
    let harga_barang = document.getElementById("harga_barang").value;
    let category = document.getElementById("category").value;
    let stok_barang = document.getElementById("stok_barang").value;
    let deskripsi_barang = document.getElementById("deskripsi_barang").value;

    let file = document.getElementById("formFile").files[0];
    let tampung = {
        nama_barang: nama_barang,
        harga_barang: harga_barang,
        category: category,
        stok_barang: stok_barang,
        deskripsi_barang: deskripsi_barang,
    };
    let data = new FormData();

    if (file === undefined) {
        data.append("data", JSON.stringify(tampung));
        data.append("file", "");
    } else {
        data.append("data", JSON.stringify(tampung));
        data.append("file", file);
    }

    simpanDataBarang.onsubmit = async (e) => {
        e.preventDefault();

        let response = await fetch(url, {
            method: "POST",
            credentials: "same-origin",
            headers: {
                "X-CSRF-Token":
                    document.querySelector("input[name=_token]").value,
            },
            body: data,
        });

        let result = response;
        await result.json().then(function (res) {
            data = res;
            $("#tambahBarang").modal("hide");
            let tbodyall = document.querySelector("#keseluruhanData");
            let tambah = tbodyall.insertRow(0);
            tambah.id = data.id;
            let cell1 = tambah.insertCell(0);
            let cell2 = tambah.insertCell(1);
            let cell3 = tambah.insertCell(2);
            cell1.innerHTML = data.nama_barang;
            cell2.innerHTML = data.stok_barang;
            cell3.innerHTML =
                "<button type='button' class='btn btn-outline-dark' onclick='showData(" +
                data.id +
                ")' data-toggle='modal' data-target='#myModal' data-backdrop='static'>Detail</button> | <button type='button' class='btn btn-outline-danger' onclick='hapusBarang(" +
                data.id +
                ")'>Hapus</button>";
            cell2.className = "center";
            cell3.className = "center";
        });

        document.getElementById("nama_barang").value = "";
        document.getElementById("harga_barang").value = "";
        document.getElementById("category").value = "";
        document.getElementById("stok_barang").value = "";
        document.getElementById("deskripsi_barang").value = "";
        document.getElementById("formFile").value = null;
    };
}

function hapusBarang(id) {
    if (confirm("Hapus Barang?")) {
        fetch("/hapusBarang/" + id).then(function (response) {
            if (response.status == 200) {
                let gettbody = document.getElementById("keseluruhanData");
                let gettrindex = document.getElementById(id);
                gettbody.removeChild(gettrindex);
            } else if (response.status == 500) {
                alert(
                    "Barang sudah terdaftar dalam sebuah nota transaksi yang dibuat."
                );
            }
        });
    } else {
        return false;
    }
}

function cariBarang() {
    let url = queryCariBarang.getAttribute("action");
    let nama_barang = document.getElementById("filter_nama_barang").value;
    let category = document.getElementById("filter_category").value;
    let dataCariBarang = {
        nama_barang: nama_barang,
        category: category,
    };
    queryCariBarang.onsubmit = async (e) => {
        e.preventDefault();
        let response = await fetch(url, {
            method: "POST",
            credentials: "same-origin",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-Token":
                    document.querySelector("input[name=_token]").value,
            },
            body: JSON.stringify(dataCariBarang),
        });

        let result = response;
        await result.json().then(function (res) {
            let data = res;
            $("#myModalFilterBarang").modal("hide");

            while (tbodyall.hasChildNodes()) {
                tbodyall.removeChild(tbodyall.firstChild);
            }

            data.forEach(function (m) {
                let tbodyall = document.querySelector("#keseluruhanData");
                let tambah = tbodyall.insertRow();
                tambah.id = m.id;
                let cell1 = tambah.insertCell(0);
                let cell2 = tambah.insertCell(1);
                let cell3 = tambah.insertCell(2);
                cell1.innerHTML = m.nama_barang;
                cell2.innerHTML = m.stok_barang;
                cell3.innerHTML =
                    "<button type='button' class='btn btn-outline-dark' onclick='showData(" +
                    m.id +
                    ")' data-toggle='modal' data-target='#myModal' data-backdrop='static'>Detail</button> | <button type='button' class='btn btn-outline-danger' onclick='hapusBarang(" +
                    m.id +
                    ")'>Hapus</button>";
                cell2.className = "center";
                cell3.className = "center";
            });
            if (data.length > 0) {
                let ubah = document.getElementById("loadmore");
                ubah.innerHTML = "Load More...";
                ubah.removeAttribute("disabled", "true");
            }

            loadmore.onclick = async (e) => {
                e.preventDefault();
                let ambiljumlah = document
                    .getElementById("keseluruhanData")
                    .getElementsByTagName("tr").length;
                dataCariBarang.skip = ambiljumlah;
                let response = await fetch("/loadmoreQueryBarang", {
                    method: "POST",
                    credentials: "same-origin",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-Token":
                            document.querySelector("input[name=_token]").value,
                    },
                    body: JSON.stringify(dataCariBarang),
                });
                let result = response;
                await result.json().then(function (res) {
                    let data = res;
                    data.forEach(function (m) {
                        let tbodyall =
                            document.querySelector("#keseluruhanData");
                        let tambah = tbodyall.insertRow();
                        tambah.id = m.id;
                        let cell1 = tambah.insertCell(0);
                        let cell2 = tambah.insertCell(1);
                        let cell3 = tambah.insertCell(2);
                        cell1.innerHTML = m.nama_barang;
                        cell2.innerHTML = m.stok_barang;
                        cell3.innerHTML =
                            "<button type='button' class='btn btn-outline-dark' onclick='showData(" +
                            m.id +
                            ")' data-toggle='modal' data-target='#myModal' data-backdrop='static'>Detail</button> | <button type='button' class='btn btn-outline-danger' onclick='hapusBarang(" +
                            m.id +
                            ")'>Hapus</button>";
                        cell2.className = "center";
                        cell3.className = "center";
                    });
                    if (data.length === 0) {
                        let ubah = document.getElementById("loadmore");
                        ubah.innerHTML = "Semua Barang Sudah Tampil";
                        ubah.setAttribute("disabled", "true");
                    } else {
                    }
                });
            };
        });
    };
}

function showData(id) {
    fetch("/detailBarang/" + id)
        .then((response) => response.json())
        .then((response) => {
            response.forEach(function (m) {
                let get = document.getElementById("editBarang");
                document.getElementById("slotNama").innerHTML =
                    "<b>Nama Barang :</b> <br>" + m.nama_barang;
                document.getElementById("slotHarga").innerHTML =
                    "<b>Harga Barang :</b> <br>" +
                    Intl.NumberFormat("id-ID", {
                        style: "currency",
                        currency: "IDR",
                        minimumFractionDigits: 0,
                    }).format(m.harga_barang);
                document.getElementById("slotCategory").innerHTML =
                    "<b>Category Barang :</b> <br>" + m.category;
                document.getElementById("slotStock").innerHTML =
                    "<b>Stok Barang :</b> <br>" + m.stok_barang;
                document.getElementById("slotDeskripsi").innerHTML =
                    "<b>Deskripsi Barang :</b> <br>" + m.deskripsi_barang;
                document
                    .getElementById("tempatFoto")
                    .setAttribute("src", "/data_file_barang/" + m.foto_barang);
                get.setAttribute("onclick", "editBarang(" + m.id + ")");
            });
        });
}

function editBarang(id) {
    fetch("/showEditBarang/" + id)
        .then((hasil) => hasil.json())
        .then((hasil) => {
            hasil.forEach(function (m) {
                document.getElementById("edit_nama_barang").value =
                    m.nama_barang;
                document.getElementById("edit_harga_barang").value =
                    m.harga_barang;
                document.getElementById("edit_stok_barang").value =
                    m.stok_barang;
                document.getElementById("edit_deskripsi_barang").value =
                    m.deskripsi_barang;
                $("select[name=edit_category]").val(m.id_category);
                $("#edit_category").selectpicker("refresh");
                // $('.selectpicker').selectpicker('val', 0);
                let update = document.getElementById("update_barang");
                update.setAttribute("onclick", "updateBarang(" + m.id + ")");
            });
        });
}

function updateBarang(id) {
    let url = updateDataBarang.getAttribute("action");
    let nama_barang = document.getElementById("edit_nama_barang").value;
    let harga_barang = document.getElementById("edit_harga_barang").value;
    let category_barang = document.getElementById("edit_category").value;
    let stok_barang = document.getElementById("edit_stok_barang").value;
    let deskripsi_barang = document.getElementById(
        "edit_deskripsi_barang"
    ).value;
    let file = document.getElementById("edit_formFile").files[0];
    let data = new FormData();

    let tampung = {
        id: id,
        nama_barang: nama_barang,
        harga_barang: harga_barang,
        category_barang: category_barang,
        stok_barang: stok_barang,
        deskripsi_barang: deskripsi_barang,
    };

    if (file === undefined) {
        data.append("data", JSON.stringify(tampung));
        data.append("file", "");
    } else {
        data.append("data", JSON.stringify(tampung));
        data.append("file", file);
    }

    updateDataBarang.onsubmit = async (e) => {
        e.preventDefault();

        let get = await fetch(url, {
            method: "POST",
            credentials: "same-origin",
            headers: {
                "X-CSRF-Token":
                    document.querySelector("input[name=_token]").value,
            },
            body: data,
        });

        await get.json().then(function (res) {
            let respon = res;
            let gettrupdate = document.getElementById(respon.id);
            gettrupdate.children[0].innerHTML = respon.nama_barang;
            gettrupdate.children[1].innerHTML = respon.stok_barang;
            document.getElementById("edit_formFile").value = null;
            $("#ModalEditBarang").modal("hide");
        });
    };
}

function closeDetailBarang() {
    document.getElementById("slotNama").innerHTML = "";
    document.getElementById("slotHarga").innerHTML = "";
    document.getElementById("slotCategory").innerHTML = "";
    document.getElementById("slotStock").innerHTML = "";
    document.getElementById("slotDeskripsi").innerHTML = "";
    document.getElementById("tempatFoto").setAttribute("src", "");
}
