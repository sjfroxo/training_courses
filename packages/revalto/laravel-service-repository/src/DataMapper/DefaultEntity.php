<?php

namespace Revalto\ServiceRepository\DataMapper;

class DefaultEntity implements \JsonSerializable
{
    /**
     * Modify columns
     *
     * @var array
     */
    protected array $modify = [];

    /**
     * @param array $original Original Columns
     */
    public function __construct(
        protected array $original = []
    ) {}

    /**
     * @return array
     */
    protected function getValues(): array
    {
        return array_merge($this->original, $this->modify);
    }

    /**
     * Check is modify column
     *
     * @param string $key
     * @return bool
     */
    public function isModify(string $key): bool
    {
        return in_array($key, $this->modify);
    }

    /**
     * Is exists column
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->getValues());
    }

    /**
     * Get column value
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed|null
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->getValues()[$key] ?? $default;
    }

    /**
     * Set column value
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, mixed $value): void
    {
        $this->modify[$key] = $value;
    }

    /**
     * Magic method for get column value
     *
     * @param string $name
     * @return mixed|null
     */
    public function __get(string $name)
    {
        return $this->get($name);
    }

    /**
     * Method for set column value
     *
     * @param string $name
     * @param $value
     * @return void
     */
    public function __set(string $name, $value): void
    {
        $this->set($name, $value);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->getValues();
    }
}
