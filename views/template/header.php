<?php
/**
 * @var array $admin
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Taskmanager BeeJee</title>
	<?= \beejee\assets\AssetBundle::printCss(); ?>
</head>

<body>
<div id="app">
    <header>
        <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
            <h5 class="my-0 mr-md-auto font-weight-normal">Taskmanager BeeJee</h5>
            <nav class="my-2 my-md-0 mr-md-3">
                <authform :admin-json='<?= json_encode($admin) ?>'></authform>
            </nav>
        </div>
    </header>

    <main role="main">