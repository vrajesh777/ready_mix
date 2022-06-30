<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OrdersModel;
use App\Models\CronCheckModel;

class ShiftOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shift_order:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shift pending current date order to next date';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->OrdersModel = new OrdersModel;
        $this->CronCheckModel = new CronCheckModel;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data['time'] = date('h:i A');
        $this->CronCheckModel->create($data);
        $arr_orders = [];
        $today = date('Y-m-d');
        $today = date('Y-m-d',strtotime("-1 day", strtotime($today)));
        
        $obj_orders = $this->OrdersModel->whereHas('ord_details', function(){})
                                    ->with(['ord_details.del_notes'])
                                    ->whereDate('extended_date',$today)
                                    ->get();

        if($obj_orders)
        {
            $arr_orders = $obj_orders->toArray();
        }
        
        $booking_qty = $del_qty = $remaing_qty = 0;

        foreach ($arr_orders as $key => $value) {

            $booking_qty = $value['ord_details'][0]['quantity'] ?? 0;
            $del_qty     = array_sum(array_column($value['ord_details'][0]['del_notes'],'quantity')) ?? 0;
            $remaing_qty = $booking_qty - $del_qty;

            if($remaing_qty > 0)
            {
                $extended_date = date('Y-m-d',strtotime("+1 day", strtotime($value['extended_date'])));

                $this->OrdersModel->where('id',$value['id'])
                                  ->update(['extended_date'=>$extended_date]);
            }
            
        }
    }
}
