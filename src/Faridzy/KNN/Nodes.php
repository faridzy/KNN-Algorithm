<?php
/**
 * Created by PhpStorm.
 * User: mfarid
 * Date: 17/03/19
 * Time: 04.11
 */

namespace Faridzy\KNN;


class Nodes
{

    protected $data = array();
    protected $neighbors;
    protected $distance;

    /**
     * Nodes constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->neighbors = array();
        $this->distance = 1;
    }


    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getNeighbors()
    {
        return $this->neighbors;
    }

    /**
     * @param mixed $neighbors
     */
    public function setNeighbors($neighbors)
    {
        $this->neighbors = $neighbors;
    }

    /**
     * @return mixed
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param mixed $distance
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }


    /**
     * @param $field
     * @return mixed|null
     */
    public function get($field)
    {
        if (!isset($this->data[$field])) {
            return null;
        }
        return $this->data[$field];
    }







}