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
    public function __construct(
        protected Invoice $invoice,
        protected User $user
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->saveInvoiceAsPdf();

        $this->user->notify(new InvoicePaid($this->invoice));
    }

    protected function saveInvoiceAsPdf(): void
    {

        // $base64Pdf = Browsershot::html($view)->base64pdf();

        // app/Notifications/InvoicePaid.php

//        return (new MailMessage()) // a better to do it if you don't need to save all of the generated files.
//            ->line("You have a new paid invoice from Laracasts.")
//            ->line("Thank you for using our application!")
//            ->attachData(base64_decode($this->$base64Pdf), 'invoice.pdf');

        Browsershot::html($this->html())
            ->showBackground()
            ->margins(10, 10, 10, 10)
            ->save($this->invoice->downloadPath());
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
