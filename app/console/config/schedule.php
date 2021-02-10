<?php
/**
 * @var \omnilight\scheduling\Schedule $schedule
 */
$schedule->command('telegram/test')->cron();
$schedule->command('tariff-payment/check-low-balance')->everyTenMinutes();
