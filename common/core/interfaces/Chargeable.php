<?php
/**
 * @author Valentin Konusov <rlng-krsk@yandex.ru>
 */

namespace common\core\interfaces;

interface Chargeable
{
    /**
     * Return overall cost
     *
     * @return mixed
     */
    public function getCost();
}