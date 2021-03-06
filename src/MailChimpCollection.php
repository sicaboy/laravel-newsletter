<?php

namespace Sicaboy\Newsletter;

use Illuminate\Support\Collection;
use DrewM\MailChimp\MailChimp;

class MailChimpCollection extends Collection
{

    public static function createFromConfig(array $config): self
    {
        $collection = new static();

        foreach ($config as $name => $apiKey) {
            $mailChimp = new Mailchimp($apiKey);
            $mailChimp->verify_ssl = config('newsletter.ssl', true);
            $collection->put($name, $mailChimp);
        }

        return $collection;
    }

    public function findByName(string $name): MailChimp
    {
        if(!$this->get($name)){
            throw new \Exception('Cannot find MailChimp object with name: ' . $name);
        }
        return$this->get($name);
    }

    public function getDefault(): MailChimp
    {
        return current($this->items);
    }
}
