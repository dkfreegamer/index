<?php
if (isset($_POST['submit'])) {
//normal
$Sname = $_POST['Sname'];
$artist = $_POST['artist'];
$album = $_POST['album'];

//song
	$file = $_FILES['sfile'];

	$fileName = $_FILES['sfile']['name'];
	$fileType = $_FILES['sfile']['type'];
	$fileTmpName = $_FILES['sfile']['tmp_name'];
	$fileError = $_FILES['sfile']['error'];
	$fileSize = $_FILES['sfile']['size'];
	$fileMaxSize = 1000000;
	echo "$fileSize";

	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));
//album
	$afile = $_FILES['salbum'];

	$afileName = $_FILES['salbum']['name'];
	$afileType = $_FILES['salbum']['type'];
	$afileTmpName = $_FILES['salbum']['tmp_name'];
	$afileError = $_FILES['salbum']['error'];
	$afileSize = $_FILES['salbum']['size'];
	$afileMaxSize = 1000000;

	$afileExt = explode('.', $afileName);
	$afileActualExt = strtolower(end($afileExt));
	$aalowed = array('jpg', 'jpeg', 'png', 'pdf');

//if login
	$allowed = array('mp3');
	if (isset($_SESSION['id'])) {
	//database check
	$sql = "SELECT sid FROM music WHERE sid='$sid'";
	$result = mysqli_query($conn, $sql);
	$uidcheck = mysqli_num_rows($result);
				
		if (in_array($fileActualExt, $allowed)) {
			if ($fileError === 0) {
				if ($fileMaxSize >= $fileSize) {
						if(in_array($afileActualExt, $aalowed)){
						//song
						$fileNameNew = uniqid('', true).'.'.$fileActualExt;
						$fileDestination = '../music/songs'.$fileNameNew;
						move_uploaded_file($fileTmpName, $fileDestination);
						//album
						$afileNameNew = uniqid('', true).'.'.$afileActualExt;
						$afileDestination = '../music/album'.$afileNameNew;
						move_uploaded_file($afileTmpName, $afileDestination);
						//insert names
						$songins = '/music/songs/'+$fileNameNew;
						$albumins = '/music/album/'+$afileNameNew;
						//database insert
						$sql = "INSERT INTO music (sname, sfilename, salbum, sid, sfilealbum, sartist) 
						VALUES ('$sname','$songins','$album','$sid','$albumins','$artist')";
						$result = mysqli_query($conn, $sql);
						//header("Location: ../index.php?uploadsuccess");
				} else{
					echo"not allowed album filetype";
				}
			} else {
					echo "Your file is too big!";
			}
			
		} else {
			echo "There was an error uploading your file!";
		}
	} else {
		echo "You cannot upload files of this type!";
	}
}
}