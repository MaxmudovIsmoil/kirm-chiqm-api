<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
        CREATE OR REPLACE TRIGGER debtor_details_after_delete AFTER DELETE ON debtor_details FOR EACH ROW
            BEGIN
                IF OLD.status = 1 THEN
                    UPDATE debtors SET money = (money - OLD.money) WHERE debtors.id = OLD.debtor_id;
                ELSE
                    UPDATE debtors SET money = (money + OLD.money) WHERE debtors.id = OLD.debtor_id;
                END IF;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER debtor_details_after_delete');
    }
};
