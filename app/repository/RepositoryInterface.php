<?php

interface RepositoryInterface
{
    public function insert(object $entity): bool;
    public function update(int $id, object $entity): bool;
    public function delete(int $id): bool;
    public function selectAll(): array;
}
