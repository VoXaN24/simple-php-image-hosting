<?php
// Configuration
$title = 'VoxImage';
$filedir = 'up';
$maxsize = 10485760; //max size in bytes
$allowedExts = array('png', 'jpg', 'jpeg', 'gif');
$allowedMime = array('image/png', 'image/jpeg', 'image/pjpeg', 'image/gif');
$baseurl = $_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']).'/'.$filedir;
?>
<html>
<head>
    <title><?php print $title; ?></title>
<link rel="stylesheet" href="css.css" type="text/css" />
</head>
<body>
	<div id="upload">
		<form enctype="multipart/form-data" action="<?php print $_SERVER['PHP_SELF']; ?>" method="POST">
		<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
		Fichier a uploader: <br />
		<input size="62"  name="file" type="file" accept="image/*" />
		<input type="submit" value="Uploader le Fichier" />
		</form>
		<div id="info">
		Taille max: 10 Mo <br/>
		Format supporter: png, jpg, gif <br/>
		</div>
	</div>
	<div id="image">
	<a name="image">
<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

		if ((in_array($_FILES['file']['type'], $allowedMime))
		&& (in_array(strtolower($ext), $allowedExts)) 
		&& (@getimagesize($_FILES['file']['tmp_name']) !== false)
		&& ($_FILES['file']['size'] <= $maxsize)) {
			$md5 = substr(md5_file($_FILES['file']['tmp_name']), 0, 7);
			$newname = time().$md5.'.'.$ext;
			move_uploaded_file($_FILES['file']['tmp_name'], $filedir.'/'.$newname);
			$baseurl = $_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']).'/'.$filedir;
			$imgurl = 'http://'.$baseurl.'/'.$newname;
			print '<br />';
			print 'Votre lien:<br />';
			print '<input type="text" value="'.$imgurl.'" ><br /><br />';
			print '<a href="'.$imgurl.'"><img src="'.$imgurl.'" /></a><br />';
		}

		else {
			print '<br />';
			print 'Incorrect <br />';
		}
		
	}
?>
	</div>
</body>
</html>

