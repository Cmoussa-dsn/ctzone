<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\OrderItem;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Display the user's custom PC builds.
     */
    public function customBuilds(Request $request): View
    {
        $user = $request->user();
        
        // Find custom PC products owned by this user
        // First, find in active cart
        $cartCustomPCs = CartItem::where('user_id', $user->id)
            ->whereHas('product', function($query) {
                $query->where('type', 'custom_pc');
            })
            ->with('product')
            ->get();
            
        // Then, find in completed orders
        $orderCustomPCs = OrderItem::whereHas('order', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->whereHas('product', function($query) {
                $query->where('type', 'custom_pc');
            })
            ->with(['product', 'order'])
            ->get();
        
        return view('profile.custom-builds', [
            'user' => $user,
            'cartCustomPCs' => $cartCustomPCs,
            'orderCustomPCs' => $orderCustomPCs,
        ]);
    }
}
