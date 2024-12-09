<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\Date;

class SleepRecordsController extends AppController
{
    public function index()
    {
        $user = $this->Authentication->getIdentity();
        $startDate = new Date('monday this week');
        
        $sleepRecords = $this->SleepRecords->find()
            ->where([
                'user_id' => $user->id,
                'date >=' => $startDate,
                'date <=' => $startDate->modify('+6 days')
            ])
            ->order(['date' => 'ASC'])
            ->all();

        $weekStats = $this->SleepRecords->getWeekStats($user->id, $startDate);
        
        // Préparer les données pour le graphique
        $chartData = [
            'labels' => [],
            'cycles' => [],
            'energy' => []
        ];

        foreach ($sleepRecords as $record) {
            $chartData['labels'][] = $record->date->format('d/m');
            $chartData['cycles'][] = $record->sleep_cycles;
            $chartData['energy'][] = $record->energy_level;
        }

        $this->set(compact('sleepRecords', 'weekStats', 'chartData'));
    }

    public function add()
    {
        $sleepRecord = $this->SleepRecords->newEmptyEntity();
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['user_id'] = $this->Authentication->getIdentity()->id;
            
            $sleepRecord = $this->SleepRecords->patchEntity($sleepRecord, $data);
            
            if ($this->SleepRecords->save($sleepRecord)) {
                $this->Flash->success('Enregistrement sauvegardé.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Erreur lors de la sauvegarde.');
        }
        
        $this->set(compact('sleepRecord'));
    }

    public function edit($id = null)
    {
        $user = $this->Authentication->getIdentity();
        $sleepRecord = $this->SleepRecords->get($id, [
            'conditions' => ['user_id' => $user->id]
        ]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sleepRecord = $this->SleepRecords->patchEntity($sleepRecord, $this->request->getData());
            if ($this->SleepRecords->save($sleepRecord)) {
                $this->Flash->success('Modifications sauvegardées.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Erreur lors de la sauvegarde.');
        }
        
        $this->set(compact('sleepRecord'));
    }
} 