<?php

class FinalResult 
{


    private function mapData($file, $header) 
    {
        //while isn't the end of the file or error, while loop reads the rows
        while(!feof($file)) {
            $row = fgetcsv($file);

            //checking if the row has all the fields expected
            if(count($row) === 16) {

                //assign values to variables and checking for empty fields
                $amount = !$row[8] || $row[8] == '0' ? 0 : (float) $row[8];
                $accountNumber = !$row[6] ? 'Bank account number missing' : (int) $row[6];
                $branchCode = !$row[2] ? 'Bank branch code missing' : $row[2];
                $endToEndId = !$row[10] && !$row[11] ? 'End to end id missing' : $row[10] . $row[11];

                //output the record associative array
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

                //add the record to the records associative array
                $records[] = $record;
            }
        }
        //return the records to the results() method
        return $records;
    }




    public function results($filePath) 
    {
        try {

            //opens the file in the path received in the arguments and check for false
            $file = fopen($filePath, 'r');
            if (!$file) {
                throw new Exception('File not found.');
            };
        
            //reads file's header and check for false
            $header = fgetcsv($file);
            if(!$header) {
                throw new Exception('File is empty.');
            };
        }

        //catches any errors that might have occurred.
        catch (Exception $error) {

            //maybe using echo isn't ideal, depending on the architecture of the app/api
            echo 'Message: ' . $error->getMessage();
            
        };

        //calls a private method, passing the file handler and the currency, 
        //inside the class that reads the file and returns the records 
        //in an associative array
        $records = $this->mapData($file, $header[0]);
        
        //closes the file
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
