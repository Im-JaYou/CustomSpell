<?php

namespace delnyan\spells\targeted;

use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\Player;

class Pain extends TargetedSpellBase {

    private $damage = 0;
    private $ignoreArmor = false;
    private $cause = 0;

    public function __construct(Player $caster, Entity $target, float $damage, bool $ignoreArmor = false, int $cause = EntityDamageEvent::CAUSE_VOID) {
        parent::__construct($caster, $target);
        $this-> setDamage($damage);
        $this-> setIgnoreArmor($ignoreArmor);
        $this-> setCause($cause);
    }

    public function work() {
        if($this-> isIgnoreArmor())
            $this-> getTarget()-> setHealth($this-> getTarget()-> getHealth() - $this-> getDamage());
        else {
            $source = new EntityDamageEvent($this-> getTarget(), $this-> getCause(), $this-> getDamage());
            $this-> getTarget()-> attack($source);
        }
    }

    public function setDamage(float $damage) {
        $this-> damage = $damage;
    }

    public function getDamage(): float {
        return $this-> damage;
    }

    public function setIgnoreArmor(bool $ignoreArmor) {
        $this-> ignoreArmor = $ignoreArmor;
    }

    public function isIgnoreArmor(): bool {
        return $this-> ignoreArmor;
    }

    public function setCause(int $cause) {
        //In EntityDamageEvent, the range of constants representing the cause is from 0 to 15.
        if($cause >= 0 && $cause <= 15)
            $this-> cause = $cause;
        else $this-> cause = EntityDamageEvent::CAUSE_VOID;
    }

    public function getCause(): int {
        return $this-> cause;
    }
}