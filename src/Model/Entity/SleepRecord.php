<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class SleepRecord extends Entity
{
    protected array $_accessible = [
        'user_id' => true,
        'date' => true,
        'bedtime' => true,
        'waketime' => true,
        'afternoon_nap' => true,
        'evening_nap' => true,
        'energy_level' => true,
        'sport' => true,
        'comments' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
    ];

    protected function _getSleepCycles()
    {
        $bedtime = $this->bedtime->toNative();
        $waketime = $this->waketime->toNative();
        
        if ($waketime < $bedtime) {
            $waketime = $waketime->modify('+1 day');
        }
        
        $interval = $waketime->diff($bedtime);
        $hours = $interval->h + ($interval->i / 60);
        
        // Un cycle = 1.5 heures
        return $hours / 1.5;
    }

    protected function _getIsFullCycle()
    {
        $cycles = $this->sleep_cycles;
        $roundedCycles = round($cycles);
        $difference = abs($cycles - $roundedCycles);
        
        // Un cycle = 1.5 heures = 90 minutes
        // 10 minutes = 10/90 = 0.11 cycles
        return $difference <= 0.11;  // Si la différence est de 10 minutes ou moins
    }

    protected function _getHasEnoughCycles()
    {
        return $this->sleep_cycles >= 5;  // 5 cycles = 7.5 heures
    }

    protected function _getSleepHours()
    {
        $bedtime = $this->bedtime->toNative();
        $waketime = $this->waketime->toNative();
        
        if ($waketime < $bedtime) {
            $waketime = $waketime->modify('+1 day');
        }
        
        $interval = $waketime->diff($bedtime);
        return $interval->h + ($interval->i / 60);
    }
} 