<?php

namespace App\Http\Controllers;

use App\User_payment_detail;
use App\User_plan_detail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;
use DateTime;
use Session;
use Mail;

class User_payment_detailController extends Controller
{
    public function index(){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Payments'])) {
            if($access['Payments']['r_view']=='1' || $access['Payments']['r_insert']=='1' || $access['Payments']['r_edit']=='1' || $access['Payments']['r_delete']=='1' || $access['Payments']['r_approvals']=='1' || $access['Payments']['r_export']=='1') {

                $this->set_payment_details();
                
                $sql = "select A.*, B.name as user_name from user_payment_details A left join group_users B on (A.user_id = B.gu_id) where module = 'Assure'";
                $payments = DB::select($sql);
                return view('payment.index', ['access' => $access, 'payments' => $payments]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'User Payment Details', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'User Payment Details', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function pay_now($id){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Payments'])) {
            if($access['Payments']['r_edit']=='1') {
                $sql = "select A.*, B.name as user_name from user_payment_details A left join group_users B on (A.user_id = B.gu_id) where A.id = '$id'";
                $data = DB::select($sql);
                return view('payment.details', ['access' => $access, 'data' => $data]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'User Payment Details', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'User Payment Details', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function calculateFiscalYearForDate($inputDate){
        $year=substr($inputDate, 0, strpos($inputDate, "-"));
        $month=substr($inputDate, strpos($inputDate, "-")+1, strrpos($inputDate, "-")-1);

        $year=intval($year);
        $month=intval($month);

        if($month<4){
            $fyStart=$year-1;
            $fyEnd=$year;
        } else {
            $fyStart=$year;
            $fyEnd=$year+1;
        }

        $fyStart=substr(strval($fyStart),2);
        $fyEnd=substr(strval($fyEnd),2);

        $financial_year=$fyStart.'-'.$fyEnd;

        return $financial_year;
    }
    
    public function generate_invoice_no($order_date){
        $sql="select * from series_master where type='Tax_Invoice'";
        $result=DB::select($sql);
        if(count($result)>0){
            $series=intval($result[0]->series)+1;

            $sql="update series_master set series = '$series' where type = 'Tax_Invoice'";
            DB::update($sql);
        } else {
            $series=1;

            $sql="insert into series_master (type, series) values ('Tax_Invoice', '$series')";
            DB::insert($sql);
        }

        if (isset($order_date)){
            if($order_date==''){
                $financial_year="";
            } else {
                $financial_year=$this->calculateFiscalYearForDate($order_date);
            }
        } else {
            $financial_year="";
        }
        
        $invoice_no = 'PECAN/'.$financial_year.'/'.strval($series);

        return $invoice_no;
    }

    public function set_payment_details(){
        $sql = "select max(payment_id) as payment_id from user_payment_details";
        $data = DB::select($sql);
        $payment_id = 0;
        if(count($data)>0){
            $payment_id = intval($data[0]->payment_id);
        }

        $sql = "select * from payment_transactions where id > " . $payment_id . " order by id";
        $data = DB::select($sql);
        if(count($data)>0){
            for($i=0; $i<count($data); $i++){
                if($data[$i]->status=='Success'){
                    $payment_id = $data[$i]->id;
                    $user_id = $data[$i]->user_id;
                    $sub_id = $data[$i]->sub_id;
                    $trans_id = $data[$i]->trans_id;
                    $module = $data[$i]->module;
                    $transaction_amount = $data[$i]->amount;
                    $order_date = $data[$i]->order_date;
                    $pay_mode = $data[$i]->pay_mode;
                    $sub_start_date = $data[$i]->sub_start_date;
                    $sub_end_date = $data[$i]->sub_end_date;

                    $num_of_prop = 0;
                    $plan_name = '';
                    $invoice_no = '';

                    if(isset($sub_id)){
                        if($sub_id!=0){
                            $sql = "select * from subscription where id = " . $sub_id;
                            $data2 = DB::select($sql);
                            $num_of_prop = 0;
                            $plan_name = '';
                            if(count($data2)>0){
                                $num_of_prop = $data2[0]->num_of_prop;
                                $plan_name = $data2[0]->package_name;
                            }

                            $invoice_no = $this->generate_invoice_no($order_date);

                            $data3['user_id'] = $user_id;
                            $data3['module'] = $module;
                            $data3['payment_id'] = $payment_id;
                            $data3['payment_date'] = $order_date;
                            $data3['plan_name'] = $plan_name;
                            $data3['invoice_no'] = $invoice_no;
                            $data3['invoice_date'] = $order_date;
                            $data3['no_of_properties'] = $num_of_prop;
                            $data3['payment_method'] = $pay_mode;
                            $data3['transaction_amount'] = $transaction_amount;
                            // $data3['payment_due_date'] = $sub_end_date;
                            $data3['payment_status'] = 'paid';
                            $data3['status'] = 'approved';
                            $data3['created_by'] = '1';
                            $data3['updated_by'] = '1';

                            $value = floatval($transaction_amount);
                            $amount = round($value/1.18,2);
                            $discount = 0;
                            $price = round($amount - $discount,2);
                            $cgst_rate = 9;
                            $sgst_rate = 9;
                            $igst_rate = 0;
                            $cgst = round($amount * $cgst_rate / 100,2);
                            $sgst = round($amount * $sgst_rate / 100,2);
                            $igst = round($amount * $igst_rate / 100,2);
                            $gst = round($cgst + $sgst + $igst,2);
                            $total_amount = round($amount + $gst,2);
                            $round_off_amount = round($value - $total_amount,2);

                            $data3['amount'] = $amount;
                            $data3['discount'] = $discount;
                            $data3['price'] = $price;
                            $data3['cgst_rate'] = $cgst_rate;
                            $data3['sgst_rate'] = $sgst_rate;
                            $data3['igst_rate'] = $igst_rate;
                            $data3['cgst'] = $cgst;
                            $data3['sgst'] = $sgst;
                            $data3['igst'] = $igst;
                            $data3['gst'] = $gst;
                            $data3['total_amount'] = $total_amount;
                            $data3['round_off_amount'] = $round_off_amount;

                            User_payment_detail::create($data3);

                            $data4['user_id'] = $user_id;
                            $data4['module'] = $module;
                            $data4['plan_name'] = $plan_name;
                            $data4['no_of_properties'] = $num_of_prop;
                            $data4['plan_expires_on'] = $sub_end_date;
                            $data4['status'] = 'approved';
                            $data4['created_by'] = '1';
                            $data4['updated_by'] = '1';

                            $sql = "select * from user_plan_details where user_id = " . $user_id;
                            $data2 = DB::select($sql);
                            if(count($data2)>0){
                                $id = $data2[0]->id;
                                User_plan_detail::find($id)->update($data4);
                            } else {
                                User_plan_detail::create($data4);
                            }

                            $this->send_payment_receipt_email($user_id, $transaction_amount);

                            // echo json_encode($data4);
                            // echo '<br/>';
                        }
                    }
                    
                    if(isset($trans_id)){
                        if($trans_id!=0){
                            $sql = "select * from user_payment_details where id = " . $trans_id;
                            $data2 = DB::select($sql);
                            if(count($data2)>0){
                                $data3['payment_id'] = $payment_id;
                                $data3['module'] = $module;
                                $data3['payment_date'] = $order_date;
                                $data3['payment_method'] = $pay_mode;
                                $data3['payment_status'] = 'paid';
                                $data3['updated_by'] = '1';

                                $id = $data2[0]->id;
                                User_payment_detail::find($id)->update($data3);

                                $this->send_payment_receipt_email($user_id, $transaction_amount);

                                // echo json_encode($data3);
                                // echo '<br/>';
                            }
                        }
                    }
                }
            }
        }
    }

    public function send_payment_receipt_email($user_id, $transaction_amount){
        $user = User::find($user_id);
        $name = $user->name;
        $first_name = $user->first_name;
        $email = $user->gu_email;

        // $user_id = Crypt::encryptString($user_id);

        $total_outstanding = 0;
        $sql = "select sum(transaction_amount) as total_outstanding from user_payment_details where user_id = '" . $user_id . "' and payment_status != 'paid'";
        $result = DB::select($sql);
        if(count($result)>0){
            if(isset($result[0]->total_outstanding)){
                $total_outstanding = $result[0]->total_outstanding;
            }
        }

        $data = array('user_id'=>$user_id, 'name'=>$first_name, 'email'=>$email, 'transaction_amount'=>$transaction_amount, 'total_outstanding'=>$total_outstanding);

        Mail::send('payment.mail_payment_receipt', $data, function($message) use ($data) {
            $message->to($data['email'], $data['name'])
                    ->bcc('prasad.bhisale@pecanreams.com')
                    ->subject('Receipt of Payment')
                    ->from('info@pecanreams.com','Pecan Reams');
        });

        $sms = "Hi%20".$first_name."%2C%20Thank%20you%20for%20your%20payment%20of%20Rs%2E%20".$transaction_amount."%2EFor%20feedback%20please%20visit%20http%3A%2F%2Fwww%2Epecanreams%2Ecom";
        $sms = str_replace(' ', '%20', $sms);
        $sms = str_replace(':', '%3A', $sms);
        $surl = "http://smshorizon.co.in/api/sendsms.php?user=Ashish_Chandak&apikey=QizzeB4YLplingobMXX2&mobile=" . $mobile . "&message=" . $sms . "&senderid=PECANR&type=txt";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $surl);
        curl_exec($ch);
        curl_close($ch);
    }

    public function set_monthly_payment_details(){
        $sql = "select distinct created_by from pn_properties where status = 'approved' order by created_by";
        $data = DB::select($sql);
        if(count($data)>0){
            for($i=0; $i<count($data); $i++){
                $user_id = $data[$i]->created_by;
                $now = date('Y-m-d');
                $prop_num = 0;
                $transaction_amount = 0;

                $start_date = date("Y-m-1", strtotime("-1 month"));
                $end_date = date("Y-m-t", strtotime("-1 month"));

                // $start_date = date("Y-m-d", strtotime("-1 month"));
                // $end_date = date("Y-m-d");

                // echo $user_id;
                // echo '<br/>';
                // echo $start_date;
                // echo '<br/>';
                // echo $end_date;
                // echo '<br/>';

                $sql = "select * from user_plan_details where user_id = '$user_id' and module = 'Assure'";
                $data2 = DB::select($sql);
                if(count($data2)>0){
                    $plan_name = $data2[0]->plan_name;
                    $no_of_properties = intval($data2[0]->no_of_properties);
                    $plan_expires_on = new DateTime($data2[0]->plan_expires_on);
                } else {
                    $plan_name = '';
                    $no_of_properties = 0;
                    $plan_expires_on = '';
                }

                // echo $plan_name;
                // echo '<br/>';
                // echo $no_of_properties;
                // echo '<br/>';

                // $plan_expires_on = new DateTime('2017-10-25');

                $start_date = new DateTime($start_date);
                $end_date = new DateTime($end_date);
                $balance_days = 0;

                if($plan_expires_on != ''){
                    if($plan_expires_on>=$start_date && $plan_expires_on<=$end_date){
                        $diff = date_diff($plan_expires_on, $end_date);
                        $balance_days = intval($diff->format("%a"));
                    } else {
                        $balance_days = 0;
                    }
                }
                
                // echo $balance_days;
                // echo '<br/>';

                $sql = "select count(id) as no_of_prop from pn_properties where status = 'approved' and created_by = '$user_id'";
                $data2 = DB::select($sql);
                if(count($data2)>0){
                    $no_of_prop = intval($data2[0]->no_of_prop);
                } else {
                    $no_of_prop = 0;
                }

                // echo $sql;
                // echo '<br/>';
                // echo $no_of_properties;
                // echo '<br/>';
                // echo $no_of_prop;
                // echo '<br/>';

                $invoice_date = null;
                $sql = "select max(invoice_date) as invoice_date from user_payment_details where status = 'approved' and user_id = '$user_id' and plan_name = 'Monthly' and module = 'Assure'";
                $data2 = DB::select($sql);
                if(count($data2)>0){
                    if(isset($data2[0]->invoice_date)){
                        $invoice_date = new DateTime($data2[0]->invoice_date);
                    }
                }

                if($no_of_properties<$no_of_prop){
                    $prop_num = $no_of_prop - $no_of_properties;

                    $sql = "select * from 
                            (select * from pn_properties where status = 'approved' and created_by = '$user_id' order by id desc) A limit " . $prop_num;
                    $data2 = DB::select($sql);

                    // echo $sql;
                    // echo '<br/>';

                    if(count($data2)>0){
                        for($j=0; $j<count($data2); $j++){
                            $created_at = $data2[$j]->created_at;
                            $date = new DateTime($created_at);
                            $date = new DateTime($date->format('Y-m-d'));

                            if(isset($invoice_date)){
                                if($invoice_date>$date){
                                    $date = $invoice_date;
                                }
                            }

                            // echo $created_at;
                            // echo '<br/>';
                            // echo $invoice_date->format('Y-m-d H:i:s');
                            // echo '<br/>';
                            // echo $date->format('Y-m-d H:i:s');
                            // echo '<br/>';
                            // echo $start_date->format('Y-m-d H:i:s');
                            // echo '<br/>';
                            // echo $end_date->format('Y-m-d H:i:s');
                            // echo '<br/>';

                            if($date>=$start_date && $date<$end_date){
                                $diff = date_diff($date, $end_date);
                                $days = intval($diff->format("%a"));

                                // echo $created_at;
                                // echo '<br/>';
                                // echo $days;
                                // echo '<br/>';
                                // echo $balance_days;
                                // echo '<br/>';

                                // if($days>$balance_days){
                                //     $transaction_amount = $transaction_amount + ($balance_days*200)/30;
                                // } else {
                                //     $transaction_amount = $transaction_amount + ($days*200)/30;
                                // }

                                if($balance_days!=0){
                                    $transaction_amount = $transaction_amount + (($balance_days*200)/30);
                                } else {
                                    $transaction_amount = $transaction_amount + (($days*200)/30);
                                }

                            }
                        }
                    }
                }

                if($transaction_amount>0){
                    // echo $transaction_amount;
                    // echo '<br/>';

                    $invoice_no = $this->generate_invoice_no($end_date->format('Y-m-d'));

                    // echo $invoice_no;
                    // echo '<br/>';

                    // echo $end_date->format('Y-m-d');
                    // echo '<br/>';

                    // $end_date->modify("+15 days");

                    $due_date = $end_date;
                    $due_date->modify("+10 days");

                    // echo $end_date->format('Y-m-d');
                    // echo '<br/>';

                    $data3['user_id'] = $user_id;
                    // $data3['payment_id'] = $payment_id;
                    // $data3['payment_date'] = $order_date;
                    $data3['plan_name'] = 'Monthly';
                    $data3['module'] = 'Assure';
                    $data3['invoice_no'] = $invoice_no;
                    $data3['invoice_date'] = date('Y-m-d');
                    $data3['no_of_properties'] = $prop_num;
                    // $data3['payment_method'] = $pay_mode;
                    $data3['transaction_amount'] = round($transaction_amount,0);
                    $data3['payment_due_date'] = $due_date->format('Y-m-d');
                    $data3['payment_status'] = 'pending';
                    $data3['status'] = 'approved';
                    $data3['created_by'] = '1';
                    $data3['updated_by'] = '1';
                    $data3['start_date'] = $start_date->format('Y-m-d');
                    $data3['end_date'] = $end_date->format('Y-m-d');

                    $value = round($transaction_amount,0);
                    $amount = round($value/1.18,2);
                    $discount = 0;
                    $price = round($amount - $discount,2);
                    $cgst_rate = 9;
                    $sgst_rate = 9;
                    $igst_rate = 0;
                    $cgst = round($amount * $cgst_rate / 100,2);
                    $sgst = round($amount * $sgst_rate / 100,2);
                    $igst = round($amount * $igst_rate / 100,2);
                    $gst = round($cgst + $sgst + $igst,2);
                    $total_amount = round($amount + $gst,2);
                    $round_off_amount = round($value - $total_amount,2);

                    // echo $amount;
                    // echo '<br/>';
                    // echo $gst;
                    // echo '<br/>';
                    // echo $value;
                    // echo '<br/>';
                    // echo $total_amount;
                    // echo '<br/>';
                    // echo $round_off_amount;
                    // echo '<br/>';

                    $data3['amount'] = $amount;
                    $data3['discount'] = $discount;
                    $data3['price'] = $price;
                    $data3['cgst_rate'] = $cgst_rate;
                    $data3['sgst_rate'] = $sgst_rate;
                    $data3['igst_rate'] = $igst_rate;
                    $data3['cgst'] = $cgst;
                    $data3['sgst'] = $sgst;
                    $data3['igst'] = $igst;
                    $data3['gst'] = $gst;
                    $data3['total_amount'] = $total_amount;
                    $data3['round_off_amount'] = $round_off_amount;

                    // echo json_encode($data3);
                    // echo '<br/>';

                    $id = User_payment_detail::create($data3)->id;

                    $this->send_payment_due_email($id, $user_id, $start_date, $end_date, $invoice_no, $total_amount);
                }
            }
        }
    }

    public function send_payment_due_email($id, $user_id, $start_date, $end_date, $invoice_no, $total_amount){
        $user = User::find($user_id);
        $name = $user->name;
        $first_name = $user->first_name;
        $email = $user->gu_email;
        $mobile = $user->gu_mobile;

        // $user_id = Crypt::encryptString($user_id);

        $data = array('id'=>$id, 'user_id'=>$user_id, 'name'=>$first_name, 'email'=>$email, 'start_date'=>$start_date->format('d/m/Y'), 'end_date'=>$end_date->format('d/m/Y'), 'invoice_no'=>$invoice_no, 'total_amount'=>$total_amount);

        Mail::send('payment.mail_payment_due', $data, function($message) use ($data) {
            $message->to($data['email'], $data['name'])
                    ->bcc('prasad.bhisale@pecanreams.com')
                    ->subject('Your Invoice for the month of '.$start_date->format('M-Y'))
                    ->from('info@pecanreams.com','Pecan Reams');
        });

        $sms = "Hi%20".$first_name."%2C%20Your%20payment%20of%20Rs%2E%20".$total_amount."%20for%20the%20services%20at%20Pecan%20Reams%20is%20due%20for%20".str_replace('-', '%2D', $start_date->format('M-Y'))."%20month%2E%20Request%20you%20to%20make%20the%20payment%20to%20avoid%20suspension%20of%20services%2E";
        $sms = str_replace(' ', '%20', $sms);
        $sms = str_replace(':', '%3A', $sms);
        $surl = "http://smshorizon.co.in/api/sendsms.php?user=Ashish_Chandak&apikey=QizzeB4YLplingobMXX2&mobile=" . $mobile . "&message=" . $sms . "&senderid=PECANR&type=txt";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $surl);
        curl_exec($ch);
        curl_close($ch);
    }

    public function set_payment_reminders(){
        $sql = "select * from user_payment_details where reminders is null or reminders < 2";
        $data = DB::select($sql);
        $payment_id = 0;
        if(count($data)>0){
            for($i=0; $i<count($data); $i++){
                $id = $data[$i]->id;
                $user_id = $data[$i]->user_id;
                $start_date = $data[$i]->start_date;
                $end_date = $data[$i]->end_date;
                $invoice_no = $data[$i]->invoice_no;
                $transaction_amount = $data[$i]->transaction_amount;

                $start_date = new DateTime($start_date);
                $end_date = new DateTime($end_date);

                $this->send_payment_reminder_email($id, $user_id, $start_date, $end_date, $invoice_no, $transaction_amount);
            }
            
        }
    }

    public function send_payment_reminder_email($id, $user_id, $start_date, $end_date, $invoice_no, $transaction_amount){
        $user = User::find($user_id);
        $name = $user->name;
        $first_name = $user->first_name;
        $email = $user->gu_email;

        $data = array('id'=>$id, 'user_id'=>$user_id, 'name'=>$first_name, 'email'=>$email, 'start_date'=>$start_date->format('d/m/Y'), 'end_date'=>$end_date->format('d/m/Y'), 'total_amount'=>$transaction_amount);

        Mail::send('payment.mail_payment_receipt', $data, function($message) use ($data) {
            $message->to($data['email'], $data['name'])
                    ->bcc('prasad.bhisale@pecanreams.com')
                    ->subject('Reminder: Payment Overdue for the month of '.$start_date->format('M-Y'))
                    ->from('info@pecanreams.com','Pecan Reams');
        });

        $sms = "Hi%20".$first_name."%2C%20Your%20payment%20of%20Rs%2E%20".$total_amount."%20for%20the%20services%20at%20Pecan%20Reams%20is%20overdue%20for%20".str_replace('-', '%2D', $start_date->format('M-Y'))."%20month%2E%20Request%20you%20to%20make%20the%20payment%20to%20avoid%20suspension%20of%20services%2E";
        $sms = str_replace(' ', '%20', $sms);
        $sms = str_replace(':', '%3A', $sms);
        $surl = "http://smshorizon.co.in/api/sendsms.php?user=Ashish_Chandak&apikey=QizzeB4YLplingobMXX2&mobile=" . $mobile . "&message=" . $sms . "&senderid=PECANR&type=txt";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $surl);
        curl_exec($ch);
        curl_close($ch);
    }

    public function FormatDate($date, $format = 'd/m/Y') {
        $d = DateTime::createFromFormat($format, $date);
        $returnDate = null;
        if ($d && $d->format($format) == $date) {
            // $returnDate = DateTime::createFromFormat($format, $date)->format('Y-m-d');
            $dateInput = explode('/',$date);
            $returnDate = $dateInput[2].'-'.$dateInput[1].'-'.$dateInput[0];
        }

        return $returnDate;
    }

    public function save(Request $request){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Payments'])) {
            if($access['Payments']['r_insert']=='1' || $access['Payments']['r_edit']=='1' || $access['Payments']['r_delete']=='1' || $access['Payments']['r_approvals']=='1') {
                
                $data['id'] = $request->get('id');
                $data['payment_method'] = $request->get('payment_method');
                $data['payment_date'] = $this->FormatDate($request->get('payment_date'));
                $data['payment_ref'] = $request->get('payment_ref');
                $data['payment_status'] = 'paid';

                if($data['payment_method']=='Cheque'){
                    $data['bank_name'] = $request->get('bank_name');
                    $data['branch'] = $request->get('branch');
                    $data['cheque_date'] = $this->FormatDate($request->get('cheque_date'));
                } else {
                    $data['bank_name'] = null;
                    $data['branch'] = null;
                    $data['cheque_date'] = null;
                }
                
                $user_id = auth()->user()->gu_id;
                $data['updated_by'] = $user_id;
                $id = $data['id'];
                User_payment_detail::find($id)->update($data);
                Session::flash('success_msg', 'Payment Details updated successfully!');

                return redirect('index.php/user_payment_detail');
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'User Payment Details', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'User Payment Details', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function list1(){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['UserPayments'])) {
            if($access['UserPayments']['r_view']=='1' || $access['UserPayments']['r_insert']=='1' || $access['UserPayments']['r_edit']=='1' || $access['UserPayments']['r_delete']=='1' || $access['UserPayments']['r_approvals']=='1' || $access['UserPayments']['r_export']=='1') {
                
                $user_id = auth()->user()->gu_id;

                $sql = "select A.* from user_payment_details A where A.status = 'approved' and A.payment_status = 'paid' and user_id = '$user_id'";
                $payments_done = DB::select($sql);

                $sql = "select A.* from user_payment_details A where A.status = 'approved' and A.payment_status = 'pending' and user_id = '$user_id'";
                $payments_pending = DB::select($sql);

                return view('payment.list', ['access' => $access, 'payments_done' => $payments_done, 'payments_pending' => $payments_pending]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'User Payment Details', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'User Payment Details', 'msg' => 'You donot have access to this page.']);
        }
    }

    function convert_number_to_words($number) {
        $no = floor($number);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array('0' => ' ', '1' => 'One', '2' => 'Two',
        '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
        '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
        '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
        '13' => 'Thirteen', '14' => 'Fourteen',
        '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
        '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
        '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
        '60' => 'Sixty', '70' => 'Seventy',
        '80' => 'Eighty', '90' => 'Ninety');
        $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
        while ($i < $digits_1) {
         $divider = ($i == 2) ? 10 : 100;
         $number = floor($no % $divider);
         $no = floor($no / $divider);
         $i += ($divider == 10) ? 1 : 2;
         if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number] .
                " " . $digits[$counter] . $plural . " " . $hundred
                :
                $words[floor($number / 10) * 10]
                . " " . $words[$number % 10] . " "
                . $digits[$counter] . $plural . " " . $hundred;
         } else $str[] = null;
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        $points = ($point) ? (" and " . $words[$point / 10] . " " .  $words[$point = $point % 10]) : '';

        if($points==""){
            $result = $result . "Rupees ";
        } else {
            $result = $result . "Rupees " . $points . " Paise";
        }
        return $result;
    }

    function format_money($number, $decimal=2){
        if(!isset($number)) $number=0;

        $negative=false;
        if(strpos($number, '-')!==false){
            $negative=true;
            $number = str_replace('-', '', $number);
        }

        $number = floatval(str_replace(',', '', $number));
        $number = round($number, $decimal);

        $decimal="";
        
        if(strpos($number, '.')!==false){
            $decimal = substr($number, strpos($number, '.'));
            $number = substr($number, 0, strpos($number, '.'));
        }
        
        // echo $decimal . '<br/>';
        // echo $number . '<br/>';

        $len = strlen($number);
        $m = '';
        $number = strrev($number);
        for($i=0;$i<$len;$i++){
            if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i!=$len){
                $m .=',';
            }
            $m .=$number[$i];
        }

        $number = strrev($m);
        $number = $number . $decimal;

        if($negative==true){
            $number = '-' . $number;
        }

        return $number;
    }

    public function get_invoice($id){
        $user = new User();
        $access = $user->get_access();
        // if(isset($access['Invoice'])) {
        //     if($access['Invoice']['r_view']=='1' || $access['Invoice']['r_insert']=='1' || $access['Invoice']['r_edit']=='1' || $access['Invoice']['r_delete']=='1' || $access['Invoice']['r_approvals']=='1' || $access['Invoice']['r_export']=='1') {
                
        //         $user_id = auth()->user()->gu_id;

        //         $id = Crypt::decryptString($id);

                $sql = "select A.*, B.name from user_payment_details A left join group_users B on (A.user_id = B.gu_id) where A.id = '$id'";
                $result = DB::select($sql);

                if(count($result)>0){
                    $data['name'] = $result[0]->name;
                    $data['invoice_no'] = $result[0]->invoice_no;
                    $data['invoice_date'] = $result[0]->invoice_date;
                    $data['plan_name'] = $result[0]->plan_name;

                    // $value = floatval($result[0]->transaction_amount);
                    // $amount = $value/1.18;
                    // $discount = 0;
                    // $price = $amount - $discount;
                    // $cgst_rate = 9;
                    // $sgst_rate = 9;
                    // $igst_rate = 0;
                    // $cgst = $amount * $cgst_rate / 100;
                    // $sgst = $amount * $sgst_rate / 100;
                    // $igst = $amount * $igst_rate / 100;
                    // $gst = $cgst + $sgst + $igst;

                    // $data['value'] = $this->format_money($value,2);
                    // $data['amount'] = $this->format_money($amount,2);
                    // $data['discount'] = $this->format_money($discount,2);
                    // $data['price'] = $this->format_money($price,2);
                    // $data['cgst_rate'] = $cgst_rate;
                    // $data['sgst_rate'] = $sgst_rate;
                    // $data['igst_rate'] = $igst_rate;
                    // $data['cgst'] = $this->format_money($cgst,2);
                    // $data['sgst'] = $this->format_money($sgst,2);
                    // $data['igst'] = $this->format_money($igst,2);
                    // $data['gst'] = $this->format_money($gst,2);

                    $data['value'] = $this->format_money($result[0]->transaction_amount,2);
                    $data['amount'] = $this->format_money($result[0]->amount,2);
                    $data['discount'] = $this->format_money($result[0]->discount,2);
                    $data['price'] = $this->format_money($result[0]->price,2);
                    $data['cgst_rate'] = $result[0]->cgst_rate;
                    $data['sgst_rate'] = $result[0]->sgst_rate;
                    $data['igst_rate'] = $result[0]->igst_rate;
                    $data['cgst'] = $this->format_money($result[0]->cgst,2);
                    $data['sgst'] = $this->format_money($result[0]->sgst,2);
                    $data['igst'] = $this->format_money($result[0]->igst,2);
                    $data['gst'] = $this->format_money($result[0]->gst,2);
                    $data['total_amount'] = $this->format_money($result[0]->total_amount,2);
                    $data['round_off_amount'] = $this->format_money($result[0]->round_off_amount,2);

                    $data['total_amount_in_words']=$this->convert_number_to_words($result[0]->transaction_amount) . ' Only';

                    return view('payment.invoice', ['access' => $access, 'data' => $data]);
                } else {
                    return view('message', ['access' => $access, 'title'  => 'No Data Found', 'module' => 'Tax Invoice', 'msg' => 'No data found.']);
                }
        //     } else {
        //         return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'User Payment Details', 'msg' => 'You donot have access to this page.']);
        //     }
        // } else {
        //     return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'User Payment Details', 'msg' => 'You donot have access to this page.']);
        // }
    }

    function payment_response($response_message, $order_status){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['UserPayments'])) {
            if($access['UserPayments']['r_insert']=='1' || $access['UserPayments']['r_edit']=='1' || $access['UserPayments']['r_delete']=='1' || $access['UserPayments']['r_approvals']=='1') {
                
                // $response_message = $request->get('response_message');
                // $order_status = $request->get('order_status');

                $this->set_payment_details();

                return view('message', ['access' => $access, 'title'  => $order_status, 'module' => 'User Payment Details', 'msg' => $response_message]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'User Payment Details', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'User Payment Details', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function plan(){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['UserPayments'])) {
            if($access['UserPayments']['r_view']=='1' || $access['UserPayments']['r_insert']=='1' || $access['UserPayments']['r_edit']=='1' || $access['UserPayments']['r_delete']=='1' || $access['UserPayments']['r_approvals']=='1') {
                
                $user_id = auth()->user()->gu_id;
                $final_data = array();

                $sql = "select * from user_plan_details where user_id = '$user_id' and module = 'Assure' and 
                        id = (select max(id) from user_plan_details where user_id = '$user_id' and module = 'Assure')";
                $data = DB::select($sql);
                if(count($data)>0){
                    $final_data['plan_name'] = $data[0]->plan_name . ' Yearly';
                    $final_data['no_of_properties'] = $data[0]->no_of_properties;
                    $final_data['plan_expires_on'] = $data[0]->plan_expires_on;
                }

                $no_of_properties_registered = 0;
                $sql = "select count(id) as no_of_prop from pn_properties where status = 'approved' and created_by = '$user_id'";
                $data = DB::select($sql);
                if(count($data)>0){
                    $no_of_properties_registered = $data[0]->no_of_prop;
                }

                if(!isset($final_data['plan_name'])){
                    if($no_of_properties_registered<=20){
                        $final_data['plan_name'] = 'Basic Monthly';
                    } else if($no_of_properties_registered<=50){
                        $final_data['plan_name'] = 'Business Monthly';
                    } else {
                        $final_data['plan_name'] = 'Enterprise Monthly';
                    }
                }

                $final_data['no_of_properties_registered'] = $no_of_properties_registered;

                return view('payment.plan_details', ['access' => $access, 'final_data'  => $final_data]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'User Payment Details', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'User Payment Details', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function get_plan(){
        $user = new User();
        $access = $user->get_access();
        // if(isset($access['Invoice'])) {
        //     if($access['Invoice']['r_view']=='1' || $access['Invoice']['r_insert']=='1' || $access['Invoice']['r_edit']=='1' || $access['Invoice']['r_delete']=='1' || $access['Invoice']['r_approvals']=='1' || $access['Invoice']['r_export']=='1') {
                
                $user_id = auth()->user()->gu_id;

        //         $id = Crypt::decryptString($id);

                $sql = "select * from subscription where module = 'Assure'";
                $data = DB::select($sql);

                if(count($data)>0){
                    
                    return view('payment.plans', ['access' => $access, 'subscription' => $data, 'user_id' => $user_id]);
                } else {
                    return view('message', ['access' => $access, 'title'  => 'No Data Found', 'module' => 'User Payment Details', 'msg' => 'No data found.']);
                }
        //     } else {
        //         return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'User Payment Details', 'msg' => 'You donot have access to this page.']);
        //     }
        // } else {
        //     return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'User Payment Details', 'msg' => 'You donot have access to this page.']);
        // }
    }
}