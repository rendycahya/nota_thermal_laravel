<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Barang;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;




class BarangController extends Controller
{

    public function barang(){
        $data = Barang::select('*')
        ->orderBy('id','DESC')
        ->skip(0)
        ->take(10)
        ->get();

        $category = DB::table('category_barang')->get();

        return view('barang.halaman_utama_barang',['data' => $data,'category' => $category]);
    }

    public function simpanBarang(Request $request){
        if($request->file == ''){
            $namaFile = '';

        }else if($request->file != ''){
            $isiFile = $request->file('file');
            $carbon = Carbon::now()->isoFormat('H_m_s');
            $namaFile = $carbon."_".$isiFile->getClientOriginalName();
            $tujuan_upload = 'data_file_barang';
            $isiFile->move($tujuan_upload,$namaFile);
        }

        $semua = json_decode($request->data);

        $simpan = new Barang;
        $simpan->nama_barang = $semua->nama_barang;
        $simpan->harga_barang = $semua->harga_barang;
        $simpan->id_category_barang = $semua->category;
        $simpan->stok_barang = $semua->stok_barang;
        $simpan->deskripsi_barang = $semua->deskripsi_barang;
        $simpan->foto_barang = $namaFile;
        $simpan->created_at = Carbon::now()->isoFormat('Y/MM/DD kk:mm:ss');
        $simpan->updated_at = Carbon::now()->isoFormat('Y/MM/DD kk:mm:ss');
        $simpan->save();

        return response()->json($simpan);

    }

    public function loadmoreBarang($skip){
        $data = DB::table('barang')
                        ->select('*')
                        // ->join('detail_transactions','transactions.id', '=', 'detail_transactions.id_transaction')
                        ->orderBy('id','DESC')
                        ->skip($skip)
                        ->take(10)
                        ->get();

        return response()->json($data);
    }
  
    public function hapusBarang($id){
        Barang::find($id)->delete();
        return response()->json($id);
    }

    public function queryCariBarang(Request $request){
        // if($request->category == ''){
        // $data = DB::table('barang')
        //                 // ->join('category_barang', 'barang.id_category_barang', '=', 'category_barang.id_category')
        //                 ->select('*')
        //                 ->where('nama_barang','Like', '%'.$request->nama_barang.'%')
        //                 // ->where('id_category_barang', $request->category)
        //                 ->skip(0)
        //                 ->take(10)
        //                 ->get();
        // }else if($request->category > 0){
            $data = DB::table('barang')
                        // ->join('category_barang', 'barang.id_category_barang', '=', 'category_barang.id_category')
                        ->select('*')
                        ->where('nama_barang','Like', '%'.$request->nama_barang.'%')
                        ->where('id_category_barang','Like', $request->category.'%')
                        ->skip(0)
                        ->take(10)
                        ->get();
        // }
        return response()->json($data);
    }

    public function loadmoreQueryBarang(Request $request){
        if($request->category == ''){
            $data = DB::table('barang')
                    ->select('*')
                    ->where('nama_barang','Like', '%'.$request->nama_barang.'%')
                    // ->where('id_category_barang', $request->category)
                    ->skip($request->skip)
                    ->take(10)
                    ->get();
        }else if($request->category > 0){
            $data = DB::table('barang')
                    ->select('*')
                    ->where('nama_barang','Like', '%'.$request->nama_barang.'%')
                    ->where('id_category_barang', $request->category)
                    ->skip($request->skip)
                    ->take(10)
                    ->get();
        }
        return response()->json($data);
    }

    public function detailBarang($id){
        $detailBarang = DB::table('barang')
                        ->join('category_barang', 'barang.id_category_barang', '=', 'category_barang.id_category')
                        ->select('*')
                        ->where('id',$id)
                        ->get();

        return response()->json($detailBarang);
    }

    public function getBarang(Request $request){
        $nama_barang = $request->nama_barang;
        if($nama_barang == ''){
            $data = '';
        }else{
            $data = DB::table('barang')
                ->select('*')
                ->where('nama_barang','Like', '%'.$request->nama_barang.'%')
                ->get();
        }
        

        return response()->json($data);
    }

    public function pilihBarang($id){
        $dataBarang = DB::table('barang')
                        ->select('*')
                        ->where('id',$id)
                        ->get();

        return response()->json($dataBarang);
    }

}
