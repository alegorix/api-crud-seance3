# API REST PHP - Séance 3 (CRUD complet en écriture)

Ce dossier contient l'intégralité du code fonctionnel de la **Séance 3**.

## Endpoints testables avec Thunder Client / Postman :
- `GET /api/products` (200 OK)
- `GET /api/products/{id}` (200 OK ou 404 Not Found)
- `POST /api/products` avec `{"name": "...", "price": 10.5}` (201 Created ou 400 Bad Request)
- `PUT /api/products/{id}` avec `{"name": "...", "price": 12.0}` (200 OK, 400 Bad Request ou 404 Not Found)
- `DELETE /api/products/{id}` (200 OK ou 404 Not Found)
