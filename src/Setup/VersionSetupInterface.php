<?php

namespace App\Setup;

use Fal\Stick\Fw;

interface VersionSetupInterface
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
     * @param Fw             $fw
     * @param SetupInterface $setup
     */
    public function prepare(Fw $fw, SetupInterface $setup);

    /**
     * Installation logic.
     *
     * @param Fw             $fw
     * @param SetupInterface $setup
     */
    public function install(Fw $fw, SetupInterface $setup);
}
