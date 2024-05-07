<?php declare(strict_types=1);
/**
 * @package Plugin\dh_matomo_tracking
 * @author Dennis Heinrich
 */

namespace Plugin\dh_matomo_tracking;

use JTL\Events\Dispatcher;
use JTL\Plugin\Bootstrapper;
use JTL\Shop;
use Plugin\dh_matomo_tracking\classes\ShopTracking;

/**
 * Class Bootstrap
 * @package Plugin\dh_matomo_tracking
 */
class Bootstrap extends Bootstrapper
{
    private ShopTracking $shopTracking;

    /**
     * Executed on each plugin call (e.g. on each page visit)
     * @param Dispatcher $dispatcher
     * @return void
     */
    public function boot(Dispatcher $dispatcher): void
    {
        parent::boot($dispatcher);
        try {
            if($this->runComposerAutoload() && Shop::isFrontend()) {
                $matomoSiteId = (int)$this->getPlugin()->getConfig()->getValue("site_id");
                $matomoInstanceUrl = (string)$this->getPlugin()->getConfig()->getValue("instance_url");
                $matomoAuthenticationToken = (string)$this->getPlugin()->getConfig()->getValue("authentication_token");

                if($matomoSiteId > 0 && strlen($matomoInstanceUrl) > 0 && strlen($matomoAuthenticationToken) > 0) {
                    $this->shopTracking = (new ShopTracking())
                        ->setInstanceUrl($matomoInstanceUrl)
                        ->setAuthenticationToken($matomoAuthenticationToken)
                        ->setSiteId($matomoSiteId)
                        ->createTracker();
                    
                    $fullProtocolDomainAndPath = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                    $this->shopTracking->setPageUrl($fullProtocolDomainAndPath);
                    $this->shopTracking->setLanguageCode($_SESSION['currentLanguage']->iso639);
                    
                    $dispatcher->listen('shop.hook.'.HOOK_BESTELLABSCHLUSS_PAGE, function($args) {
                        /** @var \JTL\Checkout\Bestellung */
                        $order = $args['oBestellung'];
                        $orderPositions = $order->Positionen;
                        foreach($orderPositions as $orderPosition) {
                            try {
                                if(isset($orderPosition->Artikel)) {
                                    $this->shopTracking->addCartItem($orderPosition->Artikel, $orderPosition->nAnzahl);
                                } else {
                                    switch($orderPosition->nPosTyp) {
                                        case C_WARENKORBPOS_TYP_VERSANDPOS:
                                            $shippingCosts = (float)($orderPosition->fPreis * ($orderPosition->fMwSt/10));
                                            $shippingCosts *= $orderPosition->nAnzahl;
                                            $this->shopTracking->addCartItemCustom("", "Versandkosten", $shippingCosts, $orderPosition->nAnzahl);
                                            break;
                                    }
                                }
                            } catch(\Exception $e) {
                                Shop::Container()->getLogService()->error("Fehler beim Hinzufügen eines Artikels zum Matomo-Tracking: " . $e->getMessage());
                            }
                        }
                        $this->shopTracking->addOrder($order);
                    });

                    $dispatcher->listen('shop.hook.'.HOOK_ARTIKEL_PAGE, function($args) {
                        try {
                            $this->shopTracking->setProductViewed($args['oArtikel']);
                        } catch(\Exception $e) {
                            Shop::Container()->getLogService()->error("Fehler beim Setzen des angezeigten Artikels im Matomo-Tracking: " . $e->getMessage());
                        }
                    });

                    $dispatcher->listen('shop.hook.'.HOOK_SMARTY_OUTPUTFILTER, function($args) {
                        try {
                            $this->shopTracking->completeTracking();
                        } catch(\Exception $e) {
                            Shop::Container()->getLogService()->error("Fehler beim Abschließen des Trackings: " . $e->getMessage());
                        }
                    });
                } else {
                    Shop::Container()->getLogService()->error("Das Plugin dh_matomo_tracking wurde nicht vollständig konfiguriert.");
                }
            } else {
                Shop::Container()->getLogService()->error("Das Plugin dh_matomo_tracking wurde nicht korrekt installiert, die Composer-Abhängigkeiten fehlen");
            }
        } catch(\Exception $e) {
            Shop::Container()->getLogService()->error("Fehler beim Initialisieren des Matomo-Trackings: " . $e->getMessage());
        }
    }

    private function runComposerAutoload(): bool
    {
        $autoloadFilePath = __DIR__ ."/vendor/autoload.php";
        if(file_exists($autoloadFilePath)) {
            require_once $autoloadFilePath;
            return true;
        }
        return false;
    }
}
