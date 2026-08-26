<?php
namespace Vedairo\Audit;
class Audit {
    /**
     * @param array<string,mixed> $metadata
     */
    public static function log(string $action, ?string $entityType = null, ?string $entityId = null, array $metadata = []): void {
        try {
            $db = \Vedairo\Application::$container->get('db');
            $db->table('audit_logs')->insert(['user_id' => \Vedairo\Auth\Auth::id(), 'tenant_id' => \Vedairo\Tenancy\TenantManager::id(), 'action' => $action, 'entity_type' => $entityType, 'entity_id' => $entityId, 'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null, 'metadata' => json_encode($metadata)]);
        } catch (\Throwable $e) { /* audit must not break business flow */ }
    }
}
