# Parser

This parser reads and processes files with the following extensions: .json, .xml, .csv, and .tsv.


## Usage

In the command line execute the following command:

`parser.php --file example_1.csv --unique-combinations=combination_count.csv`

or 

`php parser.php --file example_1.csv --unique-combinations=combination_count.csv`

where `example_1.csv` is the file to be parsed (including extension) and `combination_count.csv` is the name/path of the output file that will include the counts of each element.


## Tests

`Test.php` includes two examples of unit testing.  