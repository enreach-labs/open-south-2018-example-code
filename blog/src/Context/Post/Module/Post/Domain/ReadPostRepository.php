<?php

namespace Voiceworks\Context\Post\Module\Post\Domain;

interface ReadPostRepository
{
    public function find(string $id): ?PostResponse;

    public function findAll(int $limit = null, int $offset = null): PostCollectionResponse;
}