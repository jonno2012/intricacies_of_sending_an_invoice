<?php

namespace App\Http\Controllers;

use App\Notifications\InvoicePaid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\Browsershot\Browsershot;

class InvoiceDownloadsController extends Controller
{
    public function __invoke(Request $request, $invoiceId)
    {

        Mail::raw('Melllo', fn($message) => $message->to('jrhillde@gmail.com'));

        $html = view('invoices.show', [
            'invoice' => $request->user()->subscription->invoice($invoiceId),
            'header' => 'Invoice for ' . $request->user()->name,
            'user' => $request->user()->name
        ])->render();

        $invoicePath = storage_path("app/{$invoiceId}.pdf");

        Browsershot::html($html)
            ->showBackground()
            ->margins(10, 10, 10, 10)
            ->save();

        $request->user($invoicePath)->notify(new InvoicePaid($invoicePath));

        return 'done';
    }
}
