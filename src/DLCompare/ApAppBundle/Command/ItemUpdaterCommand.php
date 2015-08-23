<?php

namespace DLCompare\ApAppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use DLCompare\LoLApiBundle\Api\Exception\RateLimtiExceededException;

class ItemUpdaterCommand extends ContainerAwareCommand
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
            ->setName('dlcompare:apapp:item_update')
            ->setDescription('Update data of all items')
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
        $em         = $this->getContainer()->get('doctrine.orm.entity_manager');
        $api        = $this->getContainer()->get('lolapi');
        $manager    = $this->getContainer()->get('lolapi.manager.item');
        $items      = $manager->findAll();

        $api->setRegion('na');

        foreach($items as $item)
        {
            try
            {
                $last = $api->call('static_data', 'item_details', ['id' => $item->getDistantId()], ['itemData' => "all", 'version' => "5.14.1"]);
                $prev = $api->call('static_data', 'item_details', ['id' => $item->getDistantId()], ['itemData' => "all", 'version' => "5.11.1"]);

                if($last->stats != $prev->stats)
                {
                    $item
                        ->setFlag(true)
                    ;
                    $em->persist($item);
                }
            } 
            catch(\Exception $e)
            {
                continue;
            }
        }

        $em->flush();
    }
}