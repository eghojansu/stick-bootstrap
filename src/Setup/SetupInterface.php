<?php

namespace App\Setup;

use Fal\Stick\Form\Form;
use Fal\Stick\Fw;

interface SetupInterface
{
    /**
     * Returns version.
     *
     * @return string
     */
    public function getVersion(): string;

    /**
     * Prepare installer.
     *
     * @param  Fw     $fw
     * @param  Form   $form
     *
     * @return void
     */
    public function prepare(Fw $fw, Form $form): void;

    /**
     * Installation logic.
     *
     * @param  SqlExecutor  $exec
     *
     * @return array
     */
    public function install(SqlExecutor $exec): array;
}
