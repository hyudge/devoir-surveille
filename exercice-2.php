<?php

abstract class Vehicule 
{
    protected $demarrer = false;
    protected $vitesse = 0;
    protected $vitesseMax;

    abstract function decelerer($vitesse);
    abstract function accelerer($vitesse);

    public function demarrer() 
    {
        $this->demarrer = true;
        echo "Le véhicule démarre.\n";
    }

    public function eteindre() 
    {
        $this->demarrer = false;
        echo "Le véhicule est éteint.\n";
    }

    public function __toString() 
    {
        return "Vitesse actuelle : " . $this->vitesse . " km/h\n";
    }

    public function decoller()
    {
        if (!$this->demarrer) {
            echo "Impossible de décoller, le véhicule est éteint.\n";
            return;
        }

        if ($this->vitesse < 120) {
            echo "Vitesse insuffisante pour décoller. Vitesse actuelle : " . $this->vitesse . " km/h\n";
            return;
        }

        echo "Le véhicule décolle avec une vitesse de " . $this->vitesse . " km/h\n";
    }

    public function atterir()
    {
        if (!$this->demarrer) {
            echo "Impossible d'atterrir, le véhicule est éteint.\n";
            return;
        }

        if ($this->vitesse > 20) {
            echo "Vitesse trop élevée pour atterrir. Vitesse actuelle : " . $this->vitesse . " km/h\n";
            return;
        }

        // Quand l'avion atterrit, sa vitesse et son altitude deviennent 0
        $this->vitesse = 0;
        if (property_exists($this, 'altitude')) {
            $this->altitude = 0;
        }

        echo "Le véhicule atterrit en toute sécurité à une vitesse de " . $this->vitesse . " km/h et une altitude de " . $this->altitude . " m\n";
    }
}

// ==========================
// Classe fille : Avion
// ==========================
class Avion extends Vehicule 
{
    public $altitude = 0; // altitude en mètres

    public function __construct($vitesseMax)
    {
        $this->vitesseMax = $vitesseMax;
    }

    public function accelerer($vitesse)
    {
        if (!$this->demarrer) {
            echo "Impossible d'accélérer, l'avion est éteint.\n";
            return;
        }

        $this->vitesse += $vitesse;
        if ($this->vitesse > $this->vitesseMax) {
            $this->vitesse = $this->vitesseMax;
        }

        // On augmente l'altitude proportionnellement à la vitesse (simplifié)
        $this->altitude = $this->vitesse * 0.5;

        echo "L'avion accélère à " . $this->vitesse . " km/h et est à " . $this->altitude . " m d'altitude\n";
    }

    public function decelerer($vitesse)
    {
        $this->vitesse -= $vitesse;
        if ($this->vitesse < 0) $this->vitesse = 0;

        // L'altitude baisse proportionnellement à la vitesse
        $this->altitude = $this->vitesse * 0.5;

        echo "L'avion ralentit à " . $this->vitesse . " km/h et est à " . $this->altitude . " m d'altitude\n";
    }
}

// ==========================
// Exemple d’utilisation
// ==========================
$monAvion = new Avion(800);
$monAvion->demarrer();
$monAvion->accelerer(100);
$monAvion->decoller(); // vitesse < 120 => message d'avertissement
$monAvion->accelerer(50);
$monAvion->decoller(); // maintenant il peut décoller
$monAvion->decelerer(130); // réduit la vitesse pour pouvoir atterrir
$monAvion->atterir(); // vitesse et altitude deviennent 0
$monAvion->eteindre();
