<?php
require_once __DIR__ . '/../models/Product.php';

class ProductController {
    private Product $product;

    public function __construct(PDO $db) {
        $this->product = new Product($db);
    }

    public function handleGet(?int $id): void {
        header("Content-Type: application/json; charset=UTF-8");

        if ($id !== null) {
            $item = $this->product->getById($id);
            if ($item) {
                http_response_code(200);
                echo json_encode($item);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Produit introuvable."]);
            }
        } else {
            $items = $this->product->getAll();
            http_response_code(200);
            echo json_encode($items);
        }
    }

    public function handlePost(): void {
        header("Content-Type: application/json; charset=UTF-8");
        
        $raw = file_get_contents("php://input");
        $data = json_decode($raw, true);

        if (!is_array($data) || empty(trim($data['name'] ?? '')) || !isset($data['price']) || !is_numeric($data['price'])) {
            http_response_code(400);
            echo json_encode(["message" => "Données invalides : 'name' (texte) et 'price' (numérique) sont obligatoires."]);
            return;
        }

        $insertedId = $this->product->create(trim($data['name']), (float)$data['price']);

        if ($insertedId !== false) {
            http_response_code(201);
            echo json_encode([
                "message" => "Produit créé avec succès.",
                "id" => $insertedId
            ]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Erreur interne lors de la création du produit."]);
        }
    }

    public function handlePut(?int $id): void {
        header("Content-Type: application/json; charset=UTF-8");

        if ($id === null) {
            http_response_code(400);
            echo json_encode(["message" => "L'ID du produit est requis dans l'URL pour la modification."]);
            return;
        }

        if (!$this->product->getById($id)) {
            http_response_code(404);
            echo json_encode(["message" => "Produit introuvable."]);
            return;
        }

        $raw = file_get_contents("php://input");
        $data = json_decode($raw, true);

        if (!is_array($data) || empty(trim($data['name'] ?? '')) || !isset($data['price']) || !is_numeric($data['price'])) {
            http_response_code(400);
            echo json_encode(["message" => "Données invalides : 'name' (texte) et 'price' (numérique) sont requis."]);
            return;
        }

        if ($this->product->update($id, trim($data['name']), (float)$data['price'])) {
            http_response_code(200);
            echo json_encode(["message" => "Produit mis à jour avec succès."]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Erreur interne lors de la mise à jour."]);
        }
    }

    public function handleDelete(?int $id): void {
        header("Content-Type: application/json; charset=UTF-8");

        if ($id === null) {
            http_response_code(400);
            echo json_encode(["message" => "L'ID du produit est requis dans l'URL."]);
            return;
        }

        if (!$this->product->getById($id)) {
            http_response_code(404);
            echo json_encode(["message" => "Produit introuvable."]);
            return;
        }

        if ($this->product->delete($id)) {
            http_response_code(200);
            echo json_encode(["message" => "Produit supprimé avec succès."]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Erreur interne lors de la suppression."]);
        }
    }
}
