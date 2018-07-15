<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$this->getTitle();?></title>
<?php foreach ($this->getCssAssets() as $css_asset): ?>
    <link rel="stylesheet" type="text/css" href="/assets/css/<?=$css_asset?>.css">
<?php endforeach;?>
</head>

<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img class="logo" src="/assets/images/crystallio.png" class="img-fluid">
            Crystallio
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="/about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="/contact">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

