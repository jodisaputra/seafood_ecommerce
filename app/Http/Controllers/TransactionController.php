<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Order;
use App\Models\Invoice;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = Invoice::all();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '';
                    $btn .= '<a href="'. route('transaction.show', $row->id) .'" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> See Details</a>';
                    return $btn;
                })
                ->addColumn('status', function($row){
                    $paymentStatus = ucfirst($row->status);
                    return $paymentStatus;
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }
        return view('pages.admin.transaction.index');
    }

    public function show($id)
    {
        $invoice = Invoice::where('id', $id)->with(['customer','orders.product.category'])->first();
        // header('Content-Type: application/json');
        // echo json_encode($invoice);
        // die;

        return view('pages.admin.transaction.invoice', [
            'invoice' => $invoice
        ]);

    }

    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->update([
            'delivery_status'     => $request->delivery_status,
        ]);

        Alert::toast('Berhasil Diubah', 'success');
        return redirect()->route('transaction.show', $id);
    }
}
