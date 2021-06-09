<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Stock;
use App\Transaksi;
use App\Report;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){   
        $this->tutupbuku();
        $user_id = Auth::id();
        $year = Date('Y');
        $month = Date('m');
        $query = Transaksi::with(['Stock'])->where('user_id',$user_id)->whereYear('created_at', $year)->whereMonth('created_at',$month)->get();
        $count = sizeof($query);
        $expense = Transaksi::where('user_id',$user_id)->where('inout',"IN")->whereYear('created_at', $year)->whereMonth('created_at',$month)->sum('totalprice');
        $income = Transaksi::where('user_id',$user_id)->where('method' , "cash")->where('inout',"OUT")->whereYear('created_at', $year)->whereMonth('created_at',$month)->sum('totalprice');
        $tempo = Transaksi::where('user_id',$user_id)->where('method' , "tempo")->sum('totalprice');
        
        $profit = number_format( $income-$expense,0);
        $expense = number_format( $expense,0);
        $income = number_format( $income,0);
        $tempo = number_format( $tempo,0);
        $getdate = Report::where('user_id',$user_id)->orderby('date','asc')->take(3)->pluck('date');
        $tanggal = array();
        foreach($getdate as $bulan){
            array_push($tanggal,date("F d, Y",strtotime(substr($bulan,0,10)))); 
        }
        $reports = Report::where('user_id',$user_id)->orderby('date','asc')->take(3)->get();
        $reportincome = array();
        $reportoutcome = array();
        $reportprofit = array();

        foreach($reports as $key => $report){
            array_push($reportincome,$report->income);
            array_push($reportoutcome,$report->outcome);
            array_push($reportprofit,$report->profit);
        }
        return view('user.home' , ['count' => $count , 'expense' => $expense , 'income' => $income , 'profit' => $profit , 'tempo' => $tempo , 'tanggal' => $tanggal , 'reportincome' => $reportincome , 'reportoutcome' => $reportoutcome , 'reportprofit' => $reportprofit]);
    }

    public function itemkeluar(){
        $items = Stock::where('user_id' , Auth::id())->orderby('item_name' , "asc")->get();
        return view('user.itemkeluar' , ['items' => $items]);
    }

    public function itemkeluarProcess(Request $request){
        $user_id = Auth::id();
        $item = $request->input('itemid');
        $item_id = explode(",",$item)[0];
        $amount = $request->input('amount');
        $inout = "OUT";
        $totalprice = $request->input('totalprice');

        //init stock
        $stock = Stock::find($item_id);
        //check stock
        if(($stock->item_stock-$amount) < 0){
            return redirect()->back()->with('error' , "Stock tidak mencukupi");
        }
        //init transaksi
        $transaksi = new Transaksi();
        $transaksi->user_id = $user_id;
        $transaksi->item_id =  $item_id;
        $transaksi->amount = $amount;
        $transaksi->inout = $inout;
        $transaksi->totalprice = $totalprice;
        $transaksi->save();
        
        //cutstock
        $stock->item_stock -= $amount;
        $stock->save();

        return redirect()->back()->with('success' , "Berhasil!");

    }

    public function itemmasuk(){
        $items = Stock::where('user_id' , Auth::id())->orderby('item_name' , "asc")->get();
        return view('user.itemmasuk' , ['items' => $items]);
    }

    public function itemmasukProcess(Request $request){
        $user_id = Auth::id();
        $item = $request->input('itemid');
        $item_id = explode(",",$item)[0];
        $amount = $request->input('amount');
        $inout = "IN";
        $totalprice = $request->input('totalprice');

        //init stock
        $stock = Stock::find($item_id);
       
        //init transaksi
        $transaksi = new Transaksi();
        $transaksi->user_id = $user_id;
        $transaksi->item_id =  $item_id;
        $transaksi->amount = $amount;
        $transaksi->inout = $inout;
        $transaksi->totalprice = $totalprice;
        $transaksi->save();

        //cut stock
        $stock->item_stock += $amount;
        $stock->save();

        return redirect()->back()->with('success' , "Berhasil!");

    }

    public function stock(){
        $items = Stock::where('user_id' , Auth::id())->orderby('item_name' , "asc")->get();
        return view('user.stock' , ['items' => $items]);
    }

    public function getstock($id){
        $item = Stock::find($id);
        return view('user.getstock' , ['item' => $item]);
    }

    public function stockupdate(Request $request){
        $item_id = $request->input('item_id');
        $item_name = $request->input('name');
        $hargamasuk = $request->input('hargamasuk');
        $hargakeluar = $request->input('hargakeluar');
        $jumlahstock = $request->input('jumlahstock');

        $data = Stock::where('id' , $item_id)->update([
            'item_name' => $item_name,
            'item_price_in' => $hargamasuk,
            'item_price_out' => $hargakeluar,
            'item_stock' => $jumlahstock
        ]);
        return redirect()->back()->with('success' , "Item telah terupdate!");
    }

    public function tambahitem(){
        return view('user.tambahitem');
    }

    public function tambahitemProcess(Request $request){
        $user_id = Auth::id();
        $item_name = $request->input('name');
        $hargamasuk = $request->input('hargamasuk');
        $hargakeluar = $request->input('hargakeluar');
        $jumlahstock = $request->input('jumlahstock');

        $stock = new Stock();
        $stock->user_id = $user_id;
        $stock->item_name = $item_name;
        $stock->item_price_in = $hargamasuk;
        $stock->item_price_out = $hargakeluar;
        $stock->item_stock = $jumlahstock;
        $stock->save();
        return redirect()->back()->with('success',"Barang telah ditambahkan!");

    }

    public function tambahitembaru(){
        return view('user.tambahitembaru');
    }

    public function tambahitembaruprocess(Request $request){
        $user_id = Auth::id();
        $item_name = $request->input('name');
        $hargamasuk = $request->input('hargamasuk');
        $hargakeluar = $request->input('hargakeluar');
        $jumlahstock = $request->input('jumlahstock');
        $inout = "IN";
        $totalprice = $hargamasuk * $jumlahstock;

        $stock = new Stock();
        $stock->user_id = $user_id;
        $stock->item_name = $item_name;
        $stock->item_price_in = $hargamasuk;
        $stock->item_price_out = $hargakeluar;
        $stock->item_stock = $jumlahstock;
        $stock->save();

        //init transaksi
      
        $transaksi = new Transaksi();
        $transaksi->user_id = $user_id;
        $transaksi->item_id =  $stock->id;
        $transaksi->amount = $jumlahstock;
        $transaksi->inout = $inout;
        $transaksi->totalprice = $totalprice;
        $transaksi->save();

       
        return redirect()->back()->with('success',"Item baru telah ditambahkan!");
    }
    
    public function transaksi(){
        $user_id = Auth::id();
        $items = Transaksi::with(['Stock'])->where('user_id' , $user_id)->orderby('created_at','desc')->get();
        $startdate = Date('d/m/Y');
        $enddate = Date('d/m/Y');
        return view('user.transaksi' , ['items' => $items , 'startdate' => $startdate , 'enddate' => $enddate]);
    }

    public function transaksiFilter(Request $request){
        $user_id = Auth::id();
        $startdate = $request->input('tanggalmulai');
        $enddate = $request->input('tanggalakhir');
        if(is_null($enddate)){
            $items = Transaksi::with(['Stock'])->where('user_id' , $user_id)->where('created_at', '>=' ,$startdate)->orderby('created_at','desc')->get();
       }
       else{
            $items = Transaksi::with(['Stock'])->where('user_id' , $user_id)->where('created_at', '>' ,$startdate)->where('created_at', '<=' ,$enddate)->orderby('created_at','desc')->get();
       }
        return view('user.transaksi' , ['items' => $items , 'startdate' => $startdate , 'enddate' => $enddate]);
        
    }
    
    public function tempo(Request $request){
        $user_id = Auth::id();
        $item = $request->input('itemid');
        $item_id = explode(",",$item)[0];
        $amount = $request->input('amount');
        $inout = "OUT";
        $totalprice = $request->input('totalprice');
        $nama = $request->input('nama');


        //init stock
        $stock = Stock::find($item_id);
        //check stock
        if(($stock->item_stock-$amount) < 0){
            return redirect()->back()->with('error' , "Stock tidak mencukupi");
        }
        //init transaksi
        $transaksi = new Transaksi();
        $transaksi->nama = $nama;
        $transaksi->user_id = $user_id;
        $transaksi->item_id =  $item_id;
        $transaksi->amount = $amount;
        $transaksi->inout = $inout;
        $transaksi->totalprice = $totalprice;
        $transaksi->method = "tempo";
        $transaksi->save();
        
        //cutstock
        $stock->item_stock -= $amount;
        $stock->save();

        return redirect()->back()->with('success' , "Berhasil!");
    }

    public function transaksitempo(){
        $user_id = Auth::id();
        $items = Transaksi::with(['Stock'])->where('user_id' , $user_id)->where('method','tempo')->orderby('created_at','desc')->get();
        $startdate = Date('d/m/Y');
        $enddate = Date('d/m/Y');
        return view('user.transaksitempo' , ['items' => $items , 'startdate' => $startdate , 'enddate' => $enddate]);
    }

    public function transaksitempolunas($id){
        $data = Transaksi::where('id' , $id)->update(['method' => "cash" , 'created_at' => date('Y-m-d')]);
        return redirect()->back();
    }

    public function tutupbuku(){
        $user_id = Auth::id();
        $year = Date('Y');
        $month = Date('m');
        //$month = 2;
        $expense = Transaksi::where('user_id',Auth::id())->where('inout',"IN")->where('method',"cash")->whereYear('created_at', $year)->whereMonth('created_at',$month)->sum('totalprice');
        $income = Transaksi::where('user_id',Auth::id())->where('inout',"OUT")->where('method',"cash")->whereYear('created_at', $year)->whereMonth('created_at',$month)->sum('totalprice');
        
        //check sudah closing bulan ini belum
        $checkClosing = Report::where('user_id' , $user_id)->whereYear('created_at', $year)->whereMonth('created_at',$month)->pluck('id')->first();
        
        if(is_null($checkClosing)){
            $report = new Report();
            $report->user_id = $user_id;
            $report->date = date('Y-m-d H:i:s');
            $report->income = $income;
            $report->outcome = $expense;
            $report->profit = $income-$expense;
            $report->save();
        }
        else{
            $report = Report::where('id',$checkClosing)->update([
                'date' =>  date('Y-m-d H:i:s'),
                'income' => $income,
                'outcome' => $expense,
                'profit' => $income-$expense
                ]);
        }

        
        return redirect()->back()->with('success' , "Berhasil Closing");
    }

    public function reportprofit(){
        $user_id = Auth::id();
        $datas =  Report::where('user_id',$user_id)->orderby('date','desc')->take(3)->get(['date','profit']);
        $tanggal = array();
        $report = array();
        foreach($datas as $key => $data){
            array_push($tanggal,date("F d, Y",strtotime(substr($data->date,0,10))));
            array_push($report,$data->profit);
        }
        $tanggal = array_reverse($tanggal);
        $report = array_reverse($report);

        $label = "Profit";
        $color = array(
            'rgba(18,69,98, 1)',
            'rgba(18,69,98, 1)',
            'rgba(18,69,98, 1)',
            'rgba(18,69,98, 1)',
            'rgba(18,69,98, 1)',
            'rgba(18,69,98, 1)',
            'rgba(18,69,98, 1)',
            'rgba(18,69,98, 1)',
            'rgba(18,69,98, 1)',
            'rgba(18,69,98, 1)',
            'rgba(18,69,98, 1)',
            'rgba(18,69,98, 1)',
        );
        return view('user.chartprofit' , ['tanggal' => $tanggal , 'report' => $report ,'label' => $label , 'color' => $color , 'datas' => $datas]);
    }

    public function reportprofitfilter(Request $request){
        $period = $request->input('period');
        $user_id = Auth::id();
        $datas =  Report::where('user_id',$user_id)->orderby('date','desc')->take($period)->get(['date','profit']);
        $tanggal = array();
        $report = array();
        foreach($datas as $key => $data){
            array_push($tanggal,date("F d, Y",strtotime(substr($data->date,0,10))));
            array_push($report,$data->profit);
        }
        $tanggal = array_reverse($tanggal);
        $report = array_reverse($report);
        $label = "Profit";
        $color = array(
            'rgba(18,69,98, 1)',
            'rgba(18,69,98, 1)',
            'rgba(18,69,98, 1)',
            'rgba(18,69,98, 1)',
            'rgba(18,69,98, 1)',
            'rgba(18,69,98, 1)',
            'rgba(18,69,98, 1)',
            'rgba(18,69,98, 1)',
            'rgba(18,69,98, 1)',
            'rgba(18,69,98, 1)',
            'rgba(18,69,98, 1)',
            'rgba(18,69,98, 1)',
        );
        return view('user.chartprofit' , ['tanggal' => $tanggal , 'report' => $report ,'label' => $label , 'color' => $color , 'datas' => $datas]);
    }
    
    public function reportincome(){
        $user_id = Auth::id();
        $datas =  Report::where('user_id',$user_id)->orderby('date','desc')->take(3)->get(['date','income']);
        $tanggal = array();
        $report = array();
        foreach($datas as $key => $data){
            array_push($tanggal,date("F d, Y",strtotime(substr($data->date,0,10))));
            array_push($report,$data->income);
        }
        $tanggal = array_reverse($tanggal);
        $report = array_reverse($report);
        
        $label = "Pemasukan";
        $color = array(
            'rgba(89,152,26, 1)',
            'rgba(89,152,26, 1)',
            'rgba(89,152,26, 1)',
            'rgba(89,152,26, 1)',
            'rgba(89,152,26, 1)',
            'rgba(89,152,26, 1)',
            'rgba(89,152,26, 1)',
            'rgba(89,152,26, 1)',
            'rgba(89,152,26, 1)',
            'rgba(89,152,26, 1)',
            'rgba(89,152,26, 1)',
            'rgba(89,152,26, 1)',
        );
        return view('user.chartincome' , ['tanggal' => $tanggal , 'report' => $report ,'label' => $label , 'color' => $color , 'datas' => $datas]);
    }

    public function reportincomefilter(Request $request){
        $period = $request->input('period');
        $user_id = Auth::id();
        $datas =  Report::where('user_id',$user_id)->orderby('date','desc')->take($period)->get(['date','income']);
        $tanggal = array();
        $report = array();
        foreach($datas as $key => $data){
            array_push($tanggal,date("F d, Y",strtotime(substr($data->date,0,10))));
            array_push($report,$data->income);
        }
        $tanggal = array_reverse($tanggal);
        $report = array_reverse($report);
        
        $label = "Pemasukan";
        $color = array(
            'rgba(89,152,26, 1)',
            'rgba(89,152,26, 1)',
            'rgba(89,152,26, 1)',
            'rgba(89,152,26, 1)',
            'rgba(89,152,26, 1)',
            'rgba(89,152,26, 1)',
            'rgba(89,152,26, 1)',
            'rgba(89,152,26, 1)',
            'rgba(89,152,26, 1)',
            'rgba(89,152,26, 1)',
            'rgba(89,152,26, 1)',
            'rgba(89,152,26, 1)',
        );
        return view('user.chartincome' , ['tanggal' => $tanggal , 'report' => $report ,'label' => $label , 'color' => $color , 'datas' => $datas]);
    }

    public function reportoutcome(){
        $user_id = Auth::id();
        $datas =  Report::where('user_id',$user_id)->orderby('date','desc')->take(3)->get(['date','outcome']);
        $tanggal = array();
        $report = array();
        foreach($datas as $key => $data){
            array_push($tanggal,date("F d, Y",strtotime(substr($data->date,0,10))));
            array_push($report,$data->outcome);
        }
        $tanggal = array_reverse($tanggal);
        $report = array_reverse($report);

        $label = "Pengeluaran";
        $color = array(
            'rgba(228,61,64, 1)',
            'rgba(228,61,64, 1)',
            'rgba(228,61,64, 1)',
            'rgba(228,61,64, 1)',
            'rgba(228,61,64, 1)',
            'rgba(228,61,64, 1)',
            'rgba(228,61,64, 1)',
            'rgba(228,61,64, 1)',
            'rgba(228,61,64, 1)',
            'rgba(228,61,64, 1)',
            'rgba(228,61,64, 1)',
            'rgba(228,61,64, 1)',
        );
        return view('user.chartoutcome' , ['tanggal' => $tanggal , 'report' => $report ,'label' => $label , 'color' => $color , 'datas' => $datas]);
    }

    public function reportoutcomefilter(Request $request){
        $period = $request->input('period');
        $user_id = Auth::id();
        $datas =  Report::where('user_id',$user_id)->orderby('date','desc')->take($period)->get(['date','outcome']);
        $tanggal = array();
        $report = array();
        foreach($datas as $key => $data){
            array_push($tanggal,date("F d, Y",strtotime(substr($data->date,0,10))));
            array_push($report,$data->outcome);
        }
        $tanggal = array_reverse($tanggal);
        $report = array_reverse($report);
        $label = "Pengeluaran";
        $color = array(
            'rgba(228,61,64, 1)',
            'rgba(228,61,64, 1)',
            'rgba(228,61,64, 1)',
            'rgba(228,61,64, 1)',
            'rgba(228,61,64, 1)',
            'rgba(228,61,64, 1)',
            'rgba(228,61,64, 1)',
            'rgba(228,61,64, 1)',
            'rgba(228,61,64, 1)',
            'rgba(228,61,64, 1)',
            'rgba(228,61,64, 1)',
            'rgba(228,61,64, 1)',
        );
        return view('user.chartoutcome' , ['tanggal' => $tanggal , 'report' => $report ,'label' => $label , 'color' => $color , 'datas' => $datas]);
    }
    
    
}
