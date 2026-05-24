<?php
namespace Models;
use PDO;

class CategoryModel extends BaseModel {
    protected string $table = 'categories';

    public function findBySlug(string $slug): ?array {
        return $this->findOneWhere('slug', $slug);
    }

    public function findActive(): array {
        $stmt = $this->pdo->query("SELECT * FROM categories WHERE is_active = TRUE ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByType(string $type): array {
        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE (type = ? OR type = 'both') AND is_active = TRUE ORDER BY name ASC");
        $stmt->execute([$type]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
