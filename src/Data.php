<?php

namespace App;

use Fal\Stick\Form\Field;
use Fal\Stick\Fw;

class Data
{
    const YES = array(
        'Yes' => 1,
        'No' => 0,
    );
    const ROLES = array(
        'ROLE_ADMIN' => 'ROLE_ADMIN',
        'ROLE_USER' => 'ROLE_USER',
    );
    const TIMES = array(
        'Minutes' => 'minutes',
        'Hours' => 'hours',
        'Days' => 'days',
        'Weeks' => 'weeks',
        'Months' => 'months',
    );

    public static function choose(Fw $fw, $value, $constant)
    {
        $name = 'self::'.strtoupper($constant);

        return defined($name) && ($found = array_search($value, constant($name))) ? $found : $value;
    }

    public static function mapper(Fw $fw, Field $field)
    {
        if (!$field->has('mapper_name') || !$field->has('mapper_label')) {
            throw new \LogicException('Items need mapper and label.');
        }

        $items = array();
        $mapper = $fw->mapper($field->get('mapper_name'));
        $label = $field->get('mapper_label');
        $call = is_callable($label);
        $filters = $field->has('mapper_filters') ? $field->get('mapper_filters') : null;
        $options = $field->has('mapper_options') ? $field->get('mapper_options') : null;
        $ttl = $field->has('mapper_ttl') ? $field->get('mapper_ttl') : 0;
        $id = $field->has('mapper_id') ? $field->get('mapper_id') : 'id';

        foreach ($mapper->find($filters, $options, $ttl) as $item) {
            $key = $call ? $label($item) : $item[$label];
            $items[$key] = $item[$id];
        }

        return $items;
    }

}
