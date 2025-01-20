<?php
declare(strict_types=1);

namespace App\Controller;

class MenusController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        
        // Get current user
        $currentUser = $this->Authentication->getIdentity();
        
        // Check permissions for all menu-related actions
        if (!$currentUser || $currentUser->permission < 2) {
            $this->Flash->error('Access denied. Administrator permission required.');
            return $this->redirect(['controller' => 'Users', 'action' => 'admin']);
        }
    }

    public function index()
    {
        $menus = $this->Menus->find()
            ->order(['ordre' => 'ASC'])
            ->all();
        $currentUser = $this->Authentication->getIdentity();
        $this->set(compact('menus', 'currentUser'));
    }

    public function add()
    {
        $menu = $this->Menus->newEmptyEntity();
        if ($this->request->is('post')) {
            $menu = $this->Menus->patchEntity($menu, $this->request->getData());
            if ($this->Menus->save($menu)) {
                $this->Flash->success('Le menu a été sauvegardé.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Le menu n\'a pas pu être sauvegardé.');
        }
        $this->set(compact('menu'));
    }

    public function edit($id = null)
    {
        $menu = $this->Menus->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $menu = $this->Menus->patchEntity($menu, $this->request->getData());
            if ($this->Menus->save($menu)) {
                $this->Flash->success('Le menu a été mis à jour.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Le menu n\'a pas pu être mis à jour.');
        }
        $this->set(compact('menu'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $menu = $this->Menus->get($id);
        if ($this->Menus->delete($menu)) {
            $this->Flash->success('Le menu a été supprimé.');
        } else {
            $this->Flash->error('Le menu n\'a pas pu être supprimé.');
        }
        return $this->redirect(['action' => 'index']);
    }
} 