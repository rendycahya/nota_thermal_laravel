let ambil = document.querySelector(".tampil_data");
let tbodyall = document.querySelector("#keseluruhanData");
let tambahindex = 0;
let datacari = "";

function showData(id) {
    fetch("/showData/" + id)
        .then((response) => response.json())
        .then((response) => {
            response.forEach(function (m, i) {
                let tambah_tr = ambil.insertRow();
                tambah_tr.insertCell().innerHTML = m.nama_barang;
                tambah_tr.insertCell().innerHTML = m.nama_barang;
                tambah_tr.insertCell().innerHTML = m.banyak_barang;
                tambah_tr.insertCell().innerHTML = Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",
                    minimumFractionDigits: 0,
                }).format(m.harga_barang);
                tambah_tr.insertCell().innerHTML = Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",
                    minimumFractionDigits: 0,
                }).format(m.total_harga_barang);
                tambahindex++;
            });
            document.getElementById("jumlah_semua").innerHTML =
                Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",
                    minimumFractionDigits: 0,
                }).format(response[0].total_semua);
            document.getElementById("metode_pembayaran").innerHTML =
                response[0].metode_pembayaran;
            document.getElementById("jenis_transaksi").innerHTML =
                response[0].jenis_transaksi;
            document.getElementById("nama_pembeli").innerHTML =
                response[0].nama_pembeli;
            document.getElementById("uang_dibayar").innerHTML =
                Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",
                    minimumFractionDigits: 0,
                }).format(response[0].uang_bayar);
            document.getElementById("uang_kembali").innerHTML =
                Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",
                    minimumFractionDigits: 0,
                }).format(response[0].uang_kembali);
            document.getElementById("pembuat_nota").innerHTML =
                response[0].pembuat;
            let onklik = document.querySelector("#printNota");
            onklik.setAttribute(
                "onclick",
                "printNota(" + response[0].id_transaction + ")"
            );
            if (response[0].metode_pembayaran == "Transfer") {
                let getTag = document.getElementById("bukti_tf");
                getTag.style.display = "";
                document.getElementById("link_bukti_tf").innerHTML =
                    "<a href='/data_file/" +
                    response[0].bukti_tf +
                    "' target='_blank'>" +
                    response[0].bukti_tf +
                    "</a>";
            } else if (response[0].metode_pembayaran == "Cash") {
                let getTag = document.getElementById("bukti_tf");
                getTag.style.display = "none";
                document.getElementById("link_bukti_tf").innerHTML = "";
            }
        });
}

function tutupModal() {
    while (ambil.hasChildNodes()) {
        ambil.removeChild(ambil.lastChild);
    }
    document.getElementById("jumlah_semua").innerHTML = "";
    document.getElementById("nama_pembeli").innerHTML = "";
    document.getElementById("uang_dibayar").innerHTML = "";
    document.getElementById("uang_kembali").innerHTML = "";
    document.getElementById("pembuat_nota").innerHTML = "";
    let onklik = document.querySelector("#printNota");
    onklik.setAttribute("onclick", "printNota()");
}

function hapusNota(id) {
    if (confirm("Hapus Nota?")) {
        fetch("/hapusNota/" + id)
            .then((response) => response.json())
            .then((response) => {
                let gettbody = document.getElementById("keseluruhanData");
                let gettrindex = document.getElementById(id);
                gettbody.removeChild(gettrindex);
            });
    } else {
    }
}

function printNota(id) {
    window.open("/cetakNota/" + id, "_blank");
}

function loadmore_() {
    let ambiljumlah = document
        .getElementById("keseluruhanData")
        .getElementsByTagName("tr").length;
    fetch("/loadmore/" + ambiljumlah)
        .then((response) => response.json())
        .then((response) => {
            response.forEach(function (m) {
                let tambah = tbodyall.insertRow();
                tambah.id = m.id;
                let cell1 = tambah.insertCell(0);
                let cell2 = tambah.insertCell(1);
                let cell3 = tambah.insertCell(2);
                let cell4 = tambah.insertCell(3);
                cell1.innerHTML = m.nama_pembeli;
                cell2.innerHTML = Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",
                    minimumFractionDigits: 0,
                }).format(m.total_semua);
                cell3.innerHTML = new Date(m.created_at).toLocaleString(
                    "id-ID",
                    {
                        year: "numeric",
                        day: "2-digit",
                        month: "2-digit",
                        weekday: "long",
                        hour: "2-digit",
                        minute: "2-digit",
                    }
                );
                cell4.innerHTML =
                    "<button type='button' class='btn btn-outline-dark' onclick='showData(" +
                    m.id +
                    ")' data-toggle='modal' data-target='#myModal' data-backdrop='static'>Detail</button> | <button type='button' class='btn btn-outline-danger' onclick='hapusNota(" +
                    m.id +
                    ")'>Hapus</button>";
                cell4.className = "center";
            });
            if (response.length === 0) {
                let ubah = document.getElementById("loadmore");
                ubah.innerHTML = "Semua Nota Sudah Tampil";
                ubah.setAttribute("disabled", "true");
            }
        });
}

function cariNota() {
    let url = queryCari.getAttribute("action");
    let tanggal_awal = document.getElementById("tanggal_awal").value;
    let tanggal_akhir = document.getElementById("tanggal_akhir").value;
    let cari_nama_pembeli = document.getElementById("cari_nama_pembeli").value;
    let jenis_transaksi = document.getElementById("jenis_transaksi").value;

    datacari = {
        tanggal_awal: tanggal_awal,
        tanggal_akhir: tanggal_akhir,
        cari_nama_pembeli: cari_nama_pembeli,
        jenis_transaksi: jenis_transaksi,
    };

    queryCari.onsubmit = async (e) => {
        e.preventDefault();

        let response = await fetch(url, {
            method: "POST",
            credentials: "same-origin",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-Token":
                    document.querySelector("input[name=_token]").value,
            },
            body: JSON.stringify(datacari),
        });

        let result = response;
        await result.json().then(function (res) {
            let data = res;
            $("#myModalFilter").modal("hide");

            while (tbodyall.hasChildNodes()) {
                tbodyall.removeChild(tbodyall.firstChild);
            }

            data.forEach(function (m) {
                let tambah = tbodyall.insertRow();
                tambah.id = m.id;
                let cell1 = tambah.insertCell(0);
                let cell2 = tambah.insertCell(1);
                let cell3 = tambah.insertCell(2);
                let cell4 = tambah.insertCell(3);
                cell1.innerHTML = m.nama_pembeli;
                cell2.innerHTML = Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",
                    minimumFractionDigits: 0,
                }).format(m.total_semua);
                cell3.innerHTML = new Date(m.created_at).toLocaleString(
                    "id-ID",
                    {
                        year: "numeric",
                        day: "2-digit",
                        month: "2-digit",
                        weekday: "long",
                        hour: "2-digit",
                        minute: "2-digit",
                    }
                );
                cell4.innerHTML =
                    "<button type='button' class='btn btn-outline-dark' onclick='showData(" +
                    m.id +
                    ")' data-toggle='modal' data-target='#myModal' data-backdrop='static'>Detail</button> | <button type='button' class='btn btn-outline-danger' onclick='hapusNota(" +
                    m.id +
                    ")'>Hapus</button>";
                cell4.className = "center";
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
                datacari.skip = ambiljumlah;
                let response = await fetch("/loadmoreQuery", {
                    method: "POST",
                    credentials: "same-origin",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-Token":
                            document.querySelector("input[name=_token]").value,
                    },
                    body: JSON.stringify(datacari),
                });

                let result = response;
                await result.json().then(function (res) {
                    let data = res;
                    data.forEach(function (m) {
                        let tambah = tbodyall.insertRow();
                        tambah.id = m.id;
                        let cell1 = tambah.insertCell(0);
                        let cell2 = tambah.insertCell(1);
                        let cell3 = tambah.insertCell(2);
                        let cell4 = tambah.insertCell(3);
                        cell1.innerHTML = m.nama_pembeli;
                        cell2.innerHTML = Intl.NumberFormat("id-ID", {
                            style: "currency",
                            currency: "IDR",
                            minimumFractionDigits: 0,
                        }).format(m.total_semua);
                        cell3.innerHTML = new Date(m.created_at).toLocaleString(
                            "id-ID",
                            {
                                year: "numeric",
                                day: "2-digit",
                                month: "2-digit",
                                weekday: "long",
                                hour: "2-digit",
                                minute: "2-digit",
                            }
                        );
                        cell4.innerHTML =
                            "<button type='button' class='btn btn-outline-dark' onclick='showData(" +
                            m.id +
                            ")' data-toggle='modal' data-target='#myModal' data-backdrop='static'>Detail</button> | <button type='button' class='btn btn-outline-danger' onclick='hapusNota(" +
                            m.id +
                            ")'>Hapus</button>";
                        cell4.className = "center";
                    });
                    if (data.length === 0) {
                        let ubah = document.getElementById("loadmore");
                        ubah.innerHTML = "Semua Nota Sudah Tampil";
                        ubah.setAttribute("disabled", "true");
                    } else {
                    }
                });
            };
        });
    };
}
