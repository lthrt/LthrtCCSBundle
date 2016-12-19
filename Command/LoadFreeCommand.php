<?php
namespace Lthrt\CCSBundle\Command;

use Lthrt\CCSBundle\DataFixtures\FreeLoader;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class LoadFreeCommand extends ContainerAwareCommand
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('lthrt:load:free')
            ->setAliases(['lthrt:lo:fr'])
            ->setDescription('Loads zips and cities into database, skipping already present')
            ->addOption('em', null, InputOption::VALUE_REQUIRED, 'entity manager')
            ->setHelp(<<<EOT
The <info>lthrt:load:free</info> Loads zips and cities into a database if they are not already
present.  Data comes from 'Free Zip Code Database': http://federalgovernmentzipcodes.us/


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
        $loader  = new FreeLoader($manager);
        $result  = $loader->loadZips();

        if ($result['insertedCities']) {
            $output->writeln("<info>" . count($result['insertedCities']) . "</info> cities added.");
        }

        if ($result['ignoredCities']) {
            $output->writeln("<comment>" . count($result['ignoredCities']) . "</comment> duplicated cities ignored.");
        }

        if ($result['insertedZips']) {
            $output->writeln("<info>" . count($result['insertedZips']) . "</info> zips added.");
        }

        if ($result['ignoredZips']) {
            $output->writeln("<comment>" . count($result['ignoredZips']) . "</comment> duplicated zips ignored.");
        }

        $output->writeln("");
    }
}
