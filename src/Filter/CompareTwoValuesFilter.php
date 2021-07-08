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

    /** @var string */
    private $operation;

    /**
     * @var \Mediact\VariableExpander\VariableExpander|\Mediact\VariableExpander\VariableExpanderInterface
     */
    private $expander;

    /**
     * CompareTwoValuesFilter constructor.
     *
     * @param string                                                   $value1
     * @param string                                                   $value2
     * @param string                                                   $operation
     * @param \Mediact\VariableExpander\VariableExpanderInterface|null $expander
     */
    public function __construct(
        string $value1,
        string $value2,
        string $operation,
        VariableExpanderInterface $expander = null
    ) {

        $this->operation = $operation;
        $this->value1    = $value1;
        $this->value2    = $value2;
        $this->expander  = $expander ?? new VariableExpander();
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
        switch ($this->operation) {
            case 'equal':
                return $container->get($this->value1) === $container->get($this->value2);
            case 'in_array':
                return in_array($container->get($this->value2), $container->get($this->value1));
            case 'not_in_array':
                return ! in_array($container->get($this->value2), $container->get($this->value1));
            case 'not_equal':
                return $container->get($this->value1) !== $container->get($this->value2);
            case 'greater':
                return $container->get($this->value1) > $container->get($this->value2);
            case 'Less':
                return $container->get($this->value1) < $container->get($this->value2);
        }

        return false;
    }
}
