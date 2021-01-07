<?php


namespace Jdlabs\Spaniel\Actions;

use Jdlabs\Spaniel\Fields\BaseField;
use Jdlabs\Spaniel\Utils\Singleton;

abstract class BaseAction extends Singleton
{

    /**
     * @param array $fields
     * @param string $page
     * @param string $section
     */
    public static function registerFieldsGroup(array $fields, string $page, string $section)
    {
        foreach ($fields as $field) {
            add_settings_field(
                $field->getOptionId(),
                $field->getTitle(),
                [
                    static::class,
                    'renderField',
                ],
                $page,
                $section,
                [
                    'field' => serialize($field)
                ]
            );

            register_setting($page, $field->getOptionId());
        }
    }

    /**
     * @param array $args
     */
    public function renderField(array $args)
    {
        /** @var BaseField $field */
        $field = unserialize($args['field']);
        $field->render();
    }
}