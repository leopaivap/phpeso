<?php

interface RepositoryInterface
{
    public function insert(object $entity): ?int;
    public function update(int $id, object $entity): bool;
    public function delete(int $id): bool;
}