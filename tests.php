<?php
include("parser.php");


function testMissingModel($path){
    $CSVfile = fopen($path, "r") or die("Failed to load the CSV file");
    $headers= fgets($CSVfile);
    $headers= explode(",", $headers);
    if ($CSVfile !== FALSE) {
        while (! feof($CSVfile)) {
            $data = fgetcsv($CSVfile, 1000, ",");
            if ($data != ""){
                try{
                    $products[] = mapProduct($data, $headers);
                    print_r("Model Ignored");
                }catch(Exception){
                    throw new Exception("Brand Name Requiered. Test Passed");
                }
                } 
            }}}

//Testing if allows execution with blanks in the model of some elements.            
testMissingModel("example_1_emptymodels.csv");
// Printed "Brand Name Required. Test Passed" as the file has blanks the execution stops.

function checkExtension($argv){
    $input=explode(".",$argv[2]);
    $countFile=explode("=",$argv[3]);
    try{
        if($input[1]== "csv"){
            readCSV($argv[2],$countFile[1]);
        } else if ($input[1]== "json"){
            readJSON($argv[2], $countFile[1]);
        }else if($input[1]== "xml"){
            readXML($argv[2], $countFile[1]);
        }else if($input[1]== "tsv"){
            readTSV($argv[2], $countFile[1]);
        }else{
            echo "Format not recognised. Test Passed";
        }
        }catch(Exception $error){
            echo $error->getMessage();
        }
}
//Test to check that it won't accept different extensions than csv, tsv, xml, json.
checkExtension(array("parser.php", "--file", "test.xlsx", "--unique-combinations=combination_count.csv"));
//Returned: Format not recognised. Test Passed
?>