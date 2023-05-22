<?php

namespace Lupennat\Preview;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class Preview extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'preview';

    /**
     * The field's preview callback.
     *
     * @var (callable(mixed, mixed,):(bool|string))|bool|string
     */
    public $previewCallback = false;

    /**
     * Preview Button Label.
     *
     * @var string|null
     */
    public $previewLabel = null;

    /**
     * Preview Field to Show.
     *
     * @var Field
     */
    public $previewField;

    /**
     * Indicates if the element should be shown on the creation view.
     *
     * @var (callable(\Laravel\Nova\Http\Requests\NovaRequest):(bool))|bool
     */
    public $showOnCreation = false;

    /**
     * Indicates if the element should be shown on the update view.
     *
     * @var (callable(\Laravel\Nova\Http\Requests\NovaRequest, mixed):(bool))|bool
     */
    public $showOnUpdate = false;

    /**
     * The field's preview.
     *
     * @return $this
     */
    public function is(Field $field)
    {
        return $this->when(true, $field);
    }

    /**
     * Change Preview Label.
     *
     * @return $this
     */
    public function withPreviewLabel(string $previewLabel)
    {
        $this->previewLabel = $previewLabel;

        return $this;
    }

    /**
     * The Field preview condition.
     *
     * @param  (callable(mixed):(bool|string))|bool|string $previewCallback
     *
     * @return $this
     */
    public function when($previewCallback, Field $field)
    {
        $this->previewCallback = $previewCallback;
        $this->previewField = $field;

        return $this;
    }

    /**
     * Resolve the field's value for display.
     *
     * @param mixed       $resource
     * @param string|null $attribute
     *
     * @return void
     */
    public function resolveForDisplay($resource, $attribute = null)
    {
        parent::resolveForDisplay($resource, $attribute);

        $this->previewField->resolveForDisplay($resource, $attribute);

        if ($this->previewCallback === true) {
            $this->makeFieldPreviewable();
        } elseif (is_callable($this->previewCallback)) {
            $resolvedPreview = call_user_func($this->previewCallback, $this->value, $this->resource, $attribute ?? $this->attribute);
            if ($resolvedPreview) {
                if (is_string($resolvedPreview)) {
                    $this->previewLabel = $resolvedPreview;
                }

                $this->makeFieldPreviewable();
            }
        }
    }

    /**
     * Make Field Previewable.
     *
     * @return void
     */
    protected function makeFieldPreviewable()
    {
        $this->previewField->withMeta([
            'originalComponent' => $this->previewField->component(),
            'previewLabel' => $this->previewLabel,
        ]);
        $this->previewField->component = 'preview';
        $this->previewField->exceptOnForms();
    }

    /**
     * Check for showing when updating.
     *
     * @param mixed $resource
     */
    public function isShownOnUpdate(NovaRequest $request, $resource): bool
    {
        return false;
    }

    /**
     * Check for showing when creating.
     */
    public function isShownOnCreation(NovaRequest $request): bool
    {
        return false;
    }

    /**
     * Prepare the field for JSON serialization.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->previewField->jsonSerialize();
    }
}
