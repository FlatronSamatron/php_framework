<?php

declare(strict_types=1);
namespace Framework\Console\Commands;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Framework\Console\CommandInterface;

class MigrateCommand implements CommandInterface
{
    private string $name = 'migrate';
    private const string MIGRATIONS_TABLE = 'migrations';

    public function __construct(private Connection $connection, private string $migrationsPath)
    {
    }

    public function execute(array $parameters = []): int
    {
        try {
            $this->connection->setAutoCommit(false);

            $this->createMigrationTable();
            $this->connection->beginTransaction();

            $appliedMigrations = $this->appliedMigrations();

            $migrationsFiles = $this->getMigrationFile();

            $migrationsToApply = array_values(array_diff($migrationsFiles, $appliedMigrations));

            $schema = new Schema();

            foreach ($migrationsToApply as $migration) {
                $migrationInstance = require $this->migrationsPath."/$migration";
                $migrationInstance->up($schema);
                $this->addMigration($migration);
            }

            $sqlArray = $schema->toSql($this->connection->getDatabasePlatform());

            foreach ($sqlArray as $sql) {
                $this->connection->executeQuery($sql);
            }

            $this->connection->commit();
        } catch (\Throwable $e) {
            $this->connection->rollBack();
            throw $e;
        }

        $this->connection->setAutoCommit(true);

        return 0;
    }

    private function createMigrationTable(): void
    {
        $schemaManager = $this->connection->createSchemaManager();

        if (!$schemaManager->tablesExist(self::MIGRATIONS_TABLE)) {
            $schema = new Schema();
            $table  = $schema->createTable(self::MIGRATIONS_TABLE);
            $table->addColumn('id', Types::INTEGER, [
                    'unsigned'      => true,
                    'autoincrement' => true,
            ]);

            $table->addColumn('migration', Types::STRING);
            $table->addColumn('created_at', Types::DATETIME_IMMUTABLE, [
                    'default' => 'CURRENT_TIMESTAMP',
            ]);
            $table->setPrimaryKey(['id']);

            $sqlArray = $schema->toSql($this->connection->getDatabasePlatform());

            $this->connection->executeQuery($sqlArray[0]);

            echo 'Migration table created'.PHP_EOL;
        }
    }

    private function appliedMigrations(): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        return $queryBuilder
                ->select('migration')
                ->from(self::MIGRATIONS_TABLE)
                ->executeQuery()
                ->fetchFirstColumn();
    }

    private function getMigrationFile(): array
    {
        $migrationFiles = scandir($this->migrationsPath);

        $filteredFiles = array_filter($migrationFiles, fn($fileName) => !in_array($fileName, ['.', '..']));

        return array_values($filteredFiles);
    }

    private function addMigration(string $migration)
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->insert(self::MIGRATIONS_TABLE)
                ->values(['migration' => ':migration'])
                ->setParameter('migration', $migration)
                ->executeQuery();
    }
}