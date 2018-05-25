<?php

declare(strict_types=1);

namespace App\Test\Tools;

class Context
{
    /**
     * Static instance holder.
     *
     * @var Context
     */
    private static $instance;

    /**
     * @var array
     */
    public $context;

    /**
     * Class constructor.
     *
     * @param array $context
     */
    public function __construct(array $context)
    {
        $this->context = $context;
    }

    /**
     * Get/create instance.
     *
     * @param array $context
     *
     * @return Context
     */
    public static function instance(array $context = []): Context
    {
        if (!self::$instance) {
            self::$instance = new static($context);
        }

        return self::$instance;
    }
}
