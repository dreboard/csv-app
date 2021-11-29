<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number');
            $table->string('email')->unique();
            $table->unique(['first_name', 'last_name'], 'index_contact_name');
            $table->timestamps();
        });

        DB::table('contacts')->insert([
            'id' => 1,
            'first_name' => 'Andre',
            'last_name' => 'Board',
            'email' => 'dre.board@gmail.com',
            'phone_number' => '444-444-4444',
            'created_at' => '2021-11-01 02:17:51.000000'
        ]);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
