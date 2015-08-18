<?php

namespace DLCompare\ApAppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use DLCompare\LoLApiBundle\Api\Exception\RateLimtiExceededException;

class ImporterCommand extends ContainerAwareCommand
{   
    /**
     * @var array
     */ 
    protected $data = array();

    /**
     * Configures the command
     */
    protected function configure()
    {
        $this
            ->setName('dlcompare:apapp:import')
            ->setDescription('Imports data from dataset')
            ->addArgument('version', InputArgument::REQUIRED, 'version')
            ->addArgument('region', InputArgument::REQUIRED, 'region')
        ;
    }

    /**
     * Executes the command
     *
     * @param Symfony\Component\Console\Input\InputInterface $input
     * @param Symfony\Component\Console\Output\OutputInterfac $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {     
        $wversion = $input->getArgument('version');
        $wregion  = $input->getArgument('region');

        $dir = __DIR__.'/../Resources/dataset';

        $versions   = ['5.14','5.11'];
        $modes      = ['RANKED_SOLO','NORMAL_5X5'];
        $regions    = ['eune', 'euw', 'kr', 'lan', 'las', 'na', 'oce', 'ru', 'tr'];

        foreach($versions as $version)
        {
            if($version != $wversion) { continue; }
            foreach($modes as $mode)
            {
                foreach($regions as $region)
                {
                    if($region != $wregion) { continue; }
                    $path = $version . '/' . $mode . '/' . strtoupper($region) . '.json';
                    $json = json_decode(file_get_contents($dir . '/' . $path));
                    
                    $output->writeln("\t" . '<comment>Importing <info>' . count($json) . '</info> matches from file <info>' . $path . '</info></comment>');
                    foreach($json as $matchId)
                    {
                        $this->getContainer()->get('lolapi.importer.factory')->getImporter('match')->import(['region' => $region, 'matchId' => $matchId]);
                        $this->getContainer()->get('doctrine.orm.entity_manager')->flush();
                    }
                }
            }
        }
    }
}