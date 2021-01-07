<?php


namespace Jdlabs\Spaniel\Traits;


trait InteractsWithBlocks
{
    /**
     * @param string $block_key
     * @param array $block
     */
    public function registerBlock(string $block_key, array $block)
    {
        block_lab_add_block($block_key, $block);
    }

    /**
     * @param array $array
     * @param string $key
     * @return array|array[]
     */
    protected static function toBlockOptions(array $array, string $key = 'id')
    {
        return array_map(static function (array $item) use ($key) {
            return [
                'label' => $item['name'],
                'value' => $item[$key]
            ];
        }, $array);
    }

    /**
     * @param array|null $options
     * @param string $id
     * @return mixed|null
     */
    protected static function findLabel(?array $options, string $id)
    {
        if (!$options) {
            return null;
        }

        $filtered_options = array_filter($options, static function ($option) use ($id) {
            return $option['value'] == $id;
        });

        return $filtered_options[array_key_first($filtered_options)]['label'] ?? null;
    }
}