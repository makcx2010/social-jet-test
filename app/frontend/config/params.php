<?php
return [
    'excludeUserPermissions' => [
        'app_frontend__site__index',
        'auth',
        'user__profile',
        'site',
        'client__public',
        'user__user__access_denied',
        'payment__account__deposit',
        'payment__account__confirm',
        'service__file__download',
        'auth__auth__login_with_token',
        'url__url__redirect_to_long_url',
        'client__public__confirm_change_version',
        'client__public__download',
        'payment__account__payment_order'
    ],
    'companyAccessDeniedUrl' => ['/user/user/access-denied'],
    'urlToCompanySettings'   => ['/user/company/profile'],
    'urlToUploadTemplates'   => ['/service/main/add']
];
