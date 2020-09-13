<?php

namespace Score\Event;
use Score\Main;
use pocketmine\event\Listener;
use pocketmine\{Server, Player};
use pocketmine\event\player\{PlayerQuitEvent, PlayerJoinEvent, PlayerRespawnEvent};
use pocketmine\event\entity\EntityLevelChangeEvent;


class EventListener implements Listener{
    
	/** @var Main */
	private $plugin;
	
	/**
     * @param Main $plugin
     */
	public function __construct(Main $plugin){
	$this->plugin = $plugin;
	$this->getServer()->getPluginManager()->registerEvents($this, $this->getPlugin());
	}
	
	public function getPlugin(){
	return $this->plugin;
	}
	
	public function getServer(){
	return $this->getPlugin()->getServer();
	}
	    
	/**
     * @param EntityLevelChangeEvent $event
     */
	public function onChange(EntityLevelChangeEvent $event){
      $player = $event->getEntity();
      if($player instanceof Player){
          $api = Main::getScoreboard();
          $api->remove($player);
      }
	}
	/**
     * @param PlayerQuitEvent $event
     */
	public function onQuit(PlayerQuitEvent $event){
	$player = $event->getPlayer();
     	if($this->getPlugin()->isScore($player->getName())){
	       $this->getPlugin()->unScore($player->getName());
	    }
	}
	/**
     * @param PlayerJoinEvent $event
     */
	public function onJoin(PlayerJoinEvent $event){
	$player = $event->getPlayer();
	$player->sendMessage("Score");
	     	if(!$this->getPlugin()->isScore($player->getName())){
	     	    $this->getPlugin()->setScore($player->getName());
	     	}
	     	
	}
}