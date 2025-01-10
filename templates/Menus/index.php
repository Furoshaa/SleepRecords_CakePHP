<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Menu[]|\Cake\Collection\CollectionInterface $menus
 */
?>
<div class="menus index content">
    <h3>Gestion des Menus</h3>
    <?= $this->Html->link(__('Nouveau Menu'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <table>
        <thead>
            <tr>
                <th>Ordre</th>
                <th>Intitulé</th>
                <th>Lien</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($menus as $menu): ?>
            <tr>
                <td><?= $this->Number->format($menu->ordre) ?></td>
                <td><?= h($menu->intitule) ?></td>
                <td><?= h($menu->lien) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('Modifier'), ['action' => 'edit', $menu->id]) ?>
                    <?= $this->Form->postLink(__('Supprimer'), ['action' => 'delete', $menu->id], ['confirm' => __('Êtes-vous sûr de vouloir supprimer {0}?', $menu->intitule)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div> 