<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained();
            $table->string('status')->default('pending');
            $table->dateTime('order_time');
            $table->dateTime('delivery_time');
            $table->integer('pre_tax');
            $table->integer('tax');
            $table->integer('total');
            $table->timestamps();
        });
    }
};
