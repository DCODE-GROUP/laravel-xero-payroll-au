<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXeroTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xero_tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->text('id_token');
            $table->string('token_type')->nullable();
            $table->text('access_token');
            $table->text('refresh_token')->nullable();
            $table->string('scope')->nullable();
            $table->string('current_tenant_id')->nullable();
            $table->integer('expires')->nullable();
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
        Schema::dropIfExists('xero_tokens');
    }
}
