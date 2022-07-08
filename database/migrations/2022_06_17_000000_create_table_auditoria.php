<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAuditoria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::connection(config('auditoria.db_connection'))->hasTable('auditoria')) {
            return;
        }

        Schema::connection(config('auditoria.db_connection'))->create('auditoria', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('accion')->index();
            $table->text('query');
            $table->string('usuario_id')->index()->nullable();
            $table->text('payload');
            $table->string('url')->index();
            $table->string('tabla')->index();
            $table->timestamp('created_at')->nullable()->index();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('auditoria.db_connection'))->dropIfExists('auditoria');
    }
}