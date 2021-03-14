<?php

namespace Vazzi\PrivateMessage\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use Vazzi\PrivateMessage\Main;
use Vazzi\PrivateMessage\MessageAPI;

class ReplyCommand extends Command
{

	public function __construct()
	{
		parent::__construct('reply');
		$this->setAliases(['r']);
		$this->setDescription('Reply to your last privat message.');
		$this->setUsage('/reply [Message]');
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
				if (Main::$lastPlayer[$sender->getName()] != null && Main::getInstance()->getServer()->getPlayer(Main::$lastPlayer[$sender->getName()]) instanceof Player)
				{
					$target = Main::getInstance()->getServer()->getPlayer(Main::$lastPlayer[$sender->getName()]);
					if ($target->getName() != $sender->getName())
					{
						$msg = implode(" ", $args);
						MessageAPI::sendMessage($target, $msg, $sender);
						Main::$lastPlayer[$sender->getName()] = $target->getName();
						Main::$lastPlayer[$target->getName()] = $sender->getName();
					}
					else
					{
						$sender->sendMessage(
							Main::PREFIX . TextFormat::WHITE . "Du kannst dir nicht selber schreiben!"
						);
						return false;
					}
				}
				else
				{
					$sender->sendMessage(
						Main::PREFIX . TextFormat::WHITE . "Dieser Spieler ist nicht erreichbar!"
					);
				}
			}
			else
			{
				$sender->sendMessage(
					Main::PREFIX . TextFormat::RED . "Du musst eine Nachricht angeben!"
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