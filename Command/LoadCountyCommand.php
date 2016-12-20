<?php
namespace Lthrt\CCSBundle\Command;

use Lthrt\CCSBundle\DataFixtures\CountyLoader;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class LoadCountyCommand extends ContainerAwareCommand
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('lthrt:load:county')
            ->setAliases(['lthrt:lo:fr'])
            ->setDescription('Loads county names and coverages into database, skipping already present')
            ->addOption('em', null, InputOption::VALUE_REQUIRED, 'entity manager')
            ->setHelp(<<<EOT
The <info>lthrt:load:county</info> Loads county names and coverages into database, skipping already present

EOT
            );
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(
        InputInterface  $input,
        OutputInterface $output
    ) {
        $emName  = $input->getOption('em');
        $manager = $this->getContainer()->get('doctrine')->getManager($emName);
        $loader  = new CountyLoader($manager);
        $result  = $loader->loadCounties();

        if ($result['insertedCounties']) {
            $output->writeln("<info>" . count($result['insertedCounties']) . "</info> counties added.");
        }

        if ($result['ignoredCounties']) {
            $output->writeln("<comment>" . count($result['ignoredCounties']) . "</comment> duplicated counties ignored.");
        }

        if ($result['insertedCoverages']) {
            $output->writeln("<info>" . count($result['insertedCoverages']) . "</info> coverages added.");
        }

        if ($result['ignoredCoverages']) {
            $output->writeln("<comment>" . count($result['ignoredCoverages']) . "</comment> duplicated coverages ignored.");
        }

        $output->writeln("");
    }
}
