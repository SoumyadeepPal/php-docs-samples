<?php

/**
 * Copyright 2019 Google LLC.
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

/**
 * For instructions on how to run the full sample:
 *
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/bigtable/README.md
 */

// Include Google Cloud dependendencies using Composer
require_once __DIR__ . '/../../vendor/autoload.php';

if (count($argv) < 3 || count($argv) > 5) {
    return printf("Usage: php %s PROJECT_ID INSTANCE_ID TABLE_ID" . PHP_EOL, __FILE__);
}
list($_, $project_id, $instance_id, $table_id) = $argv;

// [START bigtable_hw_get_with_filter]

use Google\Cloud\Bigtable\BigtableClient;
use Google\Cloud\Bigtable\V2\RowFilter;

/** Uncomment and populate these variables in your code */
// $project_id = 'The Google project ID';
// $instance_id = 'The Bigtable instance ID';
// $table_id = 'The Bigtable table ID';


// Connect to an existing table with an existing instance.
$dataClient = new BigtableClient([
    'projectId' => $project_id,
]);
$table = $dataClient->table($instance_id, $table_id);

printf('Getting a single greeting by row key.' . PHP_EOL);
$key = 'greeting0';
// Only retrieve the most recent version of the cell.
$row_filter = (new RowFilter)->setCellsPerColumnLimitFilter(1);

$column = 'greeting';
$columnFamilyId = 'cf1';

$row = $table->readRow($key, [
    'rowFilter' => $row_filter
]);
printf('%s' . PHP_EOL, $row[$columnFamilyId][$column][0]['value']);
// [END bigtable_hw_get_with_filter]
