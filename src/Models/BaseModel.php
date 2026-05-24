<?php
namespace Models;
use PDO;

abstract class BaseModel {
    protected PDO $pdo;
    protected string $table;
    protected string $primaryKey = 'id';

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function findAll(string $orderBy = 'created_at DESC', ?int $limit = null, int $offset = 0): array {
        $sql = "SELECT * FROM {$this->table} ORDER BY {$orderBy}";
        if ($limit) $sql .= " LIMIT $limit OFFSET $offset";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function findWhere(string $column, $value, string $orderBy = 'created_at DESC'): array {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$column} = ? ORDER BY {$orderBy}");
        $stmt->execute([$value]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findOneWhere(string $column, $value): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$column} = ? LIMIT 1");
        $stmt->execute([$value]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function insert(array $data): int|false {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})");
        return $stmt->execute(array_values($data)) ? (int)$this->pdo->lastInsertId() : false;
    }

    public function update(int $id, array $data): bool {
        $sets = implode(' = ?, ', array_keys($data)) . ' = ?';
        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET {$sets} WHERE {$this->primaryKey} = ?");
        $values = array_values($data);
        $values[] = $id;
        return $stmt->execute($values);
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?");
        return $stmt->execute([$id]);
    }

    public function count(string $column = null, $value = null): int {
        $sql = "SELECT COUNT(*) FROM {$this->table}";
        if ($column) {
            $stmt = $this->pdo->prepare("$sql WHERE {$column} = ?");
            $stmt->execute([$value]);
        } else {
            $stmt = $this->pdo->query($sql);
        }
        return (int)$stmt->fetchColumn();
    }

    public function paginate(int $page = 1, int $perPage = 20, string $where = null, array $params = []): array {
        $offset = ($page - 1) * $perPage;
        $whereClause = $where ? "WHERE $where" : '';
        $total = $this->pdo->prepare("SELECT COUNT(*) FROM {$this->table} $whereClause");
        $total->execute($params);
        $totalCount = (int)$total->fetchColumn();
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} $whereClause ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");
        $stmt->execute($params);
        return [
            'items' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'total' => $totalCount,
            'page' => $page,
            'perPage' => $perPage,
            'lastPage' => max(1, (int)ceil($totalCount / $perPage))
        ];
    }
}
