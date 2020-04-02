<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class AddedUserGithubProfileField
 */
class AddedUserGithubProfileField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'users', function (Blueprint $table) {
                $table->string('github_username')->after('email');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            'users', function (Blueprint $table) {
                $table->dropColumn('github_username');
            }
        );
    }
}
