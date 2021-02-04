<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace WebWhales\AlumioWooCommerceConnector\Filter;

use Mediact\DataContainer\DataContainerInterface;
use Mediact\DataContainer\Filter\FilterInterface;
use Mediact\VariableExpander\VariableExpander;
use Mediact\VariableExpander\VariableExpanderInterface;

class CompareTwoValuesFilter implements FilterInterface
{


    /** @var string */
    private $value1;

    /** @var string */
    private $value2;

    private $operation;

    /** @var VariableExpanderInterface */
    private $expander;
    /**
     * Constructor.
     *
     * @param string   $value1
     * @param string   $value2
     * @param string $operation
     */
    public function __construct(
        string $value1,
        string $value2,
        string $operation,

        VariableExpanderInterface $expander = null
    ) {

        $this->operation = $operation;
        $this->value1  = $value1;
        $this->value2  = $value2;
        $this->expander   = $expander ?? new VariableExpander();
    }

    /**
     * Filter the given container.
     *
     * @param DataContainerInterface $container
     *
     * @return bool
     */
    public function __invoke(DataContainerInterface $container): bool
    {
        switch ($this->operation){
            case 'equal':
                return $container->get($this->value1) === $container->get($this->value2);
                break;
            case 'not_equal':
                return $container->get($this->value1) !== $container->get($this->value2);
                break;
            case 'greater':
                return $container->get($this->value1) > $container->get($this->value2);
                break;
            case 'Less':
                return $container->get($this->value1) < $container->get($this->value2);
                break;

        }
        return false;


    }
}
