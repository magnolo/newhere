<?php
/**
 * @category   <category>
 * @package    App\Services
 * @author     Martin Ras <mr@easyname.com>
 * @copyright  2006-2016 easyname GmbH (http://www.easyname.com)
 * @license    easyname License Agreement
 */
namespace App\Services;

use Illuminate\Contracts\Support\Arrayable;

class Category
{
    public function prepareForResponse($data)
    {
        $return = [];
        if ($data instanceof \App\Category) {
            $return = $data->toArray();
            $translations = $data->translations()->getResults();
            foreach ($translations as $t) {
                $t->load('language');
                $return['translations'][] = $t->toArray();
            }

            $children = $data->children()->getResults();
            foreach ($children as $c) {
                $return['children'][] = $this->prepareForResponse($c);
            }
        } else if ($data instanceof Arrayable) {
            foreach ($data as $item) {
                $return[] = $this->prepareForResponse($item);
            }
        }

        return $return;
    }
}