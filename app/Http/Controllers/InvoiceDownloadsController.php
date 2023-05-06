<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\Browsershot\Browsershot;

class InvoiceDownloadsController extends Controller
{
    public function __invoke(Request $request, $invoiceId)
    {

        $html = view('invoices.show', [
            'invoice' => $request->user()->subscription->invoice($invoiceId),
            'header' => 'Invoice for ' . $request->user()->name,
            'user' => $request->user()->name
        ])->render();

        Browsershot::html($html)
            ->showBackground()
            ->margins(10, 10, 10, 10)
            ->save(storage_path("app/{$invoiceId}.pdf"));

        return 'done';
    }
}
