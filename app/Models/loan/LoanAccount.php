<?php

namespace App\Models\loan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class LoanAccount extends Model
{
    use HasFactory;

    protected $table = 'loan_accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_no','loan_amount','customer_id','nominee_id','loan_scheme_id','late_fee','rate','total_payable_amount',
        'total_installment_no','loan_date','start_installment_date','end_installment_date','active_fg','remarks','account_status'
    ];

    protected $appends = [
        'status','account_status'
    ];

    public function getEncryptIdAttribute()
    {
        return Crypt::encrypt($this->attributes['id']);
    }

    public function customer()
    {
        return $this->belongsTo('App\models\person\Customer', 'customer_id', 'id');
    }

    public function nominee()
    {
        return $this->belongsTo('App\models\person\Customer', 'customer_id', 'id');
    }

    public function loanScheme()
    {
        return $this->belongsTo(LoanScheme::class, 'savings_scheme_id', 'id');
    }

    public function activeLoanScheme()
    {
        return $this->loanScheme()->where('active_fg',1);
    }

    // public function savingsDeposits()
    // {
    //     return $this->hasMany(SavingsDeposit::class, 'savings_accounts_id', 'id');
    // }

    // public function activeSavingsDeposits()
    // {
    //     return $this->savingsDeposits()->where('active_fg',1);
    // }

    // // current month deposit
    // public function currentSavingsDeposit()
    // {
    //     return $this->hasOne(SavingsDeposit::class, 'savings_accounts_id', 'id')->where('active_fg',1);
    // }

    public function getStatusAttribute()
    {
        if ($this->attributes['active_fg'] == 1) return '<label class="label label-success">ACTIVE</label>';
            return '<label class="label label-danger">INACTIVE</label>';
    }

    public function getAccountStatusAttribute()
    {
        if ($this->attributes['account_status'] == 1) return '<label class="label label-success">Running</label>';
            return '<label class="label label-danger">Complete</label>';
    }
}