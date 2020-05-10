<?php

namespace delnyan\spells\targeted;

use delnyan\spells\SpellBase;
use pocketmine\entity\Entity;
use pocketmine\Player;

abstract class TargetedSpellBase extends SpellBase {
    private $target = null;

    public function __construct(Player $caster, Entity $target, string $name, string $description = '', float $cost = 0, int $costType = 0, float $cooldown = 0, int $castType = 0, $costItem = null) {
        parent::__construct($caster, $name, $description, $cost, $costType, $cooldown, $castType, $costItem);
        $this-> setTarget($target);
    }

    public function setTarget(Entity $target) {
        $this-> target = $target;
    }

    public function getTarget(): Entity {
        return $this-> target;
    }
}