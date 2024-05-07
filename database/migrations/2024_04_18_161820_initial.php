<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Administrator, Employee, Customer
            $table->enum('type', ['A', 'E', 'C']);

            // User access is blocked
            $table->boolean('blocked')->default(false);

            // User Photo/Avatar
            $table->string('photo_filename')->nullable();

            // custom data
            $table->json('custom')->nullable();

            // Users can be deleted with "soft deletes"
            $table->softDeletes();
        });

        Schema::create('customers', function (Blueprint $table) {
            // Customer primary key is the same as the user primary key
            // ("customers" entity is a subclass of "users" entity
            $table->bigInteger('id')->unsigned()->primary();
            $table->foreign('id')->references('id')->on('users');

            $table->string('nif', 9)->nullable();

            // Default Payment Type for the customer
            // VISA - Visa
            // PAYPAL - Paypal
            // MBWAY - MB way
            // This is nullable, because customer might not have a default payment type
            $table->enum('payment_type', ['VISA', 'PAYPAL', 'MBWAY'])->nullable();

            // Default payment reference, that depends of the payment type:
            // VISA -> Card Number with 16 digitos
            // PAYPAL -> email
            // MBWay -> PT mobile phone - 9 digits (1st digit is always)
            // This is nullable, because customer might not have a default payment reference
            $table->string('payment_ref')->nullable();

            // custom data
            $table->json('custom')->nullable();

            // Timestamps
            $table->timestamps();
            // Customers can be deleted with "soft deletes"
            $table->softDeletes();
        });

        // Parametros de configuração - só deverá haver 1 registo
        Schema::create('configuration', function (Blueprint $table) {
            $table->id();
            $table->decimal('ticket_price', 8, 2);     // e.g. 9.00
            $table->decimal('registered_customer_ticket_discount', 8, 2);  // e.g. 1.00

            // custom data
            $table->json('custom')->nullable();
        });

        // Theaters
        Schema::create('theaters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // Teather Photo - optional
            $table->string('photo_filename')->nullable();

            // custom data
            $table->json('custom')->nullable();

            // Theaters can be deleted with "soft deletes"
            $table->softDeletes();
        });

        // Seats
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('theater_id');
            $table->foreign('theater_id')->references('id')->on('theaters');
            $table->string('row', 1);
            $table->integer('seat_number');

            // custom data
            $table->json('custom')->nullable();
            // Seats should be softdeleted if the associated theater is also soft deleted
            $table->softDeletes();
        });

        // Movies genres
        Schema::create('genres', function (Blueprint $table) {
            $table->string('code', 20);
            $table->primary('code');
            $table->string('name');

            // custom data
            $table->json('custom')->nullable();

            // Movie genres can be deleted with "soft deletes"
            $table->softDeletes();
        });

        // Movies
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('genre_code', 20);
            $table->foreign('genre_code')->references('code')->on('genres');
            $table->integer('year');
            // Poster image. If poster image is null, application should present a default image
            $table->string('poster_filename')->nullable();
            $table->text('synopsis');
            // Trailer (with video) is an external link
            $table->string('trailer_url')->nullable();

            // custom data
            $table->json('custom')->nullable();

            // Timestamps
            $table->timestamps();
            // Movies can be deleted with "soft deletes"
            $table->softDeletes();
        });

        // Screenings
        Schema::create('screenings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id');
            $table->foreign('movie_id')->references('id')->on('movies');
            $table->foreignId('theater_id');
            $table->foreign('theater_id')->references('id')->on('theaters');
            $table->date('date');
            $table->time('start_time');

            // custom data
            $table->json('custom')->nullable();

            // Timestamps
            $table->timestamps();
        });

        // purchases
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            // Purchase customer might not be a registered known customer
            // Therefore, customer_id accepts nulls
            $table->foreignId('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->date('date');
            $table->decimal('total_price', 8, 2);
            // if Purchase customer is registered, the customer_name and NIF will assume (by Default) the registered customer name
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('nif', 9)->nullable();
            // Payment Type
            // VISA - Visa
            // PAYPAL - Paypal
            // MBWAY - MB way
            $table->enum('payment_type', ['VISA', 'PAYPAL', 'MBWAY']);
            // Payment Reference depends of the payment type
            // VISA -> Card Number with 16 digitos
            // PAYPAL -> email
            // MBWay -> PT mobile phone - 9 digits (1st digit is always)
            $table->string('payment_ref');

            // If the application stores the receipt PDF copy,
            $table->string('receipt_pdf_filename')->nullable();

            // custom data
            $table->json('custom')->nullable();

            $table->timestamps();
        });


        // Tickets
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('screening_id');
            $table->foreign('screening_id')->references('id')->on('screenings');
            $table->foreignId('seat_id');
            $table->foreign('seat_id')->references('id')->on('seats');
            $table->foreignId('purchase_id');
            $table->foreign('purchase_id')->references('id')->on('purchases');
            $table->decimal('price', 8, 2);

            // If the application uses a qr_code (URL) for the ticket
            // Note: must be an absolute URL
            $table->string('qrcode_url')->nullable();

            $table->enum('status', ['valid', 'invalid'])->default('valid');

            // custom data
            $table->json('custom')->nullable();

            $table->timestamps();
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
