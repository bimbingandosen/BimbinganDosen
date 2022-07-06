<?php 
	
	include 'assets/koneksi.php';

	function setPengumuman($con,$id_user,$judul,$desc,$type){
		$date = date("Y-m-d");
		$query = mysqli_query($con,"INSERT INTO pengumuman (id_user,judul_pengumuman,tgl_pengumuman,deskripsi_pengumuman,type) VALUES ('$id_user','$judul','$date','$desc','$type');");		
	}

	if(isset($_GET['act'])){
		if($_GET['act'] == "signin"){
			$username = $_POST['username'];
			$password = $_POST['password'];
			$query = mysqli_query($con,"SELECT * FROM users WHERE username = '$username' AND password = '$password';");
			if(mysqli_num_rows($query) > 0){
				$data = mysqli_fetch_assoc($query);
				$response['kode'] = 200;
				$response['message'] = "Sign In Berhasil";
				$response['userModel'] = array(
						'id_user' => $data['id_users'],
						'username' => $data['username'],
						'role' => $data['role'],
						'id_role' => $data['id_role'],
				);
			}else{
				$response['kode'] = 404;
				$response['message'] = "Gagal Karena Username Atau Password Tidak Cocok / Belum Terdaftar";
			}
		}
		if($_GET['act'] == "DaftarBimbingan"){
			$id = $_POST['id_mahasiswa'];
			$judul = $_POST['judul'];
			$desc = $_POST['deskripsi'];
			$date = date("Y-m-d h:i:s");
			$query = mysqli_query($con,"INSERT INTO bimbingan(tgl_pengajuan,status_bimbingan,id_mahasiswa,judul_bimbingan,deskripsi_bimbingan) VALUES ('$date','0','$id','$judul','$desc')");
			if($query){
				$response['kode'] = 200;
				$response['message'] = "Daftar Bimbingan Berhasil";
				$queryst = mysqli_query($con,"SELECT * FROM users where role = 'admin';");
				$datas = mysqli_fetch_assoc($queryst)['id_users'];
				setPengumuman($con,$datas,"Daftar Bimbingan","Mahasiswa Dengan id :".$id." Mendaftar Bimbingan","Bimbingan");
			}else{
				$response['kode'] = 404;
				$response['message'] = "Gagal Mendaftar Bimbingan,Ada Masalah Pada koneksi Internal";
			}
		}
		if($_GET['act'] == "setStatusJadwal"){
			$id = $_POST['id_jadwal'];
			$status = $_POST['status'];
			$query = mysqli_query($con,"UPDATE jadwal SET status_jadwal = '$status' WHERE id_jadwal = '$id'");
			if($query){
				$response['kode'] = 200;
				$response['message'] = "Update Status Berhasil";
				$res = "";
				switch ($status) {
					case '1':
						$res = "Diterima";
						break;
					case '2':
						$res = "DiTolak";
						break;
				}
				$queryst = mysqli_query($con,"SELECT * FROM users where role = 'admin';");
				$datas = mysqli_fetch_assoc($queryst)['id_users'];
				setPengumuman($con,$datas,"Konfirmasi Jadwal","Jadwal Dengan Id: ".$id." ".$res,"Jadwal");
			}else{
				$response['kode'] = 404;
				$response['message'] = "Gagal Update Status, Ada Kendala Internal";
			}
		}
		if($_GET['act'] == "getDataMahasiswa"){
			$id = $_POST['id_mahasiswa'];
			$query = mysqli_query($con,"SELECT * FROM mahasiswa WHERE id_mahasiswa = '$id';");
			if(mysqli_num_rows($query) > 0){
				$data = mysqli_fetch_assoc($query);
				$response['kode'] = 200;
				$response['message'] = "Data Berhasil Diambil";
				$response['mahasiswaModel'] = array(
						'id_mahasiswa' => $data['id_mahasiswa'],
						'nama_mahasiswa' => $data['nama_mahasiswa'],
						'nim_mahasiswa' => $data['nim_mahasiswa'],
						'ttl_mahasiswa' => $data['ttl_mahasiswa'],
						'alamat_mahasiswa' => $data['alamat_mahasiswa'],
						'telp_mahasiswa' => $data['telp_mahasiswa'],
						'email_mahasiswa' => $data['email_mahasiswa'],
				);
			}else{
				$response['kode'] = 404;
				$response['message'] = "Not Found";
			}
		}
		if($_GET['act'] == "getMahasiswa"){
			$query = mysqli_query($con,"SELECT * FROM mahasiswa;");
			if(mysqli_num_rows($query) > 0){
				$response['ListMahasiswa'] =array();
				$response['kode'] = 200;
				$response['message'] = "Data Berhasil Diambil";
				while ($data = mysqli_fetch_array($query)) {
					array_push($response['ListMahasiswa'], array(
						'id_mahasiswa' => $data['id_mahasiswa'],
						'nama_mahasiswa' => $data['nama_mahasiswa'],
						'nim_mahasiswa' => $data['nim_mahasiswa'],
						'ttl_mahasiswa' => $data['ttl_mahasiswa'],
						'alamat_mahasiswa' => $data['alamat_mahasiswa'],
						'telp_mahasiswa' => $data['telp_mahasiswa'],
						'email_mahasiswa' => $data['email_mahasiswa']
				));
				}
			}else{
				$response['kode'] = 404;
				$response['message'] = "Not Found";
			}
		}
		if($_GET['act'] == "getPengumumanAsId"){
			$id = $_POST['id_user'];
			$query = mysqli_query($con,"SELECT * FROM pengumuman WHERE id_user = '$id' ORDER BY id_pengumuman DESC LIMIT 10;");
			if(mysqli_num_rows($query) > 0){
				$response['ListPengumuman'] =array();
				$response['kode'] = 200;
				$response['message'] = "Data Berhasil Diambil";
				while ($data = mysqli_fetch_array($query)) {
					array_push($response['ListPengumuman'], array(
						'id_pengumuman' => $data['id_pengumuman'],
						'id_user' => $data['id_user'],
						'tgl_pengumuman' => $data['tgl_pengumuman'],
						'judul_pengumuman' => $data['judul_pengumuman'],
						'type' => $data['type'],
						'deskripsi_pengumuman' => $data['deskripsi_pengumuman']
					));
				}
			}else{
				$response['kode'] = 404;
				$response['message'] = "Not Found";
			}
		}
		if($_GET['act'] == "getRiwayatAsId"){
			$id = $_POST['id_user'];
			$query = mysqli_query($con,"SELECT * FROM bimbingan WHERE id_mahasiswa = '$id' ORDER BY id_bimbingan DESC;");
			if(mysqli_num_rows($query) > 0){
				$response['ListBimbingan'] = array();
				$response['kode'] = 200;
				$response['message'] = "Data Berhasil Diambil";
				while ($data = mysqli_fetch_array($query)) {
					array_push($response['ListBimbingan'],array(
						'judul_bimbingan' => $data['judul_bimbingan'],
						'deskripsi_bimbingan' => $data['deskripsi_bimbingan'],
						'tgl_pengajuan' => $data['tgl_pengajuan'],
						'status_bimbingan' => $data['status_bimbingan'],
					));
				}
			}else{
				$response['kode'] = 404;
				$response['message'] = "Not Found";
			}
		}
		if($_GET['act'] == "getPengajuan"){
			$query = mysqli_query($con,"SELECT * FROM bimbingan ORDER BY id_bimbingan DESC;");
			if(mysqli_num_rows($query) > 0){
				$response['ListBimbingan'] = array();
				$response['kode'] = 200;
				$response['message'] = "Data Berhasil Diambil";
				while ($data = mysqli_fetch_array($query)) {
					array_push($response['ListBimbingan'],array(
						'id_bimbingan' => $data['id_bimbingan'],
						'judul_bimbingan' => $data['judul_bimbingan'],
						'deskripsi_bimbingan' => $data['deskripsi_bimbingan'],
						'tgl_pengajuan' => $data['tgl_pengajuan'],
						'status_bimbingan' => $data['status_bimbingan'],
					));
				}
			}else{
				$response['kode'] = 404;
				$response['message'] = "Not Found";
			}
		}
		if($_GET['act'] == "getPengajuanAsId"){
			$id = $_POST['id_bimbingan'];
			$query = mysqli_query($con,"SELECT * FROM bimbingan WHERE id_bimbingan = '$id' ORDER BY id_bimbingan DESC;");
			if(mysqli_num_rows($query) > 0){
				$data = mysqli_fetch_assoc($query);
				$response['bimbinganModel'] = array(
						'id_bimbingan' => $data['id_bimbingan'],
						'judul_bimbingan' => $data['judul_bimbingan'],
						'deskripsi_bimbingan' => $data['deskripsi_bimbingan'],
						'tgl_pengajuan' => $data['tgl_pengajuan'],
						'status_bimbingan' => $data['status_bimbingan'],
						'catatan' => $data['catatan']);
				$response['kode'] = 200;
				$response['message'] = "Data Berhasil Diambil";
			}else{
				$response['kode'] = 404;
				$response['message'] = "Not Found";
			}
		}
		if($_GET['act'] == "setPengajuanAsId"){
			$id = $_POST['id_bimbingan'];
			$pembimbing = $_POST['pembimbing'];
			$catatan = $_POST['catatan'];
			$status = $_POST['status'];
			$query = mysqli_query($con,"SELECT * FROM dosen where nama_dosen = '$pembimbing';");
			if(mysqli_num_rows($query) > 0){
				$data = mysqli_fetch_assoc($query);
				$query2 = mysqli_query($con,"UPDATE bimbingan SET status_bimbingan = '$status', id_pembimbing = '$data[id_dosen]',catatan = '$catatan' WHERE id_bimbingan = '$id';");
				$response['kode'] = 200;
				$response['message'] = "Data Berhasil Diambil";
				$res = "";
				switch ($status) {
					case '1':
						$res = "Disetujui";
						break;
					case '2':
						$res = "DiTolak";
						break;
					
					default:
						# code...
						break;
				}
				$queryst = mysqli_query($con,"SELECT * from bimbingan INNER JOIN mahasiswa on bimbingan.id_mahasiswa = mahasiswa.id_mahasiswa INNER JOIN users ON users.id_role = mahasiswa.id_mahasiswa WHERE users.role = 'mahasiswa' AND bimbingan.id_bimbingan = '$id'");
				$datas = mysqli_fetch_assoc($queryst)['id_users'];
				setPengumuman($con,$datas,"Konfirmasi Bimbingan","Bimbingan Yang Telah Anda Ajukan Telah ".$res,"Bimbingan");
			}else{
				$response['kode'] = 404;
				$response['message'] = "Not Found";
			}
		}
		if($_GET['act'] == "getJadwalAsId"){
			$id = $_POST['id_user'];
			$query = mysqli_query($con,"SELECT * FROM jadwal inner join dosen on jadwal.id_pembimbing = dosen.id_dosen WHERE id_mhs = '$id' ORDER BY id_jadwal DESC;");
			if(mysqli_num_rows($query) > 0){
				$response['listJadwal'] = array();
				$response['kode'] = 200;
				$response['message'] = "Data Berhasil Diambil";
				while ($data = mysqli_fetch_array($query)) {
					array_push($response['listJadwal'],array(
						'id_jadwal' => $data['id_jadwal'],
						'tgl_jadwal' => $data['tgl_jadwal'],
						'jenis_kegiatan' => $data['jenis_kegiatan'],
						'pembimbing' => $data['nama_dosen'],
						'status_jadwal' => $data['status_jadwal']
					));
				}
			}else{
				$response['kode'] = 404;
				$response['message'] = "Not Found";
			}
		}
		if($_GET['act'] == "delete_mhs"){
			$id = $_POST['id_user'];
			$query = mysqli_query($con,"DELETE FROM mahasiswa WHERE id_mahasiswa = '$id';");
			if($query){
				$query2 = mysqli_query($con,"DELETE FROM users WHERE id_role = '$id' AND role = 'mahasiswa';");
				$response['kode'] = 200;
				$response['message'] = "Hapus Mahasiswa Berhasil";
			}else{
				$response['kode'] = 404;
				$response['message'] = "Not Found";
			}
		}
		if($_GET['act'] == "tambah_mhs"){
			$query = mysqli_query($con,"INSERT INTO mahasiswa (nama_mahasiswa,nim_mahasiswa,ttl_mahasiswa,alamat_mahasiswa,telp_mahasiswa,email_mahasiswa) VALUES ('$_POST[nama]','$_POST[nim]','$_POST[ttl]','$_POST[alamat]','$_POST[no_telp]','$_POST[email]')");
			if($query){
				$cek = mysqli_query($con,"SELECT * FROM mahasiswa WHERE nama_mahasiswa = '$_POST[nama]' AND nim_mahasiswa = '$_POST[nim]';");
				if(mysqli_num_rows($cek) > 0){
					$data = mysqli_fetch_assoc($cek);
					$query2 = mysqli_query($con,"INSERT INTO users (username,password,role,id_role) VALUES ('$data[nim_mahasiswa]','$_POST[password]','mahasiswa','$data[id_mahasiswa]');");
					if($query2){
						$response['kode'] = 200;
						$response['message'] = "Tambah Mahasiswa Berhasil";
					}
				}
				
			}else{
				$response['kode'] = 404;
				$response['message'] = "Not Found";
			}
		}
		if($_GET['act'] == "getJadwal"){
			$query = mysqli_query($con,"SELECT * FROM jadwal inner join dosen on jadwal.id_pembimbing = dosen.id_dosen ORDER BY id_jadwal DESC;");
			if(mysqli_num_rows($query) > 0){
				$response['listJadwal'] = array();
				$response['kode'] = 200;
				$response['message'] = "Data Berhasil Diambil";
				while ($data = mysqli_fetch_array($query)) {
					array_push($response['listJadwal'],array(
						'id_jadwal' => $data['id_jadwal'],
						'status_jadwal' => $data['status_jadwal'],
						'tgl_jadwal' => $data['tgl_jadwal'],
						'jenis_kegiatan' => $data['jenis_kegiatan'],
						'pembimbing' => $data['nama_dosen']	
					));
				}
			}else{
				$response['kode'] = 404;
				$response['message'] = "Not Found";
			}
		}
		if($_GET['act'] == "getDosen"){
			$query = mysqli_query($con,"SELECT * FROM dosen;");
			if(mysqli_num_rows($query) > 0){
				$response['listDosen'] = array();
				$response['kode'] = 200;
				$response['message'] = "Data Berhasil Diambil";
				while ($data = mysqli_fetch_array($query)) {
					array_push($response['listDosen'],array(
						'id_dosen' => $data['id_dosen'],
						'nama_dosen' => $data['nama_dosen']
					));
				}
			}else{
				$response['kode'] = 404;
				$response['message'] = "Not Found";
			}
		}
		if($_GET['act'] == "delete_dosen"){
			$id = $_POST['id_dosen'];
			$query = mysqli_query($con,"DELETE FROM dosen WHERE id_dosen = '$id';");
			if($query){
				$response['kode'] = 200;
				$response['message'] = "Hapus Mahasiswa Berhasil";
			}else{
				$response['kode'] = 404;
				$response['message'] = "Not Found";
			}
		}
		if($_GET['act'] == "tambah_dosen"){
			$query = mysqli_query($con,"INSERT INTO dosen (nama_dosen) VALUES ('$_POST[nama]')");
			if($query){
				$cek = mysqli_query($con,"SELECT * FROM dosen WHERE nama_dosen = '$_POST[nama]';");
				if(mysqli_num_rows($cek) > 0){
						$response['kode'] = 200;
						$response['message'] = "Tambah Dosen Berhasil";
				}
			}else{
				$response['kode'] = 404;
				$response['message'] = "Not Found";
			}
		}
		if($_GET['act'] == "tambah_jadwal"){
			$id_mhs = "";
			$id_dosen = "";
			$cekmhs = mysqli_query($con,"SELECT * FROM mahasiswa WHERE nama_mahasiswa = '$_POST[mhs]';");
			if(mysqli_num_rows($cekmhs) > 0){
				$data = mysqli_fetch_assoc($cekmhs);
				$id_mhs = $data['id_mahasiswa'];
			}
			$cekdosen = mysqli_query($con,"SELECT * FROM dosen WHERE nama_dosen = '$_POST[pembimbing]';");
			if(mysqli_num_rows($cekdosen) > 0){
				$data = mysqli_fetch_assoc($cekdosen);
				$id_dosen = $data['id_dosen'];
			}
			$insert = mysqli_query($con,"INSERT INTO jadwal (id_mhs,tgl_jadwal,jenis_kegiatan,id_pembimbing,status_jadwal) VALUES ('$id_mhs','$_POST[tgl_kegiatan]','$_POST[kegiatan]','$id_dosen','0');");
			if($insert){
				$response['kode'] = 200;
				$response['message'] = "Insert Data Berhasil";
			}else{
				$response['kode'] = 404;
				$response['message'] = "Not Found";
			}
		}
	}else{
		$response['kode'] = 404;
		$response['message'] = "Not Found";
	}
	echo json_encode($response);

 ?>