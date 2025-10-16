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
        return "Vitesse actuelle : " . $this->vitesse . " km/h";
    }
}

class Voiture extends Vehicule 
{
    private static $nombreVoiture = 0;

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
            echo "La voiture démarre  ";
        } else {
            echo "La voiture est déjà démarrée  ";
        }
    }

    public function eteindre()
    {
        $this->demarrer = false;
        $this->vitesse = 0;
        echo "La voiture est éteinte";
    }

    public function accelerer($nouvelleVitesse)
    {
        if (!$this->demarrer) {
            echo "Impossible d'accélérer, la voiture est éteinte";
            return;
        }

        // Si la voiture est à l'arrêt, on peut accélérer librement
        if ($this->vitesse == 0) {
            $this->vitesse = $nouvelleVitesse;
        } else {
            // On limite à +30% de la vitesse actuelle
            $vitesseMaxAutorisee = $this->vitesse * 1.3;

            if ($nouvelleVitesse > $vitesseMaxAutorisee) {
                echo "⚠️ Vous ne pouvez pas augmenter de plus de 30% d'un coup  ";
                $nouvelleVitesse = $vitesseMaxAutorisee;
            }

            // On ne dépasse pas la vitesse max du véhicule
            if ($nouvelleVitesse > $this->vitesseMax) {
                $nouvelleVitesse = $this->vitesseMax;
            }

            $this->vitesse = $nouvelleVitesse;
        }

        echo "Vitesse : " . $this->vitesse . " km/h  ";
    }

    public function decelerer($valeur)
    {
        if ($valeur > 20) {
            echo "⚠️ Vous ne pouvez pas ralentir de plus de 20km/h d'un coup  ";
            $valeur = 20;
        }
        $this->vitesse -= $valeur;
        if ($this->vitesse < 0) $this->vitesse = 0;
        echo "Vous ralentissez à " . $this->vitesse . " km/h  ";
    }
}

// ---------------------
// Exemple d'utilisation
// ---------------------

$voiture1 = new Voiture(150);
$voiture1->demarrer();
$voiture1->accelerer(40);
echo $voiture1;
$voiture1->accelerer(80); // dépasse +30 %, donc limité
echo $voiture1;
$voiture1->decelerer(30);
echo $voiture1;

echo "Nombre de voitures créées : " . Voiture::getNombreVoiture();
