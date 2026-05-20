<?php

namespace OGame\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use OGame\Http\Controllers\OGameController;
use OGame\Models\UniverseGateServer;

class UniverseGateAdminController extends OGameController
{
    public function index(): View
    {
        return view('ingame.admin.universe-gates.index', [
            'servers' => UniverseGateServer::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'universe_identifier' => ['required', 'string', 'max:64'],
            'name' => ['required', 'string', 'max:120'],
            'base_url' => ['required', 'url', 'max:255'],
            'shared_secret' => ['required', 'string', 'min:32', 'max:255'],
            'status' => ['required', 'in:pending,active,rejected,error'],
        ]);

        UniverseGateServer::updateOrCreate(
            ['universe_identifier' => $data['universe_identifier']],
            array_merge($data, ['registration_direction' => 'outgoing'])
        );

        return redirect()->route('admin.universe-gates.index')->with('success', __('Changes saved!'));
    }

    public function update(Request $request, UniverseGateServer $server): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,active,rejected,error'],
        ]);

        $server->status = $data['status'];
        if ($server->status === UniverseGateServer::STATUS_ACTIVE && $server->registered_at === null) {
            $server->registered_at = now();
        }
        $server->save();

        return redirect()->route('admin.universe-gates.index')->with('success', __('Changes saved!'));
    }

    public function destroy(UniverseGateServer $server): RedirectResponse
    {
        $server->delete();

        return redirect()->route('admin.universe-gates.index')->with('success', __('Changes saved!'));
    }
}
