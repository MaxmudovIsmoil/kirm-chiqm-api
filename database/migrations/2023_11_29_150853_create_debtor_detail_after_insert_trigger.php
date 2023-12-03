<?php

use Illuminate\Database\Migrations\Migration;
use \Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
        CREATE OR REPLACE TRIGGER debtor_details_after_insert AFTER INSERT ON debtor_details FOR EACH ROW
            BEGIN
                IF NEW.status = 1 THEN
                    UPDATE debtors SET money = money + NEW.money WHERE debtors.id = NEW.debtor_id;
                ELSE
                    UPDATE debtors SET money = money - NEW.money WHERE debtors.id = NEW.debtor_id;
                END IF;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER debtor_details_after_insert');
    }
};
