<?php

namespace OGame\Http\Controllers\Admin;

use Illuminate\View\View;
use OGame\Http\Controllers\OGameController;

class ChangelogController extends OGameController
{
    /**
     * Shows the admin changelog page.
     */
    public function index(): View
    {
        $changelogPath = base_path('CHANGELOG.md');
        $changelog = file_exists($changelogPath) ? file_get_contents($changelogPath) : '';

        return view('ingame.admin.changelog')->with([
            'changelog' => $changelog,
        ]);
    }
}
