<?php

$maxresults = 2500;
$maxpage = ceil($maxresults / 250);

$url = 'https://api.coingecko.com/api/v3/coins/markets';
$parameters = [
    'page' => '1',
    'per_page' => '250',
    'vs_currency' => 'USD',
    'order' => 'market_cap_desc',
    'price_change_percentage' => "1h,24h,7d,14d,30d,200d,1y"
];

$headers = [
    'Accepts: application/json',
//    'X-CMC_PRO_API_KEY: b6e7c9c4-3c08-4eb0-8c9c-6f7ad2f85ca7'
];

$aData = [];

while($parameters['page'] <= $maxpage){
    $qs = http_build_query($parameters); // query string encode the parameters
    $request = "{$url}?{$qs}"; // create the request URL


    $curl = curl_init(); // Get cURL resource
// Set cURL options
    curl_setopt_array($curl, array(
        CURLOPT_URL => $request,            // set the request URL
        CURLOPT_HTTPHEADER => $headers,     // set the headers
        CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
    ));

    $response = curl_exec($curl); // Send the request, save the response
    $data = json_decode($response); // print json decoded response

    foreach($data as $row){
        $aData[] = $row;
    }

    $parameters["page"]++;
}

curl_close($curl); // Close request
?>


<table>
    <thead>
        <th>#</th>
        <th>Name</th>
        <th align="right" >Price USD</th>
        <th align="right" >1h %</th>
        <th align="right" >24h %</th>
        <th align="right" >7d %</th>
        <th align="right" >30d %</th>
        <th align="right" >200d %</th>
        <th align="right" >1y %</th>
        <th align="right" >Market Cap</th>
        <th align="right" >Volume 24h USD</th>
        <th align="right" >Volume 24h</th>
        <th align="right" >Circulating Supply</th>
        <th align="right" >Last update price</th>
        <th align="right" >Last update file</th>
    </thead>

    <tbody>
        <?php foreach($aData as $row): ?>
            <tr>
                <td><?= $row->market_cap_rank ?></td>
                <td><?= $row->name ?> (<?= strtoupper($row->symbol) ?>)</td>
                <td align="right"><?= number_format($row->current_price,2, ",", ".") ?></td>
                <td align="right" <?= ($row->price_change_percentage_1h_in_currency < 0) ? 'style="color: #ff0000; font-weight: bold;"' : 'style="color: #028A0F; font-weight: bold;"' ?>><?= number_format($row->price_change_percentage_1h_in_currency, 2, ",", ".") ?>%</td>
                <td align="right"  <?= ($row->price_change_percentage_24h_in_currency < 0) ? 'style="color: #ff0000; font-weight: bold;"' : 'style="color: #028A0F; font-weight: bold;"' ?>><?= number_format($row->price_change_percentage_24h_in_currency, 2, ",", ".") ?>%</td>
                <td align="right"  <?= ($row->price_change_percentage_7d_in_currency < 0) ? 'style="color: #ff0000; font-weight: bold;"' : 'style="color: #028A0F; font-weight: bold;"' ?>><?= number_format($row->price_change_percentage_7d_in_currency, 2, ",", ".") ?>%</td>
                <td align="right"  <?= ($row->price_change_percentage_30d_in_currency < 0) ? 'style="color: #ff0000; font-weight: bold;"' : 'style="color: #028A0F; font-weight: bold;"' ?>><?= number_format($row->price_change_percentage_30d_in_currency, 2, ",", ".") ?>%</td>
                <td align="right"  <?= ($row->price_change_percentage_200d_in_currency < 0) ? 'style="color: #ff0000; font-weight: bold;"' : 'style="color: #028A0F; font-weight: bold;"' ?>><?= number_format($row->price_change_percentage_200d_in_currency, 2, ",", ".") ?>%</td>
                <td align="right"  <?= ($row->price_change_percentage_1y_in_currency < 0) ? 'style="color: #ff0000; font-weight: bold;"' : 'style="color: #028A0F; font-weight: bold;"' ?>><?= number_format($row->price_change_percentage_1y_in_currency, 2, ",", ".") ?>%</td>
                <td align="right" ><?= number_format($row->market_cap, 2, ",", ".") ?></td>
                <td align="right" ><?= number_format($row->total_volume, 2, ",", ".") ?></td>
                <td align="right" ><?= number_format($row->total_volume / $row->current_price, 2, ",", ".") ?> <?= strtoupper($row->symbol) ?></td>
                <td align="right" ><?= number_format($row->circulating_supply, 2, ",", ".") ?> <?= strtoupper($row->symbol) ?></td>
                <td align="right" ><?= (new DateTime($row->last_updated))->format("d-m-Y H:i:s") ?></td>
                <td align="right" ><?= date("d-m-Y H:i:s") ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
