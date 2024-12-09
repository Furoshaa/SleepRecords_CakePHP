<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

use Cake\ORM\TableRegistry;

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->fetch('title') ?></title>
    <?= $this->Html->css(['normalize.min', 'milligram.min', 'cake']) ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <style>
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
        }
        .logo {
            font-size: 1.5em;
            font-weight: bold;
        }
        .user-info {
            text-align: right;
        }
        .main-container {
            display: flex;
            min-height: calc(100vh - 100px);
        }
        #menu {
            width: 250px;
            padding: 1rem;
            background: #f8f9fa;
        }
        .content {
            flex: 1;
            padding: 1rem;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo">
                <?= $this->Html->link('Mon Site', '/') ?>
            </div>
            <div class="user-info">
                <?php
                $identity = $this->getRequest()->getAttribute('identity');
                if ($identity) {
                    echo h($identity->firstname) . ' ' . h($identity->lastname);
                    echo ' | ';
                    echo $this->Html->link('Déconnexion', ['controller' => 'Users', 'action' => 'logout']);
                } else {
                    echo $this->Html->link('Connexion', ['controller' => 'Users', 'action' => 'login']);
                }
                ?>
            </div>
        </div>
    </header>

    <div class="main-container">
        <div id="menu">
            <?php
            // Récupération et affichage du menu
            $menuItems = TableRegistry::getTableLocator()
                ->get('Menus')
                ->find()
                ->order(['ordre' => 'ASC']);
            
            foreach ($menuItems as $item) {
                echo $this->Html->link(
                    h($item->intitule),
                    $item->lien,
                    ['class' => 'menu-item']
                ) . '<br>';
            }
            ?>
        </div>
        <main class="content">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </main>
    </div>
    <footer>
    </footer>
</body>
</html>
