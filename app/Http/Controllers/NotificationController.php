<?php

namespace App\Http\Controllers;

use Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\ProjectMember;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications;
        return view('notifications.index', compact('notifications'));
    }

    public function acceptOrRejectProject(Notification $id, bool $accept)
    {
        $membership = ProjectMember::where('user_id', $id->user->id)->where('project_id', $id->project->id)->first();
        $membership->update(['has_accepted' => $accept]);
        $id->update(['read_at' => new \DateTime()]);

        return redirect()->route('notifications.index');
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }
        return redirect()->route('notifications.index');
    }

    public function destroy($id)
    {
        $notification = Auth::user()->notifications()->find($id);
        if ($notification) {
            $notification->delete();
        }
        return redirect()->route('notifications.index');
    }
}
