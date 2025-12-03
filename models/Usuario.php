<?php

namespace Model;

class Usuario extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];
    protected static $alertas = [];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
    }

    // Mensajes de validación para la creación de una cuenta
    public function validarNuevaCuenta() {
        static::$alertas = [];
        if(!$this->nombre) {
            static::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if(!$this->apellido) {
            static::$alertas['error'][] = 'El Apellido es Obligatorio';
        }
        if(!$this->email) {
            static::$alertas['error'][] = 'El Email es Obligatorio';
        }
        if(!$this->password) {
            static::$alertas['error'][] = 'El Password es Obligatorio';
        }
        if($this->password && strlen($this->password) < 6) {
            static::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
        }

        return static::$alertas;
    }

    public function validarLogin() {
        static::$alertas = [];
        if(!$this->email) {
            static::$alertas['error'][] = 'El email es Obligatorio';
        }
        if(!$this->password) {
            static::$alertas['error'][] = 'El Password es Obligatorio';
        }

        return static::$alertas;
    }
    public function validarEmail() {
        static::$alertas = [];
        if(!$this->email) {
            static::$alertas['error'][] = 'El email es Obligatorio';
        }
        return static::$alertas;
    }

    public function validarPassword() {
        static::$alertas = [];
        if(!$this->password) {
            static::$alertas['error'][] = 'El Password es obligatorio';
        }
        if($this->password && strlen($this->password) < 6) {
            static::$alertas['error'][] = 'El Password debe tener al menos 6 caracteres';
        }

        return static::$alertas;
    }

    // Revisa si el usuario ya existe
    public function existeUsuario() {
        $query = " SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado->num_rows) {
            self::$alertas['error'][] = 'El Usuario ya esta registrado';
        }

        return $resultado;
    }

    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken() {
        $this->token = uniqid();
    }

    public function comprobarPasswordAndVerificado($password) {
        $resultado = password_verify($password, $this->password);
        
        if(!$resultado || !$this->confirmado) {
            self::$alertas['error'][] = 'Password Incorrecto o tu cuenta no ha sido confirmada';
        } else {
            return true;
        }
    }

}