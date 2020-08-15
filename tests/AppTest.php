<?php
/**
 * API Shop
 *
 * @version   1.0
 * @author    Lounis Makhloufi <makhloufi.lounis@gmail.com>
 * @see       https://github.com/makhloufi-lounis/api-shop for the canonical source repository
 * @copyright Copyright (c) 2020.
 */

namespace App\Tests;

use PHPUnit\Framework\TestCase;

// On peut extends aussi KernelTestCase pour écrire des test dans le context du kernel et container ( utilisé plutot dans un context fonctionnel )
// On peut aussi extends WebTestCase c'est une class qui permet de tester des controller (elle permet par exemple d'envoiyer une requete et de voir la reponse )
// TestCase basique pour tester du code basique
// la conf de l'envirenement de test se trouve dans config/package/test et le fichier .env.test
class AppTest extends TestCase
{
    public function testTestsAreWorking () {
        $this->assertEquals(2 , 1+1);
    }
}
