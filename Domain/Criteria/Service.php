<?php

namespace Domain\Criteria;

class Service
{
    /**
     * @var array
     */
    private $errors = [];

    /**
     * @var bool
     */
    private $fails = false;

    /**
     * Get erros.
     *
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * Retorna se houve falha ou não.
     *
     * @return bool
     */
    public function fails()
    {
        return $this->fails;
    }

    /**
     * Retorna se ocorreu tudo bem.
     *
     * @return bool
     */
    public function passes()
    {
        return !$this->fails;
    }

    public function setError($error)
    {
        $this->errors[] = $error;
        $this->fails = true;
    }
}
