<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Menu[]|\Cake\Collection\CollectionInterface $menus
 */
?>
<div class="menus index content">
    <h3>Gestion des Menus</h3>
    <?php if ($currentUser && $currentUser->permission >= 2): ?>
        <?= $this->Html->link(__('Nouveau Menu'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <?php endif; ?>
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
                    <?php if ($currentUser && $currentUser->permission >= 2): ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $menu->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), 
                            ['action' => 'delete', $menu->id],
                            ['confirm' => __('Are you sure you want to delete # {0}?', $menu->id)]) 
                        ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div> 