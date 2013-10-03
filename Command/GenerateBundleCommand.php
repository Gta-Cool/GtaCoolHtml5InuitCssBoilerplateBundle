<?php

namespace GtaCool\Bundle\Html5InuitCssBoilerplateBundle\Command;

use Sensio\Bundle\GeneratorBundle\Command\GenerateBundleCommand as BaseGenerateBundleCommand;
use GtaCool\Bundle\Html5InuitCssBoilerplateBundle\Generator\BundleGenerator;

/**
 * Generates bundles with base template inside
 *
 * @author Jonathan Plugaru <jplugaru@hotmail.fr>
 */
class GenerateBundleCommand extends BaseGenerateBundleCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        parent::configure();
        $this->setName('gta-cool:boilerplate:generate-bundle');
        $this->setDescription('Generates a bundle with inuit.css and html5 boilerplate installed inside');
        $help = $this->getHelp();
        $help = str_replace('generate:bundle', 'gta-cool:boilerplate:generate-bundle', $help);
        $help = str_replace('bundles', 'bundles with inuit.css and html5 boilerplate installed inside', $help);
        $this->setHelp($help);
    }

    protected function createGenerator()
    {
        return new BundleGenerator(
            $this->getContainer()->get('filesystem'),
            $this->getContainer()->getParameter('inuit_css.bundle.resources_installation_dir')
        );
    }
}
