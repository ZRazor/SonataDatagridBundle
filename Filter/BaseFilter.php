<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\DatagridBundle\Filter;

/**
 * Class BaseFilter
 */
abstract class BaseFilter implements FilterInterface
{
    protected $name = null;

    protected $value = null;

    protected $options = array();

    protected $condition;

    /**
     * {@inheritdoc}
     */
    public function initialize($name, array $options = array())
    {
        $this->name = $name;
        $this->setOptions($options);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormName()
    {
        /* Symfony default form class sadly can't handle
           form element with dots in its name (when data
           get bound, the default dataMapper is a PropertyPathMapper).
           So use this trick to avoid any issue.
        */

        return str_replace('.', '__', $this->name);
    }

    /**
     * {@inheritdoc}
     */
    public function getOption($name, $default = null)
    {
        if (array_key_exists($name, $this->options)) {
            return $this->options[$name];
        }

        return $default;
    }

    /**
     * {@inheritdoc}
     */
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldType()
    {
        return $this->getOption('field_type', 'text');
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldOptions()
    {
        return $this->getOption('field_options', array('required' => false));
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return $this->getOption('label');
    }

    /**
     * {@inheritdoc}
     */
    public function setLabel($label)
    {
        $this->setOption('label', $label);
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldName()
    {
        $fieldName = $this->getOption('field_name');

        if (!$fieldName) {
            throw new \RunTimeException(sprintf('The option `field_name` must be set for field : `%s`', $this->getName()));
        }

        return $fieldName;
    }

    /**
     * @param array $options
     *
     * @return void
     */
    public function setOptions(array $options)
    {
        $this->options = array_merge($this->getDefaultOptions(), $options);
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param mixed $value
     *
     * @return void
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function isActive()
    {
        $values = $this->getValue();

        return isset($values['value'])
        && false !== $values['value']
        && "" !== $values['value'];
    }

    /**
     * @param string $condition
     *
     * @return void
     */
    public function setCondition($condition)
    {
        $this->condition = $condition;
    }

    /**
     * @return string
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * {@inheritDoc}
     */
    public function getTranslationDomain()
    {
        return $this->getOption('translation_domain');
    }
}
