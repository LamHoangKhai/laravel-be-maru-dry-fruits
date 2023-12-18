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
        CREATE TRIGGER export
	BEFORE INSERT ON warehouse
	FOR EACH ROW
	BEGIN	
		IF (NEW.transaction_date > CURDATE()) THEN
        SIGNAL SQLSTATE "45000"
        SET MESSAGE_TEXT = "Error: Transaction date cannot be in the future.";
    	END IF;
    
	    IF NEW.expiration_date < CURDATE() THEN
	    	SIGNAL SQLSTATE "45000"
	    	SET MESSAGE_TEXT = "Error: Expiration date cannot be in the past.";
	    END IF;
   
	   IF NEW.transaction_type = 2 THEN
	   	IF NOT EXISTS(SELECT 1 FROM warehouse WHERE (transaction_type = 1 AND shipment = NEW.shipment AND product_id = NEW.product_id)) THEN
	   		SIGNAL SQLSTATE "45000"
    			SET MESSAGE_TEXT = "Error: Shipment does not exist.";
    		END IF;
    		
    		IF NOT EXISTS(SELECT 1 FROM warehouse WHERE (transaction_type = 1 AND expiration_date = NEW.expiration_date AND product_id = NEW.product_id)) THEN
	   		SIGNAL SQLSTATE "45000"
    			SET MESSAGE_TEXT = "Error: Expiration date does not exist.";
    		END IF;
    		
    		IF NOT EXISTS(SELECT 1 FROM warehouse WHERE(transaction_type = 1 AND transaction_date <= NEW.transaction_date AND product_id = NEW.product_id)) THEN
	   		SIGNAL SQLSTATE "45000"
    			SET MESSAGE_TEXT = "Error: Transaction date does not exist.";
    		END IF;
    		
	   	IF(NEW.quantity > (SELECT stock_quantity FROM products WHERE id = NEW.product_id)) THEN
	   		SIGNAL SQLSTATE "45000"
		      SET MESSAGE_TEXT = "Error: Export need to equal or smaller than stock quantity.";
	   	ELSEIF(NEW.quantity > (SELECT MIN(current_quantity) FROM warehouse WHERE(shipment = NEW.shipment AND product_id = NEW.product_id))) THEN
	   		SIGNAL SQLSTATE "45000"
		      SET MESSAGE_TEXT = "Error: Export need to equal or smaller than stock quantity.";
	      END IF;
	
			SET NEW.current_quantity = 
				(SELECT current_quantity FROM warehouse WHERE transaction_type = 1 AND shipment = NEW.shipment AND product_id = NEW.product_id LIMIT 1) - NEW.quantity;
			UPDATE products
				SET products.store_quantity = products.store_quantity + NEW.quantity,
					 products.stock_quantity = stock_quantity - NEW.quantity
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

	}
};
