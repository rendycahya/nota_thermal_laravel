<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{asset('/img/kodehack.png')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/nota_css.css') }}">
    <title>KODEHACK | Page Nota Transaction</title>
</head>
<body class="fontBody">
    <div class="conta">
        <div class="headerKode">KODEHACK</div>
        <div class="alamat">Jl. Joyoboyo No.19, RT.6/RW.2,  
        <br>Medaeng, Waru, Sidoarjo, Jatim</div>
        <div class="notelp">Telp. 0851-5513-2241</div>
        <p class="border"></p>
        
        <div class="admin">Pembeli : {{$transaction->nama_pembeli}}</div>
        <div class="admin">Admin : {{ $transaction->pembuat}}</div>
        <div class="tanggal">{{ \Carbon\Carbon::parse($transaction->created_at)->isoFormat('dddd, DD/MM/Y k:mm'); }}</div>
        
        <table class="table">
        <tbody >
            @foreach($detail_transaction as $d)
            <tr>
                <td class="barang" colspan="3"># {{$d->nama_barang}}</td>
            </tr>
            <tr>
                <td class="harga">{{$d->harga_barang}}</td>
                <td class="banyak_barang">x {{$d->banyak_barang}}</td>
                <td class="total_harga">Rp {{number_format($d->total_harga_barang,0,',','.')}}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="2" class="footer">Total :</td>
                <td colspan="1" class="inFooter">Rp {{number_format($transaction->total_semua,0,',','.')}}</td>
            </tr>
            <!-- <tr>
                <td colspan="2" class="pembeli">Pembeli :</td>
                <td colspan="1" class="inFooter">{{$transaction->nama_pembeli}}</td>
            </tr> -->
            <tr>
                <td colspan="2" class="footer">Dibayar :</td>
                <td colspan="1" class="inFooter">Rp {{number_format($transaction->uang_bayar,0,',','.')}}</td>
                
            </tr>
            <tr>
                <td colspan="2" class="footer">Kembali :</td>
                <td colspan="1" class="inPembeli">Rp {{number_format($transaction->uang_kembali,0,',','.')}}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"><p class="footerBorder"></p></td>
            </tr>
            <tr>
                <td class="center" colspan="3">
                    <div class="qr" >{!! QrCode::format('svg')->errorCorrection('L')->size(90)->style('square')->eye('square')->generate(Request::url());  !!}</div>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="lastFooter">kodehack.com</td>
            </tr>
          </tfoot>
        </table>

    </div>
    
</body>
</html>
