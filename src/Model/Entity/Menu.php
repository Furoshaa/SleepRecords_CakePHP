<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Menu extends Entity
{
    /**
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'ordre' => true,
        'intitule' => true,
        'lien' => true,
        'created' => true,
        'modified' => true,
    ];
} 