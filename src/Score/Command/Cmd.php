<?php
declare(strict_types=1);
namespace Score\Command;

use Score\Main;
use pocketmine\plugin\Plugin;
use pocketmine\{Player, Server};
use pocketmine\utils\TextFormat as T;
use pocketmine\command\{CommandSender, Command, PluginIdentifiableCommand};


class Cmd extends Command implements PluginIdentifiableCommand {	
    
	private $plugin;

    /**
     * @param Main $plugin
     */
	public function __construct(Main $plugin){
	$this->plugin = $plugin;
    parent::__construct("test", " TEST", "");
	}
	public function getServer(){
	return $this->getPlugin()->getServer();
	}
	
    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     */	
	public function execute(CommandSender $sender, string $commandLabel, array $args) {
	    
	
	if(!$sender instanceof Player){
         $sender->sendMessage("Run this command in-game.");
         return;
    }
    $player = $sender->getPlayer();
	$this->getPlugin()->setForm($player);
	}

	public function getPlugin(): Plugin{
      return $this->plugin;
    }
}