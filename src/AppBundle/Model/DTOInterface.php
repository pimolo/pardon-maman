<?php

namespace AppBundle\Model;

use Symfony\Component\PropertyAccess\PropertyAccess;

abstract class DTOInterface
{
    public static function create($values = [])
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $obj = new static();
        foreach ($values as $property => $value) {
            $propertyAccessor->setValue($obj, $property, $value);
        }
    }
}
