<?php
require_once 'google-api-php-client/src/Google/Client.php';
require_once 'google-api-php-client/src/Google/Service/Oauth2.php';
require_once 'google-api-php-client/src/Google/Service/Drive.php';
session_start();

header('Content-Type: text/html; charset=utf-8');

// Init the variables
$driveInfo = "";
$folderName = "";
$folderDesc = "";
// Get the file path from the variable
$file_tmp_name = $_FILES["file"]["tmp_name"];

// Get the client Google credentials
$credentials = $_COOKIE["credentials"];

// Get your app info from JSON downloaded from google dev console
$json = json_decode(file_get_contents("../storage/secret/credentials.json"), true);
$CLIENT_ID = $json['web']['client_id'];
$CLIENT_SECRET = $json['web']['client_secret'];
$REDIRECT_URI = $json['web']['redirect_uris'][0];

// Create a new Client
$client = new Google_Client();
$client->setClientId($CLIENT_ID);
$client->setClientSecret($CLIENT_SECRET);
$client->setRedirectUri($REDIRECT_URI);
$client->addScope(
	"https://www.googleapis.com/auth/drive",
	"https://www.googleapis.com/auth/drive.appfolder");

// Refresh the user token and grand the privileges
die($credentials);
$client->setAccessToken($credentials);
$service = new Google_Service_Drive($client);

// Set the file metadata for drive
$mimeType = $_FILES["file"]["type"];
$title = $_FILES["file"]["name"];


// Call the insert function with parameters listed below
$driveInfo = insertFile($service, $title, $mimeType, $file_tmp_name);

/**
* Get the folder ID if it exists, if it doesnt exist, create it and return the ID
*
* @param Google_DriveService $service Drive API service instance.
* @param String $folderName Name of the folder you want to search or create
* @param String $folderDesc Description metadata for Drive about the folder (optional)
* @return Google_Drivefile that was created or got. Returns NULL if an API error occured
*/
$files = $service->files->listFiles();

/**
 * Insert new file in the Application Data folder.
 *
 * @param Google_DriveService $service Drive API service instance.
 * @param string $title Title of the file to insert, including the extension.
 * @param string $description Description of the file to insert.
 * @param string $mimeType MIME type of the file to insert.
 * @param string $filename Filename of the file to insert.
 * @return Google_DriveFile The file that was inserted. NULL is returned if an API error occurred.
 */
function insertFile($service, $title, $mimeType, $filename) {
	$folderId = '1IGSD8tvO8bbehb3Il2m4zviU30UJAKW2';
	$file = new Google_Service_Drive_DriveFile(array(
    'name' => $filename,
		'parents' => array(array('id' => $folderId))
));

	// Set the metadata
	$parent = new Google_Service_Drive_ParentReference();
	$parent->setId($folderId);
	$file->setTitle($title);
	$file->setMimeType($mimeType);
	$file->setParents(array($parent));
	// die(print_r($service->files));

	try {
		// Get the contents of the file uploaded
		$data = file_get_contents($filename);
		// Try to upload the file, you can add the parameters e.g. if you want to convert a .doc to editable google format, add 'convert' = 'true'

		$createdFile = $service->files->insert($file, array(
			'data' => $data,
			'mimeType' => $mimeType,
			'uploadType'=> 'multipart',
			));

		// Return a bunch of data including the link to the file we just uploaded
		return $createdFile;
	} catch (Exception $e) {
		print "An error occurred: " . $e->getMessage();
	}
}

echo "<br>Link to file: " . $driveInfo["alternateLink"];

?>
