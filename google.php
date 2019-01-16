<?php
require __DIR__ . '/vendor/autoload.php';

if (php_sapi_name() != 'cli') {
    throw new Exception('This application must be run on the command line.');
}

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
 function getClient()
 {
     $client = new Google_Client();
     $client->setApplicationName('Google Drive API PHP Quickstart');
     $client->setScopes(Google_Service_Drive::DRIVE_METADATA_READONLY);
     $client->setAuthConfig('storage/secret/credentials.json');
     $client->setAccessType('offline');
     $client->setPrompt('select_account consent');

// Get your credentials from the console
$service = new Google_Service ( $client );

$authUrl = $client->createAuthUrl ();

// Request authorization
print "Please visit:\n$authUrl\n\n";
print "Please enter the auth code:\n";
$authCode = trim ( fgets ( STDIN ) );

// Exchange authorization code for access token
$accessToken = $client->authenticate ( $authCode );
$client->setAccessToken ( $accessToken );

// Insert a file
$file = new Google_Service_Drive_DriveFile ();
$file->setTitle ( 'My document' );
$file->setDescription ( 'A test document' );
$file->setMimeType ( 'text/plain' );

$data = file_get_contents ( 'document.txt' );

$createdFile = $service->files->insert ( $file, array (
        'data' => $data,
        'mimeType' => 'text/plain'
) );

echo $createdFile;
