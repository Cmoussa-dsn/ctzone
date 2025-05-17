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
    
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    
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

    
    public function customBuilds(Request $request): View
    {
        $user = $request->user();
        
        // awal shi bedna nchayek eza mnle2e custom pc prds lal user
        // awal shi mnchuf bl cart tabaao
        $cartCustomPCs = CartItem::where('user_id', $user->id)
            ->whereHas('product', function($query) {
                $query->where('type', 'custom_pc');
            })
            ->with('product')
            ->get();
            
        // tene shi bl orders l kemlin
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
