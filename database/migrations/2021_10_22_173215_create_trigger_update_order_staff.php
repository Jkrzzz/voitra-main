<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTriggerUpdateOrderStaff extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
        CREATE TRIGGER `after_orders_update` AFTER UPDATE ON orders
             FOR EACH ROW
             BEGIN
                    UPDATE admins
SET total_order = (SELECT COUNT(*) FROM orders WHERE (orders.estimate_staff = admins.id OR orders.edit_staff = admins.id) AND orders.plan = 2),
total_order_processing = (SELECT COUNT(*) FROM orders WHERE (orders.estimate_staff = admins.id OR orders.edit_staff = admins.id) AND ( orders.status IN (1,2,3,4,5,11,12))  AND orders.plan = 2),
total_char_processing = (SELECT COALESCE(SUM(orders.total_time),0) FROM orders WHERE (orders.estimate_staff = admins.id OR orders.edit_staff = admins.id) AND ( orders.status IN (1,2,3,4,5,11,12)) AND orders.plan = 2);
             END
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `after_orders_update`');
    }
}
