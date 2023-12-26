<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER check_cancel_order
            AFTER UPDATE ON orders
            FOR EACH ROW
            BEGIN
                IF NEW.status = 5 THEN
                    IF((SELECT COUNT(*) FROM (SELECT orders.status FROM orders 
                            WHERE orders.user_id = NEW.user_id
                            ORDER BY orders.created_at DESC LIMIT 3) AS checkOrder WHERE checkOrder.status = 5 GROUP BY checkOrder.status) = 3) THEN
                            UPDATE users
                                SET users.status = 2 WHERE users.id = NEW.user_id;
                    END IF;
                END IF;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trigger_check_cancel_order');
    }
};
