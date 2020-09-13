<?php

namespace Score\Task;

use Score\Main;

use pocketmine\{Player, Server};
use pocketmine\level\Level;
use pocketmine\event\Listener;
use pocketmine\scheduler\Task;
use pocketmine\utils\{Config, TextFormat as TE};

class ScoreTask extends Task {


    protected $plugin;
    
	/**
     * @param Main $plugin
     */    
    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }
    public function getPlugin(){
	return $this->plugin;
	}
	
	public function getServer(){
	return $this->getPlugin()->getServer();
	}
    /**
     * @param Int $currentTick
     */
    public function onRun(Int $currentTick){
           foreach(Main::getInstance()->getServer()->getDefaultLevel()->getPlayers() as $pl) {
               if($this->getPlugin()->isScore($pl->getName())){
                  $this->sC($pl);
     	        }
           }
    }
    /**
     * @param Player $pl
     */
    public function sC(Player $pl) {
$api = Main::getScoreboard();
$api->new($pl, $pl->getName(), " §6§lScore ");
$api->setLine($pl, 1, "§r===================§r");

$api->setLine($pl, 2, "§6§l Test");

$api->setLine($pl, 3, "§f===================");  

$api->getObjectiveName($pl);
    }
	
}	