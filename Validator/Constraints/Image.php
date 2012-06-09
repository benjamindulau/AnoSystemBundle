<?php

namespace Ano\Bundle\SystemBundle\Validator\Constraints;

class Image extends \Symfony\Component\Validator\Constraints\File
{
    public $mimeTypes = array(
        'image/png',
        'image/jpg',
        'image/jpeg',
        'image/pjpeg',
        'image/gif',
    );
    public $minWidth = null;
    public $maxWidth = null;
    public $maxHeight = null;
    public $minHeight = null;

    public $mimeTypesMessage = 'This file is not a valid image';
    public $notDetectedMessage = 'The size of image could not be detected';
    public $maxWidthMessage = 'The image width is too big ({{ width }}px). Allowed maximum width is {{ maxWidth }}px';
    public $minWidthMessage = 'The image width is too small ({{ width }}px). Minimum width expected is {{ minWidth }}px';
    public $maxHeightMessage = 'The image height is too big ({{ height }}px). Allowed maximum width is {{ maxHeight }}px';
    public $minHeightMessage = 'The image width is too small ({{ height }}px). Minimum height expected is {{ minHeight }}px';
}
