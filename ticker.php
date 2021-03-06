#!/usr/bin/php
<?php
$baseUrl = "https://min-api.cryptocompare.com/data/price?fsym=%s&tsyms=USD";

$waitTime = (isset($argv[1])) ? $argv[1] : 180;

$currencyArray = ['Bitcoin' => 'BTC',
                    'Ethereal' => 'ETH',
                    'Litecoin' => 'LTC'];


while (true) {
    $dateTime = new DateTime('now');
    $dt = sprintf("%s", $dateTime->format("h:i:s A"));

    $titleStr = "CryptoTicker - {$dt}";

    $strArr = [];
    foreach($currencyArray as $k => $v) {
        $strArr[] = "$k Price: $" .  number_format((float)json_decode(file_get_contents(sprintf($baseUrl, $v)))->USD, 2, '.', ',');
    }

    $summaryStr = implode("\n", $strArr);

    exec("/usr/bin/notify-send '{$titleStr}' '{$summaryStr}' --icon=lock ");

    sleep($waitTime);
}




?>
