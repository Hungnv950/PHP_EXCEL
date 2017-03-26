<?php

error_reporting(E_ALL);
set_time_limit(0);

date_default_timezone_set('Europe/London');

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <title>PHPExcel Reading WorkBook Data Example #04</title>

</head>
<body>

<h1>PHPExcel Reading WorkBook Data Example #04</h1>
<h2>Get a List of the Worksheets in a WorkBook</h2>
<?php

/** Include path **/
set_include_path(get_include_path() . PATH_SEPARATOR . '../Classes/');

/** PHPExcel_IOFactory */
include 'PHPExcel/IOFactory.php';


$inputFileType = 'Excel5';
$inputFileName = './file/test.xls';

/**  Create a new Reader of the type defined in $inputFileType  **/
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
/**  Load $inputFileName to a PHPExcel Object  **/
$objPHPExcel = $objReader->load($inputFileName);

//var_dump($objPHPExcel);die;

echo '<hr />';

echo 'Reading the number of Worksheets in the WorkBook<br />';
/**  Use the PHPExcel object's getSheetCount() method to get a count of the number of WorkSheets in the WorkBook  */
$sheetCount = $objPHPExcel->getSheetCount();
echo 'There ',(($sheetCount == 1) ? 'is' : 'are'),' ',$sheetCount,' WorkSheet',(($sheetCount == 1) ? '' : 's'),' in the WorkBook<br /><br />';

echo 'Reading the names of Worksheets in the WorkBook<br />';
/**  Use the PHPExcel object's getSheetNames() method to get an array listing the names/titles of the WorkSheets in the WorkBook  */
$sheetNames = $objPHPExcel->getSheetNames();


/*Excel to json and js*/
/*Interation Sheet*/
foreach($sheetNames as $sheetIndex => $sheetName) {

    /*Echo sheet name and index of sheet*/
    echo $sheetIndex.":".$sheetName."  ";

    $sheet = $objPHPExcel->getSheet($sheetIndex);

    /*Create file name json and js */
    $fileName = $sheet->getTitle();

    $fileJsName = trim($sheet->getTitle(), ".json");

    /*Create folder Name by JSName and Json Name*/
    mkdir("file/".$fileJsName);
    mkdir("file/".$fileJsName);

    /*create Json file*/
    $myfile = fopen("file/".$fileJsName."/vi.json","w") or die("can't open Json file");

    /*Create Js file*/
    $jsFile = fopen("file/".$fileJsName."/vi.js","w") or die("can't open Js  file");

    /*get max row and max colum*/
    $highestRow = $sheet->getHighestRow()+1;
    $highestColumn = $sheet->getHighestColumn();

    $dataJson = array();
    $data = array();
    for ($i = 1; $i < $highestRow; $i++) {

        $criteriaData1 = $sheet->rangeToArray('B'.$i,true,true,true);
        $criteriaData2 = $sheet->rangeToArray('P'.$i,true,true,true);

        $criteriaData = array($criteriaData1[0][0] => $criteriaData2[0][0]);

        $data = array_merge($data, $criteriaData);
    }

    /*Write format L10n Pk-drive json */
    $dataJson = array("translations" => $data, "pluralForm" => "nplurals=1; plural=0;");
    $dataJson = json_encode($dataJson ,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    fwrite($myfile, $dataJson);

    $dataJs = json_encode($data ,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    $dataJs = "OC.L10N.register(\"". $fileJsName. '",' .$dataJs. ",\"nplurals=1; plural=0;\");";
    fwrite($jsFile, $dataJs);
}

echo '<hr />';



echo "<hr/>";



?>
<body>
</html>
