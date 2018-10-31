<?php

namespace weapons;

class bazuka extends xweap {
	final public function shoot(\whizbang $whizbang) : \sleeve {
		echo 'Dhooting with Bazuka';
		return new \sleeve;
	}
	final public function reloud(\magazine $magazine) : \magazine {
		echo 'Bye Bazuka';
		return new \magazine;
	}
}