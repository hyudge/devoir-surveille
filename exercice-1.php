<?php

abstract class Vehicule 
{
    protected $demarrer = false;
    protected $vitesse = 0;
    protected $vitesseMax;

    abstract function demarrer();
    abstract function eteindre();
    abstract function accelerer($vitesse);
    abstract function decelerer($vitesse);

    public function __toString()
    {
        return "Vitesse actuelle : " . $this->vitesse . " km/h<br/>";
    }
}

class Voiture extends Vehicule 
{
    private static $nombreVoiture = 0;
    private $freinParking = false; // <-- nouveau : état du frein à main

    public function __construct($vitesseMax)
    {
        $this->vitesseMax = $vitesseMax;
        self::$nombreVoiture++;
    }

    public static function getNombreVoiture()
    {
        return self::$nombreVoiture;
    }

    public function demarrer()
    {
        if (!$this->demarrer) {
            $this->demarrer = true;
            echo "La voiture démarre.<br/>";
        } else {
            echo "La voiture est déjà démarrée.<br/>";
        }
    }

    public function eteindre()
    {
        $this->demarrer = false;
        $this->vitesse = 0;
        echo "La voiture est éteinte.<br/>";
    }

    // ======================
    // 🚀 Accélérer
    // ======================
    public function accelerer($nouvelleVitesse)
    {
        if (!$this->demarrer) {
            echo "Impossible d'accélérer, la voiture est éteinte.<br/>";
            return;
        }

        if ($this->freinParking) {
            echo "⚠️ Impossible d'accélérer, le frein de parking est activé !<br/>";
            return;
        }

        // Si la voiture est à l'arrêt, on peut accélérer librement
        if ($this->vitesse == 0) {
            $this->vitesse = $nouvelleVitesse;
        } else {
            // On limite à +30% de la vitesse actuelle
            $vitesseMaxAutorisee = $this->vitesse * 1.3;

            if ($nouvelleVitesse > $vitesseMaxAutorisee) {
                echo "⚠️ Vous ne pouvez pas augmenter de plus de 30% d'un coup.<br/>";
                $nouvelleVitesse = $vitesseMaxAutorisee;
            }

            // On ne dépasse pas la vitesse max du véhicule
            if ($nouvelleVitesse > $this->vitesseMax) {
                $nouvelleVitesse = $this->vitesseMax;
            }

            $this->vitesse = $nouvelleVitesse;
        }

        echo "Vitesse : " . $this->vitesse . " km/h<br/>";
    }

    // ======================
    // 🐢 Décélérer
    // ======================
    public function decelerer($valeur)
    {
        $this->vitesse -= $valeur;
        if ($this->vitesse < 0) $this->vitesse = 0;
        echo "Vous ralentissez à " . $this->vitesse . " km/h<br/>";
    }

    // ======================
    // 🅿️ Frein de parking
    // ======================
    public function activerFreinParking()
    {
        if ($this->vitesse == 0) {
            $this->freinParking = true;
            echo "Frein de parking activé.<br/>";
        } else {
            echo "⚠️ Impossible d'activer le frein de parking en roulant !<br/>";
        }
    }

    public function desactiverFreinParking()
    {
        if ($this->freinParking) {
            $this->freinParking = false;
            echo "Frein de parking désactivé.<br/>";
        } else {
            echo "Le frein de parking est déjà désactivé.<br/>";
        }
    }
}

// ---------------------
// Exemple d'utilisation
// ---------------------

$voiture1 = new Voiture(150);
$voiture1->demarrer();
$voiture1->activerFreinParking(); // OK, la voiture est à 0
$voiture1->accelerer(30); // Impossible : frein activé
$voiture1->desactiverFreinParking(); // on enlève le frein
$voiture1->accelerer(30); // maintenant ça marche
$voiture1->decelerer(30);
$voiture1->activerFreinParking(); // OK, vitesse 0
echo "Nombre de voitures créées : " . Voiture::getNombreVoiture() . "<br/>";

