<?php

// src/AppBundle/Command/RunCommand.php

namespace AppBundle\Command;

use Node4\DataMiningBundle\GoogleDrive;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Node4\DataMiningBundle\LinkedIn;
use Buzz;
use Symfony\Component\Validator\Constraints\False;
use Wunderdata;


class RunCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('master:run')
            ->setDescription('Run main program');
    }

    public function getLinkedInURLForCompany($company)
    {
        $linkedIn = new LinkedIn();
        return $linkedIn->getCompanyURI($company);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        //
        $results     = array();
        $results[]   = $this->getLinkedInURLForCompany('Box UK');
        //

        //
        $googleDrive = new GoogleDrive();
        $token       = $googleDrive->getOauthToken();
        //

        //
        $browser     = new Buzz\Browser();
        $client      = new Wunderdata\Google\Client($token, $browser);

        $allSpreadsheets = $client->loadSpreadsheets();
        $worksheets = $client->loadWorksheets($allSpreadsheets[0]);
        $cellFeed = $client->loadCellFeed($worksheets[0]);

        $allCellsInWorksheet = $cellFeed->getCells();
        $count = $cellFeed->countRows();

        $readColumn = 'B';
        $writeColumn = 'C';
        $row  =  2;

        for($i = $row; $i < $count; $i++)
        {
            $readAddress  = $readColumn.$i;
            $writeAddress = $writeColumn.$i;

            $cellToRead  = $cellFeed->findCell($readAddress);
            $cellToWrite = new Wunderdata\Google\Cell();
            $cellsToWrite = new Wunderdata\Google\CellFeed(array($cellToWrite));

            $company = $cellToRead->getContent();
            $cellToWrite->setContent($company);
        }

        $browser->getLastRequest();

    }


}