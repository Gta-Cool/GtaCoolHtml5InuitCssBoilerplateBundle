<?php

namespace GtaCool\Bundle\Html5InuitCssBoilerplateBundle\Generator;

use GtaCool\Bundle\InuitCssBundle\Generator\BundleGenerator as BaseBundleGenerator;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Generates a bundle with boilerplate template inside.
 *
 * @author Jonathan Plugaru <jplugaru@hotmail.fr>
 */
class BundleGenerator extends BaseBundleGenerator
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

    public function generate($namespace, $bundle, $dir, $format, $structure)
    {
        parent::generate($namespace, $bundle, $dir, $format, $structure);

        $dir .= '/'.strtr($namespace, '\\', '/');
        $parameters = array(
            'bundle' => $bundle,
        );
        $this->setSkeletonDirs(array($this->skeletonDir));
        $this->renderFile('bundle/base.html.twig.twig', $dir.'/Resources/views/Base/base.html.twig', $parameters);
    }
}