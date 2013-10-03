<?php

namespace GtaCool\Bundle\Html5InuitCssBoilerplateBundle\Generator;

use GtaCool\Bundle\InuitCssBundle\Generator\InuitCssGenerator;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

/**
 * Generates inuit.css files inside a bundle.
 *
 * @author Jonathan Plugaru <jplugaru@hotmail.fr>
 */
class BoilerplateGenerator extends InuitCssGenerator
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var string
     */
    private $skeletonDir;

    /**
     * Constructor
     *
     * @param Filesystem $filesystem
     * @param string $resourcesInstallationDir
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(Filesystem $filesystem, $resourcesInstallationDir)
    {
        if (!is_string($resourcesInstallationDir)) {
            throw new \InvalidArgumentException("\"$resourcesInstallationDir\" must be a string");
        }

        // Need call parent constructor
        parent::__construct($filesystem, $resourcesInstallationDir);

        $this->filesystem = $filesystem;
        $this->skeletonDir = __DIR__.'/../Resources/skeleton';
    }

    public function generate(BundleInterface $bundle)
    {
        parent::generate($bundle);

        $dir = $bundle->getPath();
        $parameters = array(
            'bundle' => $bundle->getName(),
        );
        $this->setSkeletonDirs(array($this->skeletonDir));
        $this->renderFile('bundle/html5.html.twig.twig', $dir.'/Resources/views/Base/html5.html.twig', $parameters);
    }
}