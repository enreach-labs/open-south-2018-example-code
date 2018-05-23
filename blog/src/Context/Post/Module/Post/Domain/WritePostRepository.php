<?php

namespace Voiceworks\Context\Post\Module\Post\Domain;

interface WritePostRepository
{
    public function save(Post $post): void;

    public function find(string $id): ?Post;

    public function delete(Post $post): void;
}