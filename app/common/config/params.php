<?php
return [
    'adminEmail'                    => env('ADMIN_EMAIL', 'amail@galament.com'),
    'supportEmail'                  => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'cookieValidationKey'           => env('WEB_APP_COOKIE_VALIDATION_KEY', 'cookieValidationKey'),
    'cookieDomain'                  => '.' . env('WEB_APP_DOMAIN', 'edgvr2.local'),
    'frontendHostInfo'              => (env('WEB_APP_HTTP_OPTIONAL', true) ? 'http://' : 'https://') . env(
            'WEB_APP_DOMAIN',
            'edgvr2.local'
        ),
    'backendHostInfo'               => (env('WEB_APP_HTTP_OPTIONAL', true) ? 'http://' : 'https://') . env(
            'WEB_APP_ADMIN_DOMAIN',
            'admin.edgvr2.local'
        ),
    'staticHostInfo'                => (env('WEB_APP_HTTP_OPTIONAL', true) ? 'http://' : 'https://') . env(
            'WEB_APP_STATIC_DOMAIN',
            'static.edgvr2.local'
        ),
    'publicHostInfo'                => (env('WEB_APP_HTTP_OPTIONAL', true) ? 'http://' : 'https://') . env(
            'WEB_APP_PUBLIC_DOMAIN',
            'public.edgvr2.local'
        ),
    'recaptcha.secret'              => '6LdGG8gUAAAAAHufKvA3lhipD0dV2VpYEdJuqVTk',
    'languages'                     => ['ru'],
    'smsModule'                            => [
        'gateways' => [
            [
                'class'   => \core\utilities\Sms\Gateways\Mainsms\MainSmsSender::class,
                'project' => 'Edgvr2',
                'apiKey'  => '3d31b77395a02',
                'isTest'  => false
            ],
            [
                'class'  => \core\utilities\Sms\Gateways\Smsru\SmsRuSender::class,
                'apiKey' => '29E4DB1B-9802-955F-76D3-FB4957035A24',
                'isTest' => false
            ],
            [
                'class'   => \core\utilities\Sms\Gateways\Pushsms\PushSmsSender::class,
                'apiKey'  => 'eyJhbGciOiJIUzI1NiJ9.eyJjdXN0b21lcl9pZCI6OTExLCJkYXRldGltZSI6MTYwMjA3NTIzOH0.jtEuI-DLY8mByuROf_f7vM6ISyrfA22SD_gDerpW5Vs',
                'utmMark' => 'edgvr2'
            ]
        ]
    ],
    'yandexPayment'                        => [
        'shopId'          => '684305',
        'secret'          => 'test_cyHt8h1nZpyl-2sOeurm0WPEp-01icq3FfgbveQOOYQ',
        'confirmationUrl' => '/payment/account/check-status'
    ],
    'mozen'                                => [
        'webhook' => 'https://mozen.tech/api/contracts/1/external/contract/hook',
        'apiKey'  => 'DYpNfUr2.60mLvjVbtcgfdKGYYHFaZGcMfBBHJuDZ'
    ],
    'gotenbergPdfConverter'                => [
        'apiURL' => env('GOTENBERG_API_URL', 'http://doc2pdf:3000')
    ],
    'SendClientAgreementNumberInsteadOfId' => [
        'is_enabled' => false,
        'date'       => '2020-11-20 23:59:59'
    ],
    'minAmountForDeposit'                  => 30,
    'minAmountForInvoice'                  => 500,
];
