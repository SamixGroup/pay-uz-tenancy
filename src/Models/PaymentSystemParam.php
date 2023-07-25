<?php

namespace Makkapoya\PayUz\Models;


class PaymentSystemParam extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'system',
        'label',
        'name',
        'value',
        'tenant_id',
        'tenant_type'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function payment_system()
    {
        return $this->hasOne(PaymentSystem::class, 'system', 'system');
    }
}
