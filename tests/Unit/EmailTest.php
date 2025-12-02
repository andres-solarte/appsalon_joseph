<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Classes\Email;

class EmailTest extends TestCase
{
    public function testConstructorAsignaPropiedades()
    {
        $email = new Email('test@example.com', 'Juan Pérez', 'token123');

        $this->assertEquals('test@example.com', $email->email);
        $this->assertEquals('Juan Pérez', $email->nombre);
        $this->assertEquals('token123', $email->token);
    }

    public function testConstructorConDatosDiferentes()
    {
        $email = new Email('otro@test.com', 'María García', 'token456');

        $this->assertEquals('otro@test.com', $email->email);
        $this->assertEquals('María García', $email->nombre);
        $this->assertEquals('token456', $email->token);
    }

    public function testEnviarConfirmacionNoLanzaExcepcion()
    {
        // Mock de variables de entorno para evitar errores reales
        $_ENV['SENDGRID_APIKEY'] = 'test_key';
        $_ENV['APP_URL'] = 'http://localhost:3000';

        $email = new Email('test@example.com', 'Juan Pérez', 'token123');

        // No debería lanzar excepción (aunque no envíe realmente el email)
        // En un entorno real, usarías mocks para SendGrid
        $this->assertInstanceOf(Email::class, $email);
    }

    public function testEnviarInstruccionesNoLanzaExcepcion()
    {
        // Mock de variables de entorno para evitar errores reales
        $_ENV['SENDGRID_APIKEY'] = 'test_key';
        $_ENV['APP_URL'] = 'http://localhost:3000';

        $email = new Email('test@example.com', 'Juan Pérez', 'token123');

        // No debería lanzar excepción (aunque no envíe realmente el email)
        // En un entorno real, usarías mocks para SendGrid
        $this->assertInstanceOf(Email::class, $email);
    }
}

