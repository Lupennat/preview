1. [Requirements](#Requirements)
2. [Installation](#Installation)
3. [Usage](#Usage)
    1. [When Method](#when-method)
    2. [Is Method](#is-method)

## Requirements

- `php: ^7.4 | ^8`
- `laravel/nova: ^4`

## Installation

You can install the package in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require lupennat/preview
```

## Usage

Preview Field can be used to Display a Detail Field on Index Page in a dropdown (like Nova BooleanGroup Field Behaviour). On Detail Page, the field will be always displayed as native field, on Form pages the Field will not be displayed.

### When Method

You can use `when` method to switch between preview/inline mode at specific condition.\
If a string will be returned from callback, the string will be used as text for the dropdown button.

```php

use Illuminate\Support\Str;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Lupennat\Preview\Preview;

class Post extends Resource
{

    public function fields(Request $request)
    {
        return [
            Preview::make(__('Title'), 'title')->when(
                fn($value, $resource, $attribute) => strlen($value) > 20 ? Str::limit($value, 20) : false,
                Text::make(__('Title'), 'title')
            )
        ];
    }
}
```


### Is Method

You can use `is` method to always display a field as preview.

```php

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Lupennat\Preview\Preview;

class Post extends Resource
{

    public function fields(Request $request)
    {
        return [
            Preview::make(__('Description'), 'description')
                ->is(Text::make(__('Description'), 'description'))
                ->withPreviewLabel(__('View Description'))
        ];
    }
}
```
