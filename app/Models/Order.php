<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $table = 'orders';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const STATUS_SELECT = [
        'Pending'  => 'Pending',
        'Complete' => 'Complete',
    ];

    protected $fillable = [
        'order_number',
        'name',
        'email',
        'phone',
        'address',
        'pin_code',
        'city',
        'state',
        'country',
        'status',
        'gross_amount',
        'discount_amount',
        'net_amount',
        'promo_code_applied',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function test_series()
    {
        return $this->belongsToMany(TestSeries::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
