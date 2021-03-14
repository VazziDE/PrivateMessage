<?php

namespace Vazzi\PrivateMessage\event;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use Vazzi\PrivateMessage\Main;

class PlayerLoginListener implements Listener
{

	public function PlayerLogin(PlayerJoinEvent $event)
	{
		Main::$lastPlayer[$event->getPlayer()->getName()] = null;
	}

}