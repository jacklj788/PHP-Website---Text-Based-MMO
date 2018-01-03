<?php
class Players_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }
		

		public function createNewAccount($password, $playerName) {
			
			$query = $this->db->query('INSERT INTO PlayerStats(passWord, Name, Level, Money, Experience, Health, Energy, Strength, Agility,
			 Defense, pvpWins, pvpLoses) VALUES (\''.$password.'\',\''.$playerName.'\', 1, 10, 5, 100, 100, 20, 20, 20, 0, 0)');
		}
		
		public function getPlayerIdFromName($playerName) {
			$query = $this->db->query('SELECT playerID FROM PlayerStats WHERE Name="'.$playerName.'"');
			
			return $query->row_array();
		}
		
		public function giveStartingGear($playerID) {
			$query = $this->db->query('INSERT INTO PlayerArmours (PlayerID, ArmourID) VALUES ('.$playerID.',0)');
			$query2 = $this->db->query('INSERT INTO PlayerWeapons (PlayerID, WeaponID) VALUES ('.$playerID.',0)');
			$query3 = $this->db->query('INSERT INTO PlayerEquipped (PlayerID, WeaponID) VALUES ('.$playerID.',0)');
			$query4 = $this->db->query('INSERT INTO PlayerEquippedArmour (PlayerID, ArmourID) VALUES ('.$playerID.',0)');
		}
		
		public function mailWelcomeMessage($playerID, $playerName) {
			$query = $this->db->query('INSERT INTO MailBox (PlayerTo, PlayerToName, PlayerFrom, PlayerFromName, HasBeenRead, Heading, Content) 
			VALUES ('.$playerID.', \''.$playerName.'\', 1, \'Jack\', 0, \'Welcome!\', \'Welcome to this game. The objective is to train your stats, kill other players, level up and become the best player there is.\')');
		}
		
		public function get_id($id = FALSE)
		{
			if ($id === FALSE)
			{
                $query = $this->db->get('PlayerStats');
                return $query->result_array();
			}

			$query = $this->db->get_where('PlayerStats', array('playerID' => $id));
			return $query->row_array();
		}
		
		public function get_weapons($id = FALSE)
		{
			if($id === FALSE) {
				$query = $this->db->get('Weapons');
				return $query->result_array();
			}
			
			$query = $this->db->get_where('Weapons', array('WeaponID' => $id));
			return $query->result_array();
		}
		
		public function get_playersWeapons($id = FALSE) {
			
			$query = $this->db->query('SELECT Weapons.weaponID, Weapons.Name, Weapons.Power, Weapons.SellPrice, Weapons.Category FROM Weapons INNER JOIN PlayerWeapons ON Weapons.weaponID=PlayerWeapons.WeaponID WHERE PlayerWeapons.PlayerID='. $id
			. ' ORDER BY Weapons.Power DESC');
			
			return $query->result_array();
			
		}
		
		public function get_playersArmours($id = FALSE) {
			
			$query = $this->db->query('SELECT Armours.armourID, Armours.Name, Armours.Defence, Armours.`Sell Price`, Armours.Category FROM Armours INNER JOIN PlayerArmours ON Armours.armourID=PlayerArmours.ArmourID WHERE PlayerArmours.PlayerID='. $id 
			. ' ORDER BY Armours.Defence DESC');
			
			return $query->result_array();
			
		}
		
		// This and getPlayersEquippedArmours need refactoring. 
		public function get_playerEquippedWeapons($id = FALSE) {
			$grabList = $this->db->get_where('PlayerEquipped', array('PlayerID' => $id));
			
			$process = $grabList->result_array();
			$string = "";
			$int = 0;
			foreach($process as $value) {
				if ($int === 0) {
					$string .= ' WHERE weaponID=' . $value['WeaponID'];
				}
				else {
					$string .= ' OR weaponID=' . $value['WeaponID'];
				}
				$int = 1;
			}
			// SELECT the name of all the weapons for each of the given weapon ID's associted with the given player
			$query2 = $this->db->query('SELECT * FROM Weapons' . $string);
			return $query2->result_array();
		}
		
		public function get_playerEquippedArmours($id = FALSE) {
			$grabList = $this->db->get_where('PlayerEquippedArmour', array('PlayerID' => $id));
			
			$process = $grabList->result_array();
			$string = "";
			$int = 0;
			foreach($process as $value) {
				if ($int === 0) {
					$string .= ' WHERE armourID=' . $value['ArmourID'];
				}
				else {
					$string .= ' OR armourID=' . $value['ArmourID'];
				}
				$int = 1;
			}
			// SELECT the name of all the weapons for each of the given weapon ID's associted with the given player
			$query2 = $this->db->query('SELECT * FROM Armours' . $string);
			return $query2->result_array();
		}

		
		// PASSWORD
		public function createPassword($playerID, $passWord) {
			$query = $this->db->query('UPDATE PlayerStats SET passWord=\''.$passWord.'\' WHERE playerID='.$playerID); 
		}
		
		public function fetchPassword($playerID) {
			$query = $this->db->query('SELECT * FROM PlayerStats WHERE playerID='.$playerID);
			
			return $query->row_array();
		}

		// duplicate code - need to refactor with variables. 
		public function insertWeapon($playerID = FALSE, $weaponID = FALSE, $addThisPower, $removeThisPower) {
			
			$query = $this->db->query('DELETE FROM PlayerEquipped WHERE PlayerID=' . $playerID);
			
			$query = $this->db->query('INSERT INTO PlayerEquipped (PlayerID, WeaponID) VALUES (' . $playerID . ', ' .$weaponID .  ')');	
			
			$this->db->query('UPDATE PlayerStats SET Strength=Strength-'.$removeThisPower.' WHERE playerID='.$playerID);
			$this->db->query('UPDATE PlayerStats SET Strength=Strength+'.$addThisPower.' WHERE playerID='.$playerID);
		}
		
		public function getCurrentlyEquippedPower($playerID) {
			$currentPower = $this->db->query('SELECT Weapons.Power FROM Weapons INNER JOIN PlayerEquipped 
			ON PlayerEquipped.WeaponID=Weapons.weaponID WHERE PlayerEquipped.PlayerID='.$playerID);
			
			return $currentPower->row_array();
		}
		
		public function getNewPowerValue($playerID, $weaponID) {
			$currentPower = $this->db->query('SELECT Weapons.Power FROM Weapons INNER JOIN PlayerWeapons 
			ON PlayerWeapons.WeaponID=Weapons.weaponID WHERE PlayerWeapons.PlayerID='.$playerID.' AND PlayerWeapons.WeaponID='.$weaponID);
			
			return $currentPower->row_array();
		}
		
		public function insertArmour($playerID = FALSE, $armourID = FALSE, $addThisDefence, $removeThisDefence) {
			
			$query = $this->db->query('DELETE FROM PlayerEquippedArmour WHERE PlayerID=' . $playerID);
			
			$query = $this->db->query('INSERT INTO PlayerEquippedArmour (PlayerID, ArmourID) VALUES (' . $playerID . ', ' .$armourID .  ')');	
			
			$this->db->query('UPDATE PlayerStats SET Defense=Defense-'.$removeThisDefence.' WHERE playerID='.$playerID);
			$this->db->query('UPDATE PlayerStats SET Defense=Defense+'.$addThisDefence.' WHERE playerID='.$playerID);
		}
		
		public function getCurrentlyEquippedDefence($playerID) {
			$currentDefence = $this->db->query('SELECT Armours.Defence FROM Armours INNER JOIN PlayerEquippedArmour 
			ON PlayerEquippedArmour.ArmourID=Armours.armourID WHERE PlayerEquippedArmour.PlayerID='.$playerID);
			
			return $currentDefence->row_array();
		}
		
		public function getNewDefenceValue($playerID, $armourID) {
			$currentDefence = $this->db->query('SELECT Armours.Defence FROM Armours INNER JOIN PlayerArmours 
			ON PlayerArmours.ArmourID=Armours.armourID WHERE PlayerArmours.PlayerID='.$playerID.' AND PlayerArmours.ArmourID='.$armourID);
			
			return $currentDefence->row_array();
		}
		
		public function selectShopItems($shopCategory) {
			$query = $this->db->query('SELECT * FROM ' . $shopCategory);
			
			return $query->result_array();
		}
		
		public function selectAllPlayers() {
			$query = $this->db->query('SELECT * FROM PlayerStats ORDER BY Level DESC');
			
			return $query->result_array();
		}
		
		public function selectSearchPlayer($name) {
			$query = $this->db->query('SELECT * FROM PlayerStats WHERE Name LIKE \'' . $name . '%\'  LIMIT 5');
			
			return $query->result_array();
		}
		
		public function selectSearchPlayerLevel($level) {
			$query = $this->db->query('SELECT * FROM PlayerStats WHERE Level='.$level);
			
			return $query->result_array();
		}
		
		public function getMail($playerID = FALSE) {
			$query = $this->db->query('SELECT * FROM MailBox WHERE PlayerTo=' . $playerID);
			
			return $query->result_array();
		}
		
		public function checkEnergy($playerID) {
			$query = $this->db->query('SELECT * FROM PlayerStats WHERE PlayerID=' . $playerID);
			
			return $query->row_array();
		}
		
		public function setEnergy($playerID) {
			$query = $this->db->query('UPDATE PlayerStats SET Energy=0 WHERE playerID='.$playerID);
		}
		
		public function trainStat($playerID, $stat, $energyToTrain, $energyToRemove) {
			
			$query = $this->db->query('UPDATE PlayerStats SET '.$stat.'='.$stat."+".$energyToTrain.' WHERE playerID='.$playerID); 
			
			$query2 = $this->db->query('UPDATE PlayerStats SET Energy=Energy-'.$energyToRemove.' WHERE playerID='.$playerID); 
			
		}
		
		public function updateEnergy($multiplier, $playerID) {
			
			$query2 = $this->db->query('UPDATE PlayerStats SET Energy=Energy+(20*'.$multiplier.') WHERE playerID='.$playerID); 
		}
		
		// attacking
		
		public function killPlayer($playerID) {
			$query = $this->db->query('UPDATE PlayerStats SET Health=0 WHERE playerID='.$playerID); 
		}
		
		public function updateWinLossRecords ($winnerID, $loserID) {
			$query = $this->db->query('UPDATE PlayerStats SET pvpWins=pvpWins+1, Money=Money+5 WHERE playerID='.$winnerID);
			$query2 = $this->db->query('UPDATE PlayerStats SET pvpLoses=pvpLoses+1, Money=Money-5 WHERE playerID='.$loserID);
		}
		
		public function getHighLevel() {
			$query = $this->db->query('SELECT * FROM PlayerStats ORDER BY Level DESC');
			
			return $query->result_array();
		}
		
		public function getTopWins() {
			$query = $this->db->query('SELECT * FROM PlayerStats ORDER BY pvpWins DESC');
			
			return $query->result_array();
		}
		
		// Health
		public function healPlayer($playerID) {
			$query = $this->db->query('UPDATE PlayerStats SET Health=100, Money=Money-10 WHERE playerID='.$playerID); 
		}
		
		public function LogBattle($playerID, $enemyID, $playerLife, $enemyLife) {
			if ($playerLife > $enemyLife) {
				// Jack 1 attacks Johnny 5.
				// Jonny attacked by Jack. 
				// Johnny was attacked by Jack and they won
				$query = $this->db->query('INSERT INTO AttackRecord (PlayerID, EnemyID, DidTheyWin) VALUES ('.$enemyID.','.$playerID.', 1)');
			}
			else {
				// 5, 1, 0 - Johnny was attacked by jack but Jack lost. You won. 
				$query = $this->db->query('INSERT INTO AttackRecord (PlayerID, EnemyID, DidTheyWin) VALUES ('.$enemyID.','.$playerID.', 0)');
			}
		}
		
		public function getBattleLog($playerID) {
			$query = $this->db->query('SELECT AttackRecord.PlayerID, AttackRecord.EnemyID, AttackRecord.Date, AttackRecord.DidTheyWin, AttackRecord.HasBeenSeen, PlayerStats.playerID, PlayerStats.Name FROM AttackRecord INNER JOIN PlayerStats 
			ON AttackRecord.EnemyID=PlayerStats.playerID WHERE AttackRecord.playerID='.$playerID.' ORDER BY AttackRecord.Date DESC');
			
			return $query->result_array();
		}
		
		public function clearNotifications($playerID) {
			$query = $this->db->query('UPDATE MailBox SET HasBeenRead=1 WHERE PlayerTo='.$playerID);
			$query2 = $this->db->query('UPDATE AttackRecord SET HasBeenSeen=1 WHERE PlayerID='.$playerID);
		}
		
		public function earnMoney($playerID, $turns) {
			$query = $this->db->query('UPDATE PlayerStats SET Money=Money+'.$turns.', Energy=Energy-'.$turns.' WHERE playerID='.$playerID);
		}
		
		public function makePlayerVIP($playerID) {
			$query = $this->db->query('UPDATE PlayerStats SET vip=1 WHERE playerID='.$playerID);
		}		
		
		public function createTestMessage($playerToID, $playerTo, $heading, $content) {
			$query = $this->db->query('INSERT INTO MailBox (PlayerTo, PlayerToName, PlayerFrom, PlayerFromName, HasBeenRead, Heading, Content)
			 VALUES ('.$playerToID.', \''.$playerTo.'\', 1, \'Jack\', 0, \''.$heading.'\', \''.$content.'\')');
		}
		
		public function createNewMessage($playerToID, $playerTo, $playerID, $playerName, $heading, $content) {
			$query = $this->db->query('INSERT INTO MailBox (PlayerTo, PlayerToName, PlayerFrom, PlayerFromName, HasBeenRead, Heading, Content)
			VALUES ('.$playerToID.', \''.$playerTo.'\', '.$playerID.',\''.$playerName.'\',0,\''.$heading.'\',\''.$content.'\')');
		}
		
		public function purchaseItem($playerID, $itemID, $itemCategory, $itemPrice) {
			if ($itemCategory == "Sword") {
				$query = $this->db->query('INSERT INTO PlayerWeapons (PlayerID, WeaponID) VALUES ('.$playerID.', '.$itemID.')');
				$query2 = $this->db->query('UPDATE PlayerStats SET Money=Money-'.$itemPrice.' WHERE playerID='.$playerID);
			} else {
				$query = $this->db->query('INSERT INTO PlayerArmours (PlayerID, ArmourID) VALUES ('.$playerID.', '.$itemID.')');
				$query2 = $this->db->query('UPDATE PlayerStats SET Money=Money-'.$itemPrice.' WHERE playerID='.$playerID);
			}
		}
		
		public function vendorItem($playerID, $itemID, $itemCategory, $itemPrice) {
			if ($itemCategory == "Sword") {
				$query = $this->db->query('DELETE FROM PlayerWeapons WHERE PlayerID='.$playerID.' AND WeaponID='.$itemID.' LIMIT 1');
				$query2 = $this->db->query('UPDATE PlayerStats SET Money=Money+'.$itemPrice.' WHERE playerID='.$playerID);
			} else {
				$query = $this->db->query('DELETE FROM PlayerArmours WHERE PlayerID='.$playerID.' AND ArmourID='.$itemID.' LIMIT 1');
				$query2 = $this->db->query('UPDATE PlayerStats SET Money=Money+'.$itemPrice.' WHERE playerID='.$playerID);
			}
		}
		
		public function giveEXP($playerID) {
			$query = $this->db->query('UPDATE PlayerStats SET Experience=Experience + 10 WHERE PlayerID='.$playerID);
			
			$query2 = $this->db->query('SELECT * FROM PlayerStats WHERE playerID='.$playerID);
			return $query2->row_array();
		}
		
		public function levelUp($playerID) {
			$query = $this->db->query('UPDATE PlayerStats SET Experience=0, Level=Level+1 WHERE PlayerID='.$playerID);
		}
		
		public function removeOneEnergy($playerID) {
			$this->db->query('UPDATE PlayerStats SET Energy=Energy-1 WHERE PlayerID='.$playerID);
		}
}


















