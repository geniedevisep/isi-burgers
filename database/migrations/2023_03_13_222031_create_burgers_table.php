<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('burgers', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->decimal('prix', 10, 2);
            $table->text('description');
            $table->string('image');
            $table->integer('stock')->default(0);
            $table->string('categorie');
            $table->boolean('archived')->default(false);
            $table->boolean('disponible')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('burgers');
    }
}; 