<?php

// src/AppBundle/Command/RunCommand.php

namespace AppBundle\Command;

use Node4\LinkedInBundle;
use Node4\DataMiningBundle\Google;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;

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


    public function getOauth2Token()
    {
        $googleDrive = new Google();
        $accessToken = $googleDrive->getOauthToken();
        return $accessToken;
    }


    public function getAllLinkedInURIs()
    {
        $accessToken = $this->getOauth2Token();

        $serviceRequest = new DefaultServiceRequest($accessToken);
        ServiceRequestFactory::setInstance($serviceRequest);

        $spreadsheetService = new \Google\Spreadsheet\SpreadsheetService();
        $spreadsheetFeed    = $spreadsheetService->getSpreadsheets();
        $spreadsheet        = $spreadsheetFeed->getByTitle('Node4Clients');
        $worksheetFeed      = $spreadsheet->getWorksheets();
        $worksheet          = $worksheetFeed->getByTitle('Sheet1');
        $listFeed           = $worksheet->getListFeed();

        foreach ($listFeed->getEntries() as $entry)
        {
            $values = $entry->getValues();
            $values['linkedin'] = $this->getLinkedInURLForCompany($values['accountname']);
            $entry->update($values);
        }
    }



    public function execute(InputInterface $input, OutputInterface $output)
    {
        //$this->getAllLinkedInURIs();
        //$finder = new LinkedIn();
        //$results = $finder->getCompanyIdFromName('Box UK Limited');

        $linkedInAPIWorker = new LinkedInBundle\LinkedInService('7821zeqhr374oh', 'doA15Wo6x999tkeV', 'r_basicprofile,r_emailaddress');
        $linkedInAPIWorker->getAccessToken();
        $data = $linkedInAPIWorker->api('GET', 'https://api.linkedin.com/v1/companies/38538');
        var_dump($data);

    }
}