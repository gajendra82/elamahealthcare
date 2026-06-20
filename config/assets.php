<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Canonical public image paths (relative to public/)
    | Linux-safe, lowercase extensions, match files in the repository.
    |--------------------------------------------------------------------------
    */

    'logo' => 'images/logo/logo.jpeg',

    'seo_image' => 'images/logo/logo.jpeg',

    'hero_banners' => [
        ['path' => 'images/banners/hero-1.jpeg', 'title' => 'Global Healthcare Solutions'],
        ['path' => 'images/banners/hero-2.jpeg', 'title' => 'Quality You Can Trust'],
    ],

    'about_preview' => 'images/banners/hero-1.jpeg',

    'about_full' => 'images/banners/hero-2.jpeg',

    'leadership' => [
        'rahul' => 'images/leadership/dr-rahul-kulkarni.jpg',
        'ashwini' => 'images/leadership/dr-ashwini-kulkarni.svg',
    ],

    'csr' => [
        'images/csr/csr-1.jpeg',
        'images/csr/csr-2.jpeg',
    ],

    'certificates' => [
        'images/certificates/company-profile.png',
    ],

    'placeholders' => [
        'default' => 'images/placeholders/default.svg',
        'logo' => 'images/logo/logo.jpeg',
        'product' => 'images/placeholders/product.svg',
        'hero' => 'images/banners/hero-1.jpeg',
        'about' => 'images/banners/hero-1.jpeg',
        'leadership' => 'images/leadership/dr-ashwini-kulkarni.svg',
        'csr' => 'images/csr/csr-1.jpeg',
        'news' => 'images/banners/hero-1.jpeg',
        'certificate' => 'images/certificates/company-profile.png',
    ],

];
