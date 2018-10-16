<?php
/**
 * Import Definitions.
 *
 * LICENSE
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) 2016-2018 w-vision AG (https://www.w-vision.ch)
 * @license    https://github.com/w-vision/ImportDefinitions/blob/master/gpl-3.0.txt GNU General Public License version 3 (GPLv3)
 */

namespace ImportDefinitionsBundle\Setter;

use ImportDefinitionsBundle\Getter\GetterInterface;
use Pimcore\Model\DataObject\Concrete;
use ImportDefinitionsBundle\Model\Mapping;

class LocalizedfieldSetter implements SetterInterface, GetterInterface
{
    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function set(Concrete $object, $value, Mapping $map, $data)
    {
        $config = $map->getSetterConfig();

        $setter = explode('~', $map->getToColumn());
        $setter = sprintf('set%s', ucfirst($setter[0]));

        if (method_exists($object, $setter)) {
            $object->$setter($value, $config['language']);
        }
    }

    public function get(Concrete $object, Mapping $map, $data)
    {
        $config = $map->getSetterConfig();

        $getter = explode('~', $map->getToColumn());
        $getter = sprintf('get%s', ucfirst($getter[0]));

        if (method_exists($object, $getter)) {
            return $object->$getter($config['language']);
        }

        return null;
    }
}
