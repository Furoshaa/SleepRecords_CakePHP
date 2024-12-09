<?php
$this->Html->script('https://cdn.jsdelivr.net/npm/chart.js', ['block' => true]);
?>

<div class="sleep-records index content">
    <div class="page-header">
        <h3>Suivi du Sommeil</h3>
        <?= $this->Html->link('+ Nouvel enregistrement', ['action' => 'add'], ['class' => 'button add-button']) ?>
    </div>

    <div class="stats-container">
        <div class="weekly-stats stats-box">
            <h4>Statistiques de la semaine</h4>
            <p>
                Total des cycles : <?= number_format($weekStats['totalCycles'], 1) ?>
                <span class="indicator <?= $weekStats['hasEnoughTotalCycles'] ? 'success' : 'warning' ?>" title="Objectif: 42 cycles/semaine">●</span>
            </p>
            <p>
                4 jours consécutifs avec 5+ cycles : 
                <span class="indicator <?= $weekStats['hasFourConsecutiveDays'] ? 'success' : 'warning' ?>">●</span>
            </p>
            <p>Moyenne d'énergie : <?= number_format($weekStats['avgEnergy'], 1) ?>/10</p>
            <p>Jours de sport : <?= $weekStats['sportDays'] ?>/7</p>
        </div>

        <div class="global-stats stats-box">
            <h4>Statistiques globales</h4>
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-label">Moyenne cycles</span>
                    <span class="stat-value"><?= number_format($globalStats['avgCycles'], 1) ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Record sommeil le plus long</span>
                    <span class="stat-value"><?= number_format($globalStats['maxSleepHours'], 1) ?>h</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Record sommeil le plus court</span>
                    <span class="stat-value"><?= number_format($globalStats['minSleepHours'], 1) ?>h</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Meilleure série 5+ cycles</span>
                    <span class="stat-value"><?= $globalStats['bestStreak'] ?> jours</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Total jours enregistrés</span>
                    <span class="stat-value"><?= $globalStats['totalDays'] ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Jours avec sport</span>
                    <span class="stat-value"><?= number_format($globalStats['sportPercentage'], 1) ?>%</span>
                </div>
            </div>
        </div>
    </div>

    <div class="chart-container" style="position: relative; height:400px; width:100%; margin: 20px 0;">
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
                    <span class="indicator <?= $record->is_full_cycle ? 'success' : '' ?>" title="Cycle complet (±10 min)">●</span>
                    <span class="indicator <?= $record->has_enough_cycles ? 'success' : '' ?>" title="5 cycles ou plus">●</span>
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
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('sleepChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($chartData['labels']) ?>,
            datasets: [{
                label: 'Cycles de sommeil',
                data: <?= json_encode($chartData['cycles']) ?>,
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1,
                fill: true,
                yAxisID: 'y'
            }, {
                label: 'Niveau d\'énergie',
                data: <?= json_encode($chartData['energy']) ?>,
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                tension: 0.1,
                fill: true,
                yAxisID: 'y'
            }, {
                label: 'Heures de sommeil',
                data: <?= json_encode($chartData['hours']) ?>,
                borderColor: 'rgb(153, 102, 255)',
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                tension: 0.1,
                fill: true,
                yAxisID: 'y'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: 12,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Heures / Cycles / Niveau'
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });
});
</script>
<?php $this->end(); ?>

<style>
.indicator {
    font-size: 20px;
    color: #ccc;
    cursor: help;
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
.chart-container {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}
.add-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #2ecc71;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    transition: transform 0.2s, background-color 0.2s;
    text-decoration: none;
    height: 40px;
}
.add-button:hover {
    background: #27ae60;
    transform: translateY(-2px);
    color: white;
}
.stats-container {
    display: flex;
    gap: 2rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.stats-box {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    flex: 1;
    min-width: 300px;
}

.stats-box h4 {
    color: #2c3e50;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e9ecef;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.stat-item {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.stat-label {
    display: block;
    font-size: 1rem;
    color: #666;
    margin-bottom: 0.8rem;
}

.stat-value {
    display: block;
    font-size: 1.4rem;
    font-weight: bold;
    color: #2c3e50;
}
</style> 