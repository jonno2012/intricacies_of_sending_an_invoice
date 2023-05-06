<?php

namespace App\Http\Controllers;

use App\Jobs\SendInvoice;
use App\Notifications\InvoicePaid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\Browsershot\Browsershot;

class InvoiceDownloadsController extends Controller
{
    public function __invoke(Request $request, $invoiceId)
    {
        $request->user->sendInvoice($invoiceId);

        return 'done';
    }
}
