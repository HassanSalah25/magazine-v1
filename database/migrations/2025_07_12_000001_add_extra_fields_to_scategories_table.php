<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldsToScategoriesTable extends Migration
{
    public function up()
    {
        Schema::table('scategories', function (Blueprint $table) {
            $table->string('second_image')->nullable();
            $table->string('third_image')->nullable();
            $table->string('video_link')->nullable();
            $table->text('process_list')->nullable();
            $table->string('caption')->nullable();
        });
    }

    public function down()
    {
        Schema::table('scategories', function (Blueprint $table) {
            $table->dropColumn(['second_image', 'third_design', 'video_link', 'process_list', 'caption']);
        });
    }
}

