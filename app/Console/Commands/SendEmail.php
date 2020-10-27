<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\CommModel;
use PDF;
use GuzzleHttp\Client;
use App\Mail\InvoiceCreated;
use App\Mail\OrderCreated;
use Illuminate\Support\Facades\DB;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendmail:order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'For Sending Sales Orders';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $get_orders = CommModel::where(['DocType'=>'Sales Order', 'Status'=>1])->get();
        foreach($get_orders as $get_cardcode)
        {
            $get_email = DB::table('OCRD')
                        ->join('SMS_Emails_messages', 'SMS_Emails_messages.CardCode', '=', 'OCRD.CardCode')
                        ->where(['SMS_Emails_messages.CardCode'=> $get_cardcode->CardCode])
                        ->select('OCRD.*')
                        ->first();
            $customer_email = $get_email->E_Mail;
            $get_docentry = DB::table('ORDR')
                        ->join('SMS_Emails_messages', 'ORDR.DocNum', '=', 'SMS_Emails_messages.DocNum')
                        ->where('SMS_Emails_messages.DocNum', '=', $get_cardcode->DocNum)
                        ->select('ORDR.*')
                        ->first();
            $products = DB::table('RDR1')
                        ->where('RDR1.DocEntry', '=', $get_docentry->DocEntry)
                        ->get();

            $pdf =PDF::loadView('pdfs.order_created', compact('products', 'get_docentry', 'get_email'));

            $email_message =new OrderCreated($products, $get_docentry, $get_email);
            $email_message->attachData($pdf->output(), "Sales Order.pdf");

            \Mail::to($customer_email)->send($email_message);

            $update_status = CommModel::where('Id', $get_cardcode->Id)->update(['Status'=>0]);
            return response()->json(['success'=>'You have sent successfully.']);
        }
    }
}
