<?php

// src/AppBundle/Command/RunCommand.php

namespace AppBundle\Command;

use Node4\DataMiningBundle\GoogleSheets;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Node4\DataMiningBundle\LinkedIn;

class RunCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('master:run')
            ->setDescription('Run main program');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $company = 'Box UK';
        $obj     = new LinkedIn();
        $URI     = $obj->getCompanyURI($company);

        $GoogleSheetsObj  = new GoogleSheets();
        $token = $GoogleSheetsObj->getToken();

        $output->writeln($URI);
        $output->writeln($token);
    }
}