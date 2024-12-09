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
            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'Users',
                'action' => 'admin',
            ]);

            return $this->redirect($redirect);
        }
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('Invalid username or password');
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
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success('Registration successful. Please login.');
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error('Registration failed. Please try again.');
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
} 