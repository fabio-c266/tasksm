<?php

namespace src\Core\Libs\SchemaValidations;

use Exception;
use src\Config\Database;

class Validations
{
    protected $currentKey = null;
    protected $data = null;
    protected $param = null;

    public function string()
    {
        if (gettype($this->data) !== 'string') {
            throw new Exception(ErrorsMessages::INVALID_STRING);
        }
    }

    public function int()
    {
        if (gettype($this->data) !== 'integer') {
            throw new Exception(ErrorsMessages::INVALID_INT);
        }
    }

    public function required()
    {
        if (!isset($this->data)) {
            throw new Exception(ErrorsMessages::REQUIRED);
        }
    }

    public function optional()
    {
        //ONLY TO DESCLARE
    }

    public function min()
    {
        if (gettype($this->data) === 'string') {
            if (strlen($this->data) < $this->param) {
                throw new Exception(str_replace('{number}', $this->param, ErrorsMessages::MIN_LENGTH_ERROR));
            }
        }

        if (gettype($this->data) === 'integer') {
            if ($this->data < $this->param) {
                throw new Exception(str_replace('{number}', $this->param, ErrorsMessages::MIN_LENGTH_ERROR));
            }
        }
    }

    public function max()
    {
        if (gettype($this->data) === 'string') {
            if (strlen($this->data) > $this->param) {
                throw new Exception(str_replace('{number}', $this->param, ErrorsMessages::MAX_LENGTH_ERROR));
            }
        }

        if (gettype($this->data) === 'integer') {
            if ($this->data > $this->param) {
                throw new Exception(str_replace('{number}', $this->param, ErrorsMessages::MAX_LENGTH_ERROR));
            }
        }
    }

    public function email()
    {
        $regexEmail = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

        if (!preg_match($regexEmail, $this->data)) {
            throw new Exception(ErrorsMessages::INVALID_EMAIL);
        }
    }

    public function notexist()
    {
        $queryExists = "select $this->currentKey from $this->param where $this->currentKey = '$this->data'";

        if (Database::query($queryExists)) {
            throw new Exception(str_replace('{field}', $this->currentKey, ErrorsMessages::ALREADY_EXISTS));
        }
    }

    public function exist()
    {
        $queryExists = "select $this->currentKey from $this->param where $this->currentKey = '$this->data'";

        if (!Database::query($queryExists)) {
            throw new Exception(str_replace('{field}', $this->currentKey, ErrorsMessages::NOT_EXISTS));
        }
    }

    /** MANIPULE CLASS ATRIBUTES */

    public function setData($data)
    {
        $this->data = $data;
    }

    public function setParam($param)
    {
        $this->param = $param;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setCurrentKey($key)
    {
        $this->currentKey = $key;
    }
}
