<?php
namespace Vedairo\Storage;
class S3CompatibleStorage { public function __construct(private array $config){} public function config():array{return $this->config;} public function assertConfigured():void{foreach(['endpoint','bucket','access_key','secret_key'] as $k)if(empty($this->config[$k]))throw new \RuntimeException("Missing storage config: $k");} }
