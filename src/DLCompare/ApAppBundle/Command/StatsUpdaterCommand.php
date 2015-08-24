<?php

namespace DLCompare\ApAppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use DLCompare\ApAppBundle\Stats\ChampionStats;
use DLCompare\ApAppBundle\Stats\GameStats;
use DLCompare\ApAppBundle\Stats\ItemStats;
use DLCompare\ApAppBundle\Stats\TypeStats;

class StatsUpdaterCommand extends ContainerAwareCommand
{   
    static protected $versions = ['5.11', '5.14'];
    static protected $regions  = ['br', 'eune', 'euw', 'kr', 'lan', 'las', 'na', 'oce', 'ru', 'tr'];

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
            ->setName('dlcompare:apapp:stats_update')
            ->setDescription('Update stats of all items and champions')
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
        $output->writeln("\t" . '<comment>Updating items stats</comment>');
        $this->updateItems();
        $output->writeln("\t" . '<comment>Updating champions stats</comment>');
        $this->updateChampions();
        $output->writeln("\t" . '<comment>Updating type stats</comment>');
        $this->updateTypes();
        $output->writeln("\t" . '<comment>Updating game stats</comment>');
        $this->updateGames();
    }

    public function updateItems()
    {
        $container  = $this->getContainer();
        $manager    = $container->get('lolapi.manager.item');
        $items      = $manager->findAll();

        foreach($items as $item)
        {
            $stats = new ItemStats($item, $container);
            $stats->setRefresh(true);

            foreach(self::$versions as $version)
            {
                $stats->getUsage($version);

                foreach($stats->getMainChampions() as $champion)
                {
                   $stats->getChampionUsage($version, $champion);
                   $stats->getChampionWinrate($version, $champion);
                }
            }
        }
    }

    public function updateGames()
    {
        $container  = $this->getContainer();

        $stats = new GameStats($container);
        $stats->setRefresh(true);

        foreach(self::$versions as $version)
        {
            $stats->countByVersion($version);

            foreach(self::$regions as $region)
            {
                $stats->countByRegion($region);
                $stats->countByVersionByRegion($version, $region);
            }
        }
    }

    public function updateChampions()
    {
        $container  = $this->getContainer();
        $manager    = $container->get('lolapi.manager.champion');
        $champions  = $manager->findAll();

        foreach($champions as $champion)
        {
            $stats = new ChampionStats($champion, $container);
            $stats->setRefresh(true);

            foreach(self::$versions as $version)
            {
                $stats->getPickRate($version);
                $stats->getBanRate($version);
                $stats->getUsage($version);
                $stats->getWinRate($version);
                $stats->getKillsAverage($version);
                $stats->getDeathsAverage($version);
                $stats->getAssistsAverage($version);
                $stats->getKda($version);
                $stats->getGold($version);

                foreach($stats->getMainItems() as $item)
                {
                   $stats->getItemUsage($version, $item);
                   $stats->getItemWinrate($version, $item);
                }
            }
        }
    }

    public function updateTypes()
    {
        $container  = $this->getContainer();

        $manager  = $container->get('lolapi.manager.champion');
        $champions = $manager->findBy([], ['name' => 'ASC']);

        $types = [];
        foreach($champions as $champion)
        {
            $tags = explode(',', $champion->getTags());
            foreach($tags as $tag)
            {
                if(trim($tag) && !in_array($tag, $types))
                {
                    $types[] = $tag;
                }
            }
        }

        foreach($types as $type)
        {
            $stats = new TypeStats($type, $container);
            $stats->setRefresh(true);

            foreach(self::$versions as $version)
            {
                $stats->getPickRate($version);
                $stats->getBanRate($version);
                $stats->getWinRate($version);
                $stats->getKillsAverage($version);
                $stats->getDeathsAverage($version);
                $stats->getAssistsAverage($version);
                $stats->getKda($version);
            }
        } 
    }
}