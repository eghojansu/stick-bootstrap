<?php

namespace App;

use Fal\Stick\Fw;

class App
{
    const VERSION = 'v0.1.0';

    private $fw;

    public function __construct(Fw $fw)
    {
        $this->fw = $fw;
    }

    public function installed()
    {
        return self::VERSION === $this->fw->INSTALLED;
    }

    public function alert($message, $type = 'success', $target = null)
    {
        return $this->fw->append('SESSION.alerts.'.$type, $message, true)->reroute($target);
    }

    public function success($message, $target = null)
    {
        return $this->alert($message, __FUNCTION__, $target);
    }

    public function danger($message, $target = null)
    {
        return $this->alert($message, __FUNCTION__, $target);
    }

    public function warning($message, $target = null)
    {
        return $this->alert($message, __FUNCTION__, $target);
    }

    public function info($message, $target = null)
    {
        return $this->alert($message, __FUNCTION__, $target);
    }
}
