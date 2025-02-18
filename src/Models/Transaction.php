<?php

namespace Makkapoya\PayUz\Models;

use Makkapoya\PayUz\Http\Classes\DataFormat;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends BaseModel
{
    use SoftDeletes;

    const TIMEOUT = 43200000;
    const STATE_CREATED = 1;
    const STATE_COMPLETED = 2;
    const STATE_CANCELLED = -1;
    const STATE_CANCELLED_AFTER_COMPLETE = -2;
    const REASON_RECEIVERS_NOT_FOUND = 1;
    const REASON_PROCESSING_EXECUTION_FAILED = 2;
    const REASON_EXECUTION_FAILED = 3;
    const REASON_CANCELLED_BY_TIMEOUT = 4;
    const REASON_FUND_RETURNED = 5;
    const REASON_UNKNOWN = 10;
    const CURRENCY_CODE_UZS = 860;
    const CURRENCY_CODE_RUB = 643;
    const CURRENCY_CODE_USD = 840;
    const CURRENCY_CODE_EUR = 978;
    protected $dates = [
        'deleted_at'
    ];
    protected $casts = [
        'detail' => 'json',
    ];
    protected $fillable = [
        'payment_system', //varchar 191
        'system_transaction_id', // varchar 191
        'amount', // double (15,5)
        'currency_code', // int(11)
        'state', // int(11)
        'updated_time', //datetime
        'comment', // varchar 191
        'transactionable_type',
        'transactionable_id',
        'detail', // details
    ];

    public function cancel($reason)
    {
        $this->updated_time = DataFormat::timestamp(true);

        if ($this->state == self::STATE_COMPLETED) {
            // Scenario: CreateTransaction -> PerformTransaction -> CancelTransaction
            $this->state = self::STATE_CANCELLED_AFTER_COMPLETE;
        } else {
            // Scenario: CreateTransaction -> CancelTransaction
            $this->state = self::STATE_CANCELLED;
        }

        $this->comment = $reason;
        $detail = $this->detail;
        $detail['cancel_time'] = $this->updated_time;
        $this->detail = $detail;

        $this->update();
    }

    public function isExpired()
    {
        return $this->state == self::STATE_CREATED && DataFormat::datetime2timestamp($this->updated_time) - time() > self::TIMEOUT;
    }

    public function transactionable(): MorphTo
    {
        return $this->morphTo();
    }
}
