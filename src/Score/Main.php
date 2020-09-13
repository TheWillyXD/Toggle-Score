<?php


namespace Score;
use pocketmine\event\Listener;
use pocketmine\{Server, Player};
use pocketmine\plugin\PluginBase;
use Score\Event\EventListener;
use Score\Task\ScoreTask;
use Score\libs\FormApi\SimpleForm;
use Score\libs\ScoreApi;
use Score\Command\Cmd;
use Score\libs\FormApi\FormApi;
use Score\libs\FormApi\Form;
use Score\libs\FormApi\ModalForm;
use Score\libs\FormApi\CustomForm;

class Main extends PluginBase implements Listener {

    private static $scoreboard = null;
	private static $instance = null;
	/** @var array $score */
    public $score = [];
    
    public function onEnable(){
	$this->getlogger()->info("activado!");	
	$this->getEvents();
	$this->getServer()->getCommandMap()->register("test", new Cmd($this));
	$this->getScheduler()->scheduleRepeatingTask(new ScoreTask($this), 30);
	$this->getServer()->getPluginManager()->registerEvents($this, $this);
	
	}
    public function onLoad(){
		Main::$instance = $this;
		Main::$scoreboard = new ScoreAPI($this);
	}
	public function getEvents(){
	return new EventListener($this);
	}
	
    /**
     * @param Player $player
     */
	public function setForm(Player $player) {
            	$form = new CustomForm(function(Player $player, array $data = null){
               if($data === null ) {
                   return true;
                }               	
               if($data[0] == true){
                      $this->unScore($player->getName()); 
                      $api = $this->getScoreboard();
   	                  $api->remove($player);
                      $player->sendMessage("ScoreBoard Desactivada");
               }
               	if($data[0] == false){
                      $this->setScore($player->getName()); 
                      $player->sendMessage("ScoreBoard Activada");
                   
                }
           });
           $form->setTitle("Score On/off");
           $form->addToggle("Remover ScoreBoard?", false);
           $form->sendToPlayer($player);
    }
    /**
     * return ScoreApi
     */
    public static function getScoreboard() : ScoreAPI {
	return Main::$scoreboard;
	}
    public function isScore($name){
	return in_array($name, $this->score);
	}
	
    public function setScore($name){
	$this->score[$name] = $name;
	}
	
    public function unScore($name){
    
        if(!$this->isScore($name)){
	    return;
	    }
	unset($this->score[$name]);
	}
	public static function getInstance() {
         return self::$instance;
    } 
}