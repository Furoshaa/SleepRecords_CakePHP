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
        .footer-content {
            text-align: center;
            padding: 1rem;
            background: #f8f9fa;
            margin-top: auto;
        }
        /* Styles pour les formulaires */
        .form-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .input {
            margin-bottom: 1rem;
        }

        .input label {
            display: block;
            margin-bottom: 0.5rem;
            color: #2c3e50;
        }

        .input input[type="text"],
        .input input[type="email"],
        .input input[type="password"],
        .input input[type="date"],
        .input input[type="time"],
        .input select,
        .input textarea {
            width: 100%;
            max-width: 400px;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .input textarea {
            min-height: 100px;
        }

        .checkbox label {
            display: inline-block;
            margin-left: 0.5rem;
        }

        /* Style pour les boutons */
        .button {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: #3498db;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .button:hover {
            background: #2980b9;
        }

        /* Ajustements pour le menu */
        #menu {
            padding: 1rem;
        }

        #menu a {
            display: block;
            padding: 0.5rem;
            color: #2c3e50;
            text-decoration: none;
            border-radius: 4px;
        }

        #menu a:hover {
            background: #ecf0f1;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo">
                <?= $this->Html->link('SleepTracker', '/') ?>
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
            
            $identity = $this->getRequest()->getAttribute('identity');
            $menuItems = TableRegistry::getTableLocator()
                ->get('Menus')
                ->find();

            if ($identity) {
                // Menu pour utilisateurs connectés
                $menuItems = $menuItems->where([
                    'OR' => [
                        'lien NOT IN' => ['/login', '/register'],
                        'lien IS NULL'
                    ]
                ]);
            } else {
                // Menu pour visiteurs
                $menuItems = $menuItems->where([
                    'lien IN' => ['/login', '/register']
                ]);
            }

            $menuItems = $menuItems->order(['ordre' => 'ASC']);
            
            foreach ($menuItems as $item) {
                echo $this->Html->link(
                    h($item->intitule),
                    !empty($item->lien) ? $item->lien : '#',
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
        <div class="footer-content">
            <p>&copy; <?= date('Y') ?> Mon Site. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>
