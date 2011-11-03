<?php

namespace Ano\Bundle\SystemBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraints\TypeValidator as BaseTypeValidator;

/**
 * @api
 */
class TypeValidator extends BaseTypeValidator
{

    public function isValid($value, Constraint $constraint)
    {
        if (null === $value) {
            return true;
        }

        $type = strtolower($constraint->type);
        $type = $type == 'boolean' ? 'bool' : $constraint->type;
        $isFunction = 'is_'.$type;
        $ctypeFunction = 'ctype_'.$type;

        if (function_exists($isFunction) && call_user_func($isFunction, $value)) {
            return true;
        } else if (function_exists($ctypeFunction) && call_user_func($ctypeFunction, $value)) {
            return true;
        } else if ($value instanceof $constraint->type) {
            return true;
        }

        $this->setMessage($constraint->message, array(
            '{{ value }}' => is_object($value) ? get_class($value) : (string)$value,
            '{{ type }}'  => $constraint->type,
        ));

        return false;
    }
}
