<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/5/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication');

        // Autoriser l'accès à la page d'accueil sans authentification
        $this->Authentication->addUnauthenticatedActions(['display']);
    }

    protected function isAuthorized($minimumPermission = 0)
    {
        $user = $this->Authentication->getIdentity();
        if (!$user) {
            return false;
        }
        return $user->permission >= $minimumPermission;
    }

    protected function requirePermission($minimumPermission = 0)
    {
        if (!$this->isAuthorized($minimumPermission)) {
            $this->Flash->error('Access denied. Insufficient permissions.');
            return $this->redirect(['controller' => 'Users', 'action' => 'index']);
        }
        return true;
    }
}
