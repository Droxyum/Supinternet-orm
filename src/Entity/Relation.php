<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 11/12/15
 * Time: 15:46
 */

namespace ORM\Entity;


class Relation
{
    const ManyToOne = 'ManyToOne';
    const OneToMany = 'OneToMany';
    const OneToOne = 'OneToOne';
    const ManyToMany = 'ManyToMany';

    private $EntityStart;
    private $EntityEndNamespace;
    private $relationType;

    public function __construct(&$EntityStart, $EntityEndNamespace, $relationType)
    {
        $this->EntityStart = $EntityStart;
        $this->EntityEndNamespace = $EntityEndNamespace;
        $this->relationType = $relationType;
    }
}