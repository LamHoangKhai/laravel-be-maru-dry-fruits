<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      
        DB::unprepared('
        CREATE TRIGGER updateWarehouse
        BEFORE UPDATE ON warehouse
        FOR EACH ROW
        BEGIN
            if(NEW.quantity != OLD.quantity) THEN
                if(NEW.transaction_type = 1) THEN
                    UPDATE products
                    SET products.stock_quantity = products.stock_quantity + NEW.quantity - OLD.quantity
                    WHERE products.id =  NEW.product_id;
                    SET NEW.current_quantity = NEW.quantity;
                ELSE 
                    UPDATE products
                    SET products.stock_quantity = products.stock_quantity - NEW.quantity + OLD.quantity,
                         products.store_quantity = products.store_quantity - OLD.quantity + NEW.quantity
                    WHERE products.id =  NEW.product_id;
                    SET NEW.current_quantity = (SELECT quantity FROM warehouse WHERE (transaction_type = 1 AND product_id = NEW.product_id AND shipment = NEW.shipment)) - NEW.quantity;
                END IF;
            
            ELSEIF(NEW.transaction_type != OLD.transaction_type) THEN
                    IF(NEW.transaction_type = 1) THEN
                        UPDATE products
                            SET stock_quantity = stock_quantity + 2 * OLD.quantity,
                                 store_quantity = store_quantity -  OLD.quantity
                            WHERE products.id = NEW.product_id;
                        SET NEW.current_quantity = OLD.quantity;
                        
                    ELSEIF(NEW.transaction_type = 2) THEN
                        UPDATE products
                        SET products.stock_quantity = products.stock_quantity - 2 * NEW.quantity,
                             products.store_quantity = products.store_quantity + NEW.quantity
                        WHERE products.id =  NEW.product_id;
                        SET NEW.current_quantity = 
                        (SELECT quantity FROM warehouse WHERE transaction_type = 1 AND shipment = NEW.shipment AND product_id = NEW.product_id LIMIT 1) 
                        - (SELECT IFNULL(SUM(quantity), 0) FROM warehouse WHERE(transaction_type = 2 AND product_id = NEW.product_id AND shipment = NEW.shipment)) - NEW.quantity;
                    END IF;
                        
            ELSEIF(NEW.product_id != OLD.product_id) THEN
                if(NEW.transaction_type = 1) THEN
                    UPDATE products
                    SET products.stock_quantity = products.stock_quantity + NEW.quantity
                    WHERE products.id =  NEW.product_id;
                    SET NEW.current_quantity = NEW.quantity;
                    
                    UPDATE products
                    SET products.stock_quantity = products.stock_quantity - NEW.quantity
                    WHERE products.id =  OLD.product_id;
                    SET NEW.current_quantity = NEW.quantity;
                ELSE 
                    UPDATE products
                    SET products.stock_quantity = products.stock_quantity + NEW.quantity,
                        products.store_quantity = products.store_quantity - NEW.quantity
                    WHERE products.id =  OLD.product_id;
                        
                    UPDATE products
                    SET products.stock_quantity = products.stock_quantity - NEW.quantity,
                         products.store_quantity = products.store_quantity + NEW.quantity
                    WHERE products.id =  NEW.product_id;
                    SET NEW.current_quantity =
                    (SELECT quantity FROM warehouse WHERE transaction_type = 1 AND shipment = NEW.shipment AND product_id = NEW.product_id LIMIT 1) 
                    - (SELECT IFNULL(SUM(quantity), 0) FROM warehouse WHERE(transaction_type = 2 AND product_id = NEW.product_id AND shipment = NEW.shipment)) - NEW.quantity;
                    
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
       
    }
};
