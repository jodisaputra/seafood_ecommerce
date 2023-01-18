<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function setStatusPending()
    {
        $this->attributes['status'] = 'pending';
        self::save();
    }

    public function setStatussuccess()
    {
        $this->attributes['status'] = 'success';
        self::save();
    }

    public function setStatusFailed()
    {
        $this->attributes['status'] = 'failed';
        self::save();
    }

    public function setStatusExpired()
    {
        $this->attributes['status'] = 'expired';
        self::save();
    }
}
