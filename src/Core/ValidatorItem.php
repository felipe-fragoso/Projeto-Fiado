<?php

namespace Fiado\Core;

use Fiado\Enums\ValidatorErrorType;

class ValidatorItem
{
    private mixed $value;
    private array $errors = [];
    private array $currentError = [];
    private array $orErrors = [];
    private bool $errorCondition = false;
    private bool $orActive = false;
    private int $numOrs = 1;

    /**
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        if (count($this->orErrors) == $this->numOrs) {
            $this->errors = array_merge($this->errors, $this->orErrors);
        }

        $this->errors = array_merge($this->errors, $this->currentError);

        return $this->errors;
    }

    public function getQtyErrors()
    {
        return count($this->getErrors());
    }

    /**
     * @param string $msg
     * @param ValidatorErrorType $code
     */
    private function checkError(string $msg, ValidatorErrorType $code)
    {
        $this->errors = array_merge($this->errors, $this->currentError);
        $this->currentError = [];

        if ($this->errorCondition) {
            $this->addError($msg, $code);
        }

        $this->orActive = false;
        $this->errorCondition = false;
    }

    /**
     * @param string $msg
     * @param ValidatorErrorType $code
     */
    private function addError(string $msg, ValidatorErrorType $code)
    {
        if ($this->orActive) {
            $this->orErrors = array_merge($this->orErrors, [$code->name => $msg]);
        } else {
            $this->currentError[$code->name] = $msg;

            if (count($this->orErrors) == $this->numOrs) {
                $this->errors = array_merge($this->errors, $this->orErrors);
            }

            $this->orErrors = [];
            $this->numOrs = 1;
        }
    }

    /**
     * @return ValidatorItem
     */
    public function or()
    {
        $this->orActive = true;
        $this->orErrors = array_merge($this->orErrors, $this->currentError);
        $this->currentError = [];
        $this->numOrs++;

        return $this;
    }

    /**
     * @param string $errorMsg
     * @return ValidatorItem
     */
    public function isNull(string $errorMsg = 'Não é nulo')
    {
        $this->errorCondition = !is_null($this->value);
        $this->checkError($errorMsg, ValidatorErrorType::InvalidValue);

        return $this;
    }

    /**
     * @param string $errorMsg
     * @return ValidatorItem
     */
    public function isEmpty(string $errorMsg = 'Não está vazio')
    {
        $this->errorCondition = $this->value !== '';
        $this->checkError($errorMsg, ValidatorErrorType::NotEmpty);

        return $this;
    }

    /**
     * @param string $errorMsg
     * @return ValidatorItem
     */
    public function isRequired(string $errorMsg = 'Está vazio')
    {
        $this->errorCondition = ($this->value === null || $this->value == '') && $this->value !== false;
        $this->checkError($errorMsg, ValidatorErrorType::Required);

        return $this;
    }

    /**
     * @param int|float $max
     * @param string $errorMsg
     * @return ValidatorItem
     */
    public function isMaxValue(int | float $max, string $errorMsg = 'Excedeu o limite')
    {
        $this->errorCondition = $this->value > $max;
        $this->checkError($errorMsg, ValidatorErrorType::ValueTooHigh);

        $this->orActive = false;

        return $this;
    }

    /**
     * @param int|float $min
     * @param string $errorMsg
     * @return ValidatorItem
     */
    public function isMinValue(int | float $min, string $errorMsg = 'Abaixo do mínimo')
    {
        $this->errorCondition = $this->value < $min;
        $this->checkError($errorMsg, ValidatorErrorType::ValueTooLow);

        return $this;
    }

    /**
     * @param int $max
     * @param string $errorMsg
     * @return ValidatorItem
     */
    public function isMaxLength(int $max, string $errorMsg = 'Tamanho máximo excedido')
    {
        $this->errorCondition = strlen((string) $this->value) > $max;
        $this->checkError($errorMsg, ValidatorErrorType::LengthTooLong);

        return $this;
    }

    /**
     * @param int $min
     * @param string $errorMsg
     * @return ValidatorItem
     */
    public function isMinLength(int $min, string $errorMsg = 'Tamanho não atende ao mínimo')
    {
        $this->errorCondition = strlen((string) $this->value) < $min;
        $this->checkError($errorMsg, ValidatorErrorType::LengthTooShort);

        return $this;
    }

    /**
     * @param $min
     * @param $max
     * @param string $errorMsg
     * @return ValidatorItem
     */
    public function isRange($min, $max, string $errorMsg = 'Fora do intervalo')
    {
        $this->errorCondition = ($this->value < $min) || ($this->value > $max);
        $this->checkError($errorMsg, ValidatorErrorType::NotInRange);

        return $this;
    }

    /**
     * @param string $errorMsg
     * @return ValidatorItem
     */
    public function isNumeric(string $errorMsg = 'Não é numérico')
    {
        $this->errorCondition = !is_numeric($this->value);
        $this->checkError($errorMsg, ValidatorErrorType::NonNumeric);

        return $this;
    }

    /**
     * @param string $errorMsg
     * @return ValidatorItem
     */
    public function isEmail(string $errorMsg = 'Não é um email válido')
    {
        $this->errorCondition = !filter_var($this->value, FILTER_VALIDATE_EMAIL);
        $this->checkError($errorMsg, ValidatorErrorType::InvalidEmail);

        return $this;
    }

    private function validateCpf()
    {
        // Extrai somente os números
        $cpf = preg_replace('/[^0-9]/is', '', (string) $this->value);

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    private function validateCnpj()
    {
        $cnpj = preg_replace('/[^0-9]/is', '', (string) $this->value);

        if (strlen($cnpj) != 14) {
            return false;
        }

        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        $pesos = [
            [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2],
            [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2],
        ];

        for ($t = 12; $t < 14; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cnpj[$c] * $pesos[$t - 12][$c];
            }

            $d = ((10 * $d) % 11) % 10;

            if ($cnpj[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $errorMsg
     * @return ValidatorItem
     */
    public function isCpf(string $errorMsg = 'Não é um CPF válido')
    {
        $this->errorCondition = !$this->validateCpf();
        $this->checkError($errorMsg, ValidatorErrorType::InvalidCpf);

        return $this;
    }

    /**
     * @param string $errorMsg
     * @return ValidatorItem
     */
    public function isCnpj(string $errorMsg = 'Não é um CNPJ válido')
    {
        $this->errorCondition = !$this->validateCnpj();
        $this->checkError($errorMsg, ValidatorErrorType::InvalidCnpj);

        return $this;
    }

    /**
     * @param string $errorMsg
     * @return ValidatorItem
     */
    public function isDate(string $errorMsg = 'Não é uma data válida')
    {
        $this->errorCondition = !strtotime((string) $this->value);
        $this->checkError($errorMsg, ValidatorErrorType::InvalidDate);

        return $this;
    }

    /**
     * @param string $errorMsg
     * @return ValidatorItem
     */
    public function isPhoneNumber(string $errorMsg = 'Não é um telefone válido')
    {
        $this->errorCondition = !preg_match('/^\d{2}\d{8,9}$/', (string) $this->value);
        $this->checkError($errorMsg, ValidatorErrorType::InvalidePhoneNumber);

        return $this;
    }

    /**
     * @param string $pattern
     * @param string $errorMsg
     * @return ValidatorItem
     */
    public function isFormat(string $pattern, string $errorMsg = 'Formato inválido')
    {
        $this->errorCondition = !preg_match($pattern, (string) $this->value);
        $this->checkError($errorMsg, ValidatorErrorType::InvalidFormat);

        return $this;
    }

    /**
     * @param $value
     * @param string $errorMsg
     * @return ValidatorItem
     */
    public function isEqual($value, string $errorMsg = 'Inválido')
    {
        $this->errorCondition = $this->value !== $value;
        $this->checkError($errorMsg, ValidatorErrorType::NotEqual);

        return $this;
    }

    /**
     * @param $occurrence
     * @param string $errorMsg
     * @return ValidatorItem
     */
    public function isUnique($occurrence, string $errorMsg = 'Não é único')
    {
        $this->errorCondition = $occurrence != 0;
        $this->checkError($errorMsg, ValidatorErrorType::NotUnique);

        return $this;
    }

    /**
     * @param $occurrence
     * @param string $errorMsg
     * @return ValidatorItem
     */
    public function isPresent($occurrence, string $errorMsg = 'Não existe')
    {
        $this->errorCondition = $occurrence < 1;
        $this->checkError($errorMsg, ValidatorErrorType::DoesNotExist);

        return $this;
    }

    /**
     * @param $occurrence
     * @param string $errorMsg
     * @return ValidatorItem
     */
    public function isNew($occurrence, string $errorMsg = 'Já existe')
    {
        $this->errorCondition = $occurrence > 0;
        $this->checkError($errorMsg, ValidatorErrorType::AlreadyExists);

        return $this;
    }

    /**
     * @param $class
     * @param string $errorMsg
     * @return ValidatorItem
     */
    public function isInstanceOf($class, string $errorMsg = 'Inválido')
    {
        $this->errorCondition = !($this->value instanceof $class);
        $this->checkError($errorMsg, ValidatorErrorType::InvalidInstance);

        return $this;
    }

    /**
     * @param string $errorMsg
     * @return ValidatorItem
     */
    public function isBool(string $errorMsg = 'Não é booleano')
    {
        $this->errorCondition = !is_bool($this->value);
        $this->checkError($errorMsg, ValidatorErrorType::NonBoolean);

        return $this;
    }
}