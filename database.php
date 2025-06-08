<?php

class MongoConnection
{
    private MongoDB\Driver\Manager $manager;
    private string $uri;
    public string $dbName = "jobboard";
    public string $jobsCollection = "jobs";

    public function __construct(string $uri = "mongodb://localhost:27017")
    {
        $this->uri = $uri;
        $this->connect();
    }

    private function connect(): void
    {
        try {
            $this->manager = new MongoDB\Driver\Manager($this->uri);
        } catch (MongoDB\Driver\Exception\Exception $e) {
            throw new Exception("Failed to connect to MongoDB: " . $e->getMessage());
        }
    }

    public function getManager(): MongoDB\Driver\Manager
    {
        return $this->manager;
    }

    public function getDb(): string
    {
        return $this->dbName;
    }

    public function getCollection(): string
    {
        return $this->jobsCollection;
    }

    public function testConnection(): bool
    {
        try {
            $this->manager->executeCommand("admin", new MongoDB\Driver\Command(["ping" => 1]));
            return true;
        } catch (MongoDB\Driver\Exception\Exception $e) {
            return false;
        }
    }
}