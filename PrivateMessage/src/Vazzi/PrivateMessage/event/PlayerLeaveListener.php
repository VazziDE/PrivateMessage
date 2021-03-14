<?php

namespace Vazzi\PrivateMessage\event;


use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use Vazzi\PrivateMessage\Main;

class PlayerLeaveListener implements Listener
{

	public function PlayerLeave(PlayerQuitEvent $event)
	{
		unset(Main::$lastPlayer[$event->getPlayer()->getName()]);
	}

}