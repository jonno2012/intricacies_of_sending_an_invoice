<?php

namespace App\Jobs;

use App\Models\Invoice;
use App\Models\User;
use App\Notifications\InvoicePaid;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Spatie\Browsershot\Browsershot;

class SendInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Invoice $invoice, protected User $user)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $html = $this->html();


        $invoicePath = storage_path("app/{$this->invoice->id()}.pdf");

        Browsershot::html($html)
            ->showBackground()
            ->margins(10, 10, 10, 10)
            ->save($invoicePath);

        $this->user->notify(new InvoicePaid($invoicePath));
    }

    /**
     * @return string
     */
    public function html(): string
    {
        return view('invoices.show', [
            'invoice' => $this->invoice,
        ])->render();
    }
}
