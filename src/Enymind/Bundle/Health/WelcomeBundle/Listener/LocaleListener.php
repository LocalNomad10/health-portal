<?php

namespace Enymind\Bundle\Health\WelcomeBundle\Listener;

class LocaleListener
{
    protected $container;
    protected $availableLocales;

    public function __construct(\Symfony\Component\DependencyInjection\Container $container, $availableLocales) {
        $this->container = $container;
        $this->availableLocales = $availableLocales;
    }

    public function onKernelRequest(\Symfony\Component\HttpKernel\Event\GetResponseEvent $e) {
        $req = $e->getRequest();
        $locale = $req->getPreferredLanguage($this->availableLocales);
        $session = $this->container->get('session');
        $session->setLocale($locale);
    }
}

?>
