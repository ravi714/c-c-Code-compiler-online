<?php
$compile='';
$random_file=bin2hex(openssl_random_pseudo_bytes(10));
$code_file='';

$mytxtfile = fopen("temp_files/{$random_file}.txt", "w") or die("Unable to open file!");
$getdata=file_get_contents("php://input");
$dedata=json_decode($getdata,true);
putenv("PATH=C:\mi\bin");
fwrite($mytxtfile,$dedata['input']);
fclose($mytxtfile);

if($dedata['lang']=="c"){
    //open a file with c exction
    $myfile = fopen("temp_files/{$random_file}.c", "w") or die("Unable to open file!");
    //write the inside the file
    fwrite($myfile, $dedata['code']);
    //close the file
    fclose($myfile);
    //store name of the file in $code_file variable
    $code_file =$random_file.".c";
    //Compile the programe
    $compile=shell_exec("gcc .\\temp_files\\{$code_file} -o .\\temp_files\\{$random_file}.cout 2>&1");
}else if($dedata['lang']=="cpp"){
    $myfile = fopen("temp_files/{$random_file}.cpp", "w") or die("Unable to open file!");
    fwrite($myfile, $dedata['code']);
    fclose($myfile);
    $code_file =$random_file.".cpp";
    $compile=shell_exec("g++ .\\temp_files\\{$code_file} -o .\\temp_files\\{$random_file}.cout 2>&1");
    
}

if($compile==''){
    //Run the application and show the output
    $output=shell_exec(".\\temp_files\\{$random_file}.cout < .\\temp_files\\{$random_file}.txt");
    echo "<pre>";
    unlink(".\\temp_files\\{$random_file}.txt");
    unlink(".\\temp_files\\{$code_file}");
    unlink(".\\temp_files\\{$random_file}.cout");
    echo $output;
    echo "</pre>";
}
else{
    unlink(".\\temp_files\\{$random_file}.txt");
    unlink(".\\temp_files\\{$code_file}");
    echo "<pre>";
    echo $compile;
    echo "</pre>";
}
?>
