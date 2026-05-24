<?php
namespace Models;
use PDO;

class UserModel extends BaseModel {
    protected string $table = 'users';

    public function findByEmail(string $email): ?array {
        return $this->findOneWhere('email', $email);
    }

    public function findByUsername(string $username): ?array {
        return $this->findOneWhere('username', $username);
    }

    public function createUser(array $data): int|false {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->insert($data);
    }

    public function verifyPassword(string $email, string $password): ?array {
        $user = $this->findByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return null;
    }

    public function verifyPasswordByUsername(string $username, string $password): ?array {
        $user = $this->findByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return null;
    }

    public function updateLastLogin(int $id): bool {
        return $this->update($id, ['last_login' => date('Y-m-d H:i:s')]);
    }

    public function findByRole(string $role): array {
        return $this->findWhere('role', $role);
    }

    public function updatePassword(int $id, string $newPassword): bool {
        return $this->update($id, ['password' => password_hash($newPassword, PASSWORD_BCRYPT)]);
    }

    public function search(string $query): array {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username LIKE ? OR email LIKE ? OR display_name LIKE ? LIMIT 20");
        $like = "%$query%";
        $stmt->execute([$like, $like, $like]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
