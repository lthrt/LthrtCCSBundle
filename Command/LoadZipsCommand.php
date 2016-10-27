<?php

namespace Lthrt\CCSBundle\Command;

use Lthrt\CCSBundle\DataFixtures\ZipLoader;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class LoadZipsCommand extends ContainerAwareCommand
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('lthrt:load:zips')
            ->setAliases(['lthrt:lo:zi'])
            ->setDescription('Loads zips, counties, and cities into database, skipping zips and cities already present')
            ->addOption('overwrite', null, InputOption::VALUE_NONE, 'Overwrite even if city exists')
            ->addOption('em', null, InputOption::VALUE_REQUIRED, 'entity manager')
            ->setHelp(<<<EOT
The <info>lthrt:load:zips</info> Loads zips, counties, and cities database
if they are not already present.  States must be loaded first
(with <comment>lthrt:load:states</comment>)

You really want to use the <comment>--no-debug</comment> flag

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
        $overwrite = $input->getOption('overwrite') ?: false;
        $emName    = $input->getOption('em');
        $manager   = $this->getContainer()->get('doctrine')->getManager($emName);
        $loader    = new ZipLoader($manager);
        $result    = $loader->loadZips($overwrite);

        if (isset($result['noStates'])) {
            $output->writeln("States must be loaded first: <comment>lthrt:load:states</comment>");
        } else {
            $output->writeln("<info>" . $result['cities'] . "</info> cities added.");
            $output->writeln("<info>" . $result['counties'] . "</info> counties added.");
            $output->writeln("<info>" . $result['zips'] . "</info> zip codes added.");
        }
    }
}
