<?php

interface ServiceInterface
{
    public function insert(array $data): bool;
    public function update(array $data): bool;
    public function delete(int $id): bool;
    public function selectAll(): array;
}
?>