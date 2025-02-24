<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'type',
        'amount',
        'status',
        'payment_method',
        'description',
        'processed_at',
        'recipient_id',
    ];

    // In Transaction.php model

public function account()
{
    return $this->belongsTo(Account::class, 'account_id'); // Associating with the sender's account
}

public function recipientAccount()
{
    return $this->belongsTo(Account::class, 'recipient_id'); // Associating with the recipient's account
}


    public function user()
    {
        return $this->belongsTo(Account::class);
    }

    public function recipient()
    {
        return $this->belongsTo(Account::class, 'recipient_id');
    }
}
