<?php
ini_set('memory_limit', '-1');


//Product Object to be filled with data from files and printed.
class Product{
    public $brand_name;
    public $model_name; 
    public $condition_name;
    public $grade_name;
    public $gb_spec_name;
    public $colour_name;
    public $network_name;
}


/*
Function to map each line of the csv to the corresponding product 
element and print the Product object in the console.
*/


function mapProduct($line, $headers){
    $ins_prod= new Product();
    $ins_prod->brand_name=$line[0] ??  throw new Exception("Brand Name Requiered");
    $ins_prod->model_name=$line[1] ??  throw new Exception("Model Name Required");
    $ins_prod->condition_name=$line[2]?? '';
    $ins_prod->grade_name=$line[3]?? '';
    $ins_prod->gb_spec_name=$line[4]?? '';
    $ins_prod->colour_name=$line[5]?? ''; 
    $ins_prod->network_name=$line[6]?? '';

    //Print in the same format as the product object.
    print_r($headers[0].": ". $ins_prod->brand_name . "\n" . $headers[1].": ". $ins_prod->model_name. "\n". 
    $headers[2].": ". $ins_prod->condition_name ."\n". $headers[3].": ". $ins_prod->grade_name . "\n".
    $headers[4].": ". $ins_prod->gb_spec_name . "\n". $headers[5].": ". $ins_prod->colour_name. "\n".
     $headers[6].": ". $ins_prod->network_name. "\n". "_______________________________________"."\n" );

    return $ins_prod;
}

//Function that takes the counts and creates a new file including the counts value.
function createCountsFile($arr,$filename, $headers){
    $newFile = fopen($filename, 'a');
    print_r("Creating the counts file. Please wait... " . "\n");
    fwrite($newFile, $headers."\n");
    foreach($arr as $k=>$v){

        
        fwrite($newFile, $k .",".$v);
        fwrite($newFile,"\n");

        //Object-like format. Commented out as the example in the task is in CSV format.
        #fwrite($newFile, "brand_name :". $pieces[0]."\n");
        #fwrite($newFile,"model_name: ". $pieces[1]."\n");
        #fwrite($newFile,"condition_name: ". $pieces[2]."\n");
        #fwrite($newFile,"grade_name: ". $pieces[3]."\n");
        #fwrite($newFile,"gb_spec_name: ". $pieces[4]."\n");
        #fwrite($newFile,"colour_name: ". $pieces[5]."\n");
        #fwrite($newFile,"network_name: ". $pieces[6]."\n");
        #fwrite($newFile,"Count: ". $v. "\n");
        #fwrite($newFile,"\n"."\n");
    }
    fclose($newFile);
    print_r("File ".$filename." with counts created. "."\n");
}

/*
Main function to read CSV, calls the mapping to the product object and creates and pushes each element into an array 
to obtain the frequencies and feed it to the function that creates the new file.
*/
function readCSV($path, $countsFile){
    $CSVfile = fopen($path, "r") or die("Failed to load the CSV file");
    $headers= fgets($CSVfile);
    $headers= explode(",", $headers);
    $products = array();
    $count_array = array();
    if ($CSVfile !== FALSE) {
        while (! feof($CSVfile)) {
            $data = fgetcsv($CSVfile, 1000, ",");
            if ($data != ""){
                
                $products[] = mapProduct($data, $headers);
                $joined= implode(",", $data);
                array_push($count_array,$joined);

            }
        }

        fclose($CSVfile);
        array_push($headers,'"count"');//push the a new header for the count
    }
    $counts= array_count_values($count_array);
    print_r($headers);
    $headers= implode(",",$headers);//Reconstruct the string to be written in the file
    createCountsFile($counts,$countsFile, $headers);
}


/*
JSon format files. Uses the same structure as CSV. Once it is decoded to php array it calls the other 
functions to create objects of Product, then print them and create the new file.
*/

function readJSON($path, $countsFile){
    $products = array();
    $count_array = array();
    $readJSONFile = file_get_contents($path) or die("Failed to load the JSON file.");
    $array = json_decode($readJSONFile, TRUE);
    #var_dump($array); // print array
    $headers= array_keys($array[0]);
    
    foreach($array as $arr){
        #print_r(array_values($arr));
        $values= array_values($arr); // get the frequencies of the objects
        $products[] = mapProduct($values, $headers);
        $joined= implode(",", $values);
        array_push($count_array,$joined);
}array_push($headers,'count');
$counts= array_count_values($count_array);
$headers= implode(",", $headers);
createCountsFile($counts,$countsFile, $headers);
}


/* 
XML reader. 
*/
function readXML($path, $countsFile){
    $products = array();
    $count_array = array();
    $file= simplexml_load_file($path) or die("Failed to load the XML file");
    #$objJsonDocument = json_encode($file);
    #$arrOutput = json_decode($objJsonDocument, TRUE);
    $labels= array();
    try{    
        foreach($file->children()[0] as $child){
            if(!in_array($child->getName(),$labels)) array_push($labels,$child->getName());
        }
        foreach($file->children() as $children){
            $temp= array();
            foreach($children->children() as $product){
                array_push($temp, $product); 
            }
            $products[] = mapProduct($temp, $labels);
            $joined= implode(",", $temp);
            array_push($count_array,$joined);
        }} catch(Exception){
            throw new Exception ("Review Format of the XML. This function parses the format:  
                <root>
                    <product>
                        ...elements    
                    </product>
                </root>    ");
        }
    array_push($labels,'count');
    $counts= array_count_values($count_array);
    $labels= implode(",", $labels);
    createCountsFile($counts,$countsFile, $labels);

}

/* 
TSV reader.
*/

function readTSV($path, $countsFile){
    $TSVfile = fopen($path, "r") or die("Failed to load the TSV file");
    $headers= fgets($TSVfile);
    $headers= explode("\t", $headers);
    $products = array();
    $count_array = array();
    if ($TSVfile !== FALSE) {
        while (! feof($TSVfile)) {
            $data = fgetcsv($TSVfile, 1000, "\t");
            if ($data != ""){
                $products[] = mapProduct($data, $headers);
                $joined= implode(",", $data);
                array_push($count_array,$joined);

            }
        }

        fclose($TSVfile);
    }
    array_push($headers,'"count"');
    $counts= array_count_values($count_array);
    $headers= implode(",", $headers);
    createCountsFile($counts,$countsFile, $headers);
}


/* 
Testing each function:

readCSV("example_1.csv", "countone.csv"); => Success
readTSV("products_tab_separated.tsv", "counttwo.tsv"); =>Success
readJSON("test.json", "countthree.csv"); => Sucess
readXML("test.xml", "countfour.csv"); => Sucess
*/


/*
Reads the argvs to obtain the input file and the name where the output file should be.
*/
$input=explode(".",$argv[2]);
$countFile=explode("=",$argv[3]);

#Driver: Based on the extension name different functions are called.
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
    echo "Format not recognised. Please provide a file with one of the following extensions: \n [.json, .csv, .tsv, .xml]";
}
}catch(Exception $error){
    echo $error->getMessage();
}

?>