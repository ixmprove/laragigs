<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // Common Resource Routes
    // index - Show all listings
    // show - Show single Listing
    // create - Show form to create new Listing
    // store - Store new Listing
    // edit - Show form to edit Listing
    // update - Update Listing
    // destroy - Delete Listing


    // Show all listings
    public function index()
    {
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
        ]);
    }

    // Show single listing
    public function show(Listing $listing)
    {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    // Show Create Form
    public function create()
    {
        return view('listings.create');
    }

    // Store Listing Data (POST)
    public function store(Request $request)
    {
        // dd(request()->file('logo'));
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        };

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        return redirect('/')->with('message', 'Listing Created Successfully');
    }

    // Show Edit Form
    public function edit(Listing $listing)
    {
        // Make sure Logged in user is owner.
        if ($listing->user_id != auth()->id()) {
            abort(403, 'No Permission');
        }

        return view('listings.edit', [
            'listing' => $listing
        ]);
    }

    // Store Edit Data (POST)
    public function update(Request $request, Listing $listing)
    {
        // Make sure Logged in user is owner.
        if ($listing->user_id != auth()->id()) {
            abort(403, 'No Permission');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        };

        $listing->update($formFields);

        return redirect('/listings/' . $listing->id)->with('message', 'Listing updated successfully!');
    }

    // Remove Listing (DELETE)
    public function destroy(Listing $listing)
    {
        // Make sure Logged in user is owner.
        if ($listing->user_id != auth()->id()) {
            abort(403, 'No Permission');
        }

        $listing->delete();
        return redirect('/')->with('message', 'Listing removed successfully!');
    }

    // Manage Listings
    public function manage()
    {
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }
}
