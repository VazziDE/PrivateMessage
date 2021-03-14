<?php

namespace Vazzi\PrivateMessage\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use Vazzi\PrivateMessage\Main;
use Vazzi\PrivateMessage\MessageAPI;

class MessageCommand extends Command
{
	public function __construct()
	{
		parent::__construct('message');
		$this->setAliases(['msg']);
		$this->setDescription('Send a private Message to other players.');
		$this->setUsage('/message [Player] [Message]');
	}

	/**
	 * @param CommandSender $sender
	 * @param string $commandLabel
	 * @param string[] $args
	 * @return mixed
	 */
	public function execute(CommandSender $sender, string $commandLabel, array $args)
	{
		if($sender instanceof Player)
		{
			if(count($args) > 0)
			{
				if (Main::getInstance()->getServer()->getPlayer($args[0]) instanceof Player)
				{
					$target = Main::getInstance()->getServer()->getPlayer($args[0]);
					if ($target->getName() != $sender->getName())
					{
						$omsg = implode(" ", $args);
						$msg = str_replace($args[0], "", $omsg);
						Main::$lastPlayer[$sender->getName()] = $target->getName();
						Main::$lastPlayer[$target->getName()] = $sender->getName();
						MessageAPI::sendMessage($target, $msg, $sender);
					}
					else
					{
						$sender->sendMessage(
							Main::PREFIX . TextFormat::RED . "Du kannst dir nicht selber schreiben!"
						);
						return false;
					}
				}
				else
				{
					$sender->sendMessage(
						Main::PREFIX . TextFormat::RED . "Dieser Spieler ist nicht erreichbar!"
					);
				}
			}
			else
			{
				$sender->sendMessage(
					Main::PREFIX . TextFormat::RED . "Du musst einen Spieler und eine Nachricht angeben!"
				);
				return false;
			}
		}
		else
		{
			$sender->sendMessage(
				Main::PREFIX . TextFormat::RED . "Du musst ein Spieler sein!"
			);
			return false;
		}
	}
}