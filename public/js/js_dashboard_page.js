function tutupModalFilter() {
    $("#myModalFilterTransaksi").modal("hide");
}

function queryFilterTransaksi() {
    let url = QueryFilter.getAttribute("action");
    let tanggal_awal = document.getElementById("tanggal_awal").value;
    let tanggal_akhir = document.getElementById("tanggal_akhir").value;

    datacari = {
        tanggal_awal: tanggal_awal,
        tanggal_akhir: tanggal_akhir,
    };

    QueryFilter.onsubmit = async (e) => {
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
            $("#myModalFilterTransaksi").modal("hide");
            document.getElementById("tagFilterTAkhir").innerHTML =
                "Tanggal Akhir : " + tanggal_akhir;
            document.getElementById("tagFilterTAwal").innerHTML =
                "Tanggal Awal : " + tanggal_awal;
            document.getElementById("total_pemasukan").innerHTML =
                Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",
                    minimumFractionDigits: 0,
                }).format(data.total_pemasukan);
            document.getElementById("banyak_total_pemasukan").innerHTML =
                "Dari " + data.banyak_total_pemasukan + " Transaksi Pemasukkan";
            document.getElementById("total_pengeluaran").innerHTML =
                Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",
                    minimumFractionDigits: 0,
                }).format(data.total_pengeluaran);
            document.getElementById("banyak_total_pengeluaran").innerHTML =
                "Dari " +
                data.banyak_total_pengeluaran +
                " Transaksi Pengeluaran";
        });
    };
}
