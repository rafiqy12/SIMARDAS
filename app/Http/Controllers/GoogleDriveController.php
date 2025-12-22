<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Client;
use Google\Service\Drive;

class GoogleDriveController
{
    private function client()
    {
        $client = new Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(route('google.callback'));
        $client->addScope(Drive::DRIVE_FILE);
        $client->setAccessType('offline');
        $client->setPrompt('consent');

        return $client;
    }

    public function redirect()
    {
        return redirect($this->client()->createAuthUrl());
    }

    public function callback(Request $request)
    {
        $client = new Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));

        $token = $client->fetchAccessTokenWithAuthCode($request->code);

        if (isset($token['error'])) {
            return redirect()->route('backup.index')
                ->with('error', 'Google authentication failed');
        }

        // simpan token ke session (atau database user)
        session(['google_drive_token' => $token]);

        return redirect()->route('backup.index')
            ->with('success', 'Google Drive connected successfully');
    }
}
