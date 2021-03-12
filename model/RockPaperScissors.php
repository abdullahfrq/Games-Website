<?php

class RockPaperScissors {
	public $secretNumber = 5;
	public $numGuesses = 0;
	public $history = array();
	public $state = "";

	public function __construct() {
        	$this->secretNumber = rand(1,3);
    	}
	
	public function makeRPS($guess){
		$this->secretNumber = rand(1,3);
		$this->numGuesses++;
		if($guess==$this->secretNumber){
			$this->state="its a draw!";
		} else if($guess==1 and $this->secretNumber==2){
			$this->state="paper beats rock, you lost!";
		} else if($guess==2 and $this->secretNumber==3){
			$this->state="scissors beats paper, you lost!";
		} else if($guess==3 and $this->secretNumber==1){
			$this->state="rock beats scissors, you lost!";
		} else {
			$this->state="you won!";
		}
		$this->history[] = "Guess #$this->numGuesses was $guess, computer chose $this->secretNumber, $this->state";
	}

	public function getState(){
		return $this->state;
	}
}
?>
