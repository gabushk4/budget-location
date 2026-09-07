<?php

declare(strict_types=1);

function redirect(String $url): void {

    header('Location:' . $url);
    exit;

}

function notAdminRedirectHome() {
   if (!IS_ADMIN) redirect(Page::Home->url());
}

// Pour débug, Dump
function pre(Mixed $data): void {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}

// Pour débug, Dump and Die
function dd(Mixed $data): void {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    exit;
}