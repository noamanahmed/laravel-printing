<?php

namespace Rawilk\Printing\Contracts;

use Illuminate\Support\Collection;

interface Printer
{
    public function capabilities();

    public function description();

    public function id();

    public function isOnline();

    public function name();

    public function status();

    public function trays();

    public function jobs();
}
