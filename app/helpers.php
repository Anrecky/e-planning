<?php


if (!function_exists('layoutConfig')) {
    function layoutConfig()
    {

        if (Request::is('modern-light-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.vlm');
        } else if (Request::is('modern-dark-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.vdm');
        } else if (Request::is('collapsible-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.cm');
        } else if (Request::is('horizontal-light-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.hlm');
        } else if (Request::is('horizontal-dark-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.hlm');
        }

        // RTL

        else if (Request::is('rtl/modern-light-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.vlm-rtl');
        } else if (Request::is('rtl/modern-dark-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.vdm-rtl');
        } else if (Request::is('rtl/collapsible-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.cm-rtl');
        } else if (Request::is('rtl/horizontal-light-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.hlm-rtl');
        } else if (Request::is('rtl/horizontal-dark-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.hdm-rtl');
        }



        // Login

        else if (Request::is('login')) {

            $__getConfiguration = Config::get('app-config.layout.vlm');
        } else {
            $__getConfiguration = Config::get('barebone-config.layout.bb');
        }

        return $__getConfiguration;
    }
}


if (!function_exists('getRouterValue')) {
    function getRouterValue()
    {

        if (Request::is('modern-light-menu/*')) {

            $__getRoutingValue = '/modern-light-menu';
        } else if (Request::is('modern-dark-menu/*')) {

            $__getRoutingValue = '/modern-dark-menu';
        } else if (Request::is('collapsible-menu/*')) {

            $__getRoutingValue = '/collapsible-menu';
        } else if (Request::is('horizontal-light-menu/*')) {

            $__getRoutingValue = '/horizontal-light-menu';
        } else if (Request::is('horizontal-dark-menu/*')) {

            $__getRoutingValue = '/horizontal-dark-menu';
        }

        // RTL

        else if (Request::is('rtl/modern-light-menu/*')) {

            $__getRoutingValue = '/rtl/modern-light-menu';
        } else if (Request::is('rtl/modern-dark-menu/*')) {

            $__getRoutingValue = '/rtl/modern-dark-menu';
        } else if (Request::is('rtl/collapsible-menu/*')) {

            $__getRoutingValue = '/rtl/collapsible-menu';
        } else if (Request::is('rtl/horizontal-light-menu/*')) {

            $__getRoutingValue = '/rtl/horizontal-light-menu';
        } else if (Request::is('rtl/horizontal-dark-menu/*')) {

            $__getRoutingValue = '/rtl/horizontal-dark-menu';
        }

        // Login

        else if (Request::is('login')) {

            $__getRoutingValue = '/modern-light-menu';
        } else {
            $__getRoutingValue = '';
        }


        return $__getRoutingValue;
    }
}


if (!function_exists('terbilang')) {
    function terbilang($number)
    {
        $bilangan = [
            '',
            'satu',
            'dua',
            'tiga',
            'empat',
            'lima',
            'enam',
            'tujuh',
            'delapan',
            'sembilan',
            'sepuluh',
            'sebelas'
        ];

        if ($number < 12) {
            return $bilangan[$number];
        } elseif ($number < 20) {
            return terbilang($number - 10) . ' belas';
        } elseif ($number < 100) {
            return terbilang($number / 10) . ' puluh ' . terbilang($number % 10);
        } elseif ($number < 200) {
            return ' seratus ' . terbilang($number - 100);
        } elseif ($number < 1000) {
            return terbilang($number / 100) . ' ratus ' . terbilang($number % 100);
        } elseif ($number < 2000) {
            return ' seribu ' . terbilang($number - 1000);
        } elseif ($number < 1000000) {
            return terbilang($number / 1000) . ' ribu ' . terbilang($number % 1000);
        } elseif ($number < 1000000000) {
            return terbilang($number / 1000000) . ' juta ' . terbilang($number % 1000000);
        } elseif ($number < 1000000000000) {
            return terbilang($number / 1000000000) . ' milyar ' . terbilang($number % 1000000000);
        } elseif ($number < 1000000000000000) {
            return terbilang($number / 1000000000000) . ' trilyun ' . terbilang($number % 1000000000000);
        } else {
            return 'Maaf, tolong masukkan angka yang lebih kecil.';
        }
    }
}


if (!function_exists('status_receipt')) {
    function status_receipt($var)
    {
        if ($var == "draft") {
            return "<span class='badge badge-light-secondary'>Draft</span>";
        } elseif ($var == "wait-verificator") {
            return "<span class='badge badge-light-warning'>Menunggu Verifikator</span>";
        } elseif ($var == "wait-ppk") {
            return "<span class='badge badge-light-primary'>Menunggu PPK</span>";
        } elseif ($var == "wait-spi") {
            return "<span class='badge badge-light-primary'>Menunggu SPI</span>";
        } elseif ($var == "reject-verificator") {
            return "<span class='badge badge-light-danger'>Tolak Verifikator</span>";
        } elseif ($var == "reject-ppk") {
            return "<span class='badge badge-light-danger'>Tolak PPK</span>";
        } elseif ($var == "reject-spi") {
            return "<span class='badge badge-light-danger'>Tolak SPI</span>";
        } elseif ($var == "accept") {
            return "<span class='badge badge-light-success'>Selesai</span>";
        } else
            return "-";
    }
}
