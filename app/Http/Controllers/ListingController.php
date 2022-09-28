<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

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
        // dd(request('tag'));
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->get()
        ]);
    }

    // Show single listing
    public function show(Listing $listing)
    {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }
}
