<?php
/**
 * Copyright 2018 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
require __DIR__ . '/vendor/autoload.php';

if (php_sapi_name() != 'cli') {
    throw new Exception('This application must be run on the command line.');
}

include './of_database.php';

$client = new Google_Client();
$client->setApplicationName('sheet');

$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);

$client->setAccessType('offline');

$client->setAuthConfig('auth_details.json');

$service = new Google_Service_Sheets($client);


$spreadsheetId = '1YlKcIsrFqY08Pm5DK_GpoHdW5lX1NNMB0ZCE';

// For selecting max id
$range = 'Sheet1!A1:E10000';
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$values = $response->getValues();

if (empty($values)) {
    print "No data found.\n";
} else {
    $val = 0;
    foreach ($values as $row) {
        // Print columns A and E, which correspond to indices 0 and 4.
        if ($row[0] != "") {
            $val = $row[0];
        }
    }
}

$conn = mysqli_connect(DB_HOST , DB_USER , DB_PASS , DB_TABLE);
$SELECT1 = "SELECT * From register Where id > $val";
$result = mysqli_query($conn, $SELECT1);
while( $row = mysqli_fetch_array($result)) {
    $range = 'Sheet1!A1:F1';
    $response = $service->spreadsheets_values->get($spreadsheetId, $range);
    $values = [
        [$row[0], "$row[1]", "$row[2]", "$row[3]", "$row[4]", "$row[5]"]
    ];
    $body = new Google_Service_Sheets_ValueRange([
        'values' => $values
    ]);
    $params = [
        'valueInputOption' => "RAW"
    ];
    $res = $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);
}




