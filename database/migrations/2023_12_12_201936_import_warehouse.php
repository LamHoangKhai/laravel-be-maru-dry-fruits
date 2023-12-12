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
        CREATE TRIGGER import
        AFTER INSERT ON transactions
        FOR EACH ROW
        BEGIN
            if NEW.transaction_type = 1 THEN 
                if(NEW.quantity != NEW.current_quantity) THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "Error: The quantity need equal to current quantity.";
                END IF;
                UPDATE products
                SET stock_quantity = stock_quantity + NEW.quantity
                WHERE id = NEW.product_id;
            END IF;
        END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
