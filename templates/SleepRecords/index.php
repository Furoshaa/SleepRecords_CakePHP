<?php
$this->Html->script('https://cdn.jsdelivr.net/npm/chart.js', ['block' => true]);
?>

<div class="sleep-records index content">
    <h3>Suivi du Sommeil</h3>
    <?= $this->Html->link('Ajouter un enregistrement', ['action' => 'add'], ['class' => 'button float-right']) ?>

    <div class="weekly-stats">
        <h4>Statistiques de la semaine</h4>
        <p>
            Total des cycles : <?= number_format($weekStats['totalCycles'], 1) ?>
            <span class="indicator <?= $weekStats['hasEnoughTotalCycles'] ? 'success' : 'warning' ?>">●</span>
        </p>
        <p>
            4 jours consécutifs avec 5+ cycles : 
            <span class="indicator <?= $weekStats['hasFourConsecutiveDays'] ? 'success' : 'warning' ?>">●</span>
        </p>
    </div>

    <div class="chart-container" style="position: relative; height:300px; margin-bottom: 20px;">
        <canvas id="sleepChart"></canvas>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Coucher</th>
                <th>Lever</th>
                <th>Cycles</th>
                <th>Forme</th>
                <th>Sieste</th>
                <th>Sport</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sleepRecords as $record): ?>
            <tr>
                <td><?= $record->date->format('d/m/Y') ?></td>
                <td><?= $record->bedtime->format('H:i') ?></td>
                <td><?= $record->waketime->format('H:i') ?></td>
                <td>
                    <?= number_format($record->sleep_cycles, 1) ?>
                    <span class="indicator <?= $record->is_full_cycle ? 'success' : '' ?>">●</span>
                    <span class="indicator <?= $record->has_enough_cycles ? 'success' : '' ?>">●</span>
                </td>
                <td><?= $record->energy_level ?>/10</td>
                <td>
                    <?= $record->afternoon_nap ? 'Après-midi' : '' ?>
                    <?= $record->evening_nap ? 'Soir' : '' ?>
                </td>
                <td><?= $record->sport ? 'Oui' : 'Non' ?></td>
                <td>
                    <?= $this->Html->link('Modifier', ['action' => 'edit', $record->id]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $this->append('script'); ?>
<script>
const ctx = document.getElementById('sleepChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($chartData['labels']) ?>,
        datasets: [{
            label: 'Cycles de sommeil',
            data: <?= json_encode($chartData['cycles']) ?>,
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1
        }, {
            label: 'Niveau d\'énergie',
            data: <?= json_encode($chartData['energy']) ?>,
            borderColor: 'rgb(255, 99, 132)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
<?php $this->end(); ?>

<style>
.indicator {
    font-size: 20px;
    color: #ccc;
}
.indicator.success {
    color: #00c851;
}
.indicator.warning {
    color: #ffbb33;
}
.weekly-stats {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
    margin: 20px 0;
}
</style> 