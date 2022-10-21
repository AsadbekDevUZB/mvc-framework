<?php

namespace assaad\core\form;

use assaad\core\Model;

abstract class BaseField
{
    abstract public function renderInput(): string;
    public Model $model;
    public string $attribute;
    /**
     * @param Model $model
     * @param string $attribute
     */
    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }

    public function __toString()
    {
        return sprintf(
            '
            <div class="mb-3">
                <label class="form-label">%s</label>
                    %s
                <div class="invalid-feedback">
                    %s
                </div>        
            </div>
        ',
            $this->model->getLabels($this->attribute),
            $this->renderInput(),
            $this->model->getFirstError($this->attribute)
        );
    }
}