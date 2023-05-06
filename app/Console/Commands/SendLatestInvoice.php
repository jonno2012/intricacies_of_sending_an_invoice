<?php

namespace App\Console\Commands;

use App\Jobs\SendInvoice;
use App\Models\User;
use Illuminate\Console\Command;

class SendLatestInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jrhill:send-latest-invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a user their most recent invoice';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->ask('What is the email address of the account');

        $user = User::where(['email' => $email])->firstOrFail()->sendLatestInvoice();

        $this->info("Invoice delivered to {$user->name}");

        return 0;
    }
}
