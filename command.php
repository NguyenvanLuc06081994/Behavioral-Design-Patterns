<?php
//Receiver
class Bulb
{
    public function turnOn(): void
    {
        echo "Bulb has been lit";
    }

    public function turnOff(): void
    {
        echo "Darkness!";
    }
}

interface Command
{
    public function execute(): void;

    public function undo(): void;

    public function redo(): void;
}

//Command
class TurnOn implements Command
{
    protected Bulb $bulb;

    public function __construct(Bulb $bulb)
    {
        $this->bulb = $bulb;
    }

    public function execute(): void
    {
        $this->bulb->turnOn();
    }
    public function undo(): void
    {
        $this->bulb->turnOff();
    }

    public function redo(): void
    {
        $this->execute();
    }
}

class TurnOff implements Command
{
    protected Bulb $bulb;

    public function __construct(Bulb $bulb)
    {
        $this->bulb = $bulb;
    }

    public function execute(): void
    {
        $this->bulb->turnOff();
    }

    public function undo(): void
    {
        $this->bulb->turnOn();
    }

    public function redo(): void
    {
        $this->execute();
    }
}

//Invoker

class RemoteControl
{
    public function submit(Command $command): void
    {
        $command->execute();
    }
}

$bulb = new Bulb();

$turnOn = new TurnOn($bulb);
$turnOff = new TurnOff($bulb);

$remote = new RemoteControl();

$remote->submit($turnOn);
$remote->submit($turnOff);



