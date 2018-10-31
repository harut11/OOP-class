<?php

namespace weapons;

class bazuka extends xweap {
	public function shoot(\whizbang $whizbang) : \sleeve {
		echo 'Dhooting with Bazuka';
		return new \sleeve;
	}
	public function reloud(\magazine $magazine) : \magazine {
		echo 'Bye Bazuka';
		return new \magazine;
	}
}