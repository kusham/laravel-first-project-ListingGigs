<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Validation\Rule;


class ListingController extends Controller
{
    public function index() {
        return view('Listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(4)
        ]);
    }

    public function show(Listing $listing) {
        return view(
            'Listings.show',[
                "listing" => $listing
            ]);
    }
    public function create() {
        return view('Listings.create');
    }
    public function store() {
    
        $formFelid = request()->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if(request()->hasFile('logo')) {
            $formFelid['logo'] = request()->file('logo')->store('logos', 'public');
        }
        $formFelid['user_id'] = auth()->id();

        Listing::create($formFelid);
        return redirect('/')->with('message', 'Listing created successfully!');
    }

    public function edit(Listing $listing) {
        return view('listings.edit', ['listing' => $listing]);
    }

    public function update(Listing $listing) {
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }
        
        $formFelid = request()->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);
        if(request()->hasFile('logo')) {
            $formFelid['logo'] = request()->file('logo')->store('logos', 'public');
        }

        $listing->update($formFelid);
        return redirect('/')->with('message', 'Listing updated successfully!');
    }

     // Delete Listing
     public function destroy(Listing $listing) {
        // Make sure logged in user is owner
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }
        
        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted successfully');
    }

    public function manage() {
        return view('Listings.manage', ['listings' => auth()->User()->listings()->get()]);
    }
}
