<?php
namespace Vedairo\AI;
class RAG {
    /**
     * @return int
     */
    public static function addDocument(string $title, string $content, ?int $tenantId = null): int {
        $db = \Vedairo\Application::$container->get('db');
        $id = $db->table('knowledge_documents')->insert(['tenant_id' => $tenantId, 'title' => $title, 'path' => null, 'mime_type' => 'text/plain', 'status' => 'ready']);
        $chunks = preg_split('/\n\s*\n|(?<=.{1000})\s+/u', trim($content), -1, PREG_SPLIT_NO_EMPTY) ?: [];
        foreach ($chunks as $i => $chunk) $db->table('knowledge_chunks')->insert(['document_id' => $id, 'chunk_index' => $i, 'content' => $chunk, 'embedding' => null]);
        return $id;
    }

    /**
     * @return array<int,array<string,mixed>>
     */
    public static function search(string $query, int $limit = 5, ?int $tenantId = null): array {
        $db = \Vedairo\Application::$container->get('db');
        $rows = $db->table('knowledge_chunks')->raw('SELECT kc.*,kd.title,kd.tenant_id FROM knowledge_chunks kc JOIN knowledge_documents kd ON kd.id=kc.document_id WHERE (? IS NULL OR kd.tenant_id=?) ORDER BY kc.id DESC', [$tenantId, $tenantId]) ?: [];

        $terms = array_values(array_filter((array) preg_split('/\s+/u', mb_strtolower($query))));
        $scored = [];
        foreach ($rows as $r) {
            $text = mb_strtolower($r['content'] ?? '');
            $score = 0;
            foreach ($terms as $t) {
                $score += substr_count($text, $t);
            }
            if ($score > 0) {
                $r['score'] = $score;
                $scored[] = $r;
            }
        }

        usort($scored, fn($a, $b) => $b['score'] <=> $a['score']);
        return array_slice($scored, 0, $limit);
    }
}
