# Simple code challenge - Diego Bittencourt #

This is the repository to my answer for the Simple Code Challenge

The changes and the reasons why they were made follows below. Each change for the specific commit they were made
1 - Create the repository.
    [Commit #1](https://github.com/Diego-Bittencourt/php_code_challenge/commit/f4a59a65948b3bb4537055a4954e53ddbff6d931)

2 - The variables inside the code were using names hard to understand, $f or $h. Therefore, I changed the variable names
    to something easier to understand what the variable holds, like ```$file``` to hold the file handler or ```$filePath``` to clarify the function argument is a path to the file. As needed, camelCase were used.
    [Commit #2](https://github.com/Diego-Bittencourt/php_code_challenge/commit/60cb0cf6e0eedf9f267bf195e14370a89e91854c)

3 - Still in the variables, some variables names are abbreviations of the values they contain, like ```$r```  for row and 
    ```$ban``` for account number or even ```e2e``` for end-to-end id. However, some with little knowledge about what the
    code is about might have a hard time to guess or even misunderstand the value. So, I also changed these variable names
    to make it clear the value they hold like ```$row``` or ```accountNumber```.
    [Commit #3](https://github.com/Diego-Bittencourt/php_code_challenge/commit/48357ee4d9bf67da9f15d2f97e9be0cd8e667d22)

4 - The class FinalResult had only one method that deals with loading the csv file, read the csv file, iterate through
    the csv file lines and create an associative array for each row, add each associative array to a bigger array and return data to be included in yet another associative array.
    This looks like many tasks included in only one method. It might be hard to follow and manage. Therefore, I created another private method inside the FinalResult class. This new method, called mapData, receives the file handler and the header from the results method and returns the array containing the data in the file. The result method deals with opening the file and returning the final associative array with the records and other properties loaded before.
    [Commit #4](https://github.com/Diego-Bittencourt/php_code_challenge/commit/4c5fb260a33b1f9c0277e31f41efa2198255a79e)

5 - The code always works well because the file is in the subfolder support. Although, in a real situation, there might be 
    errors, there might be connection problems or other situations in which the file can't be found or it is empty. So I left a comment to remind myself to create a error handling later.
    [Commit #5](https://github.com/Diego-Bittencourt/php_code_challenge/commit/a86721d15bfc3f727a065f8440265347c88dbdfa)

6 - All strings are being declared using double quotes ``` "" ```. There is a good practice suggestion to use single quotes
    in PHP. Using single quotes can lead to slightly higher performance, but it only matters in high-load apps, as explained[here] (https://phpbestpractices.org/#quotes). The most important is consistency. Taking a look at the FinalResultTes.php file, double-quotes are being used. In a real scenario,
    I'd stick with the double quotes since it's clearly the pattern, but I changed because it is a test.
    I also change the indentation for functions and classes declaration to make it easier to read. It's a pattern observed
    in the FinalResultTest.php file.
    [Commit #6](https://github.com/Diego-Bittencourt/php_code_challenge/commit/55fe3016136b200728821afd5a7c52313cc2cfd1)

7 - Error handling. I implemented a ```try``` and ```catch``` block. Inside the block, the results method opens the file
    and get the pointer using f(open). If the file couldn't be found, fopen() returns false. Soon after, the fgetcsv() function tries to read the file and, if it's empty, returns false if fails. On both function, an ```if``` statement checks if the value is false and throw an ```Exception``` with a message for each case. After that, ```catch``` catches any possible exceptions and throws the message using ```echo```. Showing the error message using ```echo``` might not be ideal due the app/api architecture. In a real scenario, I'd ask my supervisor or the tech lead for how to show the Exception.
    [Commit #7](https://github.com/Diego-Bittencourt/php_code_challenge/commit/cb40bd897a1daf04aab0cb28d0f4c4fe22e1e0a1)

8 - In the line 11 of the mapData() method, there is an ```if``` statement that checks if the row, from the csv file, has 16
    items, as expected. The comparison was being done by using a == loose comparison operator. The === explicit expression operetor should be used whenever possible. I changed the == operator to === operator for that ```if``` statement.
    There is another == comparison operator in the line 12, checking for the ```$row[8] == '0'```. It might be good to change that too, but that is a comparison with numbers so, in a real case scenario, I'd confirm with the tech lead.
    [Commit #8](https://github.com/Diego-Bittencourt/php_code_challenge/commit/f3ea10747e5c21dde1e5e5b1f03f65c00bbcec8f)

9 - The mapData() method receives the header to insert one value in the associative array it produces. Instead of passing
    the whole ```$header```, I'm passing only the currency.
    [Commit #9](https://github.com/Diego-Bittencourt/php_code_challenge/commit/0dfacf48212be7126466225e4d343a16123ea882)

10 - The method reads a file with fopen() function but never calls fclose() to close it. Surely, after the script is done, 
     PHP closes the file automatically. However, the file remains open throughout the script which is not ideal. Therefore, 
     I'm calling fclose() at the end of the results() method.
     [Commit #10](https://github.com/Diego-Bittencourt/php_code_challenge/commit/48bd9b263279368c6b331e70df768a9676910e85)

11 - Add documentation in comments
    [Commit #11](https://github.com/Diego-Bittencourt/php_code_challenge/commit/5c84a3e5a40dbda174285ff66c9be589c14d8f3a)


**Aknowledgements**
First, thank you for the opportunity to take the test. I learned a lot more about PHP regarding *Exceptions* and *OOP*.
I'm eager to learn and always excited to aquire knowledge and strategies in Software development. I'm sorry for the ~~long~~ text, but it's good to document my learning and logic.
Hope you have a good day.
Diego 

----------------------------------------------------------------------------------------
# Simple code challenge - Original text #

This code is an example from a real world scenario that has been modified to protect the source. The code is one file from a large PHP application.

The context of the file is a parser of a result file from a specific Singapore bank regarding bank transfers. There were multiple banks from multiple countries involved in this application.

To install the dependencies run `composer install` (this assumes you have composer installed in your environment)

The code works and outputs what it required. Included is one test file with one test. This can be run and should pass with `./vendor/bin/phpunit tests`

Read through the `src/FinalResult.php` as well as the test file `tests/FinalResultTest.php` and see what improvements can be made (if any). Please be prepared to explain any modifications that have been made (or not) and why. The only rule is to not change the current end result or output.

Keep in mind this is from a larger application that handles multiple files, multiple banks, mutiple countries, and multiple currencies.

Do the best you can to demonstrate your skillset.