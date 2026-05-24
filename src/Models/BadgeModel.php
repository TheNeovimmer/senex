<?php
namespace Models;
use PDO;

class BadgeModel extends BaseModel {
    protected string $table = 'badges';

    public function findBySlug(string $slug): ?array {
        return $this->findOneWhere('slug', $slug);
    }

    public function findActive(): array {
        return $this->findWhere('is_active', true);
    }
}
