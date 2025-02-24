<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Account extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password', 'role', 'saldo'];
    
    protected $hidden = ['password'];

    public function topUp($amount)
    {
        $this->saldo += $amount;
        $this->save();
    }

    public function withdraw($amount)
    {
        if ($this->saldo < $amount) {
            throw new \Exception('Insufficient balance');
        }

        $this->saldo -= $amount;
        $this->save();
    }

    // Add relationships if needed
    public function sentTransactions()
    {
        return $this->hasMany(Transaction::class, 'account_id');
    }

    public function receivedTransactions()
    {
        return $this->hasMany(Transaction::class, 'recipient_id');
    }
}