<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_payment_detail extends Model
{
    //fillable fields
    protected $fillable = ['user_id', 'payment_id', 'module', 'payment_date', 'plan_name', 'invoice_no', 'invoice_date', 
    						'no_of_properties', 'payment_method', 'payment_ref', 
    						'transaction_amount', 'payment_due_date', 'payment_status', 'bank_name', 'branch', 'cheque_date', 
    						'status', 'created_by', 'updated_by', 'approved_by', 'approved_at', 'amount', 'discount', 'price', 
    						'cgst_rate', 'sgst_rate', 'igst_rate', 'cgst', 'sgst', 'igst', 'gst', 'total_amount', 'round_off_amount'];
}
