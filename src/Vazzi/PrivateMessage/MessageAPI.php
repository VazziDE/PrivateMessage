<?php

namespace Vazzi\PrivateMessage;

use pocketmine\Player;

class MessageAPI
{

	public static function sendMessage(Player $player, String $msg, Player $sender)
	{
		$player->sendMessage(Main::PREFIX . "§7[§a" . $sender->getName() . "§7] §f-> §7[§cME§7]  §f» §7" . $msg);
		$sender->sendMessage(Main::PREFIX . "§7[§cME§7] §f-> §7[§a" . $player->getName() . "§7]  §f» §7" . $msg);
	}

}