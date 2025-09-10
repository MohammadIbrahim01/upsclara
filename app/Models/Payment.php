<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public $table = 'payments';

    public const MODE_OF_PAYMENT_SELECT = [
        'Razorpay' => 'Razorpay',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const STATUS_SELECT = [
        'Processing' => 'Processing',
        'Success'    => 'Success',
        'Cancelled'  => 'Cancelled',
        'Refunded'   => 'Refunded',
    ];

    protected $fillable = [
        'order_id',
        'payment',
        'transaction',
        'mode_of_payment',
        'amount',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
