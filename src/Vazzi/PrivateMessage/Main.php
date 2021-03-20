<?php

namespace Vazzi\PrivateMessage;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\Server;
use Vazzi\PrivateMessage\command\MessageCommand;
use Vazzi\PrivateMessage\command\ReplyCommand;
use Vazzi\PrivateMessage\event\PlayerLeaveListener;
use Vazzi\PrivateMessage\event\PlayerLoginListener;

class Main extends PluginBase {

	const PREFIX = TextFormat::DARK_GRAY . '[' . TextFormat::DARK_AQUA . 'Message' . TextFormat::DARK_GRAY  . '] ' . TextFormat::GRAY .  '»' . TextFormat::WHITE . ' ';
	public static $instance = null;

	public static $lastPlayer = [];

	public static function getInstance() {
		return self::$instance;
	}

	public function onLoad(){
		self::$instance = $this;
	}

	public function onEnable() {
		$this->getServer()->getLogger()->info(self::PREFIX . TextFormat::GREEN . "PrivateMessage Plugin activated.");
		$this->unregister(["msg", "tell", "r"]);
		$this->registerEvents();
		$this->registerCommands();
	}

	public function registerCommands()
	{
		$cmds = $this->getServer()->getCommandMap();
		$cmds->register('PrivateMessage', new MessageCommand());
		$cmds->register('PrivateMessage', new ReplyCommand());
	}

	public function unregister($commands){
		$map = $this->getServer()->getCommandMap();
		foreach ($commands as $cmd) {
			$command = $map->getCommand($cmd);
			if ($command !== null) {
				$map->unregister($command);
			}
		}
	}


	public function registerEvents()
	{
		$this->getServer()->getPluginManager()->registerEvents(new PlayerLoginListener(), $this);
		$this->getServer()->getPluginManager()->registerEvents(new PlayerLeaveListener(), $this);
	}
}
