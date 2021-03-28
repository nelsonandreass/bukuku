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
        //$month = 2;
        $expense = Transaksi::where('user_id',Auth::id())->where('inout',"IN")->whereYear('created_at', $year)->whereMonth('created_at',$month)->sum('totalprice');
        $income = Transaksi::where('user_id',Auth::id())->where('inout',"OUT")->whereYear('created_at', $year)->whereMonth('created_at',$month)->sum('totalprice');
        
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
        $tanggal = Report::where('user_id',$user_id)->orderby('date','desc')->take(3)->pluck('date');
        $report = Report::where('user_id',$user_id)->orderby('date','desc')->take(3)->pluck('profit');
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
        return view('user.chartprofit' , ['tanggal' => $tanggal , 'report' => $report ,'label' => $label , 'color' => $color]);
    }
    public function reportprofitfilter(Request $request){
        $period = $request->input('period');
        $user_id = Auth::id();
        $tanggal = Report::where('user_id',$user_id)->orderby('date','desc')->take($period)->pluck('date');
        $report = Report::where('user_id',$user_id)->orderby('date','desc')->take($period)->pluck('profit');
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
        return view('user.chartprofitfilter' , ['tanggal' => $tanggal , 'report' => $report ,'label' => $label , 'color' => $color]);
    }
    
    public function reportincome(){
        $user_id = Auth::id();
        $tanggal = Report::where('user_id',$user_id)->orderby('date','desc')->take(3)->pluck('date');
        $report = Report::where('user_id',$user_id)->orderby('date','desc')->take(3)->pluck('income');
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
        return view('user.chartincome' , ['tanggal' => $tanggal , 'report' => $report ,'label' => $label , 'color' => $color]);
    }
    public function reportincomefilter(Request $request){
        $period = $request->input('period');
        $user_id = Auth::id();
        $tanggal = Report::where('user_id',$user_id)->orderby('date','desc')->take($period)->pluck('date');
        $report = Report::where('user_id',$user_id)->orderby('date','desc')->take($period)->pluck('income');
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
        return view('user.chartincomefilter' , ['tanggal' => $tanggal , 'report' => $report ,'label' => $label , 'color' => $color]);
    }

    public function reportoutcome(){
        $user_id = Auth::id();
        $tanggal = Report::where('user_id',$user_id)->orderby('date','desc')->take(3)->pluck('date');
        $report = Report::where('user_id',$user_id)->orderby('date','desc')->take(3)->pluck('outcome');
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
        return view('user.chartincome' , ['tanggal' => $tanggal , 'report' => $report ,'label' => $label , 'color' => $color]);
    }

    public function reportoutcomefilter(Request $request){
        $period = $request->input('period');
        $user_id = Auth::id();
        $tanggal = Report::where('user_id',$user_id)->orderby('date','desc')->take($period)->pluck('date');
        $report = Report::where('user_id',$user_id)->orderby('date','desc')->take($period)->pluck('outcome');
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
        return view('user.chartincomefilter' , ['tanggal' => $tanggal , 'report' => $report ,'label' => $label , 'color' => $color]);
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
