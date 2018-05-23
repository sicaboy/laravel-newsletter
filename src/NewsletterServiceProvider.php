<?php

namespace Sicaboy\Newsletter;

use DrewM\MailChimp\MailChimp;
use Illuminate\Support\ServiceProvider;

class NewsletterServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/newsletter.php', 'newsletter');

        $this->publishes([
            __DIR__.'/../config/newsletter.php' => config_path('newsletter.php'),
        ]);
    }

    public function register()
    {
        $this->app->singleton(Newsletter::class, function () {
            $mailChimpCollection = MailChimpCollection::createFromConfig(config('newsletter.apiKeys'));
            $configuredLists = NewsletterListCollection::createFromConfig(config('newsletter'));

            return new Newsletter($mailChimpCollection, $configuredLists);
        });

        $this->app->alias(Newsletter::class, 'newsletter');
    }
}
