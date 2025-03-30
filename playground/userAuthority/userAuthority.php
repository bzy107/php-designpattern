<?php

declare(strict_types=1);

// やること
// ユーザ権限を確認する
// 権限がある場合にtrueを返す それ以外はfalse

// 想定
// 社員なら誰でも見れる権限
// 営業部しか見れない権限
// 部長以上ならみれる権限（部長の上は副社長と社長のみとする）
// 営業部 かつ 部長以上ならみれる権限

// 参照: アプリケーションアーキテクチャ設計パターンP.180
// TODO: TDDで再実装してみる
// TODO: 名前が適切ではない

enum EmployeeRole: int
{
    case President = 0;
    case VicePresident = 1;
    case Director = 2;
    case Manager = 3;
    case Employee = 4;
    case Guest = 99;
}

enum Department: int
{
    case Representative = 0;
    case Sales = 1;
    case IT = 2;
    case Strategy = 3;
}

class Userses
{
    /**
     * 社長     => roleId: 0
     * 副社長   => roleId: 1
     * 部長     => roleId: 2
     * 課長     => roleId: 3
     * 平社員   => roleId: 4
     * ゲスト   => roleId: 99
     */
    public function __construct(
        public readonly string $name,
        public readonly ?int $employeeId = null,
        public readonly ?Department $departmentId = null,
        public readonly ?EmployeeRole $roleId = null
    ) {
        if (is_null($this->name) || ! $this->name) {
            throw new Exception('name Error');
        }
        if (! is_null($this->employeeId) && $this->employeeId < 0) {
            throw new Exception('employeeId Error');
        }
    }
}

interface UserAuth
{
    public function isSatisfiedBy(Userses $user): bool;
}

/**
 * 禁止ユーザではないこと
 */
class EmployeeCheck implements UserAuth
{
    public function __construct(private readonly EmployeeRole $checkRoleId)
    {
    }

    public function isSatisfiedBy(Userses $user): bool
    {
        if (is_null($user->roleId)) {
            return false;
        }
        if ($user->roleId->value !== $this->checkRoleId->value) {
            return true;
        }

        return false;
    }
}

/**
 * 対象部であるかどうか
 */
class DepertmentCheck implements UserAuth
{
    public function __construct(private readonly Department $targetDepartmeneId)
    {
    }

    public function isSatisfiedBy(Userses $user): bool
    {
        if (is_null($user->departmentId)) {
            return false;
        }
        if ($user->departmentId->value === $this->targetDepartmeneId->value) {
            return true;
        }

        return false;
    }
}

/**
 * 以上かどうか
 */
class RankCheck implements UserAuth
{
    public function __construct(private readonly EmployeeRole $targetRoleId)
    {
    }

    public function isSatisfiedBy(Userses $user): bool
    {
        if (is_null($user->roleId)) {
            return false;
        }
        if ($user->roleId->value <= $this->targetRoleId->value) {
            return true;
        }

        return false;
    }
}

/**
 * 部かつ以上であるかどうか
 */
class SalesDepertmentAndDirectorCheck implements UserAuth
{
    public function __construct(
        private readonly EmployeeRole $targetRoleId,
        private readonly Department $targetDepartmeneId
    ) {
    }

    public function isSatisfiedBy(Userses $user): bool
    {
        if (is_null($user->roleId) || is_null($user->departmentId)) {
            return false;
        }
        if ($user->roleId->value <= $this->targetRoleId->value
            && $user->departmentId->value === $this->targetDepartmeneId->value
        ) {
            return true;
        } else {
            return false;
        }
    }
}

class Main
{
    public function checkPermission(Userses $user, array $userPermissionAray)
    {
        foreach ($userPermissionAray as $p) {
            if ($p->isSatisfiedBy($user)) {
                return 'allow!!!!';
            }
        }

        return 'not allow.....';
    }
}

$employee1 = new Userses('Guest Jon');
$employee2 = new Userses('employee Mick', 100, Department::IT, EmployeeRole::Employee);
$employee3 = new Userses('VicePresident zerensky', 100, Department::Strategy, EmployeeRole::Manager);

$array = [];
// $array[]= new EmployeeCheck(EmployeeRole::Guest);
// $array[]= new DepertmentCheck(Department::Sales);
// $array[]= new DepertmentCheck(Department::Representative);
$array[] = new RankCheck(EmployeeRole::Manager);
$array[] = new SalesDepertmentAndDirectorCheck(EmployeeRole::President, Department::Strategy);

$main = new Main();
echo $main->checkPermission($employee1, $array) . PHP_EOL;
echo $main->checkPermission($employee2, $array) . PHP_EOL;
echo $main->checkPermission($employee3, $array) . PHP_EOL;
