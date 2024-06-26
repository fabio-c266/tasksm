<?php

namespace src\Core\Libs\SchemaValidations;

class ErrorsMessages
{
    const INVALID_STRING = "o campo não pode ser diferente de uma string";

    const INVALID_INT = "o campo não pode ser diferente de um número inteiro";
    const INVALID_EMAIL = "inválido";
    const REQUIRED = "campo obrigatório";
    const MIN_LENGTH_ERROR = "no mínimo {number} caracteres.";
    const MAX_LENGTH_ERROR = "no máximo {number} caracteres.";

    const ALREADY_EXISTS = "já possui um registro com esse {field}";
    const NOT_EXISTS = "não possui nehum {field} com esse valor";
}
