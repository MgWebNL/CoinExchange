<?php
$url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
$parameters = [
    'start' => '1',
    'limit' => '5000',
    'convert' => 'USD'
];

$headers = [
    'Accepts: application/json',
    'X-CMC_PRO_API_KEY: b6e7c9c4-3c08-4eb0-8c9c-6f7ad2f85ca7'
];
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
curl_close($curl); // Close request
//var_dump($data);
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
        <th align="right" >60d %</th>
        <th align="right" >90d %</th>
        <th align="right" >Market Cap</th>
        <th align="right" >Volume 24h USD</th>
        <th align="right" >Volume 24h</th>
        <th align="right" >Circulating Supply</th>
        <th align="right" >Last update price</th>
        <th align="right" >Last update file</th>
    </thead>

    <tbody>
        <?php foreach($data->data as $row): ?>
            <tr>
                <td><?= $row->cmc_rank ?></td>
                <td><?= $row->name ?> (<?= $row->symbol ?>)</td>
                <td align="right"><?= number_format($row->quote->USD->price,2, ",", ".") ?></td>
                <td align="right" <?= ($row->quote->USD->percent_change_1h < 0) ? 'style="color: #ff0000; font-weight: bold;"' : 'style="color: #028A0F; font-weight: bold;"' ?>><?= number_format($row->quote->USD->percent_change_1h, 2, ",", ".") ?>%</td>
                <td align="right"  <?= ($row->quote->USD->percent_change_24h < 0) ? 'style="color: #ff0000; font-weight: bold;"' : 'style="color: #028A0F; font-weight: bold;"' ?>><?= number_format($row->quote->USD->percent_change_24h, 2, ",", ".") ?>%</td>
                <td align="right"  <?= ($row->quote->USD->percent_change_7d < 0) ? 'style="color: #ff0000; font-weight: bold;"' : 'style="color: #028A0F; font-weight: bold;"' ?>><?= number_format($row->quote->USD->percent_change_7d, 2, ",", ".") ?>%</td>
                <td align="right"  <?= ($row->quote->USD->percent_change_30d < 0) ? 'style="color: #ff0000; font-weight: bold;"' : 'style="color: #028A0F; font-weight: bold;"' ?>><?= number_format($row->quote->USD->percent_change_30d, 2, ",", ".") ?>%</td>
                <td align="right"  <?= ($row->quote->USD->percent_change_60d < 0) ? 'style="color: #ff0000; font-weight: bold;"' : 'style="color: #028A0F; font-weight: bold;"' ?>><?= number_format($row->quote->USD->percent_change_60d, 2, ",", ".") ?>%</td>
                <td align="right"  <?= ($row->quote->USD->percent_change_90d < 0) ? 'style="color: #ff0000; font-weight: bold;"' : 'style="color: #028A0F; font-weight: bold;"' ?>><?= number_format($row->quote->USD->percent_change_90d, 2, ",", ".") ?>%</td>
                <td align="right" ><?= number_format($row->quote->USD->market_cap, 2, ",", ".") ?></td>
                <td align="right" ><?= number_format($row->quote->USD->volume_24h, 2, ",", ".") ?></td>
                <td align="right" ><?= number_format($row->quote->USD->volume_24h / $row->quote->USD->price, 2, ",", ".") ?> <?= $row->symbol ?></td>
                <td align="right" ><?= number_format($row->circulating_supply, 2, ",", ".") ?> <?= $row->symbol ?></td>
                <td align="right" ><?= (new DateTime($row->quote->USD->last_updated))->format("d-m-Y H:i:s") ?></td>
                <td align="right" ><?= date("d-m-Y H:i:s") ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
