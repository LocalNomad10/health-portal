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
        $hostParts = explode( ".", $req->getHttpHost() );
        
        if( in_array( $hostParts[0], $this->availableLocales ) ) {
          $req->setLocale( $hostParts[0] );
        }
        else {
          $locale = $req->getPreferredLanguage($this->availableLocales);
          $req->setLocale($locale);
        }
    }
}

?>
