<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TransactionApiTest extends TestCase
{
    use DatabaseMigrations; 
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate', ['--database' => 'testing']);
    }

    public function testCreateTransaction()
{
    // data dummy
    $customer = factory(Customer::class)->create();
    $address = factory(CustomerAddress::class)->create(['customer_id' => $customer->id]);
    $product = factory(Product::class)->create();
    $paymentMethod = factory(PaymentMethod::class)->create();

    $data = [
        'customer_id' => $customer->id,
        'address_id' => $address->id,
        'product_id' => $product->id,
        'payment_method_id' => $paymentMethod->id,
        'quantity' => 3,
    ];

    // Mengirim permintaan POST ke endpoint API untuk membuat transaksi
    $response = $this->post('/api/transactions', $data);

    // Memeriksa respons HTTP
    $response->assertStatus(201);

    // Memeriksa apakah data transaksi sudah disimpan di database
    $this->assertDatabaseHas('transactions', [
        'customer_id' => $customer->id,
        'address_id' => $address->id,
        'product_id' => $product->id,
        'payment_method_id' => $paymentMethod->id,
        'quantity' => 3,
    ]);
}

}
