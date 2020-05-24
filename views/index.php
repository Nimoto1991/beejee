<?php include_once('template/header.php') ?>
<?php
/** @var array $admin */
/** @var string $tasks */
/** @var string $orderBy */
/** @var string $orderDir */
/** @var int $page */
/** @var int $count */
/** @var int $itemsPerPage */
?>
    <sort order-by="<?= $orderBy ?>" order-dir="<?= $orderDir ?>"></sort>
    <task-list page='<?= $page ?>' :admin='<?= json_encode($admin) ?>' :task-list-json='<?= $tasks ?>'></task-list>
    <pagination page='<?= $page ?>' count='<?= $count ?>' items-per-page="<?= $itemsPerPage ?>"></pagination>
<?php include_once('template/footer.php') ?>