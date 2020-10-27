<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CommModel;
use PDF;
use GuzzleHttp\Client;
use App\Mail\InvoiceCreated;
use App\Mail\OrderCreated;
use Illuminate\Support\Facades\DB;

class ManageCommunicationController extends Controller
{
    public function emailsView()
    {
        $allEmails = DB::table('SMS_Emails_messages')
                    ->join('OCRD', 'SMS_Emails_messages.CardCode', '=', 'OCRD.CardCode')
                    ->where(['SMS_Emails_messages.Type'=> '2'])
                    ->select('SMS_Emails_messages.*', 'OCRD.*')
                    ->get();
        $pendingEmails = DB::table('SMS_Emails_messages')
                    ->join('OCRD', 'SMS_Emails_messages.CardCode', '=', 'OCRD.CardCode')
                    ->where(['SMS_Emails_messages.Type'=> '2', 'status'=>1])
                    ->select('SMS_Emails_messages.*', 'OCRD.*')
                    ->get();
        $sentEmails = DB::table('SMS_Emails_messages')
                    ->join('OCRD', 'SMS_Emails_messages.CardCode', '=', 'OCRD.CardCode')
                    ->where(['SMS_Emails_messages.Type'=> '2', 'status'=>0])
                    ->select('SMS_Emails_messages.*', 'OCRD.*')
                    ->get();
        return view('manage_emails', compact('allEmails', 'pendingEmails', 'sentEmails'));
    }

    public function smsView()
    {
        $allSms = DB::table('SMS_Emails_messages')
                    ->join('OCRD', 'SMS_Emails_messages.CardCode', '=', 'OCRD.CardCode')
                    ->where(['SMS_Emails_messages.Type'=> '1'])
                    ->select('SMS_Emails_messages.*', 'OCRD.*')
                    ->get();
        $pendingSms = DB::table('SMS_Emails_messages')
                    ->join('OCRD', 'SMS_Emails_messages.CardCode', '=', 'OCRD.CardCode')
                    ->where(['SMS_Emails_messages.Type'=> '1', 'status'=>1])
                    ->select('SMS_Emails_messages.*', 'OCRD.*')
                    ->get();
        $sentSms = DB::table('SMS_Emails_messages')
                    ->join('OCRD', 'SMS_Emails_messages.CardCode', '=', 'OCRD.CardCode')
                    ->where(['SMS_Emails_messages.Type'=> '1', 'status'=>0])
                    ->select('SMS_Emails_messages.*', 'OCRD.*')
                    ->get();
        return view('manage_sms', compact('allSms', 'pendingSms', 'sentSms'));
    }

    public function sendEmail($id)
    {
        $get_cardcode = CommModel::where('Id', $id)->first();


        if($get_cardcode->DocType == 'Invoice')
        {
            $get_email = DB::table('OCRD')
                        ->join('SMS_Emails_messages', 'SMS_Emails_messages.CardCode', '=', 'OCRD.CardCode')
                        ->where(['SMS_Emails_messages.CardCode'=> $get_cardcode->CardCode])
                        ->select('OCRD.*')
                        ->first();
            $customer_email = $get_email->E_Mail;
            $get_docentry = DB::table('OINV')
                        ->join('SMS_Emails_messages', 'OINV.DocNum', '=', 'SMS_Emails_messages.DocNum')
                        ->where('SMS_Emails_messages.DocNum', '=', $get_cardcode->DocNum)
                        ->select('OINV.*')
                        ->first();
            $products = DB::table('INV1')
                        ->where('INV1.DocEntry', '=', $get_docentry->DocEntry)
                        ->get();

            $pdf =PDF::loadView('pdfs.Invoice_created', compact('products', 'get_docentry', 'get_email'));

            $email_message =new InvoiceCreated($products, $get_docentry, $get_email);
            $email_message->attachData($pdf->output(), "invoice.pdf");

            \Mail::to($customer_email)->send($email_message);

            $update_status = CommModel::where('Id', $id)->update(['Status'=>0]);
            return response()->json(['success'=>'You have successfully upload file.']);

        } elseif($get_cardcode->DocType == 'Sales Order')
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
           // $email_message->attachData($pdf->output(), "Sales Order.pdf");

            \Mail::to($customer_email)->send($email_message);

            $update_status = CommModel::where('Id', $id)->update(['Status'=>0]);
            return response()->json(['success'=>'You have successfully upload file.']);
        }

    }

    public function sendSms($id)
    {
        $get_cardcode = CommModel::where('Id', $id)->first();
        $get_customer = DB::table('OCRD')
                ->join('SMS_Emails_messages', 'SMS_Emails_messages.CardCode', '=', 'OCRD.CardCode')
                ->where(['SMS_Emails_messages.CardCode'=> $get_cardcode->CardCode])
                ->select('OCRD.*')
                ->first();
        $customer_phone = $get_customer->Cellular;
        $client = new Client();
        $request = $client->get('http://infopi.io/text/index.php?app=ws&u=idealceramics&h=9326fffccdbcc7a6ec3067df8be4d951&op=pv&to='.$customer_phone.'&msg=Hello, '.$get_customer->CardName.'. Your goods have been dispatched for delivery. Thank you for shopping with us');
        $update_status = CommModel::where('Id', $id)->update(['Status'=>0]);
        return response()->json(['success'=>'You have successfully upload file.']);
    }

    public function walk_in()
    {
        return view('manage_walkin');
    }
}
