<?php

namespace App\Services;

class SeoService
{
    public function __construct(
        private readonly SettingService $settingService,
        private readonly AssetService $assetService,
    ) {}

    public function defaults(): array
    {
        return [
            'title' => $this->settingService->get(
                'seo_default_title',
                'Elama Healthcare Solutions Pvt. Ltd.'
            ),
            'description' => $this->settingService->get(
                'seo_default_description',
                'Global Healthcare Solutions Built on Trust, Quality & Innovation. Delivering affordable quality pharmaceutical products across the globe.'
            ),
            'image' => $this->assetService->seoImageUrl(),
            'canonical' => url()->current(),
            'type' => 'website',
            'schema' => $this->organizationSchema(),
        ];
    }

    public function forPage(
        string $title,
        ?string $description = null,
        ?string $image = null,
        ?string $canonical = null,
        string $type = 'website',
        ?array $schema = null
    ): array {
        $defaults = $this->defaults();

        return [
            'title' => $title,
            'description' => $description ?? $defaults['description'],
            'image' => $image ? $this->assetService->url($image, 'logo') : $defaults['image'],
            'canonical' => $canonical ?? url()->current(),
            'type' => $type,
            'schema' => $schema ?? $this->organizationSchema(),
        ];
    }

    public function organizationSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $this->settingService->get('company_name', 'Elama Healthcare Solutions Pvt. Ltd.'),
            'url' => url('/'),
            'logo' => $this->assetService->logoUrl(),
            'description' => $this->settingService->get(
                'seo_default_description',
                'Global Healthcare Solutions Built on Trust, Quality & Innovation.'
            ),
            'foundingDate' => $this->settingService->get('company_founded', '1986'),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $this->settingService->get(
                    'contact_address',
                    config('contact.address')
                ),
                'addressLocality' => config('contact.locality'),
                'addressRegion' => config('contact.region'),
                'addressCountry' => config('contact.country'),
            ],
            'telephone' => $this->settingService->get('contact_phone', config('contact.phone')),
            'email' => $this->settingService->get('contact_email', config('contact.email')),
            'sameAs' => array_values(array_filter([
                $this->settingService->get('social_linkedin'),
                $this->settingService->get('social_facebook'),
                $this->settingService->get('social_twitter'),
            ])),
        ];
    }

    public function productSchema(array $product): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product['name'] ?? $product['product_name'] ?? '',
            'description' => $product['description'] ?? $product['name'] ?? '',
            'category' => $product['category'] ?? '',
            'image' => $product['image'] ?? asset_url(config('assets.logo'), 'logo'),
            'brand' => [
                '@type' => 'Brand',
                'name' => $this->settingService->get('company_name', 'Elama Healthcare Solutions Pvt. Ltd.'),
            ],
        ];
    }
}
