<div class="sleep-records form content">
    <h3>Ajouter un enregistrement de sommeil</h3>
    <?= $this->Form->create($sleepRecord) ?>
    <fieldset>
        <?php
            echo $this->Form->control('date', [
                'type' => 'date',
                'label' => 'Date',
                'value' => date('Y-m-d')
            ]);
            echo $this->Form->control('bedtime', [
                'type' => 'time',
                'label' => 'Heure de coucher'
            ]);
            echo $this->Form->control('waketime', [
                'type' => 'time',
                'label' => 'Heure de lever'
            ]);
            echo $this->Form->control('afternoon_nap', [
                'type' => 'checkbox',
                'label' => 'Sieste après-midi'
            ]);
            echo $this->Form->control('evening_nap', [
                'type' => 'checkbox',
                'label' => 'Sieste soir'
            ]);
            echo $this->Form->control('energy_level', [
                'type' => 'select',
                'options' => array_combine(range(0, 10), range(0, 10)),
                'label' => 'Niveau d\'énergie'
            ]);
            echo $this->Form->control('sport', [
                'type' => 'checkbox',
                'label' => 'Sport effectué'
            ]);
            echo $this->Form->control('comments', [
                'type' => 'textarea',
                'label' => 'Commentaires'
            ]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Enregistrer')) ?>
    <?= $this->Form->end() ?>
</div> 