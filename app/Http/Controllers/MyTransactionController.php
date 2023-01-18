<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;

class MyTransactionController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['orders.product.category'])->paginate(5);
        // header('Content-Type: application/json');
        // echo json_encode($invoices);
        // die;
        return view('pages.my-account', compact('invoices'));
    }
}
