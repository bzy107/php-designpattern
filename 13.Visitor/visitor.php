<?php
declare(strict_types=1);



interface RoleVisitor
{
    public function visitUser(User $role);
    public function visitGroup(Group $role);
}

class RecordingVisitor implements RoleVisitor
{
    private array $visited = [];

    public function visitGroup(Group $role)
    {
        $this->visited[] = $role;
    }

    public function visitUser(User $role)
    {
        $this->visited[] = $role;
    }

    public function getVisited() : array
    {
        return $this->visited;
    }
}

interface Role
{
    public function accept(RoleVisitor $visitor);
}

class User implements Role
{
    public function __construct(private string $name)
    {
    }

    public function getName() : string
    {
        return sprintf('User %s', $this->name);
    }

    public function accept(RoleVisitor $visitor)
    {
        $visitor->visitUser($this);
    }
}

class Group implements Role
{
    public function __construct(private string $name)
    {
    }

    public function getName() : string
    {
        return sprintf('Group %s', $this->name);
    }


    public function accept(RoleVisitor $visitor)
    {
        $visitor->visitGroup($this);
    }
}

$visitor = new RecordingVisitor();



$user = new User('Dominik');
$user->accept($visitor);
var_dump($visitor->getVisited());


print($user->getName()).PHP_EOL;