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

    public function __call($method, $arguments)
    {
        if (0 === strncasecmp($method, 'alert', 5)) {
            return $this->alert($arguments[0], strtolower(substr($method, 5)), $arguments[1] ?? null);
        }

        throw new \BadMethodCallException(sprintf('Unable to call method %s::%s.', __CLASS__, $method));
    }

    public function isInstalled()
    {
        return self::VERSION === $this->fw->INSTALLED;
    }

    public function isMaintenance()
    {
        $maintenance = $this->fw->store->maintenance;

        return ($maintenance && strtotime($maintenance) >= time()) && !$this->fw->auth->isGranted('ROLE_ADMIN');
    }

    public function alert($message, $type = 'success', $target = null)
    {
        return $this->fw->append('SESSION.alerts.'.$type, $message, true)->reroute($target);
    }
}
