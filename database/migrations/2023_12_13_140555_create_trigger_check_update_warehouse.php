<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
        CREATE TRIGGER checkUpdateTransaction
        AFTER UPDATE ON warehouse
        FOR EACH ROW
        BEGIN
            IF(NEW.quantity != OLD.quantity) THEN
                IF(NEW.transaction_type = 2) THEN
                    IF(NEW.quantity > (SELECT stock_quantity FROM products WHERE id = NEW.product_id) OR NEW.quantity > (SELECT MIN(current_quantity) FROM warehouse WHERE(shipment = NEW.shipment AND product_id = NEW.product_id))) THEN
                       SIGNAL SQLSTATE "45000"
                      SET MESSAGE_TEXT = "Error: Export need to equal or smaller than stock quantity.";
                  END IF;
              END IF;
            ELSEIF (NEW.transaction_type != OLD.transaction_type) THEN
                if(NEW.transaction_type = 1) THEN
                    IF (SELECT COUNT(*) FROM warehouse WHERE shipment = NEW.shipment > 1) THEN
                       SIGNAL SQLSTATE "45000"
                       SET MESSAGE_TEXT = "Error: Shipment was exist.";
                    END IF;
                ELSE 
                    IF NOT EXISTS(SELECT * FROM warehouse WHERE transaction_type = 1) THEN
                        SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "Error: Cannot change ";
                    END IF;
                    IF NOT EXISTS(SELECT 1 FROM warehouse WHERE transaction_type = 1 AND shipment = NEW.shipment AND product_id = NEW.product_id) THEN
                       SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "Error: Shipment does not exist.";
                    END IF;
    
                    IF NOT EXISTS(SELECT 1 FROM warehouse WHERE transaction_type = 1 AND product_id = NEW.product_id AND expiration_date = NEW.expiration_date) THEN
                          SIGNAL SQLSTATE "45000"
                          SET MESSAGE_TEXT = "Error: Expiration date does not exist.";
                      END IF;
                
                    IF NOT EXISTS(SELECT 1 FROM warehouse WHERE transaction_type = 1 AND product_id = NEW.product_id AND transaction_date < NEW.transaction_date) THEN
                       SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "Error: Transaction date does not exist.";
                    END IF;
                END IF;
                
              ELSEIF(NEW.product_id != OLD.product_id) THEN
                IF NOT EXISTS(SELECT 1 FROM products WHERE id = NEW.product_id) THEN
                   SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "Error: Product was not exist.";
                  END IF;
                  
                  IF(NEW.transaction_type = 2) THEN
                      IF NOT EXISTS(SELECT shipment FROM warehouse WHERE(transaction_type = 1 AND product_id = NEW.product_id AND shipment = NEW.shipment)) THEN
                          SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "Error: Shipment was not exist.";
                   END IF;
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
