<?php

use App\Enum\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Renommé de 'name' à 'title'
            $table->text('description')->nullable();
            $table->date('due_date'); // Ajout de la date d'échéance
            $table->enum('status', [Status::PROGRESS, Status::DONE, Status::SUSPENDED])->default(Status::PROGRESS);
            $table->foreignId('project_id')->constrained()->onDelete('cascade'); // Projet associé
            $table->foreignId('user_id')->nullable(false)->constrained()->onDelete('cascade'); // Utilisateur assigné
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
