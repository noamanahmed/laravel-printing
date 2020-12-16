<?php

namespace Rawilk\Printing\Contracts;

use Illuminate\Support\Collection;

interface Driver
{
    public function newPrintTask();

    public function find($printerId = null);

    public function printers();
}
