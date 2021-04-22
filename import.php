<?php 
include '+koneksi.php';
$idagenda = isset($_GET['idagenda']) ? $_GET['idagenda'] : null;

if(@$_FILES['file_csv']['size'] > 0) {
    $fileName = @$_FILES['file_csv']['tmp_name'];
    $handle = fopen($fileName, "r");
    $valueArray = [];
    while (($data = fgetcsv($handle, 1000, ","))) {
        $valueArray[] = $data;
    }
    fclose($handle);
    // print_r($valueArray);
    foreach ($valueArray as $key => $value) {
        mysqli_query($con, "INSERT INTO tugas (judul, durasi, id_agenda) VALUES ('$value[0]', '$value[1]', '$_GET[idagenda]')") or die(mysqli_error($con));
    }
}
// echo "<script>window.location='./?page=create&idagenda=".$_GET['idagenda']."';</script>";
// echo '<meta http-equiv="refresh" content="0;url=./?page=create&idagenda='.$_GET["idagenda"].'" />';
header("location: ./?page=create&idagenda=".$_GET['idagenda']);
?>