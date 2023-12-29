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
        CREATE TRIGGER cancelOrder
        AFTER UPDATE ON orders
        FOR EACH ROW
        BEGIN
            IF NEW.status = 5 THEN
                UPDATE order_items 
                    SET deleted_at = NOW()
                    WHERE order_id = NEW.id;
            END IF;
        END;

        CREATE TRIGGER cancelOrderItem
        AFTER UPDATE ON order_items
        FOR EACH ROW
        BEGIN
            DECLARE updated_quantity DECIMAL(10, 2);
            IF (NEW.deleted_at IS NOT NULL) THEN
                SET updated_quantity = CAST(NEW.weight AS DECIMAL(10, 2)) / 1000 * NEW.quantity;
                UPDATE products
                    SET products.store_quantity = products.store_quantity + updated_quantity
                WHERE products.id = NEW.product_id;
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
