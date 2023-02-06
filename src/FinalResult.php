<?php

class FinalResult {
    function results($filePath) {
        $file = fopen($filePath, "r");
        $header = fgetcsv($file);
        $records = [];
        while(!feof($file)) {
            $row = fgetcsv($file);
            if(count($row) == 16) {
                $amount = !$row[8] || $row[8] == "0" ? 0 : (float) $row[8];
                $accountNumber = !$row[6] ? "Bank account number missing" : (int) $row[6];
                $branchCode = !$row[2] ? "Bank branch code missing" : $row[2];
                $endToEndId = !$row[10] && !$row[11] ? "End to end id missing" : $row[10] . $row[11];
                $record = [
                    "amount" => [
                        "currency" => $header[0],
                        "subunits" => (int) ($amount * 100)
                    ],
                    "bank_account_name" => str_replace(" ", "_", strtolower($row[7])),
                    "bank_account_number" => $accountNumber,
                    "bank_branch_code" => $branchCode,
                    "bank_code" => $row[0],
                    "end_to_end_id" => $endToEndId,
                ];
                $records[] = $record;
            }
        }
        $records = array_filter($records);
        return [
            "filename" => basename($filePath),
            "document" => $file,
            "failure_code" => $header[1],
            "failure_message" => $header[2],
            "records" => $records
        ];
    }
}

?>
