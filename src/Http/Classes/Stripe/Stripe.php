<?php

namespace Makkapoya\PayUz\Http\Classes\Stripe;

use Session;
use Stripe as StripeGateway;
use Illuminate\Http\Request;
use Makkapoya\PayUz\Models\Transaction;
use Makkapoya\PayUz\Models\PaymentSystem;
use Makkapoya\PayUz\Http\Classes\DataFormat;
use Makkapoya\PayUz\Services\PaymentService;
use Makkapoya\PayUz\Http\Classes\BaseGateway;
use Makkapoya\PayUz\Models\PaymentSystemParam;
use Makkapoya\PayUz\Services\PaymentSystemService;
use Makkapoya\PayUz\Http\Classes\PaymentException;

class Stripe extends BaseGateway
{
    public $config;
    public $request;
    public $response;
    public $merchant;
    public $payment_system;
    const CUSTOM_FORM = 'pay-uz::merchant.stripe';

    /**
     * Payme constructor.
     */
    public function __construct()
    {
        $this->config   = PaymentSystemService::getPaymentSystemParamsCollect(PaymentSystem::STRIPE);
        $this->request  = request();
    }
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function run()
    {
        StripeGateway\Stripe::setApiKey($this->config['secret_key']);
        if (!empty($this->config['proxy'])) {
            $curl = new StripeGateway\HttpClient\CurlClient([CURLOPT_PROXY => $this->config['proxy']]);
            // tell Stripe to use the tweaked client
            StripeGateway\ApiRequestor::setHttpClient($curl);
        }

        $charge = StripeGateway\Charge::create([
            "amount" => (int)$this->request->amount,
            "currency" => "USD",
            "source" => $this->request->stripeToken,
            "description" => "Pay for service"
        ]);
        $model = PaymentService::convertKeyToModel($this->request->key);
        $create_time = DataFormat::timestamp(true);
        $transaction = Transaction::create([
            'payment_system'        => PaymentSystem::STRIPE,
            'system_transaction_id' => (int)rand() * 1000,
            'amount'                => (int)$model->total,
            'currency_code'         => Transaction::CURRENCY_CODE_UZS,
            'state'                 => Transaction::STATE_COMPLETED,
            'updated_time'          => 1 * $create_time,
            'comment'               => '',
            'detail'                => [],
            'transactionable_type'  => get_class($model),
            'transactionable_id'    => $model->id
        ]);
        Session::flash('success', 'Payment successful!');
        //todo: create transaction for stripe
        PaymentService::payListener(null, $transaction, 'after-pay');
        header("Location: " . $this->request->url);
        echo "<script>window.location.href='" . $this->request->url . "';</script>";
    }
    public function getRedirectParams($model, $amount, $currency, $url)
    {
        return [
            'config' => $this->config,
            'url' => $url,
            'amount' => $amount,
            'currency' => $currency,
            'key' => PaymentService::convertModelToKey($model),
        ];
    }
}