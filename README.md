# Parser

This parser reads and processes files with the following extensions: .json, .xml, .csv, and .tsv. It returns a csv file with the counts of each unique element in the provided file.


## Usage

In the command line execute the following command:

`parser.php --file example_1.csv --unique-combinations=combination_count.csv`

or 

`php parser.php --file example_1.csv --unique-combinations=combination_count.csv`

where `example_1.csv` is the file to be parsed (including extension) and `combination_count.csv` is the name/path of the output file that will include the counts of each element.

The following files are testing datasets for the parser:

- example_1.csv
- example_1_emptymodels.csv
- test.json
- test.xml
- products.tsv

## Tests

`Test.php` includes two examples of unit testing.  
The following files are results of individual function testing (per each file extension):

- Combination_count.csv
- Counttwo.tsv
- Countthree.csv
- Countfour.csv


___________________________________________________________________________________________________________________________________

## Original Task:

# Build a Supplier Product List Processor

#### Requirement: 

We have multiple different formats of files that need to be parsed and returned back as a Product object with all the headings as mapped properties. 

Each product object constitutes a single row within the csv file.

#### Example Application API:
`parser.php --file example_1.csv --unique-combinations=combination_count.csv`

When the above is run the parser should display row by row each product object representation of the row. And create a file with a grouped count for each unique combination i.e. make, model, colour, capacity, network, grade, condition.

#### Example Product Object:
- make: 'Apple' (string, required) - Brand name
- model: 'iPhone 6s Plus' (string, required) - Model name
- colour: 'Red' (string) - Colour name
- capacity: '256GB' (string) - GB Spec name
- network: 'Unlocked' (string) - Network name
- grade: 'Grade A' (string) - Grade Name
- condition: 'Working' (string) - Condition name

#### Example Unique Combinations File:
- make: 'Apple'
- model: 'iPhone 6s Plus'
- colour: 'Red'
- capacity: '256GB'
- network: 'Unlocked'
- grade: 'Grade A'
- condition: 'Working'
- count: 129

#### Things to note:
  - New formats could be introduced in the future ie. (json, xml etc).
  - File headings could change in the future.
  - Some files can be very large so watch out for memory usage.
  - The code should be excutable from a terminal.
  - Please provide brief read me describing how to run your application.
  - PHP 7+ must be used.
  - Should be built using native PHP and no third party libraries.
  - Required fields if not found within file should throw an exception.


#### Bonus:
  - Add unit/integration tests.

Example files can be found in the examples directory.

Please make sure this project is completed at least one working day before your interview.

The completed project should be submitted by pushing the code to GitHub and a link emailed to HR.
