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
    public function index()
    {   
        $user_id = Auth::id();
        $year = Date('Y');
        $month = Date('m');
        $query = Transaksi::with(['Stock'])->where('user_id',$user_id)->whereYear('created_at', $year)->whereMonth('created_at',$month)->get();
        $count = sizeof($query);
        $expense = Transaksi::where('user_id',$user_id)->where('inout',"IN")->whereYear('created_at', $year)->whereMonth('created_at',$month)->sum('totalprice');
        $income = Transaksi::where('user_id',$user_id)->where('inout',"OUT")->whereYear('created_at', $year)->whereMonth('created_at',$month)->sum('totalprice');
        $profit = number_format( $income-$expense,0);
        $expense = number_format( $expense,0);
        $income = number_format( $income,0);
        
     

        return view('user.home' , ['count' => $count , 'expense' => $expense , 'income' => $income , 'profit' => $profit]);
    }

    public function itemkeluar(){
        $items = Stock::where('user_id' , Auth::id())->get();
        return view('user.itemkeluar' , ['items' => $items]);
    }
    public function itemkeluarProcess(Request $request){
        $user_id = Auth::id();
        $item = $request->input('itemid');
        $item_id = explode(",",$item)[0];
        $amount = $request->input('amount');
        $inout = "OUT";
        $totalprice = $request->input('totalprice');

        $transaksi = new Transaksi();
        $transaksi->user_id = $user_id;
        $transaksi->item_id =  $item_id;
        $transaksi->amount = $amount;
        $transaksi->inout = $inout;
        $transaksi->totalprice = $totalprice;
        $transaksi->save();
        
        $stock = Stock::find($item_id);
        $stock->item_stock -= $amount;
        $stock->save();

        return redirect()->back();

    }
    public function itemmasuk(){
        $items = Stock::where('user_id' , Auth::id())->get();
        return view('user.itemmasuk' , ['items' => $items]);
    }
    public function itemmasukProcess(Request $request){
        $user_id = Auth::id();
        $item = $request->input('itemid');
        $item_id = explode(",",$item)[0];
        $amount = $request->input('amount');
        $inout = "IN";
        $totalprice = $request->input('totalprice');

        $transaksi = new Transaksi();
        $transaksi->user_id = $user_id;
        $transaksi->item_id =  $item_id;
        $transaksi->amount = $amount;
        $transaksi->inout = $inout;
        $transaksi->totalprice = $totalprice;
        $transaksi->save();

        $stock = Stock::find($item_id);
        $stock->item_stock += $amount;
        $stock->save();

        return redirect()->back();
    }
    public function stock(){
        $items = Stock::where('user_id' , Auth::id())->get();
        return view('user.stock' , ['items' => $items]);
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
        return redirect()->back();;
    }

    public function transaksi(){
        $user_id = Auth::id();
        $items = Transaksi::with(['Stock'])->where('user_id' , $user_id)->orderby('created_at','desc')->get();
        
        return view('user.transaksi' , ['items' => $items]);
    }

    public function transaksiFilter(Request $request){
        $user_id = Auth::id();
        $startdate = $request->input('tanggalmulai');
        $enddate = $request->input('tanggalakhir');

        $items = Transaksi::with(['Stock'])->where('user_id' , $user_id)->whereBetween('created_at' , [$startdate,$enddate])->orderby('created_at','desc')->get();
        
        return view('user.transaksifilter' , ['items' => $items]);
        
    }
    
    public function tutupbuku(){
        $user_id = Auth::id();
        $year = Date('Y');
        $month = Date('m');
        $expense = Transaksi::where('user_id',Auth::id())->where('inout',"IN")->whereYear('created_at', $year)->whereMonth('created_at',$month)->sum('totalprice');
        $income = Transaksi::where('user_id',Auth::id())->where('inout',"OUT")->whereYear('created_at', $year)->whereMonth('created_at',$month)->sum('totalprice');
        $report = new Report();
        $report->user_id = $user_id;
        $report->date = date('Y-m-d H:i:s');
        $report->income = $income;
        $report->outcome = $expense;
        $report->profit = $expense-$income;
        $report->save();
    }

    public function reportprofit(){
        $user_id = Auth::id();
        $tanggal = Report::where('user_id',$user_id)->orderby('date','desc')->take(3)->pluck('date');
        $report = Report::where('user_id',$user_id)->orderby('date','desc')->take(3)->pluck('profit');
       
        return view('user.chartprofit' , ['tanggal' => $tanggal , 'report' => $report]);
    }
    public function reportprofitfilter(Request $request){
        $period = $request->input('period');
        $user_id = Auth::id();
        $tanggal = Report::where('user_id',$user_id)->orderby('date','desc')->take($period)->pluck('date');
       
        $report = Report::where('user_id',$user_id)->orderby('date','desc')->take($period)->pluck('profit');
       

        return view('user.chartprofitfilter' , ['tanggal' => $tanggal , 'report' => $report]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        
    }
}
