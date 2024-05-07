<?php
namespace Plugin\dh_matomo_tracking\classes;

use JTL\Cart\Cart;
use JTL\Catalog\Product\Artikel;
use JTL\Checkout\Bestellung;
use MatomoTracker;

class ShopTracking {
    private int $siteId;
    private string $instanceUrl;
    private string $authenticationToken;
    private MatomoTracker $matomoTracker;
    private string $pageUrl;
    private string $languageCode;
    private ?Artikel $productViewed = null;

    /**
     * Get the value of siteId
     * @return int
     */
    public function getSiteId(): int {
        return $this->siteId;
    }

    /**
     * Set the value of siteId
     * @param int $siteId
     * @return self
     */
    public function setSiteId(int $siteId): self {
        $this->siteId = $siteId;
        return $this;
    }

    /**
     * Get the value of instanceUrl
     * @return string
     */
    public function getInstanceUrl(): string {
        return $this->instanceUrl;
    }

    /**
     * Set the value of instanceUrl
     * @param string $instanceUrl
     * @return self
     */
    public function setInstanceUrl(string $instanceUrl): self {
        $this->instanceUrl = $instanceUrl;
        return $this;
    }

    /**
     * Get the value of authenticationToken
     * @return string
     */
    public function getAuthenticationToken(): string {
        return $this->authenticationToken;
    }

    /**
     * Set the value of authenticationToken
     * @param string $authenticationToken
     * @return self
     */
    public function setAuthenticationToken(string $authenticationToken): self {
        $this->authenticationToken = $authenticationToken;
        return $this;
    }

    /**
     * Get the value of matomoTracker
     * @return MatomoTracker
     */
    public function getMatomoTracker(): MatomoTracker {
        return $this->matomoTracker;
    }

    /**
     * Set the value of matomoTracker
     * @param MatomoTracker $matomoTracker
     * @return self
     */
    public function setMatomoTracker(MatomoTracker $matomoTracker): self {
        $this->matomoTracker = $matomoTracker;
        return $this;
    }

    public function createTracker(): self {
        $newTracker = new MatomoTracker($this->getSiteId(), $this->getInstanceUrl());
        $newTracker->configCookiesDisabled = true;
        $newTracker->setTokenAuth($this->getAuthenticationToken());
        $this->matomoTracker = $newTracker;
        return $this;
    }

    public function addCartItem(Artikel $product, int $quantity = 0)
    {
        $this->addCartItemCustom($product->cArtNr, $product->cName, $product->Preise->fVKBrutto, $quantity);
    }

    public function addCartItemCustom(string $cArtNr, string $cName, float $fPreis = 0, int $quantity = 0)
    {
        $this->matomoTracker->addEcommerceItem($cArtNr, $cName, '', $fPreis, $quantity);
    }

    public function addOrder(Bestellung $order)
    {
        $this->matomoTracker->doTrackEcommerceOrder($order->cBestellNr, $order->fGesamtsumme, 0.0, 0.0, 0.0, 0.0);
    }

    public function completeTracking()
    {
        if($this->matomoTracker === null) {
            return;
        }
        
        if($this->getProductViewed() !== null) {
            // Todo Add category details
            $this->matomoTracker->setEcommerceView($this->getProductViewed()->cArtNr, $this->getProductViewed()->cName, '', $this->getProductViewed()->Preise->fVKNetto);
        }

        if($this->getPageUrl() !== null) {
            $this->matomoTracker->doTrackPageView($this->getPageUrl());
        }

        if($this->getLanguageCode() !== null) {
            $this->matomoTracker->setBrowserLanguage($this->getLanguageCode());
        }
    }

    /**
     * Get the value of pageUrl
     * @return string
     */
    public function getPageUrl(): string {
        return $this->pageUrl;
    }

    /**
     * Set the value of pageUrl
     * @param string $pageUrl
     * @return self
     */
    public function setPageUrl(string $pageUrl): self {
        $this->pageUrl = $pageUrl;
        return $this;
    }

    /**
     * Get the value of languageCode
     * @return string
     */
    public function getLanguageCode(): string {
        return $this->languageCode;
    }

    /**
     * Set the value of languageCode
     * @param string $languageCode
     * @return self
     */
    public function setLanguageCode(string $languageCode): self {
        $this->languageCode = $languageCode;
        return $this;
    }

    /**
     * Get the value of product
     * @return Artikel
     */
    public function getProductViewed(): ?Artikel {
        return $this->productViewed;
    }

    /**
     * Set the value of product
     * @param Artikel $product
     * @return self
     */
    public function setProductViewed(?Artikel $product): self {
        $this->productViewed = $product;
        return $this;
    }
}
