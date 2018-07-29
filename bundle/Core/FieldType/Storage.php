<?php
/**
 * @category   PHP
 * @package    intprog
 * @version    1
 * @date       2018-07-28 18:48
 * @author     Konrad, Steve <s.konrad@wingmail.net>
 * @copyright  Copyright © 2018, Intense Programming
 */

namespace IntProg\EnhancedRelationListBundle\Core\FieldType;

use eZ\Publish\SPI\FieldType\GatewayBasedStorage;
use eZ\Publish\SPI\Persistence\Content\Field;
use eZ\Publish\SPI\Persistence\Content\Type as FieldType;
use eZ\Publish\SPI\Persistence\Content\Type\Handler;
use eZ\Publish\SPI\Persistence\Content\VersionInfo;

/**
 * Class Storage.
 *
 * @package   IntProg\EnhancedRelationListBundle\Core\FieldType
 * @author    Konrad, Steve <s.konrad@wingmail.net>
 * @copyright 2018 Intense Programming
 */
class Storage extends GatewayBasedStorage
{
    /** @var Handler $contentTypeHandler */
    protected $contentTypeHandler;

    /** @var array $languages */
    protected $languages;

    /**
     * Storage constructor.
     *
     * @param Handler $contentTypeHandler
     * @param array   $languages
     */
    public function __construct(Handler $contentTypeHandler, array $languages)
    {
        $this->languages          = $languages;
        $this->contentTypeHandler = $contentTypeHandler;
    }

    public function storeFieldData(VersionInfo $versionInfo, Field $field, array $context)
    {
        return;
    }

    public function getFieldData(VersionInfo $versionInfo, Field $field, array $context)
    {
        $fieldDefinition = $this->contentTypeHandler->getFieldDefinition(
            $field->fieldDefinitionId,
            FieldType::STATUS_DEFINED
        );

        $groups     = $fieldDefinition->fieldTypeConstraints->fieldSettings['groupSettings']['groups'];
        $groupValue = [];
        foreach ($groups as $identifier => $group) {
            foreach ($this->languages as $language) {
                if (isset($group[$language])) {
                    $groupName = $group[$language];
                }
            }
            if (!isset($groupName)) {
                $groupName = reset($group);
            }

            if (!isset($field->value->data['groups'][$identifier])) {
                $groupValue[$identifier] = [
                    'name'      => $groupName,
                    'relations' => [],
                ];
            } else {
                $groupValue[$identifier] = [
                    'name'      => $groupName,
                    'relations' => $field->value->data['groups'][$identifier],
                ];
            }

            unset($groupName);
        }

        foreach ($field->value->data['groups'] as $identifier => $relations) {
            if (!isset($groups[$identifier])) {
                $groupValue[$identifier] = [
                    'name'      => $identifier,
                    'relations' => $relations,
                ];
            }
        }

        $field->value->data['groups'] = $groupValue;
    }

    public function deleteFieldData(VersionInfo $versionInfo, array $fieldIds, array $context)
    {
        return;
    }

    public function hasFieldData()
    {
        return true;
    }

    public function getIndexData(VersionInfo $versionInfo, Field $field, array $context)
    {
        return false;
    }
}