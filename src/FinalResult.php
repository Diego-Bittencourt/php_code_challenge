<?php

class FinalResult 
{


    private function mapData($file, $header) 
    {
        while(!feof($file)) {
            $row = fgetcsv($file);
            if(count($row) === 16) {
                $amount = !$row[8] || $row[8] == '0' ? 0 : (float) $row[8];
                $accountNumber = !$row[6] ? 'Bank account number missing' : (int) $row[6];
                $branchCode = !$row[2] ? 'Bank branch code missing' : $row[2];
                $endToEndId = !$row[10] && !$row[11] ? 'End to end id missing' : $row[10] . $row[11];
                $record = [
                    'amount' => [
                        'currency' => $header,
                        'subunits' => (int) ($amount * 100)
                    ],
                    'bank_account_name' => str_replace(' ', '_', strtolower($row[7])),
                    'bank_account_number' => $accountNumber,
                    'bank_branch_code' => $branchCode,
                    'bank_code' => $row[0],
                    'end_to_end_id' => $endToEndId,
                ];
                $records[] = $record;
            }
        }
        return $records;
    }




    public function results($filePath) 
    {
        try {
            $file = fopen($filePath, 'r');
            if (!$file) {
                throw new Exception('File not found.');
            };
        
            $header = fgetcsv($file);
            if(!$header) {
                throw new Exception('File is empty.');
            };
        }

        catch (Exception $error) {
            //maybe using echo isn't ideal, depending on the architecture of the app/api
            echo 'Message: ' . $error->getMessage();
        };


        $records = $this->mapData($file, $header[0]);
        
        fclose($file);

        return [
            'filename' => basename($filePath),
            'document' => $file,
            'failure_code' => $header[1],
            'failure_message' => $header[2],
            'records' => array_filter($records)
        ];
    }
}

?>
