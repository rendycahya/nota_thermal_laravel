<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\DetailTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use URL;



class StudentController extends Controller
{

    public function index(){
        return view('welcome');
    }

    public function dashboard(){
        $total_pemasukan = Transaction::where('jenis_transaksi','=','Pemasukan')->sum('total_semua');
        $banyak_total_pemasukan = Transaction::where('jenis_transaksi','=','Pemasukan')->count();

        $total_pengeluaran = Transaction::where('jenis_transaksi','=','Pengeluaran')->sum('total_semua');
        $banyak_total_pengeluaran = Transaction::where('jenis_transaksi','=','Pengeluaran')->count();
        return view('dashboard',
        [
            'total_pemasukan' => $total_pemasukan,
            'banyak_total_pemasukan' => $banyak_total_pemasukan,
            'total_pengeluaran' => $total_pengeluaran,
            'banyak_total_pengeluaran' => $banyak_total_pengeluaran,
        ]);
    }

    public function tampilhalaman(){
        $getBarang = DB::table('barang')
                        ->select('*')
                        ->get();
        return view('form_thermal_print', ['nama_barang' => $getBarang]);
    }

    public function simpanNota(Request $request){

                if($request->file == ''){
                    $namaFile = '';

                }else if($request->file != ''){
                    $isiFile = $request->file('file');
                    $carbon = Carbon::now()->isoFormat('H_m_s');
                    $namaFile = $carbon."_".$isiFile->getClientOriginalName();
                    $tujuan_upload = 'data_file';
		            $isiFile->move($tujuan_upload,$namaFile);
                }
                
                $semua = json_decode($request->semua);

                $new = new Transaction;
                $new->total_semua = $semua->total_semua;
                $new->uang_bayar = $semua->uang_dibayar;
                $new->uang_kembali = $semua->uang_kembali;
                $new->nama_pembeli = $semua->nama_pembeli;
                $new->pembuat = session('admin')['nama'];
                $new->metode_pembayaran = $semua->metode_pembayaran;
                $new->jenis_transaksi = $semua->jenis_transaksi;
                $new->bukti_tf = $namaFile;
                $new->save();
            
                
            foreach($semua->barang as $b){
                $barang = new DetailTransaction;
                $barang->id_transaction = $new->id;
                $barang->nama_barang = $b->nama_barang;
                $barang->banyak_barang = $b->banyak_barang;
                $barang->harga_barang = $b->harga_barang;
                $barang->total_harga_barang = $b->total_harga_barang;
                $barang->save();
            }

        return response()->json($new);

    }

    public function cetakNota($id){
        $transaction = Transaction::find($id);
        $detail_transaction = DetailTransaction::select("*")->where('id_transaction',$id)->get();
        // $url = URL::to('/cetakNota/'.$id);
        $idterima = $id;
        // dd($url);
        return view('page_nota',
        [
            'transaction' => $transaction,
            'detail_transaction' => $detail_transaction,
            'id' => $idterima,
        ]);
    }

    public function showAllNota(){
            $data = DB::table('transactions')
                        ->select('*')
                        // ->join('detail_transactions','transactions.id', '=', 'detail_transactions.id_transaction')
                        ->orderBy('id','DESC')
                        ->skip(0)
                        ->take(10)
                        ->get();
            return view('all_transactions',
            [
                'data' => $data,
            ]);
    }

    public function showData($id){
        $hasilData = DB::table('transactions')
        ->join('detail_transactions','transactions.id', '=', 'detail_transactions.id_transaction')
        ->where('transactions.id', $id)
        ->get();

        return response()->json($hasilData);

    }

    public function hapusNota($id){
        Transaction::find($id)->delete();
        return response()->json($id);
    }

    public function daftar(){
        return view('daftar_user');
    }

    public function simpanPendaftaran(Request $request){
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        $simpan = new User;
        $simpan->nama = $request->name;
        $simpan->username = $request->username;
        $simpan->password = Hash::make($request->password);
        $simpan->save();

        return redirect('/');
    }

    public function masuk(Request $request){     
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]); 

        $admin = User::where('username',$request->username)
                        ->where('password',$request->password)
                        ->first();

        if($admin != null){

            $request->session()->put('admin', $admin);
            return redirect()->intended('/dashboard');
        }else{
            return redirect("/");
        }
        
    }
    
    public function logout(){
        // Auth::logout();
        Session::forget(['admin']);
        return redirect('/');
    }


    public function loadmore($skip){
        $data = DB::table('transactions')
                        ->select('*')
                        // ->join('detail_transactions','transactions.id', '=', 'detail_transactions.id_transaction')
                        ->orderBy('created_at','DESC')
                        ->skip($skip)
                        ->take(10)
                        ->get();

        return response()->json($data);
    }
    
    public function queryCari(Request $request){
        if($request->jenis_transaksi ==''){
            $data = DB::table('transactions')
                        ->select('*')
                        ->whereBetween('created_at',["$request->tanggal_awal 00:00:00","$request->tanggal_akhir 23:59:59"])
                        ->where('nama_pembeli','Like', '%'.$request->cari_nama_pembeli.'%')
                        ->skip(0)
                        ->take(10)
                        ->get();
        }elseif($request->jenis_transaksi == 'Pemasukan'){
            $data = DB::table('transactions')
                        ->select('*')
                        ->whereBetween('created_at',["$request->tanggal_awal 00:00:00","$request->tanggal_akhir 23:59:59"])
                        ->where('nama_pembeli','Like', '%'.$request->cari_nama_pembeli.'%')
                        ->where('jenis_transaksi','Pemasukan')
                        ->skip(0)
                        ->take(10)
                        ->get();
        }elseif($request->jenis_transaksi == 'Pengeluaran'){
            $data = DB::table('transactions')
                        ->select('*')
                        ->whereBetween('created_at',["$request->tanggal_awal 00:00:00","$request->tanggal_akhir 23:59:59"])
                        ->where('nama_pembeli','Like', '%'.$request->cari_nama_pembeli.'%')
                        ->where('jenis_transaksi','Pengeluaran')
                        ->skip(0)
                        ->take(10)
                        ->get();
        }
        

        return response()->json($data);

    }

    public function loadmoreQuery(Request $request){
        $data = DB::table('transactions')
                        ->select('*')
                        ->whereBetween('created_at',["$request->tanggal_awal 00:00:00","$request->tanggal_akhir 23:59:59"])
                        ->where('nama_pembeli','Like', '%'.$request->cari_nama_pembeli.'%')
                        ->skip($request->skip)
                        ->take(10)
                        ->get();
        return response()->json($data);

    }

    public function queryFilterDashboard(Request $request){
        $total_pemasukan = DB::table('transactions')
        ->select('total_semua')
        ->whereBetween('created_at',["$request->tanggal_awal 00:00:00","$request->tanggal_akhir 23:59:59"])
        ->where('jenis_transaksi','=','Pemasukan')
        ->sum('total_semua');

        $banyak_total_pemasukan = Transaction::whereBetween('created_at',["$request->tanggal_awal 00:00:00","$request->tanggal_akhir 23:59:59"])
        ->where('jenis_transaksi','=','Pemasukan')
        ->count();

        $total_pengeluaran = Transaction::whereBetween('created_at',["$request->tanggal_awal 00:00:00","$request->tanggal_akhir 23:59:59"])
        ->where('jenis_transaksi','=','Pengeluaran')
        ->sum('total_semua');

        $banyak_total_pengeluaran = Transaction::whereBetween('created_at',["$request->tanggal_awal 00:00:00","$request->tanggal_akhir 23:59:59"])
        ->where('jenis_transaksi','=','Pengeluaran')
        ->count();

        $data = [
            'total_pemasukan' => $total_pemasukan,
            'banyak_total_pemasukan' => $banyak_total_pemasukan,
            'total_pengeluaran' => $total_pengeluaran,
            'banyak_total_pengeluaran' => $banyak_total_pengeluaran,
        ];

        return response()->json($data);
        
    }
    


}
