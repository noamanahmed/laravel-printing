<?php

namespace Rawilk\Printing\Contracts;

interface PrintJob
{
    public function date();

    public function id();

    public function name();

    public function printerId();

    public function printerName();

    public function state();
}
