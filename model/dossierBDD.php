<?php

namespace model;

use model\Dossier;
use config\Config;
use PDO;

class DossierBDD extends Dossier
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Config::getpdo()->getconnexion();
    }
    public function getDossiers()
    {
        $stmt = $this->pdo->query("SELECT * FROM dossiers");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getDossierById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM dossiers WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function createDossier(Dossier $dossier)
    {
        $stmt = $this->pdo->prepare("INSERT INTO dossiers (numero_dossier) VALUES (:numero_dossier)");
        $stmt->bindParam(':numero_dossier', $dossier->getNumeroDossier());

        return $stmt->execute();
    }
}
