<?php

class FinalResult {
    function results($filePath) {
        $file = fopen($filePath, "r");
        $h = fgetcsv($file);
        $rcs = [];
        while(!feof($file)) {
            $row = fgetcsv($file);
            if(count($row) == 16) {
                $amt = !$row[8] || $row[8] == "0" ? 0 : (float) $row[8];
                $ban = !$row[6] ? "Bank account number missing" : (int) $row[6];
                $bac = !$row[2] ? "Bank branch code missing" : $row[2];
                $e2e = !$row[10] && !$row[11] ? "End to end id missing" : $row[10] . $row[11];
                $rcd = [
                    "amount" => [
                        "currency" => $h[0],
                        "subunits" => (int) ($amt * 100)
                    ],
                    "bank_account_name" => str_replace(" ", "_", strtolower($row[7])),
                    "bank_account_number" => $ban,
                    "bank_branch_code" => $bac,
                    "bank_code" => $row[0],
                    "end_to_end_id" => $e2e,
                ];
                $rcs[] = $rcd;
            }
        }
        $rcs = array_filter($rcs);
        return [
            "filename" => basename($filePath),
            "document" => $file,
            "failure_code" => $h[1],
            "failure_message" => $h[2],
            "records" => $rcs
        ];
    }
}

?>
