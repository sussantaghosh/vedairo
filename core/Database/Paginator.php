<?php
namespace Vedairo\Database;
class Paginator {
    /**
     * @param list<array<string,mixed>> $items
     * @param array<string,string> $query
     */
    public function __construct(public array $items, public int $total, public int $perPage, public int $page, public string $path, public array $query = []) {}

    public function lastPage(): int { return max(1, (int) ceil($this->total / $this->perPage)); }
    public function hasPages(): bool { return $this->lastPage() > 1; }
    public function url(int $page): string { $q = array_merge($this->query, ['page' => $page]); return $this->path . '?' . http_build_query($q); }
    public function links(): string { if (!$this->hasPages()) return ''; $out = '<nav aria-label="Pagination"><ul class="pagination">'; for ($p = 1; $p <= $this->lastPage(); $p++) { $active = $p === $this->page ? ' active' : ''; $out .= '<li class="page-item' . $active . '"><a class="page-link" href="' . htmlspecialchars($this->url($p), ENT_QUOTES) . '">' . $p . '</a></li>'; } return $out . '</ul></nav>'; }
}
