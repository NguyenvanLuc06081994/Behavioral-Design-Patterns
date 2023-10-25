<?php

abstract class Account
{
    protected ?Account $successor;
    protected int $balance;

    public function setNext(?Account $account): void
    {
        $this->successor = $account;
    }

    /**
     * @param float $amountToPay
     * @return void
     * @throws Exception
     */
    public function pay(float $amountToPay): void
    {
        if ($this->canPay($amountToPay)) {
            echo sprintf('Paid %s using %s' . PHP_EOL, $amountToPay, get_called_class());
        } elseif ($this->successor) {
            echo sprintf('Cannot pay using %s. Proceeding ..' . PHP_EOL, get_called_class());
            $this->successor->pay($amountToPay);
        } else {
            throw new Exception('None of the accounts have enough balance');
        }
    }

    public function canPay($amount): bool
    {
        return $this->balance >= $amount;
    }
}

class Bank extends Account
{
    protected int $balance;

    public function __construct(int $balance)
    {
        $this->balance = $balance;
    }
}

class Paypal extends Account
{
    protected int $balance;

    public function __construct(int $balance)
    {
        $this->balance = $balance;
    }
}

class Bitcoin extends Account
{
    protected int $balance;

    public function __construct(int $balance)
    {
        $this->balance = $balance;
    }
}

$bank = new Bank(100);          // Bank with balance 100
$paypal = new Paypal(200);      // Paypal with balance 200
$bitcoin = new Bitcoin(300);    // Bitcoin with balance 300

$bank->setNext($paypal);
$bank->setNext($bitcoin);
$bank->setNext(null);

try {
    $bank->pay(359);
} catch (Exception $e) {
    echo $e->getMessage();
}