<?php

namespace OGame\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use OGame\Http\Controllers\OGameController;

class UpdateCheckController extends OGameController
{
    /**
     * URL of the remote version.xml used to check for updates.
     */
    private const VERSION_XML_URL = 'https://raw.githubusercontent.com/hammermaps/OGameX-Test/main/public/version.xml';

    /**
     * Shows the admin update-check page.
     */
    public function index(): View
    {
        $currentVersion = config('app.version', '0.0.0');

        return view('ingame.admin.update-check')->with([
            'currentVersion' => $currentVersion,
            'versionXmlUrl'  => self::VERSION_XML_URL,
        ]);
    }

    /**
     * Fetches the remote version.xml and returns comparison data as JSON.
     */
    public function check(): JsonResponse
    {
        $currentVersion = config('app.version', '0.0.0');

        try {
            $response = Http::timeout(10)->get(self::VERSION_XML_URL);

            if (! $response->successful()) {
                return response()->json([
                    'error' => __('Could not fetch version information. HTTP status: ') . $response->status(),
                ], 502);
            }

            $xml = simplexml_load_string($response->body());

            if ($xml === false) {
                return response()->json([
                    'error' => __('Could not parse version.xml response.'),
                ], 502);
            }

            $latestVersion  = (string) $xml->version;
            $releaseDate    = (string) $xml->release_date;
            $downloadUrl    = (string) $xml->download_url;
            $changelogUrl   = (string) $xml->changelog_url;
            $description    = (string) $xml->description;

            $updateAvailable = version_compare($latestVersion, $currentVersion, '>');

            return response()->json([
                'current_version'  => $currentVersion,
                'latest_version'   => $latestVersion,
                'release_date'     => $releaseDate,
                'download_url'     => $downloadUrl,
                'changelog_url'    => $changelogUrl,
                'description'      => $description,
                'update_available' => $updateAvailable,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => __('Update check failed: ') . $e->getMessage(),
            ], 502);
        }
    }
}
