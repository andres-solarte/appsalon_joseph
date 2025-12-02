<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Model\Servicio;

class ServicioTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Limpiar alertas antes de cada test
        Servicio::getAlertas();
    }

    public function testValidarConDatosVacios()
    {
        $servicio = new Servicio([]);
        $alertas = $servicio->validar();

        $this->assertNotEmpty($alertas);
        $this->assertArrayHasKey('error', $alertas);
        $this->assertContains('El Nombre del Servicio es Obligatorio', $alertas['error']);
        $this->assertContains('El Precio del Servicio es Obligatorio', $alertas['error']);
    }

    public function testValidarSinNombre()
    {
        $servicio = new Servicio([
            'precio' => '100'
        ]);
        $alertas = $servicio->validar();

        $this->assertNotEmpty($alertas);
        $this->assertArrayHasKey('error', $alertas);
        $this->assertContains('El Nombre del Servicio es Obligatorio', $alertas['error']);
    }

    public function testValidarSinPrecio()
    {
        $servicio = new Servicio([
            'nombre' => 'Corte de Cabello'
        ]);
        $alertas = $servicio->validar();

        $this->assertNotEmpty($alertas);
        $this->assertArrayHasKey('error', $alertas);
        $this->assertContains('El Precio del Servicio es Obligatorio', $alertas['error']);
    }

    public function testValidarConPrecioNoNumerico()
    {
        $servicio = new Servicio([
            'nombre' => 'Corte de Cabello',
            'precio' => 'precio_invalido'
        ]);
        $alertas = $servicio->validar();

        $this->assertNotEmpty($alertas);
        $this->assertArrayHasKey('error', $alertas);
        $this->assertContains('El precio no es válido', $alertas['error']);
    }

    public function testValidarConDatosValidos()
    {
        $servicio = new Servicio([
            'nombre' => 'Corte de Cabello',
            'precio' => '100'
        ]);
        $alertas = $servicio->validar();

        $this->assertEmpty($alertas);
    }

    public function testValidarConPrecioNumericoComoString()
    {
        $servicio = new Servicio([
            'nombre' => 'Corte de Cabello',
            'precio' => '150.50'
        ]);
        $alertas = $servicio->validar();

        $this->assertEmpty($alertas);
    }
}

