<?php

namespace Tests\Feature;

use App\Jobs\SendInvoice;
use App\Models\Invoice;
use App\Models\User;
use App\Notifications\InvoicePaid;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;


class SendInvoiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_sends_an_invoice_to_a_user()
    {

        Notification::fake();

        $user  =User::factory()->create();

        $invoice = new Invoice( // why doesn't he use a factory here?
            id: 'INV_stub123',
            total: 1500,
            chargeDate: now()->subWeek(),
            paid: true
        );

        SendInvoice::dispatch($invoice, $user);

        Notification::assertSentTo($user, InvoicePaid::class);
    }
}
