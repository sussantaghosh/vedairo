<?php
namespace Vedairo\AI;
interface Embeddings {
    /**
     * @return list<float>
     */
    public function embed(string $text): array;
}
