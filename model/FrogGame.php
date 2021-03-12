<?php
//Source for logic: https://flexboxfroggy.com/
class FrogGame {

    public $frogs = array();
    public $free = 3;
    public $solution = array();
    public $state = "";
    public $maxMoves = 100;

	public function __construct() {

        $this->frogs = array(1,1,1,0,2,2,2);
        $this->free = 3;
        $this->solution = array(2,2,2,0,1,1,1);
        $this->init = $this->frogs;			
		$this->maxMoves = 100;
		$this->state = "";
		
    }

	//reset the frog game
	public function newGame(){
		$this->frogs = array(1,1,1,0,2,2,2);
		$this->free = 3;
		$this->maxMoves = 100;
		$this->state = "";
	}
	
    //make the frog move, at $move, move
	public function makeMove($move){

		if ($this->state == "") {

			if (($this->frogs[$move] == 2 && ($move - $this->free == 1 || $move - $this->free == 2)) ||
				($this->frogs[$move] == 1 && ($move - $this->free == -1 || $move - $this->free == -2)))
            {
                $this->frogs[$this->free] = $this->frogs[$move]; 
                $this->frogs[$move] = 0; 
                $this->free = $move; 
                //Prevent spam requests from utilizing server resources by decrementing maxmoves. Also encourages user to complete in min moves.
				//Will use this to compute the score theoretically. But at 3:30 AM i am okay with no score tracking. I hope you r doing okay too. :)
                $this->maxMoves --;
                $this->isSolved(); //Check if solved; prevented a race condition with getState() in the controller class.
        }
		}
	}
	
	//check to see if user won
	public function isSolved() {
		if ($this->solution == $this->frogs) {
			$this->state = "you won!";
		}
	}

	public function getState() {
		$this->isSolved(); //When called by controller, we want to make sure the solution is handled appropriately.
		return $this->state;
	}

}
?>