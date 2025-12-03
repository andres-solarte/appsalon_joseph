<?php 

namespace Model;

class Servicio extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'nombre', 'precio'];
    protected static $alertas = [];

    public $id;
    public $nombre;
    public $precio;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';
    }

    public function validar() {
        static::$alertas = [];
        if(!$this->nombre) {
            static::$alertas['error'][] = 'El Nombre del Servicio es Obligatorio';
        }
        if(!$this->precio) {
            static::$alertas['error'][] = 'El Precio del Servicio es Obligatorio';
        }
        if($this->precio && !is_numeric($this->precio)) {
            static::$alertas['error'][] = 'El precio no es válido';
        }

        return static::$alertas;
    }
}