<?php

namespace classes;

abstract class magazine {
	abstract public function getCapacity() : int;
	abstract public function getAmmo() : ammo;
}