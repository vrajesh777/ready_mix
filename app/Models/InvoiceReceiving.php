<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceReceiving extends Model
{
    use HasFactory;
    protected $table = 'purchase_order_invoices';
    protected $fillable = [
                            'p_order_id',
                            'order_number',
                            'supplier_id',
                            'invoice_id',
                            'received',
                            'bin_id',
                        ];
}
