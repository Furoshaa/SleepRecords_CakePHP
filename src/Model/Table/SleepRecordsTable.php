<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\Time;

class SleepRecordsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('sleep_records');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->belongsTo('Users');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmptyDate('date');

        $validator
            ->time('bedtime')
            ->requirePresence('bedtime', 'create')
            ->notEmptyTime('bedtime');

        $validator
            ->time('waketime')
            ->requirePresence('waketime', 'create')
            ->notEmptyTime('waketime');

        $validator
            ->boolean('afternoon_nap')
            ->allowEmptyString('afternoon_nap');

        $validator
            ->boolean('evening_nap')
            ->allowEmptyString('evening_nap');

        $validator
            ->integer('energy_level')
            ->range('energy_level', [0, 10])
            ->requirePresence('energy_level', 'create')
            ->notEmptyString('energy_level');

        $validator
            ->boolean('sport')
            ->allowEmptyString('sport');

        $validator
            ->scalar('comments')
            ->allowEmptyString('comments');

        return $validator;
    }

    public function getWeekStats($userId, $startDate)
    {
        $endDate = clone $startDate;
        $endDate->modify('+6 days');

        $records = $this->find()
            ->where([
                'user_id' => $userId,
                'date >=' => $startDate,
                'date <=' => $endDate
            ])
            ->order(['date' => 'ASC'])
            ->all();

        $totalCycles = 0;
        $consecutiveDays = 0;
        $maxConsecutiveDays = 0;
        $totalEnergy = 0;
        $sportDays = 0;
        $recordCount = 0;

        foreach ($records as $record) {
            $totalCycles += $record->sleep_cycles;
            $totalEnergy += $record->energy_level;
            if ($record->sport) {
                $sportDays++;
            }
            $recordCount++;
            
            if ($record->has_enough_cycles) {
                $consecutiveDays++;
                $maxConsecutiveDays = max($maxConsecutiveDays, $consecutiveDays);
            } else {
                $consecutiveDays = 0;
            }
        }

        return [
            'totalCycles' => $totalCycles,
            'hasEnoughTotalCycles' => $totalCycles >= 42,
            'hasFourConsecutiveDays' => $maxConsecutiveDays >= 4,
            'avgEnergy' => $recordCount > 0 ? $totalEnergy / $recordCount : 0,
            'sportDays' => $sportDays
        ];
    }

    public function getGlobalStats($userId)
    {
        $records = $this->find()
            ->where(['user_id' => $userId])
            ->all();

        $totalDays = $records->count();
        if ($totalDays === 0) {
            return [
                'avgCycles' => 0,
                'maxSleepHours' => 0,
                'minSleepHours' => 0,
                'bestStreak' => 0,
                'totalDays' => 0,
                'sportPercentage' => 0
            ];
        }

        $sportDays = 0;
        $totalCycles = 0;
        $maxSleepHours = 0;
        $minSleepHours = 24;
        $bestStreak = 0;
        $currentStreak = 0;

        foreach ($records as $record) {
            if ($record->sport) {
                $sportDays++;
            }

            $totalCycles += $record->sleep_cycles;
            $sleepHours = $record->sleep_hours;
            
            $maxSleepHours = max($maxSleepHours, $sleepHours);
            $minSleepHours = min($minSleepHours, $sleepHours);

            if ($record->has_enough_cycles) {
                $currentStreak++;
                $bestStreak = max($bestStreak, $currentStreak);
            } else {
                $currentStreak = 0;
            }
        }

        return [
            'avgCycles' => $totalCycles / $totalDays,
            'maxSleepHours' => $maxSleepHours,
            'minSleepHours' => $minSleepHours,
            'bestStreak' => $bestStreak,
            'totalDays' => $totalDays,
            'sportPercentage' => ($sportDays / $totalDays) * 100
        ];
    }
} 