<?php

namespace Makkapoya\PayUz\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Makkapoya\PayUz\Models\PaymentSystem;
use Makkapoya\PayUz\Models\PaymentSystemParam;
use Makkapoya\PayUz\Models\Tenant;

class PayUzSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Schema::hasTable('tenants')) {
            $tenant = Tenant::create([
                'title' => 'Tenant'
            ]);
        }
        if (Schema::hasTable('payment_systems')) {
            PaymentSystem::firstOrCreate([
                'name'      => 'Payme',
                'system'    => 'payme'
            ]);
            // PaymentSystem::firstOrCreate([
            //     'name'      => 'Click',
            //     'system'    => 'click'
            // ]);
            // PaymentSystem::firstOrCreate([
            //     'name'      => 'Paynet',
            //     'system'    => 'paynet'
            // ]);
            // PaymentSystem::firstOrCreate([
            //     'name'      => 'Stripe',
            //     'system'    => 'stripe'
            // ]);
        }
        if (Schema::hasTable('payment_system_params')) {
            //Paycom
            PaymentSystemParam::firstOrCreate([
                'system'    => 'payme',
                'label'     => 'Login',
                'name'      => 'login',
                'value'     => 'Paycom',
                'tenant_id' => $tenant->id,
                'tenant_type' => config('payuz.tenant_type')
            ]);
            PaymentSystemParam::firstOrCreate([
                'system'    => 'payme',
                'label'     => 'Merchant id',
                'name'      => 'merchant_id',
                'value'     => 'merchant',
                'tenant_id' => $tenant->id,
                'tenant_type' => config('payuz.tenant_type')
            ]);
            PaymentSystemParam::firstOrCreate([
                'system'    => 'payme',
                'label'     => 'Password',
                'name'      => 'password',
                'value'     => 'password',
                'tenant_id' => $tenant->id,
                'tenant_type' => config('payuz.tenant_type')
            ]);
            PaymentSystemParam::firstOrCreate([
                'system'    => 'payme',
                'label'     => 'Key',
                'name'      => 'key',
                'value'     => 'key',
                'tenant_id' => $tenant->id,
                'tenant_type' => config('payuz.tenant_type')
            ]);
            //Click
            // PaymentSystemParam::firstOrCreate([
            //     'system'    => 'click',
            //     'label'     => 'Service id',
            //     'name'      => 'service_id',
            //     'value'     => 'service_id'
            // ]);
            // PaymentSystemParam::firstOrCreate([
            //     'system'    => 'click',
            //     'label'     => 'Secret key',
            //     'name'      => 'secret_key',
            //     'value'     => 'key'
            // ]);
            // PaymentSystemParam::firstOrCreate([
            //     'system'    => 'click',
            //     'label'     => 'Merchant Id',
            //     'name'      => 'merchant_id',
            //     'value'     => '0000'
            // ]);
            // PaymentSystemParam::firstOrCreate([
            //     'system'    => 'click',
            //     'label'     => 'Merchant user id',
            //     'name'      => 'merchant_user_id',
            //     'value'     => '0000'
            // ]);

            // //Paynet
            // PaymentSystemParam::firstOrCreate([
            //     'system'    => 'paynet',
            //     'label'     => 'Login',
            //     'name'      => 'login',
            //     'value'     => 'login'
            // ]);
            // PaymentSystemParam::firstOrCreate([
            //     'system'    => 'paynet',
            //     'label'     => 'Password',
            //     'name'      => 'password',
            //     'value'     => 'password'
            // ]);
            // PaymentSystemParam::firstOrCreate([
            //     'system'    => 'paynet',
            //     'label'     => 'Service id',
            //     'name'      => 'service_id',
            //     'value'     => 'service_id'
            // ]);

            // PaymentSystemParam::firstOrCreate([
            //     'system'    => 'stripe',
            //     'label'     => 'Secret key',
            //     'name'      => 'secret_key',
            //     'value'     => 'secret_key'
            // ]);

            // PaymentSystemParam::firstOrCreate([
            //     'system'    => 'stripe',
            //     'label'     => 'Publishable key',
            //     'name'      => 'publishable_key',
            //     'value'     => 'publishable_key'
            // ]);
            // PaymentSystemParam::firstOrCreate([
            //     'system'    => 'stripe',
            //     'label'     => 'Proxy',
            //     'name'      => 'proxy',
            //     'value'     => ''
            // ]);
        }
    }
}
