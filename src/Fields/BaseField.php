<?php

namespace Jdlabs\Spaniel\Fields;


use Jdlabs\Spaniel\Utils\Config;

abstract class BaseField
{
    /**
     * @var string
     */
    protected string $id;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string
     */
    protected string $title;

    /**
     * @var string
     */
    protected string $options;

    /**
     * @var string
     */
    protected string $type;

    /**
     * @var bool
     */
    protected bool $required;

    /**
     * @var string
     */
    protected string $options_group;

    /**
     * @var string
     */
    protected string $classes = '';

    /**
     * Constructor.
     * @param string $id
     * @param string $options_group
     * @param string|null $title
     */
    public function __construct(string $id, string $options_group, ?string $title)
    {
        $this->setId($id);
        $this->setOptionsGroup($options_group);
        $this->title = $title ?: 'Field';
    }

    /**
     * @return string
     */
    protected function renderRequired(): string
    {
        return $this->isRequired() ? 'required' : '';
    }

    /**
     * @return string
     */
    protected function renderValue(): string
    {
        $value = $this->getValue();
        return $value ? 'value=' . esc_attr($this->getValue()) : '';
    }

    /**
     * @return mixed
     */
    public function render()
    {
        echo "<div>
        <input type='{$this->getType()}' 
            class='{$this->getClasses()}'
            id='{$this->getOptionId()}'
            {$this->renderRequired()}
            {$this->renderValue()}
            name='{$this->getOptionId()}'>
        </div>";
    }

    /**
     * @return mixed|null
     */
    public function getValue()
    {
        return get_option($this->getOptionId());
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return BaseField
     */
    public function setId(string $id): BaseField
    {
        if (!isset($this->name)) {
            $this->name = $id;
        }

        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return BaseField
     */
    public function setName(string $name): BaseField
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getOptions(): string
    {
        return $this->options;
    }

    /**
     * @param string $options
     * @return BaseField
     */
    public function setOptions(string $options): BaseField
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return BaseField
     */
    public function setType(string $type): BaseField
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return BaseField
     */
    public function setTitle(string $title): BaseField
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required ?? false;
    }

    /**
     * @param bool $required
     * @return BaseField
     */
    public function setRequired(bool $required): BaseField
    {
        $this->required = $required;
        return $this;
    }

    /**
     * @return string
     */
    public function getOptionsGroup(): string
    {
        return $this->options_group;
    }

    /**
     * @param string $options_group
     * @return BaseField
     */
    public function setOptionsGroup(string $options_group): BaseField
    {
        $this->options_group = $options_group;
        return $this;
    }

    /**
     * @return string
     */
    public function getOptionId(): string
    {
        $prefix = Config::configPrefix();
        return "{$prefix}{$this->getId()}";
    }

    /**
     * @param string $classes
     * @return BaseField
     */
    public function setClasses(string $classes): BaseField
    {
        $this->classes = $classes;
        return $this;
    }

    /**
     * @return string
     */
    public function getClasses(): string
    {
        return $this->classes;
    }

}