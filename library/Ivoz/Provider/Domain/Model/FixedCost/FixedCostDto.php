<?php

namespace Ivoz\Provider\Domain\Model\FixedCost;

class FixedCostDto extends FixedCostDtoAbstract
{
    /**
     * @inheritdoc
     */
    public static function getPropertyMap(string $context = '')
    {
        if ($context === self::CONTEXT_COLLECTION) {
            return [
                'id' => 'id',
                'name' => 'name'
            ];
        }

        return parent::getPropertyMap(...func_get_args());
    }
}
