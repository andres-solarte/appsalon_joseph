<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Model\Usuario;

class UsuarioTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Limpiar alertas antes de cada test
        Usuario::getAlertas();
    }

    public function testValidarNuevaCuentaConDatosVacios()
    {
        $usuario = new Usuario([]);
        $alertas = $usuario->validarNuevaCuenta();

        $this->assertNotEmpty($alertas);
        $this->assertArrayHasKey('error', $alertas);
        $this->assertContains('El Nombre es Obligatorio', $alertas['error']);
        $this->assertContains('El Apellido es Obligatorio', $alertas['error']);
        $this->assertContains('El Email es Obligatorio', $alertas['error']);
        $this->assertContains('El Password es Obligatorio', $alertas['error']);
    }

    public function testValidarNuevaCuentaConPasswordCorto()
    {
        $usuario = new Usuario([
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'email' => 'juan@test.com',
            'password' => '12345' // Menos de 6 caracteres
        ]);
        $alertas = $usuario->validarNuevaCuenta();

        $this->assertNotEmpty($alertas);
        $this->assertArrayHasKey('error', $alertas);
        $this->assertContains('El password debe contener al menos 6 caracteres', $alertas['error']);
    }

    public function testValidarNuevaCuentaConDatosValidos()
    {
        $usuario = new Usuario([
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'email' => 'juan@test.com',
            'password' => 'password123'
        ]);
        $alertas = $usuario->validarNuevaCuenta();

        $this->assertEmpty($alertas);
    }

    public function testValidarLoginConDatosVacios()
    {
        $usuario = new Usuario([]);
        $alertas = $usuario->validarLogin();

        $this->assertNotEmpty($alertas);
        $this->assertArrayHasKey('error', $alertas);
        $this->assertContains('El email es Obligatorio', $alertas['error']);
        $this->assertContains('El Password es Obligatorio', $alertas['error']);
    }

    public function testValidarLoginConDatosValidos()
    {
        $usuario = new Usuario([
            'email' => 'juan@test.com',
            'password' => 'password123'
        ]);
        $alertas = $usuario->validarLogin();

        $this->assertEmpty($alertas);
    }

    public function testValidarEmailConEmailVacio()
    {
        $usuario = new Usuario([]);
        $alertas = $usuario->validarEmail();

        $this->assertNotEmpty($alertas);
        $this->assertArrayHasKey('error', $alertas);
        $this->assertContains('El email es Obligatorio', $alertas['error']);
    }

    public function testValidarEmailConEmailValido()
    {
        $usuario = new Usuario([
            'email' => 'juan@test.com'
        ]);
        $alertas = $usuario->validarEmail();

        $this->assertEmpty($alertas);
    }

    public function testValidarPasswordConPasswordVacio()
    {
        $usuario = new Usuario([]);
        $alertas = $usuario->validarPassword();

        $this->assertNotEmpty($alertas);
        $this->assertArrayHasKey('error', $alertas);
        $this->assertContains('El Password es obligatorio', $alertas['error']);
    }

    public function testValidarPasswordConPasswordCorto()
    {
        $usuario = new Usuario([
            'password' => '12345'
        ]);
        $alertas = $usuario->validarPassword();

        $this->assertNotEmpty($alertas);
        $this->assertArrayHasKey('error', $alertas);
        $this->assertContains('El Password debe tener al menos 6 caracteres', $alertas['error']);
    }

    public function testValidarPasswordConPasswordValido()
    {
        $usuario = new Usuario([
            'password' => 'password123'
        ]);
        $alertas = $usuario->validarPassword();

        $this->assertEmpty($alertas);
    }

    public function testHashPassword()
    {
        $usuario = new Usuario([
            'password' => 'password123'
        ]);
        
        $passwordOriginal = $usuario->password;
        $usuario->hashPassword();

        $this->assertNotEquals($passwordOriginal, $usuario->password);
        $this->assertTrue(password_verify('password123', $usuario->password));
    }

    public function testCrearToken()
    {
        $usuario = new Usuario([]);
        $usuario->crearToken();

        $this->assertNotEmpty($usuario->token);
        $this->assertIsString($usuario->token);
    }

    public function testComprobarPasswordAndVerificadoConPasswordIncorrecto()
    {
        $usuario = new Usuario([
            'password' => 'password123',
            'confirmado' => '1'
        ]);
        $usuario->hashPassword();

        $resultado = $usuario->comprobarPasswordAndVerificado('passwordIncorrecto');
        $alertas = Usuario::getAlertas();

        $this->assertNotTrue($resultado);
        $this->assertNotEmpty($alertas);
        $this->assertArrayHasKey('error', $alertas);
    }

    public function testComprobarPasswordAndVerificadoConCuentaNoConfirmada()
    {
        $usuario = new Usuario([
            'password' => 'password123',
            'confirmado' => '0'
        ]);
        $usuario->hashPassword();

        $resultado = $usuario->comprobarPasswordAndVerificado('password123');
        $alertas = Usuario::getAlertas();

        $this->assertNotTrue($resultado);
        $this->assertNotEmpty($alertas);
        $this->assertArrayHasKey('error', $alertas);
    }

    public function testComprobarPasswordAndVerificadoConDatosCorrectos()
    {
        $usuario = new Usuario([
            'password' => 'password123',
            'confirmado' => '1'
        ]);
        $usuario->hashPassword();

        $resultado = $usuario->comprobarPasswordAndVerificado('password123');

        $this->assertTrue($resultado);
    }
}

