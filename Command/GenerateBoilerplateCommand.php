<?php

namespace GtaCool\Bundle\Html5InuitCssBoilerplateBundle\Command;

use Sensio\Bundle\GeneratorBundle\Command\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Sensio\Bundle\GeneratorBundle\Command\Validators;
use GtaCool\Bundle\Html5InuitCssBoilerplateBundle\Generator\BoilerplateGenerator;

/**
 * Generates inuit.css files into a bundle.
 *
 * @author Jonathan Plugaru <jplugaru@hotmail.fr>
 */
class GenerateBoilerplateCommand extends GeneratorCommand
{
    /**
     * @see Command
     */
    public function configure()
    {
        $this
            ->setDefinition(array(
                    new InputOption(
                        'bundle',
                        '',
                        InputOption::VALUE_REQUIRED,
                        'The name of the bundle where html5 and inuit.css boilerplate files will be generated'
                    ),
                ))
            ->setDescription('Generates html5 and inuit.css boilerplate files inside a bundle')
            ->setHelp(<<<EOT
The <info>gta-cool:boilerplate:add-inside-bundle</info> command helps you generates boilerplate files
inside bundles.

By default, the command interacts with the developer to tweak the generation.
Any passed option will be used as a default value for the interaction
(<comment>--bundle</comment> is the only one needed if you follow the conventions):

<info>php app/console gta-cool:boilerplate:add-inside-bundle --bundle=AcmeBlogBundle</info>

If you want to disable any user interaction, use <comment>--no-interaction</comment>
but don't forget to pass all needed options:

<info>php app/console gta-cool:boilerplate:add-inside-bundle --bundle=AcmeBlogBundle --no-interaction</info>
EOT
            )
            ->setName('gta-cool:boilerplate:add-inside-bundle')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getDialogHelper();

        if ($input->isInteractive()) {
            if (!$dialog->askConfirmation(
                $output,
                $dialog->getQuestion('Do you confirm generation','yes', '?'),
                true
            )
            ) {
                $output->writeln('<error>Command aborted</error>');

                return 1;
            }
        }

        if (null === $input->getOption('bundle')) {
            throw new \RuntimeException('The bundle option must be provided.');
        }

        $bundle = $input->getOption('bundle');
        if (is_string($bundle)) {
            $bundle = Validators::validateBundleName($bundle);

            try {
                $bundle = $this->getContainer()->get('kernel')->getBundle($bundle);
            } catch (\Exception $e) {
                $output->writeln(sprintf('<bg=red>Bundle "%s" does not exist.</>', $bundle));
            }
        }

        $generator = $this->getGenerator($bundle);
        $generator->generate($bundle);

        $output->writeln('Generating the boilerplate code: <info>OK</info>');

        $dialog->writeGeneratorSummary($output, array());
    }

    public function interact(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getDialogHelper();
        $dialog->writeSection($output, 'Welcome to the Symfony2 html5 and inuit.css boilerplate generator');

        // namespace
        $output->writeln(array(
                '',
                'First, you need to give the bundle name where boilerplate files will be generated.',
                'You must use the shortcut notation like <comment>AcmeBlogBundle</comment>',
                '',
            ));

        while (true) {
            $bundle = $dialog->askAndValidate(
                $output, $dialog->getQuestion('Bundle name', $input->getOption('bundle')),
                array('Sensio\Bundle\GeneratorBundle\Command\Validators', 'validateBundleName'),
                false,
                $input->getOption('bundle')
            );

            try {
                $b = $this->getContainer()->get('kernel')->getBundle($bundle);

                if (!file_exists($b->getPath().'/Resources/public/css/style.scss')) {
                    break;
                }

                $output->writeln(sprintf('<bg=red>Boilerplate files already exists inside "%s".</>', $bundle));
            } catch (\Exception $e) {
                $output->writeln(sprintf('<bg=red>Bundle "%s" does not exist.</>', $bundle));
            }
        }
        $input->setOption('bundle', $bundle);

        // summary
        $output->writeln(array(
                '',
                $this->getHelper('formatter')->formatBlock('Summary before generation', 'bg=blue;fg-white', true),
                '',
                sprintf('You are going to generate boilerplate files inside "<info>%s</info>" bundle', $bundle),
                '',
            ));
    }

    protected function createGenerator()
    {
        return new BoilerplateGenerator(
            $this->getContainer()->get('filesystem'),
            $this->getContainer()->getParameter('inuit_css.bundle.resources_installation_dir')
        );
    }
}
