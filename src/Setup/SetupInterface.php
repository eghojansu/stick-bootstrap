<?php

namespace App\Setup;

use Fal\Stick\Form\Form;
use Fal\Stick\Fw;

interface SetupInterface
{
    /**
     * Execute prepare for version setup.
     *
     * @param  Fw     $fw
     * @param  array  $versions
     */
    public function prepare(Fw $fw, array $versions);

    /**
     * Execute install for version setup.
     *
     * @param  Fw     $fw
     * @param  array  $versions
     */
    public function install(Fw $fw, array $versions);

    /**
     * Returns form.
     *
     * @return Form
     */
    public function getForm(): Form;

    /**
     * Add configuration to commit.
     *
     * @param string $group
     * @param array  $config
     */
    public function addGroup(string $group, array $config);

    /**
     * Returns configuration to write.
     *
     * @return string
     */
    public function stringify(): string;

    /**
     * Returns true if form submitted and valid.
     *
     * @return bool
     */
    public function isSubmitted(): bool;

    /**
     * Returns true if setup require install from beginning.
     *
     * @return bool
     */
    public function installFromBeginning(): bool;

    /**
     * Run sql query.
     *
     * @param string $sql
     */
    public function execSql(string $sql);
}
