<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameAdminNotesToSellerNotesInTransactionsTable extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->renameColumn('admin_notes', 'seller_notes');
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->renameColumn('seller_notes', 'admin_notes');
        });
    }
}