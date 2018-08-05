<?php
/**
 * @category   PHP
 * @package    intprog
 * @version    1
 * @date       2018-02-19 00:25
 * @author     Konrad, Steve <s.konrad@wingmail.net>
 * @copyright  Copyright © 2018, Intense Programming
 */

namespace IntProg\EnhancedRelationListBundle\Core\FieldType\Attribute;

use IntProg\EnhancedRelationListBundle\Core\RelationAttributeBase;

/**
 * Class Integer.
 *
 * @package   IntProg\EnhancedRelationListBundle\Core\FieldType\Attribute
 * @author    Konrad, Steve <s.konrad@wingmail.net>
 * @copyright 2018 Intense Programming
 */
class Integer extends RelationAttributeBase
{
    /** @var integer $value */
    public $value;

    /**
     * Integer constructor.
     *
     * @param array $properties
     */
    public function __construct(array $properties = [])
    {
        parent::__construct($properties);

        if (is_numeric($this->value)) {
            $this->value = (int) $this->value;
        }
    }

    /**
     * Returns the type identifier of the relation attribute.
     *
     * @return string
     */
    public function getTypeIdentifier()
    {
        return 'integer';
    }
}
