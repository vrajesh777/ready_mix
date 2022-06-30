<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\EmpIqamaModel;
use Mail;
class IqamaValidityCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'iqama_passport_expiry_check:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Iqama and Passport Expiry date';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->UserModel = new User;
        $this->EmpIqamaModel = new EmpIqamaModel;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $details = [
            'title' => 'Mail from ReadyMix',
            'body' => 'This is for testing email using smtp'
        ];
        $arr_iqamas = [];
        $today = date('Y-m-d');
        $afterOneMonth = date('Y-m-d', strtotime("+30 day", strtotime($today)));
        $afterTwoMonth = date('Y-m-d', strtotime("+60 day", strtotime($today)));
        $arr_iqamas = [];
        $obj_iqamas = $this->UserModel->join('iqamas', 'users.id', '=', 'iqamas.user_id')
            ->get(['users.email', 'users.mobile_no', 'users.join_date', 'users.first_name', 'users.last_name', 'users.role_id', 'iqamas.*']);

        if ($obj_iqamas) {
            $arr_iqamas = $obj_iqamas->toArray();
        }
        foreach ($arr_iqamas as $key => $row) {
            $details['name']  = $row['first_name'] ?? '' . ' ' . $row['last_name'] ?? '';
            $details['email'] = $row['email'] ?? '';
            $details['mobile_no'] = $row['mobile_no'] ?? '';
            if (!empty($row['email'])) {
                if (!empty($row['iqama_expiry_date']) && $row['iqama_expiry_date'] === $afterOneMonth) {
                    //send Iqama Expiry mail
                    $details['body'] = "Iqama of following employee is going to Expire on {$afterOneMonth}";
                    $details['doc_no'] = "Iqama No: " . $row['iqama_no'] ?? '';
                    \Mail::to(env('MAIL_TO_ADDRESS'))->send(new \App\Mail\MyEmailer($details));
                }
                if (!empty($row['passport_expiry_date']) && $row['passport_expiry_date'] === $afterOneMonth) {
                    //send passport Expiry mail
                    $details['body'] = "Passport of following employee is going to Expire on {$afterOneMonth}";
                    $details['doc_no'] = "Passport No: " . $row['passport_no'] ?? '';
                    \Mail::to(env('MAIL_TO_ADDRESS'))->send(new \App\Mail\MyEmailer($details));
                }
                if (!empty($row['join_date'])) {
                    //send contract Period Expiry mail
                    $contract_expiry = date('Y-m-d', strtotime("+2 years", strtotime($row['join_date'])));
                    if ($contract_expiry === $afterTwoMonth) {
                        $details['body'] = "Contract Period of following employee is going to Expire on {$contract_expiry}";
                        $details['doc_no'] = "";
                        \Mail::to(env('MAIL_TO_ADDRESS'))->send(new \App\Mail\MyEmailer($details));
                    }
                }
            }
        }
    }
}
