<?php 
namespace Modules\Payment\Services;

use Modules\Payment\Enums\PaymentMethodEnum;
use Modules\Payment\Events\RenderedPaymentMethods;
use Modules\Payment\Events\RenderingPaymentMethods;

class PaymentMethods 
{
    protected $methods = [];

    public function defaultPayment(){
       return $this->methods = [
            PaymentMethodEnum::BANK_TRANSFER => [
                'html' => view('payment::partials.bank-transfer')->render(),
                'priority' => 999,
            ]
        ];
    } 

    public function method($name, $args = [])
    {
        $this->defaultPayment();

        $args = array_merge(['html' => null, 'priority' => count([$this->methods]) + 1], $args);

        $this->methods[$name] = $args;

        return $this;
    }

    public function methods()
    {
        return $this->methods;
    }

    public function getDefaultMethod()
    {
        return setting('default_payment_method', PaymentMethodEnum::BANK_TRANSFER);
    }

    public function getSelectedMethod()
    {
        return session('selected_payment_method');
    }

    public function getSelectingMethod()
    {
        return $this->getSelectedMethod() ?: $this->getDefaultMethod();
    }

    public function render()
    {
        $this->defaultPayment() + $this->methods;

        event(new RenderingPaymentMethods($this->methods));

        $html = '';

        foreach (collect($this->methods)->sortBy('priority') as $name => $method) {

            // if (! get_payment_setting('status', $name) == 1) {
            //     continue;
            // }

            $html .= $method['html'];
        }

        event(new RenderedPaymentMethods($html));

        return $html;
    }


}