<?php
if (isset($_GET['id'])) {

    $database = new Database();
    $db = $database->getConnection();

    $id = $_GET['id'];
    $findSql = "SELECT * FROM lokasi WHERE id = ?";
    $stmt = $db->prepare($findSql);
    $stmt->bindParam(1, $_GET['id']);
    $stmt->execute();
    $row = $stmt->fetch();
    if(isset($row['id'])) {
        if (isset($_POST['button_update'])) {

            $database = new Database();
            $db = $database->getConnection();

            $validateSql = "SELECT * FROM lokasi WHERE nama_lokasi = ? AND id !=?";
            $stmt =$db->prepare($validateSQL);
            $stmt->bindParam(1, $_POST['nama_lokasi']);
            $stmt->bindParam(2, $_POST['id']);
            $stmt->execute();
            if($stmt->rowCount() > 0){
?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <h5><i class="icon fas fa-ban"></i> Gagal</h5>
            Nama Lokasi sama sudah ada 
        </div>
    <?php
    } else {
        $insertSQL = "UPDATE lokasi SET nama_lokasi = ? WHERE id =?";
        $stmt = $db->prepare($updateSQL);
        $stmt->bindParam(1, $_POST['nama_lokasi']);
        $stmt->bindParam(2, $_POST['id']);
        if ($stmt->execute()) {
            $_SESSION['hasil'] = true;
            $_SESSION['pesan'] = "Berhasil Ubah Data";
        } else {
            $_SESSION['hasil'] = false;
            $_SESSION['pesan'] = "Gagal ubah Data";
        }
        echo "<meta http-equiv='refresh' content='0;url=?page=lokasiread'>";
     }
    }
    ?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb2">
      <div class="col-sm-6"></div>
      <h1>Ubah Data Lokasi</h1>
    </div>
      <div class="col-sm-6"></div>
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
        <li class="breadcrumb-item"><a href="?page=home">Lokasi</a></li>
        <li class="breadcrumb-item active">Ubah Data</li>
      </ol>
    </div>
  </div>
</div>
</section>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Ubah Lokasi</h3>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="form-group">
                    <label for="nama_lokasi">Nama Lokasi</label>
                    <input type="hidden" class="form-control" name="id" value="<?php echo $row['id'] ?>">
                    <input type="text" class="form-control" name="nama_lokasi" value="<?php echo $row['nama_lokasi'] ?>">
                </div>
                <a href="?page=lokasiread" class="btn btn-danger btn-sm float-right">
                    <i class="fa fa-times"></i> Batal
                </a>
                <button type="submit" name="button_update" class="btn btn-success btn-sm float-right">
                    <i class="fa fa-save"></i> Simpan
                </button>
            </form>
        </div>
</section>
<?php
    } else {
        echo "<mete http-equiv='refresh' content='0;url=?page=lokasiread'>";
    }
} else {
    echo "<mete http-equiv='refresh' content='0;url=?page=lokasiread'>";
}