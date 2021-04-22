<?php include "+koneksi.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timeblocks</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/libs/fontawesome/css/all.min.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper overflow-hidden">
        <div class="row">
            <div class="col-md-6">
                <div class="box text-center">
                    <div class="row timer simply-countdown-countup" id="timer"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box">
                    <div class="wrapper-agenda bg-light rounded">
                        <div class="title-agenda border-bottom">
                            Agendas
                        </div>
                        <div class="p-4">
                            <?php $durasi = "";
                            if(@$_GET['page'] == "home" || @$_GET['page'] == "") : ?>
                            <div class="box-agenda">
                                <div class="mb-3">
                                    <a href="?page=create" class="btn btn-sm btn-dark">
                                        <i class="fa fa-plus"></i> &nbsp; Create an Agenda
                                    </a>
                                </div>
                                <div>
                                    <div class="list-group">
                                    <?php $query_agenda = mysqli_query($con, "SELECT * FROM agenda") or die(mysqli_error($con));
                                    while($data_agenda = mysqli_fetch_array($query_agenda)) : ?>
                                        <a href="?page=create&idagenda=<?=$data_agenda['id_agenda']?>" class="list-group-item list-group-item-action"><?=$data_agenda['name_agenda']?></a>
                                    <?php endwhile; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if(@$_GET['page'] == "del") {
                                $query = mysqli_query($con, "DELETE FROM agenda WHERE id_agenda = '$_GET[idagenda]'") or die(mysqli_error($con));
                                if($query) : ?>
                                    <script>window.location='?page=home';</script>
                                <?php endif;
                            } ?>
                            <?php if(@$_GET['page'] == "del2") {
                                $query = mysqli_query($con, "DELETE FROM tugas WHERE id_tugas = '$_GET[idtugas]'") or die(mysqli_error($con));
                                if($query) : ?>
                                    <script>window.location='?page=create&idagenda=<?=@$_GET['idagenda']?>';</script>
                                <?php endif;
                            } ?>
                            <?php if(@$_GET['page'] == "create") : ?>
                            <div class="box-time">
                                <div class="mb-3">
                                    <a href="?page=home" class="btn btn-sm btn-secondary">
                                        <i class="fa fa-chevron-left"></i> &nbsp; Back
                                    </a>
                                </div>
                                <form action="" method="post">
                                    <div class="mb-4 row">
                                        <?php if(@$_GET['idagenda'] != '') {
                                            $query_agenda_one = mysqli_query($con, "SELECT * FROM agenda WHERE id_agenda = '$_GET[idagenda]'") or die(mysqli_error($con));
                                            $fetch_agenda_one = mysqli_fetch_array($query_agenda_one);
                                            $data_agenda_one = $fetch_agenda_one['name_agenda'];
                                        } else {
                                            $data_agenda_one = "";
                                        } ?>
                                        <div class="col-md-8">
                                            <input type="text" name="name_agenda" value="<?=$data_agenda_one?>" placeholder="Untitled Agenda" class="form-control" required>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="submit" name="submit_agenda" class="btn btn-dark">
                                                <i class="fa fa-save"></i>
                                            </button>
                                            <?php if(@$_GET['idagenda'] != '') : ?>
                                            <a href="?page=del&idagenda=<?=@$_GET['idagenda']?>" onclick="return confirm('Yakin hapus data?')" style="margin-left:10px" class="btn btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </form>
                                <?php if(isset($_POST['submit_agenda'])) {
                                    $name_agenda = mysqli_real_escape_string($con, $_POST['name_agenda']);
                                    if(@$_GET['idagenda'] == '') {
                                        $query = mysqli_query($con, "INSERT INTO agenda (name_agenda) VALUES ('$name_agenda')") or die(mysqli_error($con));
                                    } else {
                                        $query = mysqli_query($con, "UPDATE agenda SET name_agenda = '$name_agenda' WHERE id_agenda = '$_GET[idagenda]'") or die(mysqli_error($con));
                                    }
                                    if($query) : ?>
                                        <script>window.location='./?page=home';</script>
                                    <?php endif;
                                } ?>
                                <div class="mb-3">
                                    <div class="list-group">
                                    <?php
                                    $idagenda = isset($_GET['idagenda']) ? $_GET['idagenda'] : null;
                                    $query_tugas = mysqli_query($con, "SELECT * FROM tugas WHERE id_agenda = '$idagenda'") or die(mysqli_error($con));
                                    $count_tugas = mysqli_num_rows($query_tugas);
                                    while($data_tugas = mysqli_fetch_array($query_tugas)) : ?>
                                        <a href="?page=create&idagenda=<?=$data_tugas['id_agenda']?>&idtugas=<?=$data_tugas['id_tugas']?>" class="list-group-item list-group-item-action">
                                            <?=$data_tugas['judul']?> - <?=$data_tugas['durasi']?>m
                                        </a>
                                    <?php endwhile; ?>
                                    </div>
                                </div>
                                <?php if(@$_GET['idagenda'] != '') : ?>
                                <?php if(@$_GET['idtugas'] != '') {
                                    $idtugas = isset($_GET['idtugas']) ? $_GET['idtugas'] : null;
                                    $query_tugas_one = mysqli_query($con, "SELECT * FROM tugas WHERE id_agenda = '$idagenda' AND id_tugas = '$idtugas'") or die(mysqli_error($con));
                                    $data_tugas_one = mysqli_fetch_array($query_tugas_one);
                                    $judul = $data_tugas_one['judul'];
                                    $durasi = $data_tugas_one['durasi'];
                                } else {
                                    $judul = "";
                                    $durasi = "";
                                } ?>
                                <form action="" method="post">
                                    <div class="row">
                                        <label class="form-label"><b>Add time blocks</b></label>
                                        <div class="col-md-5">
                                            <input type="text" name="judul" value="<?=$judul?>" placeholder="name" class="form-control" required>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" name="durasi" value="<?=$durasi?>" placeholder="mins" class="form-control" required>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="submit" name="submit_tugas" class="btn btn-dark">
                                                <i class="fa fa-save"></i>
                                            </button>
                                            <?php if(@$_GET['idtugas'] != '') : ?>
                                            <a href="?page=del2&idagenda=<?=@$_GET['idagenda']?>&idtugas=<?=@$_GET['idtugas']?>" onclick="return confirm('Yakin hapus data?')" style="margin-left:10px" class="btn btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </form>
                                <?php                                
                                if(isset($_POST['submit_tugas'])) {
                                    $judul = mysqli_real_escape_string($con, $_POST['judul']);
                                    $durasi = mysqli_real_escape_string($con, $_POST['durasi']);
                                    if(@$_GET['idagenda'] == '') {
                                        ?><script>alert('Agenda belum dipilih / diinput');</script><?php
                                    } else {
                                        if(@$_GET['idtugas'] == '') {
                                            $query = mysqli_query($con, "INSERT INTO tugas (judul, durasi, id_agenda) VALUES ('$judul', '$durasi', '$_GET[idagenda]')") or die(mysqli_error($con));
                                        } else {
                                            $query = mysqli_query($con, "UPDATE tugas SET judul = '$judul', durasi = '$durasi' WHERE id_tugas = '$_GET[idtugas]'") or die(mysqli_error($con));
                                        }
                                        if($query) : ?>
                                            <script>window.location='./?page=create&idagenda=<?=@$_GET['idagenda']?>';</script>
                                        <?php endif;
                                    }
                                }
                                ?>
                                <div class="mt-4">
                                    <div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-file-upload"></i> Import
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                            <li><a class="dropdown-item" href="file/example.csv"><i class="fa fa-file-excel fa-fw"></i> Download Format CSV</a></li>
                                            <li><button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#importModal"><i class="fa fa-file-import fa-fw"></i> Import File CSV</button></li>
                                        </ul>
                                    </div>
                                    <?php if($count_tugas > 0) : ?>
                                    <a href="export.php?idagenda=<?=@$_GET['idagenda']?>" class="btn btn-success"><i class="fas fa-file-export"></i> Export CSV</a>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Import Time (CSV)</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="import.php?idagenda=<?=@$_GET['idagenda']?>" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                <input type="file" name="file_csv" class="form-control" required>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Process</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </form>
        </div>
    </div>
    </div>

    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplyCountdown.min.js"></script>
    <script>
    idtugas = "<?=$durasi?>";
    durasi = parseInt(idtugas);
    date = new Date();
    simplyCountdown('.simply-countdown-countup', {
        year: date.getFullYear(),
        month: date.getMonth() + 1,
        day: date.getDate(),
        hours: date.getHours(),
        minutes: date.getMinutes() + durasi,
        seconds: date.getSeconds(),
        words: {
            days: '',
            hours: '',
            minutes: '',
            seconds: '',
            pluralLetter: ''
        },
    });

    $('.simply-days-section').hide();
    $('.simply-hours-section').hide();
    $('.simply-minutes-section').addClass('col');
    $('.simply-minutes-section').css('text-align', 'right');
    $('.simply-minutes-section div').append('<span>:</span>');
    $('.simply-seconds-section').addClass('col text-left');
    $('.simply-seconds-section').css('text-align', 'left');
    </script>
</body>
</html>