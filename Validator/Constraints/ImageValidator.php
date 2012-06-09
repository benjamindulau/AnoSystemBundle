<?php


namespace Ano\Bundle\SystemBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\FileValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Validates whether a value is a valid image file and is valid
 * against minWidth, maxWidth, minHeight and maxHeight constraints
 *
 * @author Benjamin Dulau <benjamin.dulau@gmail.com>
 */
class ImageValidator extends FileValidator
{
    public function isValid($value, Constraint $constraint)
    {
        $isValid = parent::isValid($value, $constraint);
        if (!$isValid) {
            return false;
        }

        if (null === $value || '' === $value) {
            return true;
        }

        if ($value instanceof File) {
            $value = $value->getRealPath();
//            var_dump($value); die();
        }

        $size = @getimagesize($value);
        if (empty($size) or ($size[0] === 0) or ($size[1] === 0)) {
            $this->setMessage($constraint->notDetectedMessage);

            return false;
        }

        $width  = $size[0];
        $height = $size[1];

        if ($constraint->minWidth) {
            if (!ctype_digit((string)$constraint->minWidth)) {
                throw new ConstraintDefinitionException(sprintf('"%s" is not a valid minimum width', $constraint->minWidth));
            }
            
            if ($width < $constraint->minWidth) {
                $this->setMessage($constraint->minWidthMessage, array(
                    '{{ width }}'    => $width,
                    '{{ minWidth }}' => $constraint->minWidth
                ));

                return false;
            }
        }

        if ($constraint->maxWidth) {
            if (!ctype_digit((string)$constraint->maxWidth)) {
                throw new ConstraintDefinitionException(sprintf('"%s" is not a valid maximum width', $constraint->maxWidth));
            }

            if ($width > $constraint->maxWidth) {
                $this->setMessage($constraint->maxWidthMessage, array(
                    '{{ width }}'    => $width,
                    '{{ maxWidth }}' => $constraint->maxWidth
                ));

                return false;
            }
        }

        if ($constraint->minHeight) {
            if (!ctype_digit((string)$constraint->minHeight)) {
                throw new ConstraintDefinitionException(sprintf('"%s" is not a valid minimum height', $constraint->minHeight));
            }

            if ($height < $constraint->minHeight) {
                $this->setMessage($constraint->minHeightMessage, array(
                    '{{ height }}'    => $height,
                    '{{ minHeight }}' => $constraint->minHeight
                ));

                return false;
            }
        }

        if ($constraint->maxHeight) {
            if (!ctype_digit((string)$constraint->maxHeight)) {
                throw new ConstraintDefinitionException(sprintf('"%s" is not a valid maximum height', $constraint->maxHeight));
            }

            if ($height > $constraint->maxHeight) {
                $this->setMessage($constraint->maxHeightMessage, array(
                    '{{ height }}'    => $height,
                    '{{ maxHeight }}' => $constraint->maxHeight
                ));

                return false;
            }
        }

        return true;
    }
}