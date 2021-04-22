<?php
include '+koneksi.php';

// function array2csv(array &$array) {
//    if (count($array) == 0) {
//      return null;
//    }
//    ob_start();
//    $df = fopen("php://output", 'w');
//    fputcsv($df, array_keys(reset($array)));
//    foreach ($array as $row) {
//       fputcsv($df, $row);
//    }
//    fclose($df);
//    return ob_get_clean();
// }
// function download_send_headers($filename) {
//     // disable caching
//     $now = gmdate("D, d M Y H:i:s");
//     header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
//     header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
//     header("Last-Modified: {$now} GMT");
//     // force download  
//     header("Content-Type: application/force-download");
//     header("Content-Type: application/octet-stream");
//     header("Content-Type: application/download");
//     // disposition / encoding on response body
//     header("Content-Disposition: attachment;filename={$filename}");
//     header("Content-Transfer-Encoding: binary");
// }

$idagenda = isset($_GET['idagenda']) ? $_GET['idagenda'] : null;
$query_tugas = mysqli_query($con, "SELECT * FROM tugas WHERE id_agenda = '$idagenda'") or die(mysqli_error($con));

// $tugas_array = [];
// while($data_tugas = mysqli_fetch_array($query_tugas)) :
//     array_push($tugas_array, [
//         'Judul' => $data_tugas['judul'],
//         'Durasi' => $data_tugas['durasi']
//     ]);
// endwhile;
// download_send_headers("tugas-" . date("Ymd") . ".csv");
// echo array2csv($tugas_array);

$FileName = "tugas-agenda_" . $idagenda . ".csv";
$file = fopen("file/".$FileName, "w");
// Save all records without headings
while($row = mysqli_fetch_assoc($query_tugas)){
    $valuesArray = array();
    foreach($row as $key => $value) {
        if($key == "id_tugas" || $key == "id_agenda") {
            continue;
        }
        $valuesArray[] = $value;
    }
    // print_r($valuesArray);
    // echo "<br>";
    fputcsv($file,$valuesArray); 
}
fclose("file/".$file);
header("Location: file/$FileName");
?>