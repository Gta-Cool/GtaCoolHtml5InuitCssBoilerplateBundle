<?php

namespace GtaCool\Bundle\Html5InuitCssBoilerplateBundle\Command;

use Sensio\Bundle\GeneratorBundle\Command\GenerateBundleCommand as BaseGenerateBundleCommand;
use GtaCool\Bundle\Html5InuitCssBoilerplateBundle\Generator\BundleGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
        $this->setName('gta-cool:html5-inuit.css:generate-bundle');
        $this->setDescription('Generates a bundle with inuit.css and html5 boilerplate installed inside');
        $help = $this->getHelp();
        $help = str_replace('generate:bundle', 'gta-cool:html5-inuit.css:generate-bundle', $help);
        $help = str_replace('bundles', 'bundles with inuit.css and html5 boilerplate installed inside', $help);
        $this->setHelp($help);
    }

    protected function createGenerator()
    {
        return new BundleGenerator($this->getContainer()->get('filesystem'), __DIR__.'/../Resources/skeleton');
    }
}
