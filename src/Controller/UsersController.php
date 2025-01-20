<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Mailer\Mailer;

class UsersController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['login', 'register', 'forgot_password']);
    }

    public function login()
    {
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            return $this->redirect(['controller' => 'SleepRecords', 'action' => 'index']);
        }
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('Identifiants invalides');
        }
    }

    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    public function register()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            // Set default permission level for new users
            $data['permission'] = 0; // Default to lowest permission level
            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Registration successful.'));
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('Registration failed. Please try again.'));
        }
        $this->set(compact('user'));
    }

    public function admin()
    {
        $user = $this->Authentication->getIdentity();
        $this->set(compact('user'));
    }

    public function forgotPassword()
    {
        if ($this->request->is('post')) {
            $email = $this->request->getData('email');
            $user = $this->Users->findByEmail($email)->first();
            
            if ($user) {
                // Generate new password
                $newPassword = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);
                $user->password = $newPassword;
                
                if ($this->Users->save($user)) {
                    // Send email
                    $mailer = new Mailer('default');
                    $mailer
                        ->setTo($email)
                        ->setSubject('Réinitialisation de mot de passe')
                        ->deliver('Votre nouveau mot de passe est: ' . $newPassword);
                    
                    $this->Flash->success('Un nouveau mot de passe vous a été envoyé par email.');
                    return $this->redirect(['action' => 'login']);
                }
            }
            $this->Flash->error('Adresse email non trouvée.');
        }
    }

    public function index()
    {
        // Only show users list to admin (permission level 2)
        $currentUser = $this->Authentication->getIdentity();
        if ($currentUser->permission < 2) {
            $this->Flash->error('Access denied.');
            return $this->redirect(['action' => 'admin']);
        }

        $users = $this->Users->find()
            ->select(['id', 'username', 'email', 'firstname', 'lastname', 'permission', 'created'])
            ->order(['created' => 'DESC']);
        
        $this->set(compact('users'));
    }

    // Add a new method to change user permissions (admin only)
    public function changePermission($id = null)
    {
        $this->request->allowMethod(['post']);
        $currentUser = $this->Authentication->getIdentity();
        
        if ($currentUser->permission < 2) {
            $this->Flash->error('Access denied.');
            return $this->redirect(['action' => 'admin']);
        }

        $user = $this->Users->get($id);
        if ($this->request->is('post')) {
            $newPermission = $this->request->getData('permission');
            if ($newPermission >= 0 && $newPermission <= 2) {
                $user->permission = $newPermission;
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('Permission updated successfully.'));
                } else {
                    $this->Flash->error(__('Unable to update permission.'));
                }
            } else {
                $this->Flash->error(__('Invalid permission level.'));
            }
        }
        return $this->redirect(['action' => 'index']);
    }
} 