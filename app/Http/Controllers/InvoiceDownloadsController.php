<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvoiceDownloadsController extends Controller
{
    public function __invoke(Request $request, $invoiceId)
    {
        $html = view('invoices.show', [
            'invoice' => $request->user()->subscription->invoice($invoiceId),
            'header' => 'Invoice for ' . $request->user()->name,
            'user' => $request->user()->name
        ]);

        return $html;
    }
}
