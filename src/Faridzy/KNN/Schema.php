<?php
/**
 * Created by PhpStorm.
 * User: mfarid
 * Date: 17/03/19
 * Time: 04.11
 */

namespace Faridzy\KNN;


class Schema
{
    protected  $fields = array();

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     */
    public function setFields($field)
    {
        $this->fields[] = $field;

        return $this;
    }

}