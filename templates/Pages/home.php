<?php
$this->layout = 'default';
$this->assign('title', 'Sleep Tracker - Suivez votre sommeil');
?>

<div class="home-container">
    <div class="welcome-section">
        <h1>Sleep Tracker</h1>
        <p class="intro-text">
            Améliorez votre qualité de vie en comprenant mieux vos cycles de sommeil
        </p>
        
        <div class="features">
            <div class="feature-item">
                <i class="feature-icon">🌙</i>
                <h3>Suivi du Sommeil</h3>
                <p>Enregistrez vos heures de coucher et de lever</p>
            </div>
            <div class="feature-item">
                <i class="feature-icon">📊</i>
                <h3>Analyse des Cycles</h3>
                <p>Visualisez vos cycles de sommeil et leur qualité</p>
            </div>
            <div class="feature-item">
                <i class="feature-icon">📈</i>
                <h3>Statistiques</h3>
                <p>Suivez votre progression au fil du temps</p>
            </div>
        </div>

        <?php if (!$this->getRequest()->getAttribute('identity')): ?>
            <div class="auth-buttons">
                <?= $this->Html->link(
                    'Commencer',
                    ['controller' => 'Users', 'action' => 'register'],
                    ['class' => 'button button-primary']
                ) ?>
                <?= $this->Html->link(
                    'Se connecter',
                    ['controller' => 'Users', 'action' => 'login'],
                    ['class' => 'button button-secondary']
                ) ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.home-container {
    max-width: 1000px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.welcome-section {
    text-align: center;
    background: white;
    padding: 3rem 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.welcome-section h1 {
    font-size: 3rem;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.intro-text {
    font-size: 1.4rem;
    color: #34495e;
    margin-bottom: 3rem;
}

.features {
    display: flex;
    justify-content: center;
    gap: 2rem;
    margin: 3rem 0;
    flex-wrap: wrap;
}

.feature-item {
    flex: 1;
    min-width: 250px;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 8px;
    transition: transform 0.2s;
}

.feature-item:hover {
    transform: translateY(-5px);
}

.feature-icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    display: block;
}

.feature-item h3 {
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.feature-item p {
    color: #666;
}

.auth-buttons {
    margin-top: 3rem;
    display: flex;
    justify-content: center;
    gap: 1rem;
}

.auth-buttons .button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin: 0;
    padding: 1rem 3rem;
    font-size: 1.2rem;
    border-radius: 30px;
    transition: all 0.3s ease;
    min-width: 200px;
    height: 50px;
    text-decoration: none;
}

.button-primary {
    background: #3498db;
    color: white;
    border: none;
    box-shadow: 0 4px 6px rgba(52, 152, 219, 0.2);
}

.button-primary:hover {
    background: #2980b9;
    transform: translateY(-2px);
    box-shadow: 0 6px 8px rgba(52, 152, 219, 0.3);
}

.button-secondary {
    background: white;
    color: #3498db;
    border: 2px solid #3498db;
    box-shadow: 0 4px 6px rgba(52, 152, 219, 0.1);
}

.button-secondary:hover {
    background: #f8f9fa;
    color: #3498db;
    transform: translateY(-2px);
    box-shadow: 0 6px 8px rgba(52, 152, 219, 0.2);
}

@media (max-width: 768px) {
    .features {
        flex-direction: column;
    }
    
    .feature-item {
        min-width: 100%;
    }
}
</style>
