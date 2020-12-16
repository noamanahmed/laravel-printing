<?php

namespace Rawilk\Printing\Contracts;

interface PrintTask
{
    public function content($content);

    public function file(string $filePath);

    public function url(string $url);

    public function jobTitle(string $jobTitle);

    public function printer($printerId);

    public function option(string $key, $value);

    public function range($start, $end = null);

    public function tags($tags);

    public function tray($tray);

    public function copies(int $copies);

    public function send();
}
