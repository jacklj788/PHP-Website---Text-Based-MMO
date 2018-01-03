<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
	public function __construct()
    {
		parent::__construct();
        $this->load->model('Players_model');
		$this->load->helper('cookie');
    }
	
	public function index()
	{
		$this->load->view('index');
	}
	
	// No params but data comes from the form
	public function login() {
		// data
		$playerName = $this->input->post("playerName");
		$passwordAttempt = $this->input->post("playerPassword");

		$playerID = $this->Players_model->getPlayerIdFromName($playerName);
		//$data['playerIDSession'] = $this->Players_model->setPlaySession($playerName);
		if (empty($playerID)) {
			$this->load->view('external/loginFail');
		} else {
			$dbPassword = $this->Players_model->fetchPassword($playerID['playerID']);
			
			if((password_verify($passwordAttempt, $dbPassword['passWord'])) ) {
				$cookie = array('name' => 'pID', 'value' => $playerID['playerID'], 'expire' => 3600, 'secure' => false);
				$this->input->set_cookie($cookie);
				$this->load->view('external/loginCheck');
			}
			else {
				$this->load->view('external/loginFail');
			}		
		}
		// Creates a server side cookie to pass the player ID around, creating a login session.
	}
	
	public function createAccount() {
		$this->load->view('external/createAccount');
	}
	
	public function checkUsername($playerName) {
		$playerID = $this->Players_model->getPlayerIdFromName($playerName);
		$data['name'] = $playerID;
		if (empty($playerID)) {
			echo json_encode( "Available!" );
		}
		else {
			echo json_encode( "Username is taken." );
		}
	}
	
	public function verifyAccountCreation() {
		$playerName = $this->input->post("playerNameCA");
		$playerPassword = $this->input->post("playerPasswordCA");
		
		//$playerID = 3;//$this->input->getPlayerIDToCreateAccount;
		
		$password = password_hash($playerPassword, PASSWORD_BCRYPT);
		
		// Create PlayerStats row
		$this->Players_model->createNewAccount($password, $playerName);
		// Give Items
		$playerID = $this->Players_model->getPlayerIdFromName($playerName);
		
		$this->Players_model->giveStartingGear($playerID['playerID']);
		$this->Players_model->mailWelcomeMessage($playerID['playerID'], $playerName);
		
		$this->load->view('external/creatingAccountWait');
	}
	
	public function logout() {
		delete_cookie('pID');
		$this->load->view('index');
	}
	
	public function home()
	{
		if(is_null(get_cookie('pID'))) {
			$this->load->view('index');
		}
		else {
			// Gets the player stats for player logged in
			$data['player'] = $this->Players_model->get_id(get_cookie('pID'));
			
			$data['playerWeapons'] = $this->Players_model->get_playersWeapons(get_cookie('pID'));
			$data['playerArmours'] = $this->Players_model->get_playersArmours(get_cookie('pID'));
			
			$data['equipped'] = $this->Players_model->get_playerEquippedWeapons(get_cookie('pID'));
			$data['equippedArmours'] = $this->Players_model->get_playerEquippedArmours(get_cookie('pID'));
			
			$data['mail'] = $this->Players_model->getMail(get_cookie('pID'));
			$data['battles'] = $this->Players_model->getBattleLog(get_cookie('pID'));
			
			$data['title'] = "Home";
			$this->load->view('templates/header', $data);
			$this->load->view('home/home', $data);
			$this->load->view('templates/footer');
		}
	}

	public function social() 
	{
		
		$this->Players_model->clearNotifications(get_cookie('pID'));
		$data['messages'] = $this->Players_model->getMail(get_cookie('pID'));
		$data['battles'] = $this->Players_model->getBattleLog(get_cookie('pID'));
		
		$data['title'] = "Social";
		$this->load->view('templates/header', $data);
		$this->load->view('social/social', $data);
		$this->load->view('templates/footer');
	}
	
	public function shop($itemCategory) {
		
		if ($itemCategory == "Armours") {
			$data['playerItems'] = $this->Players_model->get_playersArmours(get_cookie('pID'));
		} else {
			$data['playerItems'] = $this->Players_model->get_playersWeapons(get_cookie('pID'));
		}
		$data['items'] = $this->Players_model->selectShopItems($itemCategory);
		$data['tName'] = $itemCategory;
		
		$data['title'] = "Shop";
		$this->load->view('templates/header', $data);
		$this->load->view('shop', $data);
		$this->load->view('templates/footer');
	}
	
	public function training($statToTrain) {
		
		$data['stat'] = $statToTrain;
		
		$data['title'] = "Training";
		$this->load->view('templates/header', $data);
		$this->load->view('training/training', $data);
		$this->load->view('templates/footer');
	}
	
	public function trainStat($stat, $energy) {
		
		$energyCheck = $this->Players_model->checkEnergy(get_cookie('pID'));
		if ($energyCheck['Energy'] < $energy) {
			$this->load->view('training/trainFailed');
		}
		else {
			$energyValue = $energy / 100;
		
			$energyValue = $energyValue * rand(1, 2);  
			$data['trained'] = $energyValue;
			$this->Players_model->trainStat(get_cookie('pID'), $stat, $energyValue, $energy);
			$data['statTrained'] = $stat;
			$data['energy'] = $this->Players_model->checkEnergy(get_cookie('pID'));
			if ($energyCheck['Energy'] < 0) {
				$this->Players_model->SetEnergy(get_cookie('pID'));
			}
			$this->load->view('training/trained', $data); 
		}
		
	}
	
	public function playerRankings() {
		
		$data['playerRanks'] = $this->Players_model->selectAllPlayers();
		
		$data['title'] = "Player Ranking";
		$this->load->view('templates/header', $data);
		$this->load->view('playerRanking', $data);
		$this->load->view('templates/footer');
	}
	
	public function payNow() {
		$data['title'] = "Purchase VIP";
		$this->load->view('templates/header', $data);
		$this->load->view('paying/payNow');
		$this->load->view('templates/footer');
	}
	
	public function confirmPayment() {
		
		$this->Players_model->makePlayerVIP(get_cookie('pID'));
		
		$this->load->view('paying/confirmingPayment');
		
	}
		
	public function playerVersePlayer() {
		$data['topLevel'] = $this->Players_model->getHighLevel();
		$data['topWins'] = $this->Players_model->getTopWins();
		
		$data['title'] = "Player Verse Player";
		$this->load->view('templates/header', $data);
		$this->load->view('attack/playerVersePlayer', $data);
		$this->load->view('templates/footer');
	}
	
	// attack
	public function attackPlayer($playerIDToAttack) {
		$data['playerStats'] = $this->Players_model->get_id(get_cookie('pID'));
		$data['enemyStats'] = $this->Players_model->get_id($playerIDToAttack);
		
		if ($data['playerStats']['Health'] == 0 || $data['enemyStats']['Health'] == 0) {
			$this->load->view('attack/playerIsDead');
		}
		else if ($data['playerStats']['Energy'] == 0) {
			$this->load->view('attack/playerNoEnergy');
		}
		else {
			$data['title'] = "Battle";
			$this->load->view('templates/header', $data);
			$this->load->view('attack/attack', $data);
			$this->load->view('templates/footer');
		}
	}
	// attack
	public function battleResults($playerID, $enemyID, $playerLife, $enemyLife) {
		
		
		$this->Players_model->removeOneEnergy($playerID); 
		
		if ($playerLife < $enemyLife) {
			$this->Players_model->killPlayer($playerID);
			// $winner, $loser
			$this->Players_model->updateWinLossRecords($enemyID, $playerID);
		}
		if($playerLife > $enemyLife) {
			$this->Players_model->killPlayer($enemyID);
			
			$setEXP = $this->Players_model->giveEXP($playerID, $enemyID);
			if ($setEXP['Experience'] >= 100) {
				$this->Players_model->levelUp($playerID);
			}
			$this->Players_model->updateWinLossRecords($playerID, $enemyID);
		}
		
		$this->Players_model->LogBattle($playerID, $enemyID, $playerLife, $enemyLife);
		
		$data['playerLife'] = $playerLife;
		$data['enemyLife'] = $enemyLife;
		
		$data['title'] = "Results";
		$this->load->view('templates/header', $data);
		$this->load->view('attack/battleResults', $data);
		$this->load->view('templates/footer');
	}
	
	// heal
	
	public function healStation($free = FALSE) {
		if(is_null(get_cookie('pID'))) {
			$this->load->view('index');
		}
		else {			
			$data['player'] = $this->Players_model->get_id(get_cookie('pID'));
			
			$this->Players_model->healPlayer(get_cookie('pID'));
		}
	}
	
	public function work() {
		$data['title'] = "Work";
		$this->load->view('templates/header', $data);
		$this->load->view('work');
		$this->load->view('templates/footer');
		
	}
	
	public function earnGoldFromWork($turns) {
		$this->Players_model->earnMoney(get_cookie('pID'), $turns);
		$data['gold'] = $turns;
		$this->load->view('workResultsAJAX', $data);
	}
	// AJAX FUNCTIONS
	
	public function equipItem($playerID = FALSE, $weaponID = FALSE) {
		//$data['itemToAdd'] = ['playerWeapons'] = $this->Players_model->get_playersWeapons($playerID);
		
		$removeThisPower = $this->Players_model->getCurrentlyEquippedPower($playerID);
		$addThisPower = $this->Players_model->getNewPowerValue($playerID, $weaponID);
		
		$this->Players_model->insertWeapon($playerID, $weaponID, $addThisPower['Power'], $removeThisPower['Power']);
		
		$data['equipped'] = $this->Players_model->get_playerEquippedWeapons($playerID);
		$data['equippedArmours'] = $this->Players_model->get_playerEquippedArmours($playerID);

		$this->load->view('home/equipItem', $data); 
	}
	
	public function equipItemArm($playerID = FALSE, $armourID = FALSE) {
		//$data['itemToAdd'] = ['playerWeapons'] = $this->Players_model->get_playersWeapons($playerID);
		
		$removeThisDefence = $this->Players_model->getCurrentlyEquippedDefence($playerID);
		$addThisDefence = $this->Players_model->getNewDefenceValue($playerID, $armourID);
		
		$this->Players_model->insertArmour($playerID, $armourID, $addThisDefence['Defence'], $removeThisDefence['Defence']);
		
		$data['equipped'] = $this->Players_model->get_playerEquippedWeapons($playerID);
		$data['equippedArmours'] = $this->Players_model->get_playerEquippedArmours($playerID);
		
		
		$this->load->view('home/equipItem', $data); 
	}
	
	public function searchPlayer($name) {
		
		$data['searchPlayers'] = $this->Players_model->selectSearchPlayer($name);
		
		$this->load->view('social/searchPlayer', $data);
		
	}
	
	public function searchPlayerLevel($level) {
		
		$data['searchPlayers'] = $this->Players_model->selectSearchPlayerLevel($level);
		
		$this->load->view('social/searchPlayerLevel', $data);
		
	}
	
	public function updateEnergy($playerID) {
		$energyCheck = $this->Players_model->checkEnergy($playerID);
		
		if (($energyCheck['vip'] && $energyCheck['Energy'] < 200) || $energyCheck['vip'] == 0 && $energyCheck['Energy'] < 100) {
			
			$dateToday = date("Y-m-d H:i:s");
			
			$todaysDay = date('d', strtotime($dateToday));
			$lastDay = date('d', strtotime($energyCheck['energyLastClaimed']));
			
			$hourToday = date('H', strtotime($dateToday));
			$hourLast = date('H', strtotime($energyCheck['energyLastClaimed']));
			
			// 21 - 19
			
			$diff = $hourToday - $hourLast;
			
			// Do more testing to check this works.
			// 00(12) -> 23 is a difference of -23. +24 would mean an hour has passed.
			// 03 -> 23 is a difference of -20. + 24 = 4. Correct hours.  
			if ($todaysDay > $lastDay) {
				$diff = $diff + 24;
			}
			
			if ($diff > 0) {
				$this->Players_model->updateEnergy($diff, $playerID);
			}
			
			$this->load->view('updateEnergy');
		}
		else {
			$data['me'] = "You have enough.";
			$this->load->view('updateEnergy', $data);
		}
		
		
	}
	
	
	public function sendMail() {
		$playerStats = $this->Players_model->get_id(get_cookie('pID'));
		
		$namePlayerTo = $this->input->post('replyToName');
		$nameReplyHeading = $this->input->post('replyHeading');
		$mailContent = $this->input->post('replyContent');
		
		$playerToID = $this->Players_model->getPlayerIdFromName($namePlayerTo);

		$this->Players_model->createNewMessage($playerToID['playerID'], $namePlayerTo, $playerStats['playerID'], $playerStats['Name'], $nameReplyHeading, $mailContent);
	}
	
	public function buyItem($itemID, $itemCategory, $itemPrice) {
		$playerStats = $this->Players_model->get_id(get_cookie('pID'));
		
		if($playerStats['Money'] > $itemPrice) {
			$this->Players_model->purchaseItem($playerStats['playerID'], $itemID, $itemCategory, $itemPrice);
			$this->load->view('buyItem');
		}
		else {
			$this->load->view('declineItem');
		}
	}
	
	public function sellItem($itemID, $itemCategory, $itemPrice) {
		$playerStats = $this->Players_model->get_id(get_cookie('pID'));
		
		if($playerStats['Money'] > $itemPrice) {
			$this->Players_model->vendorItem($playerStats['playerID'], $itemID, $itemCategory, $itemPrice);
		}
		
		$this->load->view('soldItem');
	}
}







