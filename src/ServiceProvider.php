<?php
namespace XndBogdan\BardTextColor;

use Statamic\Statamic;
use Illuminate\Support\Facades\View;
use Statamic\Fieldtypes\Bard\Augmentor;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $scripts = [
        __DIR__.'/../dist/js/textcolor.js',
    ];

    public function boot() {
        parent::boot();

        $this->publishes([
            __DIR__.'/../config/bard-custom-colors.php' => config_path('bard-custom-colors.php'),
        ], 'bard-custom-colors');

        Augmentor::addMark(TextColor::class);

        $colors = [];
        if (!is_null(config('bard-custom-colors.custom_method'))) {
            $colors = call_user_func(config('bard-custom-colors.custom_method'));
        }
        else {
            $colors = config('bard-custom-colors');
        }
        Statamic::provideToScript([
            'bard-custom-colors' => $colors,
        ]);
    }
}
