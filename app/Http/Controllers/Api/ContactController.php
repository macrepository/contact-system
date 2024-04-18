<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Resources\ContactResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    /**
     * Handle api on fetching contacts with query search and pagination
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getContactList(Request $request): JsonResponse
    {
        $search = $request->input('search', '');
        $pageSize = $request->input('limit', 10);
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $pageSize;

        $query = Contact::where('user_id', Auth::id());

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $totalCount = $query->count();

        $contacts = $query->skip($offset)->take($pageSize)->get();

        if ($totalCount <= 0) {
            return response()->json(['message' => 'No contacts were found.'], 404);
        }

        $resourceCollection = ContactResource::collection($contacts);

        return response()->json([
            'data'          => $resourceCollection,
            'total'         => $totalCount,
            'totalPages'    => ceil($totalCount / $pageSize)
        ]);
    }
}
