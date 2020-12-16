<?php

declare(strict_types=1);

namespace Rawilk\Printing;

use Rawilk\Printing\Contracts\Printer;
use Rawilk\Printing\Contracts\PrintTask as PrintTaskContract;
use Rawilk\Printing\Exceptions\InvalidSource;

abstract class PrintTask implements PrintTaskContract
{
    protected $jobTitle = '';
    protected $options = [];
    protected $content = '';
    protected $printSource;

    /** @var string|mixed */
    protected $printerId;

    public function __construct()
    {
        $this->printSource = config('app.name');
    }

    public function content($content)
    {
        $this->content = $content;

        return $this;
    }

    public function file($filePath)
    {
        if (! file_exists($filePath)) {
            throw InvalidSource::fileNotFound($filePath);
        }

        $this->content = file_get_contents($filePath);

        return $this;
    }

    public function url($url)
    {
        if (! preg_match('/^https?:\/\//', $url)) {
            throw InvalidSource::invalidUrl($url);
        }

        $this->content = file_get_contents($url);

        return $this;
    }

    public function jobTitle($jobTitle)
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    public function printer($printerId)
    {
        if ($printerId instanceof Printer) {
            $printerId = $printerId->id();
        }

        $this->printerId = $printerId;

        return $this;
    }

    public function printSource($printSource)
    {
        $this->printSource = $printSource;

        return $this;
    }

    /**
     * Not all drivers may support tagging jobs.
     */
    public function tags($tags)
    {
        return $this;
    }

    /**
     * Not all drivers may support this feature.
     */
    public function tray($tray)
    {
        return $this;
    }

    /**
     * Not all drivers might support this option.
     */
    public function copies(int $copies)
    {
        return $this;
    }

    public function option(string $key, $value)
    {
        $this->options[$key] = $value;

        return $this;
    }

    protected function resolveJobTitle(): string
    {
        if ($this->jobTitle) {
            return $this->jobTitle;
        }

        return 'job_' . uniqid('', false) . '_' . date('Ymdhis');
    }
}
