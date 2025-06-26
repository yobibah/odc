<?php

namespace controllers;

abstract class Controllers
{
    protected function render(string $view, array $data = []): void
    {
        extract($data);
        require_once VIEW_PATH . $view . '.php';
    }

    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit();
    }
    // Méthode utilitaire JSON
    protected function sendJson($data, $status = 200)
    {
        http_response_code($status);
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");
        echo json_encode($data);
        exit();
    }
}

?>