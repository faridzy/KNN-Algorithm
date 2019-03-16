<?php
/**
 * Created by PhpStorm.
 * User: mfarid
 * Date: 17/03/19
 * Time: 04.10
 */

namespace Faridzy\KNN;


class Dataset

{

    protected $nodes;
    protected $k;
    protected $schema;
    protected $ranges;

    /**
     * Dataset constructor.
     * @param $k
     * @param $schema
     */
    public function __construct($k, Schema $schema)
    {
        $this->k = $k;
        $this->schema = $schema;
        $this->nodes = array();
        $this->ranges = array();
    }


    /**
     * @param Nodes $nodes
     * @return $this
     */
    public  function  add(Nodes $nodes)
    {

        $this->nodes[]=$nodes;

        return $this;

    }

    /**
     * @param Nodes $nodes
     * @param $field
     * @return mixed
     */
    public  function guess(Nodes $nodes, $field)
    {
        $neighbors=$this->nodes;

        $this->calculateDistances($nodes, $neighbors);
        $this->sort($neighbors);
        $hits = array();
        $nearest = array_slice($neighbors, 0, $this->k);
        foreach ($nearest as $neighbor)
        {
            if (!isset($hits[$neighbor->get($field)]))
            {
                $hits[$neighbor->get($field)] = 0;
            }

            $hits[$neighbor->get($field)] += 1;
        }
        $guess = array('value' => false, 'hits' => 0);

        foreach ($hits as $value => $count)
        {
            if ($count > $guess['hits'])
            {
                $guess = array('value' => $value, 'hits' => $count);
            }
        }

        return $guess['value'];


    }

    /**
     *
     */
    protected function calculateRanges()
    {
        $this->ranges = array();

        foreach ($this->schema->getFields() as $field)
        {

            $min = INF;
            $max = 0;

            foreach ($this->nodes as $node)
            {

                if ($node->get($field) < $min)
                {
                    $min = $node->get($field);
                }

                if ($node->get($field) > $max)
                {
                    $max = $node->get($field);
                }
            }

            $this->ranges[$field] = array($min, $max);
        }

    }

    /**
     * Sort by distance
     * @param array $nodes
     */
    protected  function sort(array &$nodes)
    {
        usort(
            $nodes,
            function (Nodes $a, Nodes $b)
            {
                return $a->getDistance() > $b->getDistance();
            }
        );
    }


    /**
     * @param Nodes $nodes
     * @param array $neighbors
     */
    protected  function calculateDistances(Nodes $nodes, array $neighbors)
    {

        $this->calculateRanges();

        foreach ($neighbors as $neighbor)
        {
            $deltaData = array();

            foreach ($this->schema->getFields() as $field)
            {
                list($min, $max) = $this->ranges[$field];
                $range = $max - $min;
                $delta = $neighbor->get($field) - $nodes->get($field);
                $delta = $delta / $range;
                $deltaData[$field] = $delta;
            }

            $total = 0;
            foreach ($deltaData as $delta)
            {
                $total += $delta * $delta;
            }

            $neighbor->setDistance(sqrt($total));
        }

    }






}