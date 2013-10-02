<?php

namespace GtaCool\Bundle\Html5InuitCssBoilerplateBundle\Generator;

use Sensio\Bundle\GeneratorBundle\Generator\BundleGenerator as BaseBundleGenerator;
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
     * @param string $skeletonDir
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(Filesystem $filesystem, $skeletonDir)
    {
        if (!is_string($skeletonDir)) {
            throw new \InvalidArgumentException("\"$skeletonDir\" must be a string");
        }

        $this->filesystem = $filesystem;
        $this->skeletonDir = $skeletonDir;
    }

    public function generate($namespace, $bundle, $dir, $format, $structure)
    {
        parent::generate($namespace, $bundle, $dir, $format, $structure);

        $dir .= '/'.strtr($namespace, '\\', '/');
        $parameters = array(
            'bundle' => $bundle,
        );
        $this->setSkeletonDirs(array($this->skeletonDir));
        $this->renderFile('bundle/html5.html.twig.twig', $dir.'/Resources/views/Base/html5.html.twig', $parameters);
    }
}