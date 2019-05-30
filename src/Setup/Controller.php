<?php

namespace App\Setup;

use App\App;
use Fal\Stick\Fw;

class Controller
{
    private $fw;

    public function __construct(Fw $fw)
    {
        $this->fw = $fw;
    }

    public function install(Fw $fw)
    {
        $fw->prepend('template_dir', __DIR__.'/template/;');

        $class = $fw['setup_class'];
        $setup = new $class($fw);
        $versions = $this->loadVersions();
        $allowedVersions = array_filter($versions, array($this, 'isVersionAllowed'));

        if ('yes' === $fw['GET.finish'] && $fw['SESSION.install_finish']) {
            $fw->write($fw['TEMP'].'version.ini', 'INSTALLED = '.App::VERSION);

            return $fw->template->render('install.html', array(
                'finish' => $fw->flash('SESSION.install_finish'),
                'version' => App::VERSION,
            ));
        }

        $setup->prepare($fw, $allowedVersions);

        if ($setup->isSubmitted()) {
            $setup->install($fw, $setup->installFromBeginning() ? $versions : $allowedVersions);
            $fw->write($fw['TEMP'].'parameters.ini', $setup->stringify());

            return $fw->set('SESSION.install_finish', true)->reroute('?finish=yes');
        }

        return $fw->rem('SESSION')->template->render('install.html', array(
            'finish' => false,
            'form' => $setup->getForm(),
            'version' => $fw->INSTALLED ?? 'none',
            'targetVersion' => App::VERSION,
        ));
    }

    private function loadVersions()
    {
        $versions = array();

        foreach ($this->fw->files(__DIR__.'/Version') as $file) {
            if (preg_match('~(/v\d+/.+)\.php$~', $file, $match)) {
                $class = 'App\\Setup\\Version'.str_replace('/', '\\', $match[1]);
                $version = new $class();

                if (!$version instanceof VersionSetupInterface) {
                    throw new \LogicException('Version Setup class should implements App\\Setup\\VersionSetupInterface.');
                }

                $versions[$version->getVersion()] = $version;
            }
        }

        ksort($versions);

        return $versions;
    }

    private function isVersionAllowed(VersionSetupInterface $setup)
    {
        $version = $setup->getVersion();
        $installed = $this->fw->INSTALLED;
        $passMinimum = !$installed || version_compare($version, $installed, '>');
        $passMaximum = version_compare($version, App::VERSION, '<=');

        return $passMinimum && $passMaximum;
    }
}
