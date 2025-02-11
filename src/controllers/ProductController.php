<?php
require_once 'models/Product.php';

class ProductController {
    private $product;

    public function __construct($db) {
        $this->product = new Product($db);
    }

    public function create($data) {
        $this->product->nombre = $data['nombre'];
        $this->product->descripcion = $data['descripcion'];
        $this->product->precio = $data['precio'];

        if($this->product->create()) {
            return array("success" => true, "message" => "Producto creado con éxito.");
        } else {
            return array("success" => false, "message" => "No se pudo crear el producto.");
        }
    }

    public function read($id) {
        return $this->product->read($id);
    }

    public function update($id, $data) {
        $this->product->id = $id;
        $this->product->nombre = $data['nombre'];
        $this->product->descripcion = $data['descripcion'];
        $this->product->precio = $data['precio'];

        if($this->product->update()) {
            return array("success" => true, "message" => "Producto actualizado con éxito.");
        } else {
            return array("success" => false, "message" => "No se pudo actualizar el producto.");
        }
    }

    public function delete($id) {
        $this->product->id = $id;

        if($this->product->delete()) {
            return array("success" => true, "message" => "Producto eliminado con éxito.");
        } else {
            return array("success" => false, "message" => "No se pudo eliminar el producto.");
        }
    }
}

