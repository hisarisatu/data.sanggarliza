<?php
//Buat konfigurasi upload
//Folder tujuan upload file
$eror		= false;
$folder		= './upload/';
//type file yang bisa diupload
$file_type	= array('jpg','jpeg','png','gif','bmp','doc','docx','xls','xlsx','sql');
//tukuran maximum file yang dapat diupload
$max_size	= 10000000; // 1MB
if(isset($_POST['btnUpload'])){
	//Mulai memorises data
	$file_name	= $_FILES['data_upload']['name'];
	$file_size	= $_FILES['data_upload']['size'];
	$file_name1	= $_FILES['data_upload1']['name'];
	$file_size1	= $_FILES['data_upload1']['size'];
	$file_name2	= $_FILES['data_upload2']['name'];
	$file_size2	= $_FILES['data_upload2']['size'];
	$file_name3	= $_FILES['data_upload3']['name'];
	$file_size3	= $_FILES['data_upload3']['size'];
	$file_name4	= $_FILES['data_upload4']['name'];
	$file_size4	= $_FILES['data_upload4']['size'];
	$file_name5	= $_FILES['data_upload5']['name'];
	$file_size5	= $_FILES['data_upload5']['size'];
	//cari extensi file dengan menggunakan fungsi explode
	$explode	= explode('.',$file_name);
	$explode1	= explode('.',$file_name1);
	$explode2	= explode('.',$file_name2);
	$explode3	= explode('.',$file_name3);
	$explode4	= explode('.',$file_name4);
	$explode5	= explode('.',$file_name5);
	
	$extensi	= $explode[count($explode)-1];
	$extensi1	= $explode1[count($explode1)-1];
		$extensi2	= $explode2[count($explode2)-1];
			$extensi3	= $explode3[count($explode3)-1];
				$extensi4	= $explode4[count($explode4)-1];
					$extensi5	= $explode5[count($explode5)-1];
					
	//check apakah type file sudah sesuai
	if(!in_array($extensi,$file_type)){
		$eror   = true;
		$pesan .= '- Type file yang anda upload tidak sesuai<br />';
	}
	if($file_size > $max_size){
		$eror   = true;
		$pesan .= '- Ukuran file melebihi batas maximum<br />';
	}
	//check ukuran file apakah sudah sesuai

	if($eror == true){
		echo '<div id="eror">'.$pesan.'</div>';
	}
	else{
		//mulai memproses upload file
		if(move_uploaded_file($_FILES['data_upload']['tmp_name'], $folder.$file_name) xor  move_uploaded_file($_FILES['data_upload1']['tmp_name'], $folder.$file_name1) xor move_uploaded_file($_FILES['data_upload2']['tmp_name'], $folder.$file_name2)xor move_uploaded_file($_FILES['data_upload3']['tmp_name'], $folder.$file_name3) xor move_uploaded_file($_FILES['data_upload4']['tmp_name'], $folder.$file_name4) xor move_uploaded_file($_FILES['data_upload5']['tmp_name'], $folder.$file_name5)){
			//catat nama file ke database
			$catat = mysql_query('insert into jadwal_upload(filename,filename1,filename2,filename3,filename4,filename5,detail,folder,dateupload) values ("'.$file_name.'","'.$file_name1.'","'.$file_name2.'","'.$file_name3.'","'.$file_name4.'","'.$file_name5.'", "'.$_POST['keterangan'].'", 
								  "'.$folder.'", "'.date('Y-m-d H:i:s').'")');
			echo '<div id="msg">Berhasil mengupload file '.$file_name.','.$file_name1.','.$file_name2.','.$file_name3.','.$file_name4.','.$file_name5.'</div>';
		} else{
			echo "Proses upload eror";
		}
	}
}
?>